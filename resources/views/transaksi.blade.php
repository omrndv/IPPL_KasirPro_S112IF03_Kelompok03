@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="flex h-[calc(100vh-8rem)] flex-col gap-6 overflow-hidden xl:flex-row">
    <div class="flex h-full w-full flex-col xl:w-8/12">
        <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-3xl font-black tracking-tight text-slate-950 md:text-4xl">Transaksi Kasir</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">Pilih produk, atur jumlah pesanan, lalu selesaikan pembayaran pelanggan dengan cepat.</p>
            </div>

            <form action="{{ route('pos.index') }}" method="GET" class="relative w-full lg:max-w-sm">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" class="block w-full rounded-2xl border border-slate-200 bg-white py-3 pl-11 pr-4 text-sm font-semibold text-slate-700 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100" placeholder="Cari produk atau SKU...">
            </form>
        </div>

        <div class="mb-6 flex gap-2 overflow-x-auto pb-2">
            <a href="{{ route('pos.index') }}" class="whitespace-nowrap rounded-2xl px-4 py-2.5 text-sm font-black shadow-sm transition {{ !request('category_id') ? 'bg-slate-950 text-white' : 'border border-slate-200 bg-white text-slate-500 hover:bg-slate-50 hover:text-slate-950' }}">
                Semua Menu
            </a>
            @foreach ($categories as $cat)
            <a href="{{ route('pos.index', ['category_id' => $cat->id]) }}" class="whitespace-nowrap rounded-2xl px-4 py-2.5 text-sm font-black shadow-sm transition {{ request('category_id') == $cat->id ? 'bg-slate-950 text-white' : 'border border-slate-200 bg-white text-slate-500 hover:bg-slate-50 hover:text-slate-950' }}">
                {{ $cat->name }}
            </a>
            @endforeach
        </div>

        <div class="flex-1 overflow-y-auto pr-1 pb-32 xl:pb-0">
            <div class="grid grid-cols-2 gap-4 md:grid-cols-3 2xl:grid-cols-4">
                @forelse ($products as $product)
                @php $isLow = $product->stock <= 5; @endphp

                    <div onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->selling_price }}, {{ $product->stock }})" class="group relative flex cursor-pointer flex-col overflow-hidden rounded-[2rem] border bg-white p-3 shadow-sm transition hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/70 {{ $isLow ? 'border-rose-200 hover:border-rose-300' : 'border-white/80 hover:border-blue-200' }}">
                    @if ($isLow)
                    <div class="absolute right-4 top-4 z-10 rounded-full border border-rose-200 bg-rose-50 px-2.5 py-1 text-[10px] font-black uppercase tracking-wide text-rose-600">
                        Sisa {{ $product->stock }}
                    </div>
                    @endif

                    <div class="mb-4 flex h-32 items-center justify-center overflow-hidden rounded-[1.5rem] {{ $isLow ? 'bg-rose-50' : 'bg-slate-50' }} text-5xl transition duration-300 group-hover:scale-[1.02]">
                        @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="h-full w-full object-cover" alt="{{ $product->name }}">
                        @else
                        <span class="text-4xl">📦</span>
                        @endif
                    </div>

                    <div class="flex-1">
                        <h3 class="line-clamp-2 text-sm font-black leading-snug text-slate-950">{{ $product->name }}</h3>
                        <p class="mt-1 text-xs font-bold {{ $isLow ? 'text-rose-500' : 'text-slate-400' }}">Stok: {{ $product->stock }}</p>
                    </div>

                    <div class="mt-4 flex items-center justify-between gap-3">
                        <p class="text-sm font-black text-slate-950">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</p>
                        <button class="flex h-9 w-9 shrink-0 items-center justify-center rounded-2xl bg-slate-50 text-slate-500 transition group-hover:bg-blue-600 group-hover:text-white" type="button">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </button>
                    </div>
            </div>
            @empty
            <div class="col-span-full flex h-64 flex-col items-center justify-center rounded-[2rem] border border-dashed border-slate-200 bg-white text-slate-400">
                <svg class="mb-4 h-14 w-14 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <p class="text-sm font-bold">Tidak ada produk yang ditemukan.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<div class="flex h-full w-full flex-col overflow-hidden rounded-[2rem] border border-white/80 bg-white shadow-sm xl:w-4/12">
    <div class="border-b border-slate-100 p-5">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-black text-slate-950">Current Order</h2>
                <p class="mt-1 text-sm font-semibold text-slate-400">Pesanan pelanggan saat ini</p>
            </div>
            <button onclick="clearCart()" class="rounded-2xl px-3 py-2 text-xs font-black text-rose-500 transition hover:bg-rose-50 hover:text-rose-700">Clear</button>
        </div>
    </div>

    <div id="cart-items" class="flex-1 space-y-4 overflow-y-auto p-5">
        <div class="flex h-full flex-col items-center justify-center space-y-3 text-slate-400">
            <div class="flex h-20 w-20 items-center justify-center rounded-[2rem] bg-slate-50 text-slate-300">
                <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <p class="text-sm font-bold">Keranjang masih kosong</p>
        </div>
    </div>

    <div class="border-t border-slate-100 bg-white p-5">
        <div class="mb-5 space-y-3 rounded-[1.5rem] bg-slate-50 p-4">
            <div class="flex justify-between text-sm">
                <span class="font-semibold text-slate-500">Subtotal</span>
                <span id="subtotal-display" class="font-black text-slate-950">Rp 0</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="font-semibold text-slate-500">Tax (10%)</span>
                <span id="tax-display" class="font-black text-slate-950">Rp 0</span>
            </div>
            <div class="flex items-center justify-between border-t border-slate-200 pt-3">
                <span class="font-bold text-slate-500">Total</span>
                <span id="total-display" class="text-2xl font-black text-blue-600">Rp 0</span>
            </div>
        </div>

        <button id="btn-charge" disabled onclick="onChargeClick()" data-modal-target="payment-modal" data-modal-toggle="payment-modal" class="flex w-full items-center justify-center gap-2 rounded-2xl bg-blue-600 px-5 py-4 text-base font-black text-white shadow-lg shadow-blue-600/20 transition hover:-translate-y-0.5 hover:bg-blue-700 disabled:cursor-not-allowed disabled:bg-slate-300 disabled:shadow-none disabled:hover:translate-y-0">
            <span>Charge</span>
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
            </svg>
        </button>
    </div>
