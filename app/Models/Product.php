<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'sku',
        'name',
        'unit',
        'cost_price',
        'selling_price',
        'stock',
        'is_stock_tracked',
        'image',
    ];

    // Relasi: Satu Produk milik Satu Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
