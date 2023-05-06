<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Provider;
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



}



