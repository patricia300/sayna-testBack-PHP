<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'date_payment',
        'montant_ht',
        'montant_ttc',
        'source',
        'id_stripe'
    ];

    protected $attributes = [
        "source" => 'Stripe'
    ];
}
