<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function riwayat()
    {
        $outletId = auth()->user()->outlet_id;

        $transactions = Transaction::with('details')
            ->where('outlet_id', $outletId)
            ->latest()
            ->get();

        $settings = Setting::getAllAsArray();
        $outlet = auth()->user()->outlet;

        return view('riwayat', compact('transactions', 'settings', 'outlet'));
    }

    public function laporan(Request $request)
    {
        $outletId = auth()->user()->outlet_id;

        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        $pendapatan = Transaction::where('outlet_id', $outletId)
            ->whereBetween('created_at', [$start, $end])
            ->sum('subtotal');

        $pajak = Transaction::where('outlet_id', $outletId)
            ->whereBetween('created_at', [$start, $end])
            ->sum('tax');

        $hpp = DB::table('transaction_details')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->where('transactions.outlet_id', $outletId)
            ->whereBetween('transactions.created_at', [$start, $end])
            ->sum(DB::raw('products.cost_price * transaction_details.qty'));

        $labaBersih = $pendapatan - $hpp;

        $transactionsInRange = Transaction::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(subtotal) as total')
            )
            ->where('outlet_id', $outletId)
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $chartLabels = $transactionsInRange->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('d M');
        })->toArray();

        $chartData = $transactionsInRange->pluck('total')->toArray();

        $topProducts = DB::table('transaction_details')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->select(
                'product_name',
                DB::raw('SUM(qty) as total_qty'),
                DB::raw('SUM(transaction_details.subtotal) as total_revenue')
            )
            ->where('transactions.outlet_id', $outletId)
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

    public function exportCsv(Request $request)
    {
        $outletId = auth()->user()->outlet_id;

        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        $transactions = Transaction::where('outlet_id', $outletId)
            ->whereBetween('created_at', [$start, $end])
            ->latest()
            ->get();

        $filename = "Laporan_KasirPro_{$startDate}_sampai_{$endDate}.csv";

        $handle = fopen('php://output', 'w');

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        fputcsv($handle, [
            'Invoice No',
            'Tanggal Transaksi',
            'Metode Pembayaran',
            'Omzet / Subtotal (Rp)',
            'Pajak (Rp)',
            'Modal / HPP (Rp)',
            'Laba Bersih (Rp)'
        ]);

        foreach ($transactions as $trx) {
            $hppTrx = DB::table('transaction_details')
                ->join('products', 'transaction_details.product_id', '=', 'products.id')
                ->where('transaction_details.transaction_id', $trx->id)
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