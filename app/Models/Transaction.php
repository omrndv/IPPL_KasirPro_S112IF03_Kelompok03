<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'outlet_id',
        'invoice_no',
        'subtotal',
        'tax',
        'grand_total',
        'payment_method',
        'pay_amount',
        'return_amount',
    ];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    // Relasi 1 Struk punya Banyak Detail
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
