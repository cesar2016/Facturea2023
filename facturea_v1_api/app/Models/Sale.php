<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [

        'indentificator_sale',
        'date_sale',
        'cuantity',
        'unit_price',
        'total_price',
        'type_sale_id',
        'data_purchase',
        'client_id',
        'product_id',
        'status'
    ];

    // # Relac con Client 1 a 1
    public function client(){
        return $this->belongsTo(Client::class);
    }

    // # Relac con product 1 a 1
    public function product(){
      return $this->belongsTo(Product::class);
    }
}
