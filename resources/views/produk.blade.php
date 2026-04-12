@extends('layouts.app')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Produk</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola daftar barang, harga, dan pantau stok gudang Anda.</p>
        </div>

        <div class="flex gap-3">
            <button data-modal-target="kategori-modal" data-modal-toggle="kategori-modal"
                class="flex items-center justify-center text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 transition shadow-sm"
                type="button">
                + Kategori Baru
            </button>

            <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                class="flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 transition shadow-sm"
                type="button">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                Tambah Produk
            </button>
        </div>
    </div>

    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
            <span class="font-bold">Berhasil!</span> {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200" role="alert">
            <span class="font-bold">Gagal menyimpan data:</span>
            <ul class="list-disc pl-5 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('produk.index') }}" method="GET"
        class="bg-white border border-gray-200 rounded-xl shadow-sm mb-6 p-4 flex flex-col md:flex-row items-center justify-between gap-4">

        <div class="w-full md:w-1/2 relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input type="text" name="search" id="table-search" value="{{ request('search') }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                placeholder="Cari nama produk atau SKU...">
        </div>

        <div class="w-full md:w-auto flex gap-3">
            <select name="category_id"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-pointer">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit"
                class="flex items-center justify-center text-white bg-gray-800 hover:bg-gray-900 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 transition shadow-sm">
                Cari
            </button>

            @if (request('search') || request('category_id'))
                <a href="{{ route('produk.index') }}"
                    class="flex items-center justify-center text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 font-medium rounded-lg text-sm px-4 py-2.5 transition">
                    Reset
                </a>
            @endif
        </div>
    </form>

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
                    @forelse ($products as $product)
                        <tr class="bg-white border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-4 flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-lg bg-gray-50 flex items-center justify-center overflow-hidden shrink-0 border border-gray-200 shadow-sm">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <span class="text-2xl opacity-50">📦</span>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 text-base">{{ $product->name }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5">SKU: {{ $product->sku ?? '-' }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $product->category ? $product->category->name : 'Tanpa Kategori' }}
                            </td>

                            <td class="px-6 py-4 text-right font-medium text-gray-500">
                                Rp {{ number_format($product->cost_price, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4 text-right font-bold text-blue-600">
                                Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                            </td>

                            <td
                                class="px-6 py-4 text-center {{ $product->stock <= 5 ? 'font-bold text-red-600' : 'font-semibold text-gray-900' }}">
                                {{ $product->stock }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if ($product->stock <= 5)
                                    <span
                                        class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-red-200 animate-pulse">Menipis</span>
                                @else
                                    <span
                                        class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-green-200">Aman</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-4">
                                    <button type="button"
                                        class="text-blue-600 hover:text-blue-900 transition hover:scale-110 m-0"
                                        title="Edit" data-modal-target="edit-modal" data-modal-toggle="edit-modal"
                                        onclick="editProduct({{ $product->id }}, '{{ $product->name }}', '{{ $product->sku }}', '{{ $product->category_id }}', {{ $product->cost_price }}, {{ $product->selling_price }}, {{ $product->stock }})">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>

                                    <button type="button"
                                        class="text-red-600 hover:text-red-900 transition hover:scale-110 m-0"
                                        title="Hapus" data-modal-target="delete-modal" data-modal-toggle="delete-modal"
                                        onclick="deleteProduct({{ $product->id }}, '{{ $product->name }}')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                Belum ada data produk. Silakan tambah produk baru!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-200 flex justify-between items-center text-sm text-gray-500">
            <span>Menampilkan {{ $products->count() }} produk</span>
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
                    <h3 class="text-lg font-bold text-gray-900">Input Produk Baru</h3>
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

                <form class="p-4 md:p-5" action="{{ route('produk.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="unit" value="Pcs">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="image" class="block mb-2 text-sm font-medium text-gray-900">Foto Produk
                                (Opsional)</label>
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                aria-describedby="image_help" id="image" name="image" type="file"
                                accept="image/*">
                            <p class="mt-1 text-xs text-gray-500" id="image_help">PNG, JPG atau JPEG (Maks. 2MB).</p>
                        </div>
                    </div>
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2 sm:col-span-1">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama Produk <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                placeholder="Cth: Es Kopi Susu" required>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="sku" class="block mb-2 text-sm font-medium text-gray-900">SKU / Kode
                                Barang</label>
                            <input type="text" name="sku" id="sku"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                placeholder="Cth: MIN-001 (Opsional)">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900">Kategori <span
                                    class="text-red-500">*</span></label>
                            <select name="category_id" id="category_id" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="" selected disabled>Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="stock" class="block mb-2 text-sm font-medium text-gray-900">Stok Awal <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="stock" id="stock"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                placeholder="0" required>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="cost_price" class="block mb-2 text-sm font-medium text-gray-900">Harga Beli
                                (Modal) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none text-gray-500">
                                    Rp</div>
                                <input type="number" name="cost_price" id="cost_price"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full ps-10 p-2.5"
                                    placeholder="10000" required>
                            </div>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="selling_price" class="block mb-2 text-sm font-medium text-gray-900">Harga Jual
                                <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none text-gray-500">
                                    Rp</div>
                                <input type="number" name="selling_price" id="selling_price"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full ps-10 p-2.5"
                                    placeholder="15000" required>
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
    <div id="kategori-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full backdrop-blur-sm bg-gray-900/50">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-xl shadow-2xl">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-lg font-bold text-gray-900">Input Kategori Baru</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-toggle="kategori-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Tutup modal</span>
                    </button>
                </div>

                <form class="p-4 md:p-5" action="{{ route('kategori.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama Kategori <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-3 transition"
                            placeholder="Cth: Minuman Dingin, Sparepart, dll" required>
                    </div>

                    <div class="flex items-center justify-end gap-3 mt-6">
                        <button data-modal-hide="kategori-modal" type="button"
                            class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700">Batal</button>
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center shadow-md">Simpan
                            Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="edit-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full backdrop-blur-sm bg-gray-900/50">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-xl shadow-2xl">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-lg font-bold text-gray-900">Edit Data Produk</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-toggle="edit-modal">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>

                <form id="edit-form" class="p-4 md:p-5" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2 sm:col-span-1">
                            <label class="block mb-2 text-sm font-medium text-gray-900">Nama Produk</label>
                            <input type="text" name="name" id="edit-name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                required>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label class="block mb-2 text-sm font-medium text-gray-900">SKU / Kode</label>
                            <input type="text" name="sku" id="edit-sku"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                            <select name="category_id" id="edit-category" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label class="block mb-2 text-sm font-medium text-gray-900">Stok</label>
                            <input type="number" name="stock" id="edit-stock"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                required>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label class="block mb-2 text-sm font-medium text-gray-900">Harga Beli</label>
                            <input type="number" name="cost_price" id="edit-cost"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                required>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label class="block mb-2 text-sm font-medium text-gray-900">Harga Jual</label>
                            <input type="number" name="selling_price" id="edit-sell"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                required>
                        </div>
                        <div class="col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900">Ganti Foto (Biarkan kosong jika
                                tidak diganti)</label>
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                name="image" type="file" accept="image/*">
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 mt-6 border-t pt-4">
                        <button data-modal-hide="edit-modal" type="button"
                            class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Batal</button>
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 shadow-md">Update
                            Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="delete-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full backdrop-blur-sm bg-gray-900/50">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-2xl shadow-2xl">
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="delete-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Tutup modal</span>
                </button>

                <div class="p-6 text-center">
                    <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="text-red-600 w-8 h-8" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>

                    <h3 class="mb-2 text-lg font-normal text-gray-500">Yakin ingin menghapus produk ini?</h3>
                    <p id="delete-product-name" class="mb-6 text-xl font-bold text-gray-900"></p>

                    <div class="flex items-center justify-center gap-3 mt-4">
                        <button data-modal-hide="delete-modal" type="button"
                            class="m-0 inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-gray-200 transition">
                            Tidak, Batal
                        </button>

                        <form id="delete-form" action="" method="POST" class="m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="m-0 inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 shadow-sm transition">
                                Ya, Hapus Produk
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    // Fungsi untuk melempar data dari tabel ke dalam form Modal Edit
    function editProduct(id, name, sku, category_id, cost, sell, stock) {
        // Mengubah URL action form agar mengarah ke ID produk yang benar
        document.getElementById('edit-form').action = '/produk/' + id;

        // Mengisi nilai input di dalam modal
        document.getElementById('edit-name').value = name;
        document.getElementById('edit-sku').value = sku;
        document.getElementById('edit-category').value = category_id;
        document.getElementById('edit-cost').value = cost;
        document.getElementById('edit-sell').value = sell;
        document.getElementById('edit-stock').value = stock;
    }
    // Fungsi untuk mengirim data ke Modal Hapus
    function deleteProduct(id, name) {
        // Ubah teks di dalam modal menjadi nama produk yang diklik
        document.getElementById('delete-product-name').innerText = name;

        // Ubah tujuan URL form agar menghapus ID yang benar
        document.getElementById('delete-form').action = '/produk/' + id;
    }
</script>