</div>
</div>

<div id="payment-modal" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden bg-slate-950/40 backdrop-blur-sm md:inset-0">
    <div class="relative max-h-full w-full max-w-md p-4">
        <div class="relative rounded-[2rem] border border-white/80 bg-white shadow-2xl shadow-slate-900/20">
            <div class="flex items-center justify-between border-b border-slate-100 p-5">
                <div>
                    <h3 class="text-lg font-black text-slate-950">Selesaikan Pembayaran</h3>
                    <p class="mt-1 text-sm font-semibold text-slate-400">Pilih metode dan masukkan nominal bayar.</p>
                </div>
                <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-slate-50 text-slate-400 transition hover:bg-slate-100 hover:text-slate-950" data-modal-hide="payment-modal">
                    <svg class="h-3.5 w-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                    </svg>
                </button>
            </div>

            <div class="p-5">
                <div class="mb-6 rounded-[1.5rem] bg-slate-50 p-5 text-center">
                    <p class="mb-1 text-sm font-bold text-slate-400">Total Amount</p>
                    <h2 id="modal-total-display" class="text-4xl font-black tracking-tight text-slate-950">Rp 0</h2>
                </div>

                <h4 class="mb-3 text-xs font-black uppercase tracking-[0.18em] text-slate-400">Payment Method</h4>
                <ul class="mb-6 grid w-full gap-3 md:grid-cols-3">
                    <li>
                        <input type="radio" id="pay-cash" name="payment_method" value="cash" onchange="onPaymentMethodChange(this.value)" class="peer hidden" required checked>
                        <label for="pay-cash" class="inline-flex w-full cursor-pointer items-center justify-center rounded-2xl border border-slate-200 bg-white p-3 text-slate-500 transition hover:bg-slate-50 peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:text-blue-700">
                            <div class="text-center">
                                <div class="mb-1 text-xl">💵</div>
                                <div class="text-xs font-black">Cash</div>
                            </div>
                        </label>
                    </li>
                    <li>
                        <input type="radio" id="pay-qris" name="payment_method" value="qris" onchange="onPaymentMethodChange(this.value)" class="peer hidden">
                        <label for="pay-qris" class="inline-flex w-full cursor-pointer items-center justify-center rounded-2xl border border-slate-200 bg-white p-3 text-slate-500 transition hover:bg-slate-50 peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:text-blue-700">
                            <div class="text-center">
                                <div class="mb-1 text-xl">📱</div>
                                <div class="text-xs font-black">QRIS</div>
                            </div>
                        </label>
                    </li>
                    <li>
                        <input type="radio" id="pay-card" name="payment_method" value="card" onchange="onPaymentMethodChange(this.value)" class="peer hidden">
                        <label for="pay-card" class="inline-flex w-full cursor-pointer items-center justify-center rounded-2xl border border-slate-200 bg-white p-3 text-slate-500 transition hover:bg-slate-50 peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:text-blue-700">
                            <div class="text-center">
                                <div class="mb-1 text-xl">💳</div>
                                <div class="text-xs font-black">Card</div>
                            </div>
                        </label>
                    </li>
                </ul>

                <div id="cash-received-container" class="mb-6">
                    <label class="mb-2 block text-xs font-black uppercase tracking-[0.18em] text-slate-400">Cash Received</label>
                    <input type="number" id="pay-amount" oninput="calculateChange()" class="block w-full rounded-2xl border border-slate-200 bg-white p-4 text-lg font-black text-slate-950 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100" placeholder="Masukkan jumlah uang...">
                </div>

                <div id="change-container" class="mb-6 flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                    <span class="text-sm font-bold text-slate-500">Change</span>
                    <span id="change-display" class="text-xl font-black text-slate-400">Rp 0</span>
                </div>

                <!-- QRIS Static Code Container -->
                <div id="qris-container" class="hidden mb-6 flex flex-col items-center justify-center rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-6 text-center">
                    <p class="mb-3 text-[10px] font-black uppercase tracking-[0.18em] text-slate-400">Scan QRIS untuk Pembayaran</p>
                    <div class="relative rounded-2xl bg-white p-4 shadow-sm border border-slate-100">
                        <img src="{{ asset('images/static_qris.png') }}" class="w-48 h-48 object-contain mx-auto" alt="QRIS Code">
                    </div>
                    <p class="mt-3 text-xs font-bold text-slate-500">Silakan scan kode QR di atas untuk menyelesaikan pembayaran non-tunai.</p>
                </div>

                <button type="button" onclick="submitCheckout()" id="btn-submit-payment" class="flex w-full items-center justify-center rounded-2xl bg-slate-950 px-5 py-4 text-center text-base font-black text-white shadow-lg shadow-slate-900/15 transition hover:bg-blue-600">
                    <span id="btn-text">Complete & Print Receipt</span>
                    <svg id="btn-spinner" class="ml-3 hidden h-5 w-5 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<div id="receipt-modal" class="fixed inset-0 z-[60] hidden items-center justify-center bg-slate-950/50 p-4 backdrop-blur-sm">
    <div class="w-full max-w-md overflow-hidden rounded-[2rem] bg-white shadow-2xl shadow-slate-900/20">
        <div class="h-2 w-full bg-gradient-to-r from-blue-600 via-cyan-400 to-blue-600"></div>

        <div id="receipt-print-area" class="p-6">
            <div class="mb-6 border-b border-dashed border-slate-300 pb-5 text-center">
                <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-950 text-base font-black text-white">K</div>
                <h2 id="receipt-store-name" class="text-2xl font-black tracking-tight text-slate-950">KASIRPRO</h2>
                <p id="receipt-store-address" class="mt-1 text-xs font-semibold text-slate-400"></p>
                <p id="receipt-store-phone" class="text-xs font-semibold text-slate-400"></p>
            </div>

            <div class="mb-4 flex justify-between gap-4 text-xs font-semibold text-slate-500">
                <div class="space-y-1">
                    <p>Invoice: <span id="receipt-invoice" class="font-black text-slate-950"></span></p>
                    <p>Kasir: <span class="font-black text-slate-950">{{ auth()->user()->name ?? 'Admin' }}</span></p>
                    <p>Metode: <span id="receipt-method" class="font-black uppercase text-blue-600"></span></p>
                </div>
                <div class="text-right">
                    <p id="receipt-date" class="font-black text-slate-950"></p>
                    <p>WIB</p>
                </div>
            </div>

            <div id="receipt-items" class="mb-4 space-y-3 border-y border-dashed border-slate-300 py-4"></div>

            <div class="space-y-2 text-sm">
                <div class="flex justify-between font-semibold text-slate-500">
                    <p>Subtotal</p>
                    <p id="receipt-subtotal"></p>
                </div>
                <div class="flex justify-between font-semibold text-slate-500">
                    <p id="receipt-tax-label">Tax</p>
                    <p id="receipt-tax"></p>
                </div>
                <div class="mt-3 flex justify-between border-t border-slate-100 pt-3 text-base font-black text-slate-950">
                    <p>TOTAL</p>
                    <p id="receipt-grand"></p>
                </div>
                <div class="flex justify-between pt-2 font-semibold text-slate-500">
                    <p>Dibayar</p>
                    <p id="receipt-pay"></p>
                </div>
                <div class="flex justify-between font-semibold text-slate-500">
                    <p>Kembalian</p>
                    <p id="receipt-return"></p>
                </div>
            </div>

            <div class="mt-8 text-center">
                <p id="receipt-footer" class="whitespace-pre-line text-xs font-semibold italic text-slate-400"></p>
            </div>
        </div>

        <div class="flex justify-end gap-2 border-t border-slate-100 bg-slate-50 p-4">
            <button type="button" onclick="closeReceiptModal()" class="rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-black text-slate-600 transition hover:bg-slate-100 hover:text-slate-950">
                Tutup
            </button>
            <button type="button" onclick="printReceipt()" class="inline-flex items-center rounded-2xl bg-blue-600 px-4 py-2.5 text-sm font-black text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700">
                Cetak Struk
            </button>
        </div>
    </div>
