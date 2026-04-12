@extends('layouts.app')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="flex flex-col lg:flex-row gap-6 h-[calc(100vh-6rem)] overflow-hidden">

        <div class="w-full lg:w-8/12 flex flex-col h-full">

            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Point of Sale</h1>
                    <p class="text-sm text-gray-500 mt-1">Pilih produk dan selesaikan pesanan pelanggan.</p>
                </div>

                <form action="{{ route('pos.index') }}" method="GET" class="relative w-full sm:max-w-xs">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="bg-white border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-gray-900 focus:border-gray-900 block w-full ps-10 p-2.5 shadow-sm transition"
                        placeholder="Cari produk atau SKU...">
                </form>
            </div>

            <div class="flex gap-2 mb-6 overflow-x-auto pb-2 scrollbar-hide">
                <a href="{{ route('pos.index') }}"
                    class="px-4 py-2 text-sm font-bold {{ !request('category_id') ? 'text-white bg-gray-900' : 'text-gray-600 bg-white border border-gray-200 hover:bg-gray-50' }} rounded-lg shadow-sm whitespace-nowrap transition">
                    Semua Menu
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('pos.index', ['category_id' => $cat->id]) }}"
                        class="px-4 py-2 text-sm font-bold {{ request('category_id') == $cat->id ? 'text-white bg-gray-900' : 'text-gray-600 bg-white border border-gray-200 hover:bg-gray-50' }} rounded-lg whitespace-nowrap transition">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            <div class="flex-1 overflow-y-auto pr-2 pb-20 lg:pb-0">
                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">

                    @forelse ($products as $product)
                        @php $isLow = $product->stock <= 5; @endphp

                        <div onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->selling_price }}, {{ $product->stock }})"
                            class="bg-white border {{ $isLow ? 'border-rose-200 hover:border-rose-300' : 'border-gray-200 hover:border-blue-300' }} rounded-2xl shadow-sm hover:shadow-md cursor-pointer transition-all p-3 flex flex-col group relative">

                            @if ($isLow)
                                <div
                                    class="absolute top-4 right-4 bg-rose-100 text-rose-700 text-[10px] uppercase font-bold px-2 py-0.5 rounded z-10">
                                    Sisa {{ $product->stock }}</div>
                            @endif

                            <div
                                class="h-32 {{ $isLow ? 'bg-rose-50/50' : 'bg-gray-50' }} rounded-xl flex items-center justify-center text-5xl mb-3 group-hover:scale-105 transition-transform duration-300 overflow-hidden">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                        class="w-full h-full object-cover">
                                @else
                                    📦
                                @endif
                            </div>

                            <div>
                                <h3 class="font-bold text-gray-900 text-sm leading-tight mb-1">{{ $product->name }}</h3>
                                <p class="text-xs {{ $isLow ? 'text-rose-500 font-medium' : 'text-gray-500' }} mb-2">Stok:
                                    {{ $product->stock }}</p>
                            </div>

                            <div class="mt-auto flex justify-between items-center">
                                <p class="text-gray-900 font-bold text-sm">Rp
                                    {{ number_format($product->selling_price, 0, ',', '.') }}</p>
                                <button
                                    class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center text-gray-600 group-hover:bg-blue-600 group-hover:text-white transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full flex flex-col items-center justify-center h-40 text-gray-400">
                            <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <p>Tidak ada produk yang ditemukan.</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>

        <div
            class="w-full lg:w-4/12 bg-white rounded-2xl shadow-sm border border-gray-200 flex flex-col h-full overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                <h2 class="font-bold text-gray-900 text-lg flex items-center gap-2">Current Order</h2>
                <button onclick="clearCart()"
                    class="text-xs text-rose-500 font-bold hover:text-rose-700 hover:bg-rose-50 px-2 py-1 rounded transition">Clear
                    All</button>
            </div>

            <div id="cart-items" class="flex-1 overflow-y-auto p-5 space-y-5">
                <div class="flex flex-col items-center justify-center h-full text-gray-400 space-y-3">
                    <svg class="w-16 h-16 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    <p class="text-sm">Keranjang masih kosong</p>
                </div>
            </div>

            <div class="p-5 bg-white border-t border-gray-100">
                <div class="space-y-3 mb-5">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Subtotal</span>
                        <span id="subtotal-display" class="font-bold text-gray-900">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Tax (10%)</span>
                        <span id="tax-display" class="font-bold text-gray-900">Rp 0</span>
                    </div>
                    <div class="pt-3 border-t border-gray-100 flex justify-between items-center">
                        <span class="text-gray-500 font-medium">Total</span>
                        <span id="total-display" class="text-2xl font-extrabold text-blue-600">Rp 0</span>
                    </div>
                </div>

                <button id="btn-charge" disabled data-modal-target="payment-modal" data-modal-toggle="payment-modal"
                    class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-bold py-3.5 rounded-xl shadow-sm transition flex justify-center items-center gap-2">
                    <span>Charge</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div id="payment-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full backdrop-blur-sm bg-gray-900/40">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-2xl shadow-xl border border-gray-100">
                <div class="flex items-center justify-between p-5 border-b border-gray-100 rounded-t">
                    <h3 class="text-lg font-bold text-gray-900">Selesaikan Pembayaran</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-hide="payment-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>

                <div class="p-5">
                    <div class="text-center mb-6">
                        <p class="text-sm text-gray-500 mb-1">Total Amount</p>
                        <h2 id="modal-total-display" class="text-4xl font-extrabold text-gray-900">Rp 0</h2>
                    </div>

                    <h4 class="mb-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Payment Method</h4>
                    <ul class="grid w-full gap-3 md:grid-cols-3 mb-6">
                        <li>
                            <input type="radio" id="pay-cash" name="payment_method" value="cash"
                                class="hidden peer" required checked>
                            <label for="pay-cash"
                                class="inline-flex items-center justify-center w-full p-3 text-gray-500 bg-white border border-gray-200 rounded-xl cursor-pointer peer-checked:border-gray-900 peer-checked:text-gray-900 peer-checked:bg-gray-50 hover:bg-gray-50 transition">
                                <div class="block text-center">
                                    <div class="w-full text-xl mb-1">💵</div>
                                    <div class="w-full text-xs font-bold">Cash</div>
                                </div>
                            </label>
                        </li>
                        <li>
                            <input type="radio" id="pay-qris" name="payment_method" value="qris"
                                class="hidden peer">
                            <label for="pay-qris"
                                class="inline-flex items-center justify-center w-full p-3 text-gray-500 bg-white border border-gray-200 rounded-xl cursor-pointer peer-checked:border-gray-900 peer-checked:text-gray-900 peer-checked:bg-gray-50 hover:bg-gray-50 transition">
                                <div class="block text-center">
                                    <div class="w-full text-xl mb-1">📱</div>
                                    <div class="w-full text-xs font-bold">QRIS</div>
                                </div>
                            </label>
                        </li>
                        <li>
                            <input type="radio" id="pay-card" name="payment_method" value="card"
                                class="hidden peer">
                            <label for="pay-card"
                                class="inline-flex items-center justify-center w-full p-3 text-gray-500 bg-white border border-gray-200 rounded-xl cursor-pointer peer-checked:border-gray-900 peer-checked:text-gray-900 peer-checked:bg-gray-50 hover:bg-gray-50 transition">
                                <div class="block text-center">
                                    <div class="w-full text-xl mb-1">💳</div>
                                    <div class="w-full text-xs font-bold">Card</div>
                                </div>
                            </label>
                        </li>
                    </ul>

                    <div class="mb-6">
                        <label class="block mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Cash
                            Received</label>
                        <input type="number" id="pay-amount" oninput="calculateChange()"
                            class="bg-white border border-gray-200 text-gray-900 text-lg font-bold rounded-xl focus:ring-gray-900 focus:border-gray-900 block w-full p-3 shadow-sm transition"
                            placeholder="Masukkan jumlah uang...">
                    </div>

                    <div class="flex justify-between items-center mb-6 px-1">
                        <span class="text-sm font-medium text-gray-500">Change (Kembalian)</span>
                        <span id="change-display" class="text-xl font-bold text-gray-400">Rp 0</span>
                    </div>

                    <button type="button" onclick="submitCheckout()" id="btn-submit-payment"
                        class="w-full text-white bg-gray-900 hover:bg-black font-bold rounded-xl text-md px-5 py-4 text-center transition shadow-md flex items-center justify-center">
                        <span id="btn-text">Complete & Print Receipt</span>
                        <svg id="btn-spinner" class="hidden animate-spin ml-3 h-5 w-5 text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // State Variabel
        let cart = [];
        const TAX_RATE = 0.10; // 10% Pajak
        let grandTotalValue = 0;

        // Fungsi Format Rupiah
        const formatRupiah = (number) => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number);
        };

        // 1. Fungsi Tambah ke Keranjang
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

        // 2. Fungsi Ubah Kuantitas
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

        // 3. Fungsi Render / Tampilkan Keranjang HTML
        function renderCart() {
            const cartContainer = document.getElementById('cart-items');
            const btnCharge = document.getElementById('btn-charge');
            let subtotal = 0;

            cartContainer.innerHTML = '';

            if (cart.length === 0) {
                cartContainer.innerHTML = `
                    <div class="flex flex-col items-center justify-center h-full text-gray-400 space-y-3">
                        <svg class="w-16 h-16 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <p class="text-sm">Keranjang masih kosong</p>
                    </div>`;
                btnCharge.disabled = true;
            } else {
                btnCharge.disabled = false;

                cart.forEach(item => {
                    let itemTotal = item.price * item.qty;
                    subtotal += itemTotal;

                    cartContainer.innerHTML += `
                        <div class="flex justify-between items-center">
                            <div class="flex-1 pr-3">
                                <h4 class="font-bold text-sm text-gray-900 leading-tight">${item.name}</h4>
                                <p class="text-xs text-gray-500 mt-1">${formatRupiah(item.price)}</p>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <p class="font-bold text-sm text-gray-900">${formatRupiah(itemTotal)}</p>
                                <div class="flex items-center border border-gray-200 rounded-lg bg-gray-50">
                                    <button onclick="updateQty(${item.id}, -1)" class="w-7 h-7 text-gray-500 hover:text-gray-900 flex items-center justify-center font-bold">-</button>
                                    <span class="w-6 text-center text-xs font-bold text-gray-900">${item.qty}</span>
                                    <button onclick="updateQty(${item.id}, 1)" class="w-7 h-7 text-gray-500 hover:text-gray-900 flex items-center justify-center font-bold">+</button>
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

        // 4. Bersihkan Keranjang
        function clearCart() {
            if (confirm('Yakin ingin mengosongkan keranjang?')) {
                cart = [];
                renderCart();
            }
        }

        // 5. Kalkulator Kembalian Uang (Modal)
        function calculateChange() {
            let payAmount = parseFloat(document.getElementById('pay-amount').value) || 0;
            let changeDisplay = document.getElementById('change-display');
            let submitBtn = document.getElementById('btn-submit-payment');

            if (payAmount >= grandTotalValue) {
                let change = payAmount - grandTotalValue;
                changeDisplay.innerText = formatRupiah(change);
                changeDisplay.className = "text-xl font-bold text-emerald-500";
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                changeDisplay.innerText = "Uang Kurang!";
                changeDisplay.className = "text-xl font-bold text-rose-500";
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }

        // 6. Proses Pembayaran ke Backend (AJAX / Fetch API)
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
                        payment_method: paymentMethod // <--- Komanya sudah aman di baris atasnya
                    })
                });

                let result = await response.json();

                if (response.ok) {
                    alert('✅ Transaksi Sukses!\nNo Invoice: ' + result.invoice_no + '\nKembalian: ' + formatRupiah(
                        result.return_amount));

                    cart = [];
                    renderCart();
                    document.getElementById('pay-amount').value = '';
                    document.querySelector('[data-modal-hide="payment-modal"]').click();

                    window.location.reload();
                } else {
                    alert('❌ Gagal: ' + result.message);
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
    </script>
@endsection
