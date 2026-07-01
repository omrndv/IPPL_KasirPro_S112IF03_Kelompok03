<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VoucherController extends Controller
{
    public function index()
    {
        $outletId = auth()->user()->outlet_id;
        $vouchers = Voucher::where('outlet_id', $outletId)->latest()->get();

        return view('voucher', compact('vouchers'));
    }

    public function store(Request $request)
    {
        $outletId = auth()->user()->outlet_id;

        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('vouchers', 'code')->where(function ($query) use ($outletId) {
                    return $query->where('outlet_id', $outletId);
                }),
            ],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:fixed,percent'],
            'value' => ['required', 'integer', 'min:1'],
            'min_purchase' => ['required', 'integer', 'min:0'],
        ]);

        Voucher::create(array_merge($validated, [
            'outlet_id' => $outletId,
            'is_active' => $request->has('is_active'),
        ]));

        return back()->with('success', 'Voucher berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $outletId = auth()->user()->outlet_id;
        $voucher = Voucher::where('outlet_id', $outletId)->findOrFail($id);

        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('vouchers', 'code')->ignore($id)->where(function ($query) use ($outletId) {
                    return $query->where('outlet_id', $outletId);
                }),
            ],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:fixed,percent'],
            'value' => ['required', 'integer', 'min:1'],
            'min_purchase' => ['required', 'integer', 'min:0'],
        ]);

        $voucher->update(array_merge($validated, [
            'is_active' => $request->has('is_active'),
        ]));

        return back()->with('success', 'Voucher berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $outletId = auth()->user()->outlet_id;
        $voucher = Voucher::where('outlet_id', $outletId)->findOrFail($id);
        $voucher->delete();

        return back()->with('success', 'Voucher berhasil dihapus.');
    }

    /**
     * API Cek Voucher untuk Halaman Transaksi Kasir
     */
    public function checkVoucher(Request $request)
    {
        $outletId = auth()->user()->outlet_id;

        $request->validate([
            'code'     => 'required|string',
            'subtotal' => 'required|integer|min:0',
        ]);

        $voucher = Voucher::where('outlet_id', $outletId)
            ->where('code', $request->code)
            ->where('is_active', true)
            ->first();

        if (!$voucher) {
            return response()->json([
                'success' => false,
                'message' => 'Kode voucher tidak ditemukan atau sudah tidak aktif.',
            ], 404);
        }

        if ($request->subtotal < $voucher->min_purchase) {
            return response()->json([
                'success' => false,
                'message' => 'Minimal belanja tidak mencukupi untuk menggunakan voucher ini. Min. belanja: Rp ' . number_format($voucher->min_purchase, 0, ',', '.'),
            ], 400);
        }

        // Calculate discount nominal
        $discountAmount = 0;
        if ($voucher->type === 'fixed') {
            $discountAmount = min($voucher->value, $request->subtotal);
        } else {
            $discountAmount = round($request->subtotal * ($voucher->value / 100));
        }

        return response()->json([
            'success'         => true,
            'code'            => $voucher->code,
            'name'            => $voucher->name,
            'type'            => $voucher->type,
            'value'           => $voucher->value,
            'discount_amount' => $discountAmount,
        ]);
    }
}
