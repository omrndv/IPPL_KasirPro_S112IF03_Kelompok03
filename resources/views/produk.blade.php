@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h1 class="text-3xl font-black tracking-tight text-slate-950 md:text-4xl">Manajemen Produk</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">Kelola daftar barang, harga jual, harga modal, kategori, dan pantau stok produk toko.</p>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row">
            <button data-modal-target="kategori-modal" data-modal-toggle="kategori-modal" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-black text-slate-600 shadow-sm transition hover:-translate-y-0.5 hover:bg-slate-50 hover:text-slate-950" type="button">
                + Kategori Baru
            </button>

            <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-blue-600 px-5 py-3 text-sm font-black text-white shadow-lg shadow-blue-600/20 transition hover:-translate-y-0.5 hover:bg-blue-700" type="button">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Produk
            </button>
        </div>
    </div>

    @if (session('success'))
    <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800" role="alert">
        <span class="font-black">Berhasil!</span> {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800" role="alert">
        <span class="font-black">Gagal menyimpan data:</span>
        <ul class="mt-2 list-disc pl-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('produk.index') }}" method="GET" class="flex flex-col gap-4 rounded-[2rem] border border-white/80 bg-white p-4 shadow-sm md:flex-row md:items-center md:justify-between">
        <div class="relative w-full md:max-w-xl">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input type="text" name="search" id="table-search" value="{{ request('search') }}" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm font-semibold text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" placeholder="Cari nama produk atau SKU...">
        </div>

        <div class="flex w-full flex-col gap-3 sm:flex-row md:w-auto">
            <select name="category_id" class="block w-full cursor-pointer rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-bold text-slate-600 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100 sm:w-52">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>

            <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-slate-950 px-5 py-3 text-sm font-black text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-blue-600">
                Cari
            </button>

            @if (request('search') || request('category_id'))
            <a href="{{ route('produk.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-rose-200 bg-rose-50 px-5 py-3 text-sm font-black text-rose-600 transition hover:bg-rose-100">
                Reset
            </a>
            @endif
        </div>
    </form>

    <div class="overflow-hidden rounded-[2rem] border border-white/80 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[980px] text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50 text-xs uppercase tracking-[0.14em] text-slate-400">
                        <th scope="col" class="px-6 py-4 font-black">Info Produk</th>
                        <th scope="col" class="px-6 py-4 font-black">Kategori</th>
                        <th scope="col" class="px-6 py-4 text-right font-black">Harga Modal</th>
                        <th scope="col" class="px-6 py-4 text-right font-black">Harga Jual</th>
                        <th scope="col" class="px-6 py-4 text-center font-black">Stok</th>
                        <th scope="col" class="px-6 py-4 text-center font-black">Status</th>
                        <th scope="col" class="px-6 py-4 text-center font-black">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($products as $product)
                    <tr class="bg-white transition hover:bg-slate-50/80">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-slate-100 bg-slate-50 shadow-sm">
                                    @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                    @else
                                    <span class="text-2xl opacity-50">📦</span>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <div class="truncate text-base font-black text-slate-950">{{ $product->name }}</div>
                                    <div class="mt-1 text-xs font-semibold text-slate-400">SKU: {{ $product->sku ?? '-' }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-black text-slate-600">
                                {{ $product->category ? $product->category->name : 'Tanpa Kategori' }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-right font-bold text-slate-500">
                            Rp {{ number_format($product->cost_price, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-4 text-right font-black text-blue-600">
                            Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-4 text-center {{ $product->stock <= 5 ? 'font-black text-rose-600' : 'font-black text-slate-950' }}">
                            {{ $product->stock }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if ($product->stock <= 5)
                                <span class="inline-flex rounded-full border border-rose-200 bg-rose-50 px-3 py-1 text-xs font-black text-rose-600">Menipis</span>
                            @else
                                <span class="inline-flex rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-black text-emerald-600">Aman</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" class="flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 transition hover:bg-blue-600 hover:text-white" title="Edit" data-modal-target="edit-modal" data-modal-toggle="edit-modal" onclick="editProduct({{ $product->id }}, '{{ addslashes($product->name) }}', '{{ addslashes($product->sku) }}', '{{ $product->category_id }}', {{ $product->cost_price }}, {{ $product->selling_price }}, {{ $product->stock }}, '{{ $product->unit }}', {{ $product->is_stock_tracked ? 'true' : 'false' }})">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>

                                <button type="button" class="flex h-10 w-10 items-center justify-center rounded-2xl bg-rose-50 text-rose-600 transition hover:bg-rose-600 hover:text-white" title="Hapus" data-modal-target="delete-modal" data-modal-toggle="delete-modal" onclick="deleteProduct({{ $product->id }}, '{{ addslashes($product->name) }}')">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-14 text-center">
                            <div class="mx-auto flex max-w-sm flex-col items-center text-slate-400">
                                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-[1.5rem] bg-slate-50 text-3xl">📦</div>
                                <p class="font-bold">Belum ada data produk.</p>
                                <p class="mt-1 text-sm">Silakan tambah produk baru untuk mulai mengelola inventory.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col gap-3 border-t border-slate-100 p-4 text-sm font-semibold text-slate-500 sm:flex-row sm:items-center sm:justify-between">
            <span>Menampilkan {{ $products->count() }} produk</span>
            <div class="inline-flex w-fit overflow-hidden rounded-2xl border border-slate-200 bg-white">
                <button class="px-4 py-2 transition hover:bg-slate-50">Sebelumnya</button>
                <button class="border-l border-slate-200 px-4 py-2 transition hover:bg-slate-50">Selanjutnya</button>
            </div>
        </div>
    </div>
</div>

<div id="crud-modal" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden bg-slate-950/50 backdrop-blur-sm md:inset-0">
    <div class="relative max-h-full w-full max-w-2xl p-4">
        <div class="relative rounded-[2rem] bg-white shadow-2xl shadow-slate-900/20">
            <div class="flex items-center justify-between border-b border-slate-100 p-5">
                <div>
                    <h3 class="text-lg font-black text-slate-950">Input Produk Baru</h3>
                    <p class="mt-1 text-sm font-semibold text-slate-400">Lengkapi detail produk yang akan dijual.</p>
                </div>
                <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-slate-50 text-slate-400 transition hover:bg-slate-100 hover:text-slate-950" data-modal-toggle="crud-modal">
                    <svg class="h-3.5 w-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                    </svg>
                    <span class="sr-only">Tutup modal</span>
                </button>
            </div>

            <form class="p-5" action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="unit" value="Pcs">

                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label for="image" class="mb-2 block text-sm font-bold text-slate-950">Foto Produk <span class="text-slate-400">(Opsional)</span></label>
                        <input class="block w-full cursor-pointer rounded-2xl border border-slate-200 bg-slate-50 text-sm font-semibold text-slate-600 file:mr-4 file:border-0 file:bg-slate-950 file:px-4 file:py-3 file:text-sm file:font-black file:text-white focus:outline-none" id="image" name="image" type="file" accept="image/*">
                        <p class="mt-2 text-xs font-semibold text-slate-400">PNG, JPG atau JPEG maksimal 2MB.</p>
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="name" class="mb-2 block text-sm font-bold text-slate-950">Nama Produk <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" id="name" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" placeholder="Cth: Es Kopi Susu" required>
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="sku" class="mb-2 block text-sm font-bold text-slate-950">SKU / Kode Barang</label>
                        <input type="text" name="sku" id="sku" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" placeholder="Cth: MIN-001">
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="category_id" class="mb-2 block text-sm font-bold text-slate-950">Kategori <span class="text-rose-500">*</span></label>
                        <select name="category_id" id="category_id" required class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                            <option value="" selected disabled>Pilih Kategori</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="stock" class="mb-2 block text-sm font-bold text-slate-950">Stok Awal <span class="text-rose-500">*</span></label>
                        <input type="number" name="stock" id="stock" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" placeholder="0" required>
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="cost_price" class="mb-2 block text-sm font-bold text-slate-950">Harga Beli <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-sm font-black text-slate-400">Rp</div>
                            <input type="number" name="cost_price" id="cost_price" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" placeholder="10000" required>
                        </div>
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="selling_price" class="mb-2 block text-sm font-bold text-slate-950">Harga Jual <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-sm font-black text-slate-400">Rp</div>
                            <input type="number" name="selling_price" id="selling_price" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" placeholder="15000" required>
                        </div>
                    </div>

                    <div class="col-span-2">
                        <label class="flex items-center gap-2 cursor-pointer mt-2">
                            <input type="checkbox" name="is_stock_tracked" value="1" checked class="w-4 h-4 text-blue-600 bg-slate-50 border-slate-200 rounded focus:ring-blue-500 focus:ring-2">
                            <span class="text-sm font-bold text-slate-950">Lacak Stok untuk Produk Ini</span>
                        </label>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-3 border-t border-slate-100 pt-5">
                    <button data-modal-hide="crud-modal" type="button" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-black text-slate-600 transition hover:bg-slate-50 hover:text-slate-950">Batal</button>
                    <button type="submit" class="inline-flex items-center gap-2 rounded-2xl bg-blue-600 px-5 py-3 text-sm font-black text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="kategori-modal" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden bg-slate-950/50 backdrop-blur-sm md:inset-0">
    <div class="relative max-h-full w-full max-w-md p-4">
        <div class="relative rounded-[2rem] bg-white shadow-2xl shadow-slate-900/20">
            <div class="flex items-center justify-between border-b border-slate-100 p-5">
                <div>
                    <h3 class="text-lg font-black text-slate-950">Input Kategori Baru</h3>
                    <p class="mt-1 text-sm font-semibold text-slate-400">Buat kategori untuk mengelompokkan produk.</p>
                </div>
                <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-slate-50 text-slate-400 transition hover:bg-slate-100 hover:text-slate-950" data-modal-toggle="kategori-modal">
                    <svg class="h-3.5 w-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                    </svg>
                </button>
            </div>

            <form class="p-5" action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div>
                    <label for="kategori-name" class="mb-2 block text-sm font-bold text-slate-950">Nama Kategori <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="kategori-name" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" placeholder="Cth: Minuman Dingin" required>
                </div>

                <div class="mt-6 flex items-center justify-end gap-3">
                    <button data-modal-hide="kategori-modal" type="button" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-black text-slate-600 transition hover:bg-slate-50 hover:text-slate-950">Batal</button>
                    <button type="submit" class="rounded-2xl bg-blue-600 px-5 py-3 text-sm font-black text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="edit-modal" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden bg-slate-950/50 backdrop-blur-sm md:inset-0">
    <div class="relative max-h-full w-full max-w-2xl p-4">
        <div class="relative rounded-[2rem] bg-white shadow-2xl shadow-slate-900/20">
            <div class="flex items-center justify-between border-b border-slate-100 p-5">
                <div>
                    <h3 class="text-lg font-black text-slate-950">Edit Data Produk</h3>
                    <p class="mt-1 text-sm font-semibold text-slate-400">Perbarui data produk yang sudah tersimpan.</p>
                </div>
                <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-slate-50 text-slate-400 transition hover:bg-slate-100 hover:text-slate-950" data-modal-toggle="edit-modal">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                    </svg>
                </button>
            </div>

            <form id="edit-form" class="p-5" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="unit" id="edit-unit">

                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2 sm:col-span-1">
                        <label class="mb-2 block text-sm font-bold text-slate-950">Nama Produk</label>
                        <input type="text" name="name" id="edit-name" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label class="mb-2 block text-sm font-bold text-slate-950">SKU / Kode</label>
                        <input type="text" name="sku" id="edit-sku" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label class="mb-2 block text-sm font-bold text-slate-950">Kategori</label>
                        <select name="category_id" id="edit-category" required class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label class="mb-2 block text-sm font-bold text-slate-950">Stok</label>
                        <input type="number" name="stock" id="edit-stock" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label class="mb-2 block text-sm font-bold text-slate-950">Harga Beli</label>
                        <input type="number" name="cost_price" id="edit-cost" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label class="mb-2 block text-sm font-bold text-slate-950">Harga Jual</label>
                        <input type="number" name="selling_price" id="edit-sell" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
                    </div>

                    <div class="col-span-2">
                        <label class="mb-2 block text-sm font-bold text-slate-950">Ganti Foto <span class="text-slate-400">(Kosongkan jika tidak diganti)</span></label>
                        <input class="block w-full cursor-pointer rounded-2xl border border-slate-200 bg-slate-50 text-sm font-semibold text-slate-600 file:mr-4 file:border-0 file:bg-slate-950 file:px-4 file:py-3 file:text-sm file:font-black file:text-white focus:outline-none" name="image" type="file" accept="image/*">
                    </div>
                    
                    <div class="col-span-2">
                        <label class="flex items-center gap-2 cursor-pointer mt-2">
                            <input type="checkbox" name="is_stock_tracked" id="edit-stock-tracked" value="1" class="w-4 h-4 text-blue-600 bg-slate-50 border-slate-200 rounded focus:ring-blue-500 focus:ring-2">
                            <span class="text-sm font-bold text-slate-950">Lacak Stok untuk Produk Ini</span>
                        </label>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-3 border-t border-slate-100 pt-5">
                    <button data-modal-hide="edit-modal" type="button" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-black text-slate-600 transition hover:bg-slate-50 hover:text-slate-950">Batal</button>
                    <button type="submit" class="rounded-2xl bg-blue-600 px-5 py-3 text-sm font-black text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700">Update Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="delete-modal" tabindex="-1" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden bg-slate-950/50 backdrop-blur-sm md:inset-0">
    <div class="relative max-h-full w-full max-w-md p-4">
        <div class="relative rounded-[2rem] bg-white shadow-2xl shadow-slate-900/20">
            <button type="button" class="absolute right-4 top-4 inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-slate-50 text-slate-400 transition hover:bg-slate-100 hover:text-slate-950" data-modal-hide="delete-modal">
                <svg class="h-3.5 w-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                </svg>
            </button>

            <div class="p-7 text-center">
                <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-[1.5rem] bg-rose-50 text-rose-600">
                    <svg class="h-8 w-8" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                    </svg>
                </div>

                <h3 class="mb-2 text-lg font-black text-slate-950">Yakin ingin menghapus produk ini?</h3>
                <p id="delete-product-name" class="mb-7 text-xl font-black text-rose-600"></p>

                <div class="flex items-center justify-center gap-3">
                    <button data-modal-hide="delete-modal" type="button" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-black text-slate-600 transition hover:bg-slate-50 hover:text-slate-950">
                        Tidak, Batal
                    </button>

                    <form id="delete-form" action="" method="POST" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-rose-600 px-5 py-3 text-sm font-black text-white shadow-lg shadow-rose-600/20 transition hover:bg-rose-700">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function editProduct(id, name, sku, category_id, cost, sell, stock, unit, isTracked) {
        document.getElementById('edit-form').action = '/produk/' + id;
        document.getElementById('edit-name').value = name;
        document.getElementById('edit-sku').value = sku;
        document.getElementById('edit-category').value = category_id;
        document.getElementById('edit-cost').value = cost;
        document.getElementById('edit-sell').value = sell;
        document.getElementById('edit-stock').value = stock;
        document.getElementById('edit-unit').value = unit || 'Pcs';
        document.getElementById('edit-stock-tracked').checked = isTracked;
    }

    function deleteProduct(id, name) {
        document.getElementById('delete-product-name').innerText = name;
        document.getElementById('delete-form').action = '/produk/' + id;
    }
</script>
@endsection