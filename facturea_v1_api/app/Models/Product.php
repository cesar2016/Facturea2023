<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [

        'code',
        'name',
        'stock',
        'price_purchase',
        'price_sale',
        'status',
        'date_purchase',
        'category_id',
        'brand_product_id'

    ];

    // # Relac con categori 1 a 1
    public function category(){
        return $this->belongsTo(Category::class);
    }

    // # Relac con brandproduct 1 a 1
    public function brandProduct(){
        return $this->belongsTo(BrandProduct::class);
    }

    // # Relac con Provider 1 a 1
    public function provider(){
        return $this->belongsTo(Provider::class);
    }
}
