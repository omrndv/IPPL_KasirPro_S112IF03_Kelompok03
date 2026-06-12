<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'outlet_id',
        'name',
        'description',
    ];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    // Relasi: Satu Kategori punya Banyak Produk
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
