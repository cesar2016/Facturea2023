<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [

        'client_id',
        'identificator_sale',
        'debt',
        'payment',
        'countdown',
        'data_payment',
        'status',

    ];

    // # Relac con cliente 1 a 1
    public function client(){
        return $this->belongsTo(Client::class);
    }


}
