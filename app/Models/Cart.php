<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'cartNumber',
        'month',
        'year',
        'default'
    ];

    protected $attributes = [
        'user_id' => null,
        'cartNumber' => null,
        'month' => null,
        'year' => null,
        'default' => null
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
