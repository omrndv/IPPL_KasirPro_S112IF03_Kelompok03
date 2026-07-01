<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'outlet_id',
        'code',
        'name',
        'type',
        'value',
        'min_purchase',
        'is_active',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'value'        => 'integer',
        'min_purchase' => 'integer',
    ];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }
}
