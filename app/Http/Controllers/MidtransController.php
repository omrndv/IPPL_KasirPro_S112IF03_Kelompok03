<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    protected MidtransService $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Handle notification/webhook dari server Midtrans.
     * Endpoint ini harus dikecualikan dari CSRF verification.
     */
    public function notification(Request $request)
    {
        Log::info('Midtrans webhook received', $request->all());

        $result = $this->midtransService->handleNotification();

        if (!$result['valid']) {
            Log::warning('Midtrans: Invalid notification received', $result);
            return response()->json(['message' => 'Invalid notification'], 400);
        }

        $orderId       = $result['order_id'];
        $paymentStatus = $result['payment_status'];

        $transaction = Transaction::where('midtrans_order_id', $orderId)->first();

        if (!$transaction) {
            Log::error("Midtrans: Transaction not found for order_id: {$orderId}");
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // Skip jika sudah paid (idempotent)
        if ($transaction->payment_status === 'paid') {
            return response()->json(['message' => 'Already paid']);
        }

        // Update payment status
        $transaction->payment_status = $paymentStatus;
        $transaction->save();

        // Jika gagal/cancel setelah pending → kembalikan stok
        if (in_array($paymentStatus, ['failed', 'cancelled'])) {
            $this->restoreStock($transaction);
            Log::info("Midtrans: Transaction {$orderId} {$paymentStatus}, stock restored.");
        }

        if ($paymentStatus === 'paid') {
            Log::info("Midtrans: Transaction {$orderId} PAID successfully.");
        }

        return response()->json(['message' => 'OK']);
    }

    /**
     * Kembalikan stok produk jika transaksi Midtrans gagal/dibatalkan.
     */
    private function restoreStock(Transaction $transaction): void
    {
        $transaction->load('details.product');

        foreach ($transaction->details as $detail) {
            $product = $detail->product;
            if ($product && $product->is_stock_tracked) {
                $product->stock += $detail->qty;
                $product->save();
            }
        }
    }
}
