<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    // 1. Halaman Riwayat Invoice
    public function riwayat()
    {
        $transactions = Transaction::with('details.product')->latest()->get();
        return view('riwayat', compact('transactions'));
    }

    // 2. Halaman Laba & Rugi (DENGAN FILTER RENTANG TANGGAL)
    public function laporan(Request $request)
    {
        // Default: Dari awal bulan ini, sampai hari ini
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Konversi ke format jam agar mencakup 1 hari penuh (00:00:00 - 23:59:59)
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        // A. Total Pendapatan Kotor
        $pendapatan = Transaction::whereBetween('created_at', [$start, $end])->sum('subtotal');

        // B. Total Pajak Terkumpul
        $pajak = Transaction::whereBetween('created_at', [$start, $end])->sum('tax');

        // C. Menghitung HPP (Modal Barang)
        $hpp = DB::table('transaction_details')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->whereBetween('transactions.created_at', [$start, $end])
            ->sum(DB::raw('products.cost_price * transaction_details.qty'));

        // D. Laba Bersih
        $labaBersih = $pendapatan - $hpp;

        // E. Data Grafik (Rekap Harian dalam rentang tanggal)
        $transactionsInRange = Transaction::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(subtotal) as total'))
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $chartLabels = $transactionsInRange->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('d M');
        })->toArray();
        $chartData = $transactionsInRange->pluck('total')->toArray();

        // F. Produk Terlaris
        $topProducts = DB::table('transaction_details')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->select('product_name', DB::raw('SUM(qty) as total_qty'), DB::raw('SUM(transaction_details.subtotal) as total_revenue'))
            ->whereBetween('transactions.created_at', [$start, $end])
            ->groupBy('product_name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        return view('laporan', compact(
            'pendapatan',
            'pajak',
            'hpp',
            'labaBersih',
            'chartLabels',
            'chartData',
            'topProducts',
            'startDate',
            'endDate'
        ));
    }

    // 3. Fungsi EXPORT CSV (DENGAN RENTANG TANGGAL)
    public function exportCsv(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        $transactions = Transaction::whereBetween('created_at', [$start, $end])->get();

        $filename = "Laporan_KasirPro_{$startDate}_sampai_{$endDate}.csv";

        $handle = fopen('php://output', 'w');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Header Kolom Excel
        fputcsv($handle, ['Invoice No', 'Tanggal Transaksi', 'Metode Pembayaran', 'Omzet / Subtotal (Rp)', 'Pajak (Rp)', 'Modal / HPP (Rp)', 'Laba Bersih (Rp)']);

        foreach ($transactions as $trx) {
            $hppTrx = DB::table('transaction_details')
                ->join('products', 'transaction_details.product_id', '=', 'products.id')
                ->where('transaction_id', $trx->id)
                ->sum(DB::raw('products.cost_price * transaction_details.qty'));

            fputcsv($handle, [
                $trx->invoice_no,
                $trx->created_at->format('Y-m-d H:i:s'),
                strtoupper($trx->payment_method),
                $trx->subtotal,
                $trx->tax,
                $hppTrx,
                $trx->subtotal - $hppTrx
            ]);
        }
        fclose($handle);
        exit;
    }
}
