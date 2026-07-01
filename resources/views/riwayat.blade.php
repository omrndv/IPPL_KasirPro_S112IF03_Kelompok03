@extends('layouts.app')

@section('content')
    @php
        $storeName = $settings['store_name'] ?? 'KasirPro';
        $storePhone = $settings['store_phone'] ?? '-';
        $storeAddress = $settings['store_address'] ?? 'Alamat toko belum diatur';
        $taxRate = $settings['tax_rate'] ?? 10;
        $receiptFooter = $settings['receipt_footer'] ?? 'Terima kasih atas kunjungannya!';
    @endphp

    <div class="space-y-6">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1 text-xs font-black uppercase tracking-[0.18em] text-blue-700">
                    <span class="h-2 w-2 rounded-full bg-blue-600"></span>
                    Invoice history
                </div>
                <h1 class="text-3xl font-black tracking-tight text-slate-950 md:text-4xl">Riwayat Invoice</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">Pantau seluruh riwayat transaksi kasir, metode pembayaran, pajak, total penjualan, dan cetak ulang struk pelanggan.</p>
            </div>

            <button class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-black text-slate-600 shadow-sm transition hover:-translate-y-0.5 hover:bg-slate-50 hover:text-slate-950">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export PDF
            </button>
        </div>

        @if (session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800" role="alert">
            <span class="font-black">Berhasil!</span> {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800" role="alert">
            <span class="font-black">Gagal!</span> {{ session('error') }}
        </div>
        @endif

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="group relative overflow-hidden rounded-[2rem] border border-slate-900 bg-slate-950 p-6 text-white shadow-xl shadow-slate-900/10 transition hover:-translate-y-1 hover:shadow-2xl hover:shadow-blue-600/20">
                <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-blue-500/30 blur-2xl transition group-hover:scale-125"></div>
                <div class="relative">
                    <div class="mb-5 flex items-center justify-between">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 text-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-black text-blue-100">Today</span>
                    </div>
                    <p class="text-sm font-bold text-slate-400">Transaksi Hari Ini</p>
                    <div class="mt-2 flex items-end gap-2">
                        <h3 class="text-4xl font-black tracking-tight">{{ $transactions->where('created_at', '>=', \Carbon\Carbon::today())->count() }}</h3>
                        <span class="mb-1 text-sm font-bold text-slate-400">Struk</span>
                    </div>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-[2rem] border border-white/80 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/70">
                <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-emerald-100/70 transition group-hover:scale-125"></div>
                <div class="relative">
                    <div class="mb-5 flex items-center justify-between">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-black text-emerald-600">Revenue</span>
                    </div>
                    <p class="text-sm font-bold text-slate-400">Pendapatan Hari Ini</p>
                    <h3 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Rp {{ number_format($transactions->where('created_at', '>=', \Carbon\Carbon::today())->sum('grand_total'), 0, ',', '.') }}</h3>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-[2rem] border border-white/80 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/70">
                <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-blue-100/70 transition group-hover:scale-125"></div>
                <div class="relative">
                    <div class="mb-5 flex items-center justify-between">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                            </svg>
                        </div>
                        <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-black text-blue-600">Tax</span>
                    </div>
                    <p class="text-sm font-bold text-slate-400">Pajak Terkumpul</p>
                    <h3 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Rp {{ number_format($transactions->where('created_at', '>=', \Carbon\Carbon::today())->sum('tax'), 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-[2rem] border border-white/80 bg-white shadow-sm">
            <div class="border-b border-slate-100 p-5">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-black text-slate-950">Daftar Invoice</h2>
                        <p class="mt-1 text-sm font-semibold text-slate-400">Riwayat transaksi terbaru yang tercatat di sistem.</p>
                    </div>
                    <span class="w-fit rounded-full bg-slate-50 px-3 py-1 text-xs font-black text-slate-500">{{ $transactions->count() }} transaksi</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[980px] text-left text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50 text-xs uppercase tracking-[0.14em] text-slate-400">
                            <th class="px-6 py-4 font-black">Invoice / Tanggal</th>
                            <th class="px-6 py-4 text-center font-black">Item Terjual</th>
                            <th class="px-6 py-4 text-right font-black">Subtotal</th>
                            <th class="px-6 py-4 text-right font-black">Tax</th>
                            <th class="px-6 py-4 text-right font-black">Total Akhir</th>
                            <th class="px-6 py-4 text-center font-black">Metode</th>
                            <th class="px-6 py-4 text-center font-black">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($transactions as $trx)
                            <tr class="bg-white transition hover:bg-slate-50/80">
                                <td class="px-6 py-4">
                                    <div class="font-black text-blue-600">{{ $trx->invoice_no }}</div>
                                    <div class="mt-1 text-xs font-semibold text-slate-400">{{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y, H:i') }} WIB</div>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-black text-slate-600">{{ $trx->details->sum('qty') }} Produk</span>
                                </td>

                                <td class="px-6 py-4 text-right font-bold text-slate-500">Rp {{ number_format($trx->subtotal, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-right font-bold text-slate-500">Rp {{ number_format($trx->tax, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-right text-base font-black text-slate-950">Rp {{ number_format($trx->grand_total, 0, ',', '.') }}</td>

                                <td class="px-6 py-4 text-center">
                                    @if (strtolower($trx->payment_method) == 'cash')
                                        <span class="mx-auto block w-max rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-black uppercase text-emerald-600">Cash</span>
                                    @elseif(strtolower($trx->payment_method) == 'qris')
                                        <span class="mx-auto block w-max rounded-full border border-orange-200 bg-orange-50 px-3 py-1 text-xs font-black uppercase text-orange-600">QRIS</span>
                                    @else
                                        <span class="mx-auto block w-max rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-xs font-black uppercase text-blue-600">Card</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button onclick="showInvoiceDetail('{{ $trx->invoice_no }}', '{{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y, H:i') }}', '{{ $trx->payment_method }}', {{ $trx->subtotal }}, {{ $trx->discount }}, {{ $trx->tax }}, {{ $trx->grand_total }}, {{ $trx->pay_amount }}, {{ $trx->return_amount }}, {{ json_encode($trx->details) }})" data-modal-target="invoice-modal" data-modal-toggle="invoice-modal" class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 transition hover:bg-blue-600 hover:text-white" title="Lihat Struk">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </button>
                                        <form action="{{ route('analytics.riwayat.destroy', $trx->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus invoice ini? Tindakan ini akan mengembalikan stok produk.')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-rose-50 text-rose-600 transition hover:bg-rose-600 hover:text-white" title="Hapus Invoice">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-14 text-center">
                                    <div class="mx-auto flex max-w-sm flex-col items-center text-slate-400">
                                        <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-[1.5rem] bg-slate-50 text-3xl">🧾</div>
                                        <p class="font-bold">Belum ada riwayat transaksi kasir.</p>
                                        <p class="mt-1 text-sm">Transaksi yang berhasil akan tampil di halaman ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="invoice-modal" tabindex="-1" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden bg-slate-950/50 backdrop-blur-sm md:inset-0">
        <div class="relative max-h-full w-full max-w-md p-4">
            <div class="relative overflow-hidden rounded-[2rem] bg-white shadow-2xl shadow-slate-900/20">
                <div class="h-2 w-full bg-gradient-to-r from-blue-600 via-cyan-400 to-blue-600"></div>

                <div class="p-6">
                    <div class="mb-6 border-b border-dashed border-slate-300 pb-5 text-center">
                        <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-950 text-base font-black text-white">K</div>
                        <h2 class="text-2xl font-black tracking-tight text-slate-950">{{ strtoupper($storeName) }}</h2>
                        <p class="mt-1 text-xs font-semibold text-slate-400">{{ $storeAddress }}</p>
                        <p class="text-xs font-semibold text-slate-400">Telp: {{ $storePhone }}</p>
                    </div>

                    <div class="mb-4 flex justify-between gap-4 text-xs font-semibold text-slate-500">
                        <div class="space-y-1">
                            <p>Invoice: <span id="modal-inv" class="font-black text-slate-950"></span></p>
                            <p>Kasir: <span class="font-black text-slate-950">{{ auth()->user()->name ?? 'Admin' }}</span></p>
                            <p>Metode: <span id="modal-method" class="font-black uppercase text-blue-600"></span></p>
                        </div>
                        <div class="text-right">
                            <p id="modal-date" class="font-black text-slate-950"></p>
                            <p>WIB</p>
                        </div>
                    </div>

                    <div class="mb-4 space-y-3 border-y border-dashed border-slate-300 py-4" id="modal-items"></div>

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between font-semibold text-slate-500">
                            <p>Subtotal</p>
                            <p id="modal-subtotal"></p>
                        </div>
                        <div id="modal-discount-row" class="hidden justify-between font-semibold text-rose-500">
                            <p>Diskon</p>
                            <p id="modal-discount"></p>
                        </div>
                        <div class="flex justify-between font-semibold text-slate-500">
                            <p id="modal-tax-label">Tax ({{ $taxRate }}%)</p>
                            <p id="modal-tax"></p>
                        </div>
                        <div class="mt-3 flex justify-between border-t border-slate-100 pt-3 text-base font-black text-slate-950">
                            <p>TOTAL</p>
                            <p id="modal-grand"></p>
                        </div>
                        <div class="flex justify-between pt-2 font-semibold text-slate-500">
                            <p>Cash / Dibayar</p>
                            <p id="modal-pay"></p>
                        </div>
                        <div class="flex justify-between font-semibold text-slate-500">
                            <p>Kembalian</p>
                            <p id="modal-return"></p>
                        </div>
                    </div>

                    <div class="mt-8 text-center">
                        <p class="whitespace-pre-line text-xs font-semibold italic text-slate-400">{{ $receiptFooter }}</p>
                    </div>
                </div>

                <div class="flex justify-end gap-2 border-t border-slate-100 bg-slate-50 p-4">
                    <button data-modal-hide="invoice-modal" class="rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-black text-slate-600 transition hover:bg-slate-100 hover:text-slate-950">Tutup</button>
                    <button onclick="window.print()" class="inline-flex items-center rounded-2xl bg-blue-600 px-4 py-2.5 text-sm font-black text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Cetak Struk
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const formatRp = (number) => new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(number);

        function showInvoiceDetail(inv, date, method, subtotal, discount, tax, grand, pay, returnAmount, items) {
            document.getElementById('modal-inv').innerText = inv;
            document.getElementById('modal-date').innerText = date;
            document.getElementById('modal-method').innerText = method;
            document.getElementById('modal-subtotal').innerText = formatRp(subtotal);
            
            // Handle discount row display
            const discountRow = document.getElementById('modal-discount-row');
            if (discount > 0) {
                document.getElementById('modal-discount').innerText = '- ' + formatRp(discount);
                discountRow.classList.remove('hidden');
                discountRow.classList.add('flex');
            } else {
                discountRow.classList.add('hidden');
                discountRow.classList.remove('flex');
            }

            document.getElementById('modal-tax').innerText = formatRp(tax);
            document.getElementById('modal-grand').innerText = formatRp(grand);
            document.getElementById('modal-pay').innerText = formatRp(pay);
            document.getElementById('modal-return').innerText = formatRp(returnAmount);

            // Dynamically calculate actual tax percentage based on subtotal after discount
            let totalAfterDiscount = subtotal - discount;
            let taxPercent = totalAfterDiscount > 0 ? Math.round((tax / totalAfterDiscount) * 100) : 0;
            document.getElementById('modal-tax-label').innerText = 'Tax (' + taxPercent + '%)';

            let itemsHtml = '';
            items.forEach(item => {
                itemsHtml += `
                    <div class="flex justify-between gap-4 text-sm">
                        <div class="min-w-0 flex-1">
                            <p class="truncate font-black text-slate-950">${item.product_name}</p>
                            <p class="mt-1 text-xs font-semibold text-slate-400">${item.qty} x ${formatRp(item.price)}</p>
                        </div>
                        <p class="shrink-0 font-black text-slate-950">${formatRp(item.subtotal)}</p>
                    </div>
                `;
            });
            document.getElementById('modal-items').innerHTML = itemsHtml;
        }
    </script>
@endsection