</div>

<script>
    let cart = [];
    const TAX_RATE = 0.10;
    let grandTotalValue = 0;

    const formatRupiah = (number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(number || 0);
    };

    function addToCart(id, name, price, maxStock) {
        let existingItem = cart.find(item => item.id === id);

        if (existingItem) {
            if (existingItem.qty < maxStock) {
                existingItem.qty += 1;
            } else {
                alert('Maaf, stok ' + name + ' tidak mencukupi!');
            }
        } else {
            if (maxStock > 0) {
                cart.push({
                    id: id,
                    name: name,
                    price: price,
                    qty: 1,
                    maxStock: maxStock
                });
            } else {
                alert('Maaf, stok ' + name + ' habis!');
            }
        }

        renderCart();
    }

    function updateQty(id, delta) {
        let item = cart.find(item => item.id === id);

        if (item) {
            let newQty = item.qty + delta;

            if (newQty > 0 && newQty <= item.maxStock) {
                item.qty = newQty;
            } else if (newQty === 0) {
                cart = cart.filter(cartItem => cartItem.id !== id);
            } else if (newQty > item.maxStock) {
                alert('Stok maksimal tercapai!');
            }
        }

        renderCart();
    }

    function renderCart() {
        const cartContainer = document.getElementById('cart-items');
        const btnCharge = document.getElementById('btn-charge');
        let subtotal = 0;

        cartContainer.innerHTML = '';

        if (cart.length === 0) {
            cartContainer.innerHTML = `
                <div class="flex h-full flex-col items-center justify-center space-y-3 text-slate-400">
                    <div class="flex h-20 w-20 items-center justify-center rounded-[2rem] bg-slate-50 text-slate-300">
                        <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-bold">Keranjang masih kosong</p>
                </div>
            `;

            btnCharge.disabled = true;
        } else {
            btnCharge.disabled = false;

            cart.forEach(item => {
                let itemTotal = item.price * item.qty;
                subtotal += itemTotal;

                cartContainer.innerHTML += `
                    <div class="rounded-3xl border border-slate-100 bg-slate-50 p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0 flex-1">
                                <h4 class="line-clamp-2 text-sm font-black leading-snug text-slate-950">${item.name}</h4>
                                <p class="mt-1 text-xs font-bold text-slate-400">${formatRupiah(item.price)}</p>
                            </div>
                            <p class="shrink-0 text-sm font-black text-slate-950">${formatRupiah(itemTotal)}</p>
                        </div>
                        <div class="mt-4 flex items-center justify-between">
                            <p class="text-xs font-bold text-slate-400">Qty</p>
                            <div class="flex items-center rounded-2xl border border-slate-200 bg-white p-1">
                                <button onclick="updateQty(${item.id}, -1)" class="flex h-8 w-8 items-center justify-center rounded-xl text-base font-black text-slate-500 transition hover:bg-slate-50 hover:text-slate-950">-</button>
                                <span class="w-8 text-center text-sm font-black text-slate-950">${item.qty}</span>
                                <button onclick="updateQty(${item.id}, 1)" class="flex h-8 w-8 items-center justify-center rounded-xl text-base font-black text-slate-500 transition hover:bg-slate-50 hover:text-slate-950">+</button>
                            </div>
                        </div>
                    </div>
                `;
            });
        }

        let tax = subtotal * TAX_RATE;
        grandTotalValue = subtotal + tax;

        document.getElementById('subtotal-display').innerText = formatRupiah(subtotal);
        document.getElementById('tax-display').innerText = formatRupiah(tax);
        document.getElementById('total-display').innerText = formatRupiah(grandTotalValue);
        document.getElementById('modal-total-display').innerText = formatRupiah(grandTotalValue);

        calculateChange();
    }

    function clearCart() {
        if (cart.length === 0) {
            return;
        }

        if (confirm('Yakin ingin mengosongkan keranjang?')) {
            cart = [];
            renderCart();
        }
    }

    function calculateChange() {
        let payAmount = parseFloat(document.getElementById('pay-amount').value) || 0;
        let changeDisplay = document.getElementById('change-display');
        let submitBtn = document.getElementById('btn-submit-payment');

        if (payAmount >= grandTotalValue && grandTotalValue > 0) {
            let change = payAmount - grandTotalValue;

            changeDisplay.innerText = formatRupiah(change);
            changeDisplay.className = "text-xl font-black text-emerald-500";
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            changeDisplay.innerText = grandTotalValue > 0 ? "Uang Kurang!" : "Rp 0";
            changeDisplay.className = grandTotalValue > 0 ? "text-xl font-black text-rose-500" : "text-xl font-black text-slate-400";
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }

    function onChargeClick() {
        document.getElementById('pay-cash').checked = true;
        onPaymentMethodChange('cash');
    }

    function onPaymentMethodChange(method) {
        const qrisContainer = document.getElementById('qris-container');
        const cashReceivedContainer = document.getElementById('cash-received-container');
        const changeContainer = document.getElementById('change-container');
        const payAmountInput = document.getElementById('pay-amount');

        if (method === 'qris') {
            qrisContainer.classList.remove('hidden');
            cashReceivedContainer.classList.add('hidden');
            changeContainer.classList.add('hidden');
            payAmountInput.value = grandTotalValue;
        } else if (method === 'card') {
            qrisContainer.classList.add('hidden');
            cashReceivedContainer.classList.add('hidden');
            changeContainer.classList.add('hidden');
            payAmountInput.value = grandTotalValue;
        } else {
            qrisContainer.classList.add('hidden');
            cashReceivedContainer.classList.remove('hidden');
            changeContainer.classList.remove('hidden');
            payAmountInput.value = '';
        }

        calculateChange();
    }


    async function submitCheckout() {
        let payAmount = parseFloat(document.getElementById('pay-amount').value) || 0;
        let paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let btnText = document.getElementById('btn-text');
        let spinner = document.getElementById('btn-spinner');
        let submitBtn = document.getElementById('btn-submit-payment');

        submitBtn.disabled = true;
        btnText.innerText = "Memproses...";
        spinner.classList.remove('hidden');

        try {
            let response = await fetch("{{ route('pos.checkout') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    cart: cart,
                    pay_amount: payAmount,
                    payment_method: paymentMethod
                })
            });

            let result = await response.json();

            if (response.ok && result.success) {
                const paymentCloseButton = document.querySelector('[data-modal-hide="payment-modal"]');

                if (paymentCloseButton) {
                    paymentCloseButton.click();
                }

                showReceipt(result);

                cart = [];
                renderCart();
                document.getElementById('pay-amount').value = '';
            } else {
                alert('❌ Gagal: ' + (result.message || 'Transaksi gagal diproses.'));
            }
        } catch (error) {
            console.error("Error:", error);
            alert('Terjadi kesalahan koneksi server.');
        } finally {
            submitBtn.disabled = false;
            btnText.innerText = "Complete & Print Receipt";
            spinner.classList.add('hidden');
        }
    }

    function showReceipt(result) {
        const settings = result.settings || {};

        document.getElementById('receipt-store-name').innerText = (settings.store_name || 'KasirPro').toUpperCase();
        document.getElementById('receipt-store-address').innerText = settings.store_address || 'Alamat toko belum diatur';
        document.getElementById('receipt-store-phone').innerText = 'Telp: ' + (settings.store_phone || '-');

        document.getElementById('receipt-invoice').innerText = result.invoice_no || '-';
        document.getElementById('receipt-date').innerText = result.created_at || '-';
        document.getElementById('receipt-method').innerText = result.payment_method || '-';

        document.getElementById('receipt-subtotal').innerText = formatRupiah(result.subtotal);
        document.getElementById('receipt-tax-label').innerText = 'Tax (' + (settings.tax_rate || 10) + '%)';
        document.getElementById('receipt-tax').innerText = formatRupiah(result.tax);
        document.getElementById('receipt-grand').innerText = formatRupiah(result.grand_total);
        document.getElementById('receipt-pay').innerText = formatRupiah(result.pay_amount);
        document.getElementById('receipt-return').innerText = formatRupiah(result.return_amount);
        document.getElementById('receipt-footer').innerText = settings.receipt_footer || 'Terima kasih atas kunjungannya!';

        let itemsHtml = '';

        (result.items || []).forEach(item => {
            itemsHtml += `
                <div class="flex justify-between gap-4 text-sm">
                    <div class="min-w-0 flex-1">
                        <p class="truncate font-black text-slate-950">${item.product_name}</p>
                        <p class="mt-1 text-xs font-semibold text-slate-400">${item.qty} x ${formatRupiah(item.price)}</p>
                    </div>
                    <p class="shrink-0 font-black text-slate-950">${formatRupiah(item.subtotal)}</p>
                </div>
            `;
        });

        document.getElementById('receipt-items').innerHTML = itemsHtml;

        const modal = document.getElementById('receipt-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeReceiptModal() {
        const modal = document.getElementById('receipt-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');

        window.location.reload();
    }

    function printReceipt() {
        const printContents = document.getElementById('receipt-print-area').innerHTML;

        const printWindow = window.open('', '_blank', 'width=420,height=650');

        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Struk KasirPro</title>
                <style>
                    body {
                        margin: 0;
                        padding: 20px;
                        background: #ffffff;
                        font-family: Arial, sans-serif;
                        color: #0f172a;
                    }

                    .receipt {
                        width: 320px;
                        margin: 0 auto;
                    }

                    * {
                        box-sizing: border-box;
                    }

                    .text-center { text-align: center; }
                    .text-right { text-align: right; }
                    .font-black { font-weight: 900; }
                    .font-bold { font-weight: 700; }
                    .font-semibold { font-weight: 600; }
                    .text-xs { font-size: 12px; }
                    .text-sm { font-size: 14px; }
                    .text-base { font-size: 16px; }
                    .text-2xl { font-size: 24px; }
                    .tracking-tight { letter-spacing: -0.025em; }
                    .uppercase { text-transform: uppercase; }
                    .italic { font-style: italic; }
                    .whitespace-pre-line { white-space: pre-line; }
                    .mb-1 { margin-bottom: 4px; }
                    .mb-3 { margin-bottom: 12px; }
                    .mb-4 { margin-bottom: 16px; }
                    .mb-6 { margin-bottom: 24px; }
                    .mt-1 { margin-top: 4px; }
                    .mt-3 { margin-top: 12px; }
                    .mt-8 { margin-top: 32px; }
                    .pb-5 { padding-bottom: 20px; }
                    .pt-3 { padding-top: 12px; }
                    .py-4 { padding-top: 16px; padding-bottom: 16px; }
                    .space-y-1 > * + * { margin-top: 4px; }
                    .space-y-2 > * + * { margin-top: 8px; }
                    .space-y-3 > * + * { margin-top: 12px; }
                    .flex { display: flex; }
                    .justify-between { justify-content: space-between; }
                    .gap-4 { gap: 16px; }
                    .min-w-0 { min-width: 0; }
                    .flex-1 { flex: 1; }
                    .shrink-0 { flex-shrink: 0; }
                    .truncate {
                        overflow: hidden;
                        text-overflow: ellipsis;
                        white-space: nowrap;
                    }
                    .border-b { border-bottom: 1px solid #cbd5e1; }
                    .border-t { border-top: 1px solid #e2e8f0; }
                    .border-y {
                        border-top: 1px solid #cbd5e1;
                        border-bottom: 1px solid #cbd5e1;
                    }
                    .border-dashed { border-style: dashed; }
                    .text-slate-950 { color: #020617; }
                    .text-slate-500 { color: #64748b; }
                    .text-slate-400 { color: #94a3b8; }
                    .text-blue-600 { color: #2563eb; }
                    .bg-slate-950 { background: #020617; }
                    .text-white { color: #ffffff; }
                    .rounded-2xl { border-radius: 16px; }
                    .h-12 { height: 48px; }
                    .w-12 { width: 48px; }
                    .mx-auto { margin-left: auto; margin-right: auto; }
                    .items-center { align-items: center; }
                    .justify-center { justify-content: center; }

                    @media print {
                        body {
                            padding: 0;
                        }

                        .receipt {
                            width: 100%;
                            max-width: 320px;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="receipt">
                    ${printContents}
                </div>
                <script>
                    window.onload = function() {
                        window.print();
                        window.onafterprint = function() {
                            window.close();
                        };
                    };
                <\/script>
            </body>
            </html>
        `);

        printWindow.document.close();
    }
</script>
@endsection