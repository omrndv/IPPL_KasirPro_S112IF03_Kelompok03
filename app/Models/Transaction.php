<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'outlet_id',
        'invoice_no',
        'midtrans_order_id',
        'midtrans_snap_token',
        'payment_status',
        'subtotal',
        'discount',
        'tax',
        'grand_total',
        'payment_method',
        'pay_amount',
        'return_amount',
    ];

    protected $casts = [
        'payment_status' => 'string',
        'subtotal'       => 'integer',
        'discount'       => 'integer',
        'tax'            => 'integer',
        'grand_total'    => 'integer',
        'pay_amount'     => 'integer',
        'return_amount'  => 'integer',
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

    /**
     * Cek apakah transaksi sudah dibayar.
     */
    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Cek apakah transaksi menggunakan Midtrans.
     */
    public function isMidtrans(): bool
    {
        return $this->payment_method === 'midtrans';
    }
}
