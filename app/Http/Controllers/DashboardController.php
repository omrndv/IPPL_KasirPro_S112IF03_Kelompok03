<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();

        $totalTransactions = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $lastMonthTransactions = Transaction::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();

        $totalRevenue = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('grand_total');
        $lastMonthRevenue = Transaction::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->sum('grand_total');

        $totalHpp = TransactionDetail::whereHas('transaction', function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
        })
            ->with('product')
            ->get()
            ->sum(function ($detail) {
                return optional($detail->product)->cost_price * $detail->qty;
            });

        $netProfit = $totalRevenue - $totalHpp;
        $profitMargin = $totalRevenue > 0 ? ($netProfit / $totalRevenue) * 100 : 0;

        $transactionGrowth = $this->calculateGrowth($totalTransactions, $lastMonthTransactions);
        $revenueGrowth = $this->calculateGrowth($totalRevenue, $lastMonthRevenue);

        $salesChart = collect(range(6, 0))->map(function ($day) {
            $date = Carbon::today()->subDays($day);

            return [
                'label' => $date->format('D'),
                'value' => Transaction::whereDate('created_at', $date)->sum('grand_total'),
            ];
        });

        $maxChartValue = max($salesChart->max('value'), 1);

        $topProducts = TransactionDetail::select(
            'product_name',
            DB::raw('SUM(qty) as total_qty'),
            DB::raw('SUM(subtotal) as total_revenue')
        )
            ->whereHas('transaction', function ($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
            })
            ->groupBy('product_name')
            ->orderByDesc('total_revenue')
            ->take(3)
            ->get();

        $paymentMethods = Transaction::select('payment_method', DB::raw('COUNT(*) as total'))
            ->whereDate('created_at', $today)
            ->groupBy('payment_method')
            ->get();

        $totalPaymentToday = max($paymentMethods->sum('total'), 1);

        $paymentStats = collect(['qris', 'cash', 'card'])->map(function ($method) use ($paymentMethods, $totalPaymentToday) {
            $total = $paymentMethods->firstWhere('payment_method', $method)->total ?? 0;

            return [
                'method' => strtoupper($method),
                'total' => $total,
                'percentage' => round(($total / $totalPaymentToday) * 100),
            ];
        });

        $recentTransactions = Transaction::with('details')
            ->latest()
            ->take(3)
            ->get();

        $totalProducts = Product::count();
        $lowStockProducts = Product::where('stock', '<=', 5)->count();

        return view('dashboard', compact(
            'totalTransactions',
            'totalRevenue',
            'netProfit',
            'profitMargin',
            'transactionGrowth',
            'revenueGrowth',
            'salesChart',
            'maxChartValue',
            'topProducts',
            'paymentStats',
            'recentTransactions',
            'totalProducts',
            'lowStockProducts'
        ));
    }

    private function calculateGrowth(float|int $current, float|int $previous): float
    {
        if ($previous <= 0) {
            return $current > 0 ? 100 : 0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }
}
