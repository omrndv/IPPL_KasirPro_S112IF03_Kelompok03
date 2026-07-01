<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $outletId = auth()->user()->outlet_id;

        $today = Carbon::today();

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();

        $totalTransactions = Transaction::where('outlet_id', $outletId)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        $lastMonthTransactions = Transaction::where('outlet_id', $outletId)
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->count();

        $totalRevenue = (float) Transaction::where('outlet_id', $outletId)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('grand_total');

        $lastMonthRevenue = Transaction::where('outlet_id', $outletId)
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->sum('grand_total');

        // Target Sales & Projections
        $targetSales = (float) Setting::getValue('target_sales', 0);
        
        $totalDaysInMonth = Carbon::now()->daysInMonth;
        $currentDay = Carbon::now()->day;
        $remainingDays = max($totalDaysInMonth - $currentDay, 1);
        
        // Sales velocity: revenue per day elapsed
        $daysElapsed = max($currentDay, 1);
        $salesVelocity = $totalRevenue / $daysElapsed;
        
        // Project revenue to end of month
        $projectedRevenue = $salesVelocity * $totalDaysInMonth;
        
        $targetProgress = $targetSales > 0 ? min(round(($totalRevenue / $targetSales) * 100), 100) : 0;
        
        // Calculate status
        if ($targetSales <= 0) {
            $targetStatus = 'Belum Diatur';
            $targetStatusColor = 'text-slate-500 bg-slate-50 border-slate-100';
        } elseif ($projectedRevenue >= $targetSales) {
            $targetStatus = 'On Track (Aman)';
            $targetStatusColor = 'text-emerald-700 bg-emerald-50 border-emerald-100';
        } else {
            $targetStatus = 'Meleset (Butuh Upaya)';
            $targetStatusColor = 'text-rose-700 bg-rose-50 border-rose-100';
        }

        $totalHpp = TransactionDetail::whereHas('transaction', function ($query) use ($startOfMonth, $endOfMonth, $outletId) {
                $query->where('outlet_id', $outletId)
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
            })
            ->with('product')
            ->get()
            ->sum(function ($detail) {
                return optional($detail->product)->cost_price * $detail->qty;
            });

        $netProfit = $totalRevenue - $totalHpp;

        $profitMargin = $totalRevenue > 0
            ? ($netProfit / $totalRevenue) * 100
            : 0;

        $transactionGrowth = $this->calculateGrowth($totalTransactions, $lastMonthTransactions);
        $revenueGrowth = $this->calculateGrowth($totalRevenue, $lastMonthRevenue);

        $salesChart = collect(range(6, 0))->map(function ($day) use ($outletId) {
            $date = Carbon::today()->subDays($day);

            return [
                'label' => $date->format('D'),
                'value' => Transaction::where('outlet_id', $outletId)
                    ->whereDate('created_at', $date)
                    ->sum('grand_total'),
            ];
        });

        $maxChartValue = max($salesChart->max('value'), 1);

        $topProducts = TransactionDetail::select(
                'product_name',
                DB::raw('SUM(qty) as total_qty'),
                DB::raw('SUM(subtotal) as total_revenue')
            )
            ->whereHas('transaction', function ($query) use ($startOfMonth, $endOfMonth, $outletId) {
                $query->where('outlet_id', $outletId)
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
            })
            ->groupBy('product_name')
            ->orderByDesc('total_revenue')
            ->take(3)
            ->get();

        $paymentMethods = Transaction::select('payment_method', DB::raw('COUNT(*) as total'))
            ->where('outlet_id', $outletId)
            ->whereDate('created_at', $today)
            ->groupBy('payment_method')
            ->get();

        $totalPaymentToday = max($paymentMethods->sum('total'), 1);

        $paymentStats = collect(['qris', 'cash', 'card'])->map(function ($method) use ($paymentMethods, $totalPaymentToday) {
            $total = optional($paymentMethods->firstWhere('payment_method', $method))->total ?? 0;

            return [
                'method' => strtoupper($method),
                'total' => $total,
                'percentage' => round(($total / $totalPaymentToday) * 100),
            ];
        });

        $recentTransactions = Transaction::with('details')
            ->where('outlet_id', $outletId)
            ->latest()
            ->take(3)
            ->get();

        $totalProducts = Product::where('outlet_id', $outletId)->count();

        $lowStockProducts = Product::where('outlet_id', $outletId)
            ->where('stock', '<=', 5)
            ->count();

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
            'lowStockProducts',
            'targetSales',
            'remainingDays',
            'projectedRevenue',
            'targetProgress',
            'targetStatus',
            'targetStatusColor'
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