<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = [

        'name',
        'cuit',
        'address',
        'city',
        'phone',
        'email',
        'status',

    ];

    // # Relacion de uno a muchos
    public function products(){
        return $this->hasMany(Product::class);
    }

    // # Relacion de uno a muchos
    public function brandProduct(){
        return $this->hasMany(BrandProduct::class);
    }
}
