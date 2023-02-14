<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandProduct extends Model
{
    use HasFactory;

    protected $fillable = [

        'name',
        'status',
        'provider_id'
    ];

    // # Relac con Provider 1 a 1
    public function provider(){
        return $this->belongsTo(Provider::class);
    }
}


