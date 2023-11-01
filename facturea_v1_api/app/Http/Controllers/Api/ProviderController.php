<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProviderController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $providers = Provider::all();
        return $providers;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
     {

         //return $request;
         $request->validate([

             'name' => 'required|max:255',
             'cuit' => 'min:8|max:11|unique:providers',
             'address',
             'city',
             'phone' => 'string|unique:providers',
             'email'=> 'email|unique:providers',
             'status' => 'required'
         ]);

        $provider = Provider::create($request->all());

        return $provider;

    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Provider  $provider
    //  * @return \Illuminate\Http\Response
    //  */
    public function show(Provider $provider)
    {
        return $provider;
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\Provider  $provider
    //  * @return \Illuminate\Http\Response
    //  */
     public function update(Request $request, Provider $provider)
     {


        if( !empty($request->percent) ){
           $this->increase( $provider->id, $request->percent );
        }

        //dd($request);
        $request->validate([

            'name' => 'required|max:255',
            'cuit' => 'min:8|max:11|unique:providers,cuit,'.$provider->id,
            'address',
            'city',
            'phone' => 'string|unique:providers,phone,'.$provider->id,
            'email'=> 'email|unique:providers,email,'.$provider->id,
            'status' => 'required',

        ]);

         $provider->update($request->all());
         return $provider;
     }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\Provider  $provider
    //  * @return \Illuminate\Http\Response
    //  */
     public function destroy(Provider $provider)
     {
         $provider->delete();
         return $provider;
     }

     public  function increase($provider_id, $percent )
     {

        $brandProducts = DB::table('brand_products')
        ->where('provider_id', $provider_id)
        ->pluck('id');


        $products = DB::table('products')
        ->whereIn('brand_product_id', $brandProducts)
        ->get();



        $arr_id_products = [];
        foreach ($products as $product) {

            //echo 'ID_Product '.$product->id.' $'.$product->price_sale.'<br>';

            $p = $product->price_sale * $percent / 100;

            DB::table('products')
            ->where('id', $product->id)
            ->update(['price_sale' => $p + $product->price_sale]);


            array_push($arr_id_products, $product->id);


        }

        $sales = DB::table('sales')
        ->whereIn('product_id', $arr_id_products)
        ->get();



        foreach ($sales as $sale) {

            $p_unit_price = $sale->unit_price * $percent / 100;
            $p_total_price = $sale->total_price * $percent / 100;


            DB::table('sales')
            ->where('product_id', $sale->product_id)
            ->update([
                        'unit_price' => $sale->unit_price +  $p_unit_price,
                        'total_price' => $sale->total_price + $p_total_price
                    ]);


        }


     }

      // # Se aumentan todas la cuentas corrientes en el rango de fechas que se le pase
      // Si no se elige rango de fechas, se le aumenta a todos
      public function aumento_update(Request $request)
      {

        if ( $request->percent_aumento == null || !is_numeric($request->percent_aumento)) {
            return false;
        }

        $insert_plus = [];


        if ($request->percent_aumento_check) {

            $sales = Sale::whereBetween('date_sale', [$request->percent_aumento_desde, $request->percent_aumento_hasta])
            ->where('type_sale_id', '<>', 1)
            ->get();

            if( count($sales) == 0){

                $insert_plus[] = 'No existen datos para el rango de fechas que elegio';
                return response()->json([
                    'msg' => $insert_plus,
                ]);
            }

            $id_sales = [];
            foreach ($sales as $sale) {

                $id_sales[] = $sale->identificator_sale;
            }
            //$this->recalculate_total_buy( $sales );

            $this->recalculate_total_debt( $id_sales );

            die();

            //$sale2 ? $insert_plus[] = 'AUMENTO a Ctas./Ctes., desde '.$request->percent_aumento_desde. ' hasta '.$request->percent_aumento_hasta.' aplicados con exito' : '';

        }

        $products = Product::all();
        foreach ($products as $product) {
            $product->price_purchase = $product->price_purchase + ($product->price_purchase * $request->percent_aumento / 100);
            $product->price_sale = $product->price_sale + ($product->price_sale * $request->percent_aumento / 100);
            $save1 = $product->save();
        }

        $save1 ? $insert_plus[] = 'Aumento a productos, aplicado con exito!' : '';

        return response()->json([
            'msg' => $insert_plus,
        ]);


      }


      // # RECALCULAMOS EL TOTAL DE CADA COMPRA
      function recalculate_total_buy($sales){


            foreach ($sales as $sale) {

                $sale_price = Sale::where('id',$sale->id)->where('type_sale_id', 2);

                $price_new = DB::table('products')
                    ->select('price_sale')
                    ->where('id', $sale_price->product_id)
                    ->first();

                $sale_price->unit_price = $price_new->price_sale;
                $sale_price->total_price = $price_new->price_sale * $sale_price->cuantity;
                $sale_price->save();

            }
        }

       function recalculate_total_debt($sales){

            // # COnvertimos los ids en array
            $ids_sales = (array)$sales;

            // # COmo estan repetidos los unificamos y con array_values
            // No conservamos sus viejos indices
            $ids_sales_uniques = array_values(array_unique($ids_sales));



            // Obtener todas las ventas con el mismo identificador de venta
            for ($i=0; $i < count($ids_sales_uniques); $i++) {

                $sum_price_total = DB::table('sales')->where('identificator_sale', $ids_sales_uniques[$i])->sum('total_price');

                // # Updeteamo el nuevo valor del debt del cliente
                DB::table('payments')->where('identificator_sale', $ids_sales_uniques[$i])->update(['debt' => $sum_price_total]);


            }


       }












}



