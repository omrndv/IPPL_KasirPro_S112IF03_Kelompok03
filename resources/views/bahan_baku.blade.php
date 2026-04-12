@extends('layouts.app')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Stok Bahan Baku</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola inventaris gudang, bahan resep, dan pantau batas minimum.</p>
        </div>
        <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
            class="flex items-center justify-center text-white bg-amber-600 hover:bg-amber-700 focus:ring-4 focus:ring-amber-300 font-medium rounded-lg text-sm px-5 py-2.5 transition shadow-sm"
            type="button">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Bahan Baru
        </button>
    </div>

    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200">
            <span class="font-bold">Sukses!</span> {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200">
            <span class="font-bold">Gagal:</span>
            <ul class="list-disc pl-5 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Item Bahan</h3>
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <h4 class="text-4xl font-black text-gray-900 tracking-tight">{{ $total_items }}</h4>
                <span class="text-sm font-medium text-gray-500">Macam</span>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 relative overflow-hidden group">
            <div class="absolute top-0 left-0 w-full h-1 bg-red-500"></div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Stok Kritis (Habis)</h3>
                <div
                    class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center text-red-600 shadow-inner group-hover:animate-pulse">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <h4 class="text-4xl font-black text-red-600 tracking-tight">{{ $critical_items }}</h4>
                <span class="text-sm font-medium text-gray-500">Item</span>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Estimasi Nilai Gudang</h3>
                <div
                    class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-xl font-bold text-gray-400">Rp</span>
                <h4 class="text-3xl font-black text-gray-900 tracking-tight">
                    {{ number_format($total_value ?? 0, 0, ',', '.') }}
                </h4>
            </div>
        </div>
    </div>

    <form action="{{ route('bahan.index') }}" method="GET"
        class="bg-white border border-gray-200 rounded-xl shadow-sm mb-6 p-4 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="w-full md:w-1/2 relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full ps-10 p-2.5"
                placeholder="Cari nama bahan baku...">
        </div>

        <div class="w-full md:w-auto flex gap-3">
            <select name="category"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5 cursor-pointer">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                        {{ $cat }}</option>
                @endforeach
            </select>

            <button type="submit"
                class="text-white bg-gray-800 hover:bg-gray-900 font-medium rounded-lg text-sm px-5 py-2.5">Cari</button>
            @if (request('search') || request('category'))
                <a href="{{ route('bahan.index') }}"
                    class="flex items-center text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg text-sm px-4 py-2.5">Reset</a>
            @endif
        </div>
    </form>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4">Info Bahan Baku</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4 text-center">Stok Saat Ini</th>
                        <th class="px-6 py-4 text-center">Batas Min.</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($raw_materials as $item)
                        @php $isCritical = $item->stock <= $item->min_stock; @endphp

                        <tr
                            class="{{ $isCritical ? 'bg-red-50/40 hover:bg-red-50/70' : 'bg-white hover:bg-gray-50' }} border-b transition">
                            <td class="px-6 py-4 flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center text-xl shrink-0">
                                    {{ $item->category == 'Bahan Kering' ? '📦' : ($item->category == 'Bahan Basah' ? '🥛' : '🛍️') }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 text-base">{{ $item->name }}</div>
                                    <div class="text-xs font-medium text-gray-500 mt-0.5">HPP: Rp
                                        {{ number_format($item->price_per_unit, 0, ',', '.') }} / {{ $item->unit }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $item->category }}</td>
                            <td
                                class="px-6 py-4 text-center font-bold {{ $isCritical ? 'text-red-600' : 'text-gray-900' }} text-lg">
                                {{ $item->stock + 0 }} <span
                                    class="text-xs font-normal text-gray-500">{{ $item->unit }}</span>
                            </td>
                            <td class="px-6 py-4 text-center text-gray-500 font-medium">{{ $item->min_stock + 0 }}
                                {{ $item->unit }}</td>
                            <td class="px-6 py-4 text-center">
                                @if ($isCritical)
                                    <span
                                        class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-md border border-red-200 animate-pulse">Kritis!</span>
                                @else
                                    <span
                                        class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-md border border-green-200">Aman</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-3">
                                    <button type="button"
                                        onclick="restockMaterial({{ $item->id }}, '{{ $item->name }}', '{{ $item->unit }}')"
                                        data-modal-target="restock-modal" data-modal-toggle="restock-modal"
                                        class="text-emerald-600 hover:text-emerald-900 hover:bg-emerald-100 transition bg-emerald-50 p-2 rounded-lg border border-emerald-100"
                                        title="Restock">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                    </button>
                                    <button type="button"
                                        onclick="editMaterial({{ $item->id }}, '{{ $item->name }}', '{{ $item->category }}', {{ $item->stock }}, {{ $item->min_stock }}, '{{ $item->unit }}', {{ $item->price_per_unit }})"
                                        data-modal-target="edit-modal" data-modal-toggle="edit-modal"
                                        class="text-blue-600 hover:text-blue-900 hover:bg-blue-50 transition p-2 rounded-lg"
                                        title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button type="button"
                                        onclick="deleteMaterial({{ $item->id }}, '{{ $item->name }}')"
                                        data-modal-target="delete-modal" data-modal-toggle="delete-modal"
                                        class="text-red-600 hover:text-red-900 hover:bg-red-50 transition p-2 rounded-lg"
                                        title="Hapus">
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
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">Belum ada data stok bahan
                                baku.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <datalist id="category-options">
        @foreach ($categories as $cat)
            <option value="{{ $cat }}"></option>
        @endforeach
    </datalist>

    <div id="crud-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full backdrop-blur-sm bg-gray-900/50">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-xl shadow-2xl">
                <div class="flex justify-between items-center p-4 border-b rounded-t">
                    <h3 class="text-lg font-bold text-gray-900">Tambah Bahan Baku</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
                <form class="p-4" action="{{ route('bahan.store') }}" method="POST">
                    @csrf
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2 sm:col-span-1">
                            <label class="block mb-2 text-sm font-medium">Nama Bahan <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="name"
                                class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5" required>
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label class="block mb-2 text-sm font-medium">Kategori <span
                                    class="text-red-500">*</span></label>
                            <input list="category-options" name="category"
                                class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5"
                                placeholder="Pilih atau ketik kategori baru..." required autocomplete="off">
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label class="block mb-2 text-sm font-medium">Stok Awal <span
                                    class="text-red-500">*</span></label>
                            <input type="number" step="0.01" name="stock"
                                class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5" required>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label class="block mb-2 text-sm font-medium">Batas Minimum <span
                                    class="text-red-500">*</span></label>
                            <input type="number" step="0.01" name="min_stock"
                                class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5" required>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label class="block mb-2 text-sm font-medium">Satuan <span
                                    class="text-red-500">*</span></label>
                            <select name="unit" class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5"
                                required>
                                <option value="Kg">Kg</option>
                                <option value="Gram">Gram</option>
                                <option value="Liter">Liter</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Box">Box</option>
                            </select>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label class="block mb-2 text-sm font-medium">HPP per Satuan (Rp) <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="price_per_unit"
                                class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5" required>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button data-modal-hide="crud-modal" type="button"
                            class="py-2.5 px-5 bg-white border border-gray-200 rounded-lg">Batal</button>
                        <button type="submit"
                            class="py-2.5 px-5 text-white bg-amber-600 rounded-lg hover:bg-amber-700">Simpan Bahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="edit-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full backdrop-blur-sm bg-gray-900/50">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-xl shadow-2xl">
                <div class="flex justify-between items-center p-4 border-b rounded-t">
                    <h3 class="text-lg font-bold text-gray-900">Edit Bahan Baku</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-toggle="edit-modal">
                        <svg class="w-3 h-3" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
                <form id="edit-form" class="p-4" action="" method="POST">
                    @csrf @method('PUT')
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2 sm:col-span-1">
                            <label class="block mb-2 text-sm font-medium">Nama Bahan</label>
                            <input type="text" name="name" id="edit-name"
                                class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5" required>
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label class="block mb-2 text-sm font-medium">Kategori</label>
                            <input list="category-options" name="category" id="edit-category"
                                class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5"
                                placeholder="Pilih atau ketik kategori baru..." required autocomplete="off">
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label class="block mb-2 text-sm font-medium">Stok</label>
                            <input type="number" step="0.01" name="stock" id="edit-stock"
                                class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5" required>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label class="block mb-2 text-sm font-medium">Batas Min</label>
                            <input type="number" step="0.01" name="min_stock" id="edit-min"
                                class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5" required>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label class="block mb-2 text-sm font-medium">Satuan</label>
                            <select name="unit" id="edit-unit"
                                class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5" required>
                                <option value="Kg">Kg</option>
                                <option value="Gram">Gram</option>
                                <option value="Liter">Liter</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Box">Box</option>
                            </select>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label class="block mb-2 text-sm font-medium">HPP per Satuan (Rp)</label>
                            <input type="number" name="price_per_unit" id="edit-price"
                                class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5" required>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button data-modal-hide="edit-modal" type="button"
                            class="py-2.5 px-5 bg-white border border-gray-200 rounded-lg">Batal</button>
                        <button type="submit"
                            class="py-2.5 px-5 text-white bg-blue-600 rounded-lg hover:bg-blue-700">Update Bahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="restock-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full backdrop-blur-sm bg-gray-900/50">
        <div class="relative p-4 w-full max-w-sm max-h-full">
            <div class="relative bg-white rounded-xl shadow-2xl">
                <div class="p-5 text-center">
                    <div
                        class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center mx-auto mb-4 text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Stok Masuk</h3>
                    <p id="restock-name" class="text-sm text-gray-500 mb-5 font-medium"></p>
                    <form id="restock-form" action="" method="POST">
                        @csrf
                        <div class="flex items-center justify-center gap-2 mb-6">
                            <input type="number" step="0.01" name="added_stock"
                                class="bg-gray-50 border border-gray-300 text-center text-xl font-bold rounded-lg w-24 p-2.5 focus:ring-emerald-500 focus:border-emerald-500"
                                placeholder="0" required>
                            <span id="restock-unit" class="text-gray-500 font-bold text-lg"></span>
                        </div>
                        <div class="flex justify-center gap-2">
                            <button data-modal-hide="restock-modal" type="button"
                                class="py-2 px-4 bg-white border border-gray-200 rounded-lg text-sm">Batal</button>
                            <button type="submit"
                                class="py-2 px-4 text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 text-sm font-bold shadow-md">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="delete-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full backdrop-blur-sm bg-gray-900/50">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-2xl shadow-2xl p-6 text-center">
                <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="text-red-600 w-8 h-8" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <h3 class="mb-2 text-lg font-normal text-gray-500">Yakin ingin menghapus bahan ini?</h3>
                <p id="delete-name" class="mb-6 text-xl font-bold text-gray-900"></p>
                <div class="flex items-center justify-center gap-3">
                    <button data-modal-hide="delete-modal" type="button"
                        class="m-0 inline-flex px-5 py-2.5 text-sm font-medium bg-white rounded-lg border border-gray-300 hover:bg-gray-100">Batal</button>
                    <form id="delete-form" action="" method="POST" class="m-0">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="m-0 inline-flex px-5 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">Ya,
                            Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function editMaterial(id, name, category, stock, min, unit, price) {
            document.getElementById('edit-form').action = '/bahan-baku/' + id;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-category').value = category;
            document.getElementById('edit-stock').value = stock;
            document.getElementById('edit-min').value = min;
            document.getElementById('edit-unit').value = unit;
            document.getElementById('edit-price').value = price;
        }

        function restockMaterial(id, name, unit) {
            document.getElementById('restock-form').action = '/bahan-baku/' + id + '/add-stock';
            document.getElementById('restock-name').innerText = name;
            document.getElementById('restock-unit').innerText = unit;
        }

        function deleteMaterial(id, name) {
            document.getElementById('delete-form').action = '/bahan-baku/' + id;
            document.getElementById('delete-name').innerText = name;
        }
    </script>
@endsection
