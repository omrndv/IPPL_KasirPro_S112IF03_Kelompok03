<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'outlet_id',
        'name',
        'category',
        'stock',
        'min_stock',
        'unit',
        'price_per_unit',
    ];
}