<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$clientKey    = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');
    }

    /**
     * Buat Snap token untuk transaksi yang diberikan.
     * Token ini digunakan frontend untuk membuka popup Midtrans.
     */
    public function createSnapToken(Transaction $transaction, array $customerDetails = []): array
    {
        $params = [
            'transaction_details' => [
                'order_id'     => $transaction->midtrans_order_id,
                'gross_amount' => (int) $transaction->grand_total,
            ],
            'item_details' => $this->buildItemDetails($transaction),
            'customer_details' => array_merge([
                'first_name' => 'Pelanggan',
                'email'      => 'customer@kasirpro.com',
                'phone'      => '08000000000',
            ], $customerDetails),
            'enabled_payments' => [
                'qris',
                'gopay',
                'shopeepay',
                'other_qris',
                'bank_transfer',
                'bca_va',
                'bni_va',
                'bri_va',
                'permata_va',
                'mandiri_bill',
                'alfamart',
                'indomaret',
            ],
            'expiry' => [
                'start_time' => now()->format('Y-m-d H:i:s O'),
                'unit'       => 'minutes',
                'duration'   => 30,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return ['success' => true, 'token' => $snapToken];
        } catch (\Exception $e) {
            Log::error('Midtrans createSnapToken error: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Verifikasi dan parse notification/callback dari Midtrans.
     * Kembalikan array berisi order_id, transaction_status, fraud_status.
     */
    public function handleNotification(): array
    {
        try {
            $notification = new Notification();

            $orderId           = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus       = $notification->fraud_status ?? 'accept';
            $signatureKey      = $notification->signature_key;

            // Verifikasi signature key
            $serverKey     = config('midtrans.server_key');
            $statusCode    = $notification->status_code;
            $grossAmount   = $notification->gross_amount;
            $expectedSig   = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

            if ($signatureKey !== $expectedSig) {
                Log::warning('Midtrans: Invalid signature key for order ' . $orderId);
                return ['valid' => false, 'order_id' => $orderId];
            }

            $paymentStatus = $this->resolvePaymentStatus($transactionStatus, $fraudStatus);

            return [
                'valid'             => true,
                'order_id'          => $orderId,
                'transaction_status'=> $transactionStatus,
                'fraud_status'      => $fraudStatus,
                'payment_status'    => $paymentStatus,
            ];
        } catch (\Exception $e) {
            Log::error('Midtrans handleNotification error: ' . $e->getMessage());
            return ['valid' => false, 'order_id' => null];
        }
    }

    /**
     * Mapping status Midtrans → payment_status kolom DB.
     */
    private function resolvePaymentStatus(string $transactionStatus, string $fraudStatus): string
    {
        if ($transactionStatus === 'capture') {
            return $fraudStatus === 'accept' ? 'paid' : 'failed';
        }

        return match ($transactionStatus) {
            'settlement' => 'paid',
            'pending'    => 'pending',
            'deny', 'expire', 'failure' => 'failed',
            'cancel'     => 'cancelled',
            default      => 'pending',
        };
    }

    /**
     * Build item_details dari transaction details.
     */
    private function buildItemDetails(Transaction $transaction): array
    {
        $items = [];

        foreach ($transaction->details as $detail) {
            $items[] = [
                'id'       => (string) $detail->product_id,
                'price'    => (int) $detail->price,
                'quantity' => (int) $detail->qty,
                'name'     => substr($detail->product_name, 0, 50), // Midtrans max 50 chars
            ];
        }

        // Tambah tax sebagai item jika ada
        if ($transaction->tax > 0) {
            $items[] = [
                'id'       => 'TAX',
                'price'    => (int) $transaction->tax,
                'quantity' => 1,
                'name'     => 'Pajak',
            ];
        }

        return $items;
    }
}
