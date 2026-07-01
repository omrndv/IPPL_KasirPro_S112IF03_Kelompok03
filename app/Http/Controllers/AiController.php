<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Services\GeminiService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AiController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    /**
     * Handle the AJAX request from the dashboard AI Chat Widget.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message'           => 'required|string|max:1000',
            'history'           => 'nullable|array',
            'history.*.role'    => 'required|in:user,model',
            'history.*.content' => 'required|string',
        ]);

        $userMessage = $request->input('message');
        $history     = $request->input('history', []);
        $user        = auth()->user();
        $outlet      = $user->outlet ?? null;
        $outletId    = $user->outlet_id;
        $outletName  = $outlet->name ?? 'Outlet Kami';

        // ── DATE RANGES ──────────────────────────────────────────────────────
        $now              = Carbon::now();
        $today            = Carbon::today();
        $startOfMonth     = $now->copy()->startOfMonth();
        $endOfMonth       = $now->copy()->endOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth   = $now->copy()->subMonth()->endOfMonth();
        $sevenDaysAgo     = $today->copy()->subDays(6);

        $dateLabel      = $now->translatedFormat('l, d F Y');
        $monthLabel     = $now->translatedFormat('F Y');
        $lastMonthLabel = $now->copy()->subMonth()->translatedFormat('F Y');

        // ── THIS MONTH ───────────────────────────────────────────────────────
        $totalTransactions = Transaction::where('outlet_id', $outletId)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        $totalRevenue = (float) Transaction::where('outlet_id', $outletId)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('grand_total');

        $totalHpp = TransactionDetail::whereHas('transaction', fn ($q) =>
                $q->where('outlet_id', $outletId)->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            )
            ->with('product')
            ->get()
            ->sum(fn ($d) => optional($d->product)->cost_price * $d->qty);

        $netProfit    = $totalRevenue - $totalHpp;
        $profitMargin = $totalRevenue > 0 ? round(($netProfit / $totalRevenue) * 100, 1) : 0;

        // ── LAST MONTH ───────────────────────────────────────────────────────
        $lastMonthRevenue = (float) Transaction::where('outlet_id', $outletId)
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->sum('grand_total');

        $lastMonthTrx = Transaction::where('outlet_id', $outletId)
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->count();

        $revenueGrowth = $lastMonthRevenue > 0
            ? round((($totalRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1)
            : ($totalRevenue > 0 ? 100 : 0);

        $growthSign  = $revenueGrowth >= 0 ? '+' : '';
        $growthLabel = "{$growthSign}{$revenueGrowth}% vs {$lastMonthLabel}";

        // ── TODAY ────────────────────────────────────────────────────────────
        $todayRevenue = (float) Transaction::where('outlet_id', $outletId)
            ->whereDate('created_at', $today)
            ->sum('grand_total');

        $todayTransactions = Transaction::where('outlet_id', $outletId)
            ->whereDate('created_at', $today)
            ->count();

        // ── 7-DAY TREND ──────────────────────────────────────────────────────
        $weeklyData = Transaction::select(
                DB::raw('DATE(created_at) as trx_date'),
                DB::raw('SUM(grand_total) as daily_revenue'),
                DB::raw('COUNT(*) as daily_trx')
            )
            ->where('outlet_id', $outletId)
            ->whereBetween('created_at', [$sevenDaysAgo->copy()->startOfDay(), $now])
            ->groupBy('trx_date')
            ->orderBy('trx_date')
            ->get();

        $weeklyLines = $weeklyData->map(fn ($d) =>
            Carbon::parse($d->trx_date)->translatedFormat('D, d M') .
            ': Rp ' . number_format($d->daily_revenue, 0, ',', '.') .
            " ({$d->daily_trx} trx)"
        );
        $weeklyFormatted = $weeklyLines->isNotEmpty()
            ? $weeklyLines->implode("\n")
            : '- Belum ada data 7 hari terakhir.';

        // ── TOP PRODUCTS ─────────────────────────────────────────────────────
        $topProducts = TransactionDetail::select(
                'product_name',
                DB::raw('SUM(qty) as total_qty'),
                DB::raw('SUM(subtotal) as total_revenue')
            )
            ->whereHas('transaction', fn ($q) =>
                $q->where('outlet_id', $outletId)->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            )
            ->groupBy('product_name')
            ->orderByDesc('total_revenue')
            ->take(7)
            ->get();

        $topProductsFormatted = $topProducts->isNotEmpty()
            ? $topProducts->map(fn ($item, $i) =>
                ($i + 1) . ". {$item->product_name} — {$item->total_qty} terjual, Omzet Rp " .
                number_format($item->total_revenue, 0, ',', '.')
              )->implode("\n")
            : '- Belum ada produk terjual bulan ini.';

        // ── PAYMENT METHODS ───────────────────────────────────────────────────
        $paymentLines = Transaction::select('payment_method', DB::raw('COUNT(*) as total'))
            ->where('outlet_id', $outletId)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->groupBy('payment_method')
            ->get()
            ->map(fn ($p) => strtoupper($p->payment_method) . ": {$p->total} transaksi");

        $paymentStatsText = $paymentLines->isNotEmpty() ? $paymentLines->implode(', ') : 'Belum ada data';

        // ── STOCK STATUS ──────────────────────────────────────────────────────
        $totalProducts      = Product::where('outlet_id', $outletId)->count();
        $outOfStockCount    = Product::where('outlet_id', $outletId)->where('stock', 0)->count();
        $lowStockProducts   = Product::where('outlet_id', $outletId)->where('stock', '>', 0)->where('stock', '<=', 5)->get(['name', 'stock']);

        $lowStockFormatted = $lowStockProducts->isNotEmpty()
            ? $lowStockProducts->map(fn ($p) => "  - {$p->name} (sisa: {$p->stock} pcs)")->implode("\n")
            : '  - Semua stok produk aman (> 5 pcs).';

        // ── TARGET SALES METADATA ─────────────────────────────────────────────
        $targetSales = (float) \App\Models\Setting::getValue('target_sales', 0);
        $totalDaysInMonth = Carbon::now()->daysInMonth;
        $currentDay = Carbon::now()->day;
        $remainingDays = max($totalDaysInMonth - $currentDay, 1);
        $daysElapsed = max($currentDay, 1);
        $salesVelocity = $totalRevenue / $daysElapsed;
        $projectedRevenue = $salesVelocity * $totalDaysInMonth;
        $targetProgress = $targetSales > 0 ? min(round(($totalRevenue / $targetSales) * 100), 100) : 0;
        
        $targetSalesText = $targetSales > 0 
            ? "Target Bulanan: Rp " . number_format($targetSales, 0, ',', '.') . " | Progres: {$targetProgress}% | Proyeksi Akhir Bulan: Rp " . number_format($projectedRevenue, 0, ',', '.') . " (" . ($projectedRevenue >= $targetSales ? 'On Track / Aman' : 'Meleset / Butuh Upaya') . ") | Sisa Waktu: {$remainingDays} hari"
            : "Target Bulanan belum diatur oleh pengguna.";

        // ── FORMAT CURRENCY ───────────────────────────────────────────────────
        $fmtTodayRevenue  = 'Rp ' . number_format($todayRevenue, 0, ',', '.');
        $fmtRevenue       = 'Rp ' . number_format($totalRevenue, 0, ',', '.');
        $fmtHpp           = 'Rp ' . number_format($totalHpp, 0, ',', '.');
        $fmtProfit        = 'Rp ' . number_format($netProfit, 0, ',', '.');
        $fmtLastRevenue   = 'Rp ' . number_format($lastMonthRevenue, 0, ',', '.');

        // ── SYSTEM PROMPT ─────────────────────────────────────────────────────
        $systemPrompt = "Anda adalah **KasirPro AI** — analis bisnis & konsultan strategi penjualan canggih untuk outlet **\"{$outletName}\"** yang menggunakan sistem KasirPro POS.\n\n"
            . "Anda bukan sekadar chatbot biasa. Anda adalah rekan kerja cerdas yang memahami data bisnis outlet secara mendalam dan mampu memberikan insight tajam, rekomendasi konkret, dan analisis strategis layaknya seorang senior business consultant.\n\n"
            . "━━━━━━━━━━━━━━━━━━━━━━━━━━━\n"
            . "📊 DATA REAL-TIME OUTLET — {$dateLabel}\n"
            . "━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n"
            . "🎯 TARGET PENJUALAN BULAN INI:\n"
            . "  - {$targetSalesText}\n\n"
            . "🔴 HARI INI:\n"
            . "  - Transaksi    : {$todayTransactions} kali\n"
            . "  - Pendapatan   : {$fmtTodayRevenue}\n\n"
            . "📅 BULAN INI ({$monthLabel}):\n"
            . "  - Total Transaksi       : {$totalTransactions} kali (bln lalu: {$lastMonthTrx} kali)\n"
            . "  - Total Omzet           : {$fmtRevenue}\n"
            . "  - Omzet Bulan Lalu      : {$fmtLastRevenue}\n"
            . "  - Pertumbuhan Omzet     : {$growthLabel}\n"
            . "  - Total HPP/Modal       : {$fmtHpp}\n"
            . "  - Laba Bersih           : {$fmtProfit} (margin {$profitMargin}%)\n\n"
            . "💳 METODE PEMBAYARAN (bulan ini): {$paymentStatsText}\n\n"
            . "📦 STOK PRODUK:\n"
            . "  - Total produk terdaftar : {$totalProducts}\n"
            . "  - Produk stok habis (0)  : {$outOfStockCount}\n"
            . "  - Produk stok menipis (1-5 pcs):\n{$lowStockFormatted}\n\n"
            . "🏆 TOP 7 PRODUK TERLARIS (bulan ini):\n{$topProductsFormatted}\n\n"
            . "📈 TREN PENDAPATAN 7 HARI TERAKHIR:\n{$weeklyFormatted}\n\n"
            . "━━━━━━━━━━━━━━━━━━━━━━━━━━━\n"
            . "PANDUAN MENJAWAB:\n"
            . "━━━━━━━━━━━━━━━━━━━━━━━━━━━\n"
            . "1. Selalu gunakan data di atas sebagai landasan jawaban. Jangan mengarang angka.\n"
            . "2. Berikan jawaban yang TAJAM, SPESIFIK, dan ACTIONABLE — bukan jawaban generik.\n"
            . "3. Gunakan format markdown: **bold**, bullet list, ### heading jika diperlukan.\n"
            . "4. Jika pertanyaan soal promo/strategi → sebutkan nama produk spesifik dari data.\n"
            . "5. Jika ada stok menipis/habis → proaktif ingatkan dalam jawaban yang relevan.\n"
            . "6. Nada bicara: profesional, hangat, dan supportif seperti konsultan yang peduli.\n"
            . "7. Jawab dalam Bahasa Indonesia yang lugas, tidak bertele-tele, langsung ke inti.\n"
            . "8. Jika pertanyaan di luar konteks bisnis → tolak sopan dan kembalikan ke topik bisnis.\n"
            . "9. Proaktif berikan insight/peringatan menarik jika melihat anomali dari data (mis. penurunan drastis, stok kritis).";

        // ── SEND TO GEMINI ────────────────────────────────────────────────────
        $aiResponse = $this->geminiService->generateResponse($userMessage, $systemPrompt, $history);

        return response()->json([
            'success' => true,
            'reply'   => $aiResponse,
        ]);
    }
}
