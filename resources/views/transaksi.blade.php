@extends('layouts.app')

@section('content')
    <div class="flex flex-col lg:flex-row gap-6 h-[calc(100vh-6rem)] overflow-hidden">

        <div class="w-full lg:w-8/12 flex flex-col h-full">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Point of Sale</h1>
                    <p class="text-sm text-gray-500 mt-1">Pilih produk dan selesaikan pesanan pelanggan.</p>
                </div>
                <div class="relative w-full sm:max-w-xs">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="search"
                        class="bg-white border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-gray-900 focus:border-gray-900 block w-full ps-10 p-2.5 shadow-sm transition"
                        placeholder="Cari produk atau SKU...">
                </div>
            </div>

            <div class="flex gap-2 mb-6 overflow-x-auto pb-2 scrollbar-hide">
                <button
                    class="px-4 py-2 text-sm font-bold text-white bg-gray-900 rounded-lg shadow-sm whitespace-nowrap">Semua
                    Menu</button>
                <button
                    class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 whitespace-nowrap transition">Minuman</button>
                <button
                    class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 whitespace-nowrap transition">Makanan</button>
                <button
                    class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 whitespace-nowrap transition">Snack</button>
            </div>

            <div class="flex-1 overflow-y-auto pr-2 pb-20 lg:pb-0">
                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">

                    <div
                        class="bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-md hover:border-blue-300 cursor-pointer transition-all p-3 flex flex-col group">
                        <div
                            class="h-32 bg-gray-50 rounded-xl flex items-center justify-center text-5xl mb-3 group-hover:scale-105 transition-transform duration-300">
                            ☕</div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-sm leading-tight mb-1">Kopi Susu Gula Aren</h3>
                            <p class="text-xs text-gray-500 mb-2">Stok: 24</p>
                        </div>
                        <div class="mt-auto flex justify-between items-center">
                            <p class="text-gray-900 font-bold text-sm">Rp 18.000</p>
                            <button
                                class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center text-gray-600 group-hover:bg-blue-600 group-hover:text-white transition"><svg
                                    class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg></button>
                        </div>
                    </div>

                    <div
                        class="bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-md hover:border-blue-300 cursor-pointer transition-all p-3 flex flex-col group">
                        <div
                            class="h-32 bg-gray-50 rounded-xl flex items-center justify-center text-5xl mb-3 group-hover:scale-105 transition-transform duration-300">
                            🍞</div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-sm leading-tight mb-1">Roti Bakar Coklat Keju</h3>
                            <p class="text-xs text-gray-500 mb-2">Stok: 15</p>
                        </div>
                        <div class="mt-auto flex justify-between items-center">
                            <p class="text-gray-900 font-bold text-sm">Rp 25.000</p>
                            <button
                                class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center text-gray-600 group-hover:bg-blue-600 group-hover:text-white transition"><svg
                                    class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg></button>
                        </div>
                    </div>

                    <div
                        class="bg-white border border-rose-200 rounded-2xl shadow-sm hover:shadow-md cursor-pointer transition-all p-3 flex flex-col group relative">
                        <div
                            class="absolute top-4 right-4 bg-rose-100 text-rose-700 text-[10px] uppercase font-bold px-2 py-0.5 rounded z-10">
                            Sisa 2</div>
                        <div
                            class="h-32 bg-rose-50/50 rounded-xl flex items-center justify-center text-5xl mb-3 group-hover:scale-105 transition-transform duration-300">
                            🍟</div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-sm leading-tight mb-1">Kentang Goreng</h3>
                            <p class="text-xs text-rose-500 font-medium mb-2">Stok: 2</p>
                        </div>
                        <div class="mt-auto flex justify-between items-center">
                            <p class="text-gray-900 font-bold text-sm">Rp 15.000</p>
                            <button
                                class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center text-gray-600 group-hover:bg-rose-600 group-hover:text-white transition"><svg
                                    class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg></button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div
            class="w-full lg:w-4/12 bg-white rounded-2xl shadow-sm border border-gray-200 flex flex-col h-full overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                <h2 class="font-bold text-gray-900 text-lg flex items-center gap-2">
                    Current Order
                </h2>
                <button
                    class="text-xs text-rose-500 font-bold hover:text-rose-700 hover:bg-rose-50 px-2 py-1 rounded transition">Clear
                    All</button>
            </div>

            <div class="flex-1 overflow-y-auto p-5 space-y-5">

                <div class="flex justify-between items-center">
                    <div class="flex-1 pr-3">
                        <h4 class="font-bold text-sm text-gray-900 leading-tight">Kopi Susu Gula Aren</h4>
                        <p class="text-xs text-gray-500 mt-1">Rp 18.000</p>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        <p class="font-bold text-sm text-gray-900">Rp 36.000</p>
                        <div class="flex items-center border border-gray-200 rounded-lg bg-gray-50">
                            <button
                                class="w-7 h-7 text-gray-500 hover:text-gray-900 flex items-center justify-center font-bold">-</button>
                            <span class="w-6 text-center text-xs font-bold text-gray-900">2</span>
                            <button
                                class="w-7 h-7 text-gray-500 hover:text-gray-900 flex items-center justify-center font-bold">+</button>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <div class="flex-1 pr-3">
                        <h4 class="font-bold text-sm text-gray-900 leading-tight">Kentang Goreng</h4>
                        <p class="text-xs text-gray-500 mt-1">Rp 15.000</p>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        <p class="font-bold text-sm text-gray-900">Rp 15.000</p>
                        <div class="flex items-center border border-gray-200 rounded-lg bg-gray-50">
                            <button
                                class="w-7 h-7 text-gray-500 hover:text-gray-900 flex items-center justify-center font-bold">-</button>
                            <span class="w-6 text-center text-xs font-bold text-gray-900">1</span>
                            <button
                                class="w-7 h-7 text-gray-500 hover:text-gray-900 flex items-center justify-center font-bold">+</button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="p-5 bg-white border-t border-gray-100">
                <div class="space-y-3 mb-5">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Subtotal</span>
                        <span class="font-bold text-gray-900">Rp 51.000</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Tax (10%)</span>
                        <span class="font-bold text-gray-900">Rp 5.100</span>
                    </div>
                    <div class="pt-3 border-t border-gray-100 flex justify-between items-center">
                        <span class="text-gray-500 font-medium">Total</span>
                        <span class="text-2xl font-extrabold text-blue-600">Rp 56.100</span>
                    </div>
                </div>

                <button data-modal-target="payment-modal" data-modal-toggle="payment-modal"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-sm transition flex justify-center items-center gap-2">
                    <span>Charge</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
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
                    <h3 class="text-lg font-bold text-gray-900">
                        Selesaikan Pembayaran
                    </h3>
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
                        <h2 class="text-4xl font-extrabold text-gray-900">Rp 56.100</h2>
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
                        <input type="text"
                            class="bg-white border border-gray-200 text-gray-900 text-lg font-bold rounded-xl focus:ring-gray-900 focus:border-gray-900 block w-full p-3 shadow-sm transition"
                            value="100.000">
                    </div>

                    <div class="flex justify-between items-center mb-6 px-1">
                        <span class="text-sm font-medium text-gray-500">Change (Kembalian)</span>
                        <span class="text-xl font-bold text-emerald-500">Rp 43.900</span>
                    </div>

                    <button type="button"
                        class="w-full text-white bg-gray-900 hover:bg-black font-bold rounded-xl text-md px-5 py-4 text-center transition shadow-md">
                        Complete & Print Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
