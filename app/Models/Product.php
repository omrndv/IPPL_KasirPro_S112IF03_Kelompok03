<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'outlet_id',
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

    protected $casts = [
        'is_stock_tracked' => 'boolean',
        'cost_price' => 'integer',
        'selling_price' => 'integer',
        'stock' => 'integer',
    ];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    // Relasi: Satu Produk milik Satu Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
