<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $attributes = [
        'description' => '',
        'price' => '0.00',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    protected $fillable = [
        'name',
        'description',
        'price',
    ];
}
