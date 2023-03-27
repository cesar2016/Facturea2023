<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Sale;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\SerializableClosure\Serializers\Signed;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $sale = Sale::all();
        // return $sale;


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


       // Otenemos el maximo ID para generar en indentif de venta;
       $max_value = Sale::max('identificator_sale');
       $max_value ++;

       $total_buy = 0;
        for ($i=0; $i < $request->cant_input; $i++) {

            $cant = "cant-".$i;
            $price_unit = "price_unit-".$i;
            $sub_total = "sub_total-".$i;
            $product_id = "product_id-".$i;

            //echo $request->$product_id;

            $sale = new Sale();
            $sale->identificator_sale = $max_value;
            $sale->date_sale = $request->date_sale;
            $sale->type_sale_id = $request->type_sale;
            $sale->client_id = $request->client_id;
            $sale->status = 0;

            $sale->cuantity = (int)$request->$cant;
            $sale->unit_price = number_format($request->$price_unit, 2, '.', '');
            $sale->total_price = number_format($request->$sub_total, 2, '.', '');
            $sale->product_id = (int)$request->$product_id;

            $sale->save();

            $this->updateStock((int)$request->$product_id, (int)$request->$cant);

            $total_buy += $request->$sub_total;

        }

        $this->insert_payments(

            $request->client_id,
            $max_value,
            number_format($request->delivery, 2, '.', ''),
            number_format($total_buy, 2, '.', ''),
            $request->countdown,
            $request->type_sale,
            $request->date_sale
        );

        return true;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */

    // # Busqueda por ID de Sale
    public function show($identificator_sale)
    {

        $sales = Sale::with(['Client', 'Product'])->where('identificator_sale', $identificator_sale)->get();
        return $sales;

    }

    public function show_for_id(Sale $sale)
    {

        $sales = Sale::with(['Client', 'Product'])->where('id',$sale->id)->get();
        return $sales;

    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_sale)
    {

        $saleStock = Sale::find($id_sale);

        if($request->cuantity > $saleStock->cuantity){

            //return 'Disminuir Stock ';
            $this->updateStock_for_update_item_Sale($request->product_id, $request->cuantity - $saleStock->cuantity, 'sustract');

        }

        if($request->cuantity < $saleStock->cuantity){

            //return 'Incrementar Stock ';
            $this->updateStock_for_update_item_Sale($request->product_id, $saleStock->cuantity - $request->cuantity, 'plus');

        }


        $request->validate([

            'product_id' => 'required|integer',
            'cuantity' => 'required|integer',
            'date_sale' => 'required|date',
            'unit_price' => 'required|integer',
            'total_price' => 'required|integer',

        ]);

        $sale = Sale::find($id_sale);
        $sale->product_id = $request->product_id;
        $sale->cuantity = $request->cuantity;
        $sale->date_sale = $request->date_sale;
        $sale->unit_price = $request->unit_price;
        $sale->total_price = $request->total_price;

        $sale->save();

        return $sale;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy($sale)
    {

        $item = Sale::find($sale);
        $this->updateStock_for_delete($item->product_id, $item->cuantity);

        Sale::destroy($sale);

        DB::table('payments')
            ->where('identificator_sale', $item->identificator_sale)
            ->delete();

        $itemCount = Sale::where('identificator_sale', $item->identificator_sale)->count();

        return response()->json([
                                    'itemCount' => $itemCount,
                                    'identificator_sale' => $item->identificator_sale
                                ]);
    }


    // ## Metodo para controlar Stock
    public function updateStock_for_delete($product_id, $cant)
    {
        Product::where('id', $product_id)->update(['stock' => DB::raw('stock +'.$cant)]);

    }

    // ## Metodo para controlar Stock cuando se hace una venta
    public function updateStock($product_id, $cant)
    {
        Product::where('id', $product_id)->update(['stock' => DB::raw('stock -'.$cant)]);
    }



    // ## Metodo para modif el Stock cuando se uptdetea algun item de una compra y/o compra
    public function updateStock_for_update_item_Sale($product_id, $cant, $action)
    {

        if($action == 'sustract'){

            Product::where('id', $product_id)->update(['stock' => DB::raw('stock -'.$cant)]);
        }
        if($action == 'plus'){

            Product::where('id', $product_id)->update(['stock' => DB::raw('stock +'.$cant)]);
        }
    }

    // ## Metodo para controlar los pagos
    public function insert_payments($client_id, $max_value, $delivery, $total_buy, $countdown, $type_sale, $date_sale)
    {

        if ($type_sale == 1) { // Venta de contado type_sale = 1

            $delivery = $total_buy;
            $status = 0;

        }else{

            if($delivery){

                if($delivery >= $total_buy){

                    $status = 0;
                }
                if($delivery < $total_buy){


                    $status = 1;

                }
            }else{

                $status = 1;
                $delivery = 0;
            }

        }


        // ## Calculo porcentaje de descuento
        if ($countdown > 0) {

            $countdown = $total_buy * $countdown / 100;
        }

        $payment = new Payment();

        $payment->client_id = $client_id;
        //$payment->sale_id = DB::table('sales')->latest()->first()->id;
        $payment->identificator_sale = $max_value;
        $payment->debt = $total_buy;
        $payment->payment = $delivery;
        $payment->countdown = $countdown ? number_format($countdown, 2, '.', '') : 0;
        $payment->date_payment = $date_sale;

        $payment->status = $status; // Si el cliente esta debiendo dinero se pone = 1, si esta al dia = 0

        $payment->save();

    }
}
