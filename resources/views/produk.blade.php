@extends('layouts.app')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Produk</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola daftar barang, harga, dan pantau stok gudang Anda.</p>
        </div>

        <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
            class="flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 transition shadow-sm"
            type="button">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Produk Baru
        </button>
    </div>

    <div
        class="bg-white border border-gray-200 rounded-xl shadow-sm mb-6 p-4 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="w-full md:w-1/2 relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input type="text" id="table-search"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                placeholder="Cari nama produk atau SKU...">
        </div>

        <div class="w-full md:w-auto flex gap-3">
            <select
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option value="">Semua Kategori</option>
                <option value="minuman">Minuman</option>
                <option value="makanan">Makanan</option>
                <option value="snack">Snack</option>
            </select>
            <button
                class="flex items-center justify-center text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-4 py-2.5 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                    </path>
                </svg>
                Filter
            </button>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-4">Info Produk</th>
                        <th scope="col" class="px-6 py-4">Kategori</th>
                        <th scope="col" class="px-6 py-4 text-right">Harga Beli (Modal)</th>
                        <th scope="col" class="px-6 py-4 text-right">Harga Jual</th>
                        <th scope="col" class="px-6 py-4 text-center">Stok</th>
                        <th scope="col" class="px-6 py-4 text-center">Status</th>
                        <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-4 flex items-center gap-3">
                            <div class="w-10 h-10 rounded bg-gray-100 flex items-center justify-center text-xl">☕</div>
                            <div>
                                <div class="font-bold text-gray-900">Kopi Susu Gula Aren</div>
                                <div class="text-xs text-gray-500">SKU: KOP-001</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">Minuman</td>
                        <td class="px-6 py-4 text-right font-medium text-gray-500">Rp 10.000</td>
                        <td class="px-6 py-4 text-right font-bold text-blue-600">Rp 18.000</td>
                        <td class="px-6 py-4 text-center font-semibold text-gray-900">24</td>
                        <td class="px-6 py-4 text-center">
                            <span
                                class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-green-200">Aman</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button class="text-blue-600 hover:text-blue-900 mr-2" title="Edit"><svg class="w-5 h-5"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg></button>
                            <button class="text-red-600 hover:text-red-900" title="Hapus"><svg class="w-5 h-5"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg></button>
                        </td>
                    </tr>

                    <tr class="bg-white border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-4 flex items-center gap-3">
                            <div class="w-10 h-10 rounded bg-gray-100 flex items-center justify-center text-xl">🍟</div>
                            <div>
                                <div class="font-bold text-gray-900">Kentang Goreng</div>
                                <div class="text-xs text-gray-500">SKU: SNK-002</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">Snack</td>
                        <td class="px-6 py-4 text-right font-medium text-gray-500">Rp 8.000</td>
                        <td class="px-6 py-4 text-right font-bold text-blue-600">Rp 15.000</td>
                        <td class="px-6 py-4 text-center font-bold text-red-600">2</td>
                        <td class="px-6 py-4 text-center">
                            <span
                                class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-red-200 animate-pulse">Menipis</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button class="text-blue-600 hover:text-blue-900 mr-2"><svg class="w-5 h-5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg></button>
                            <button class="text-red-600 hover:text-red-900"><svg class="w-5 h-5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200 flex justify-between items-center text-sm text-gray-500">
            <span>Menampilkan 1 sampai 2 dari 2 entri</span>
            <div class="inline-flex">
                <button class="px-3 py-1 border border-gray-300 rounded-l-lg hover:bg-gray-50">Sebelumnya</button>
                <button
                    class="px-3 py-1 border-t border-b border-r border-gray-300 rounded-r-lg hover:bg-gray-50">Selanjutnya</button>
            </div>
        </div>
    </div>

    <div id="crud-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full backdrop-blur-sm bg-gray-900/50">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-xl shadow-2xl">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-lg font-bold text-gray-900">
                        Input Produk Baru
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Tutup modal</span>
                    </button>
                </div>
                <form class="p-4 md:p-5" action="#" method="POST">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2 sm:col-span-1">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama Produk <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                placeholder="Cth: Es Kopi Susu" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="sku" class="block mb-2 text-sm font-medium text-gray-900">SKU / Kode
                                Barang</label>
                            <input type="text" name="sku" id="sku"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                placeholder="Cth: MIN-001 (Opsional)">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="category" class="block mb-2 text-sm font-medium text-gray-900">Kategori <span
                                    class="text-red-500">*</span></label>
                            <select id="category"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option selected="">Pilih Kategori</option>
                                <option value="MI">Minuman</option>
                                <option value="MA">Makanan</option>
                                <option value="SN">Snack</option>
                            </select>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="stock" class="block mb-2 text-sm font-medium text-gray-900">Stok Awal <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="stock" id="stock"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                placeholder="0" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="harga_beli" class="block mb-2 text-sm font-medium text-gray-900">Harga Beli
                                (Modal) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none text-gray-500">
                                    Rp</div>
                                <input type="number" name="harga_beli" id="harga_beli"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full ps-10 p-2.5"
                                    placeholder="10000" required="">
                            </div>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="harga_jual" class="block mb-2 text-sm font-medium text-gray-900">Harga Jual <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none text-gray-500">
                                    Rp</div>
                                <input type="number" name="harga_jual" id="harga_jual"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full ps-10 p-2.5"
                                    placeholder="15000" required="">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 mt-6 border-t pt-4">
                        <button data-modal-hide="crud-modal" type="button"
                            class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700">Batal</button>
                        <button type="submit"
                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center shadow-md">
                            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Simpan Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
