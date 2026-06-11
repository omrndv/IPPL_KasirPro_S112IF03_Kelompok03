@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-3xl font-black tracking-tight text-slate-950 md:text-4xl">Stok Bahan Baku</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">Kelola inventaris gudang, bahan resep, nilai stok, dan pantau batas minimum bahan baku.</p>
            </div>

            <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-blue-600 px-5 py-3 text-sm font-black text-white shadow-lg shadow-blue-600/20 transition hover:-translate-y-0.5 hover:bg-blue-700" type="button">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Bahan Baru
            </button>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
                <span class="font-black">Sukses!</span> {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">
                <span class="font-black">Gagal:</span>
                <ul class="mt-2 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div class="group relative overflow-hidden rounded-[2rem] border border-white/80 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/70">
                <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-blue-100/70 transition group-hover:scale-125"></div>
                <div class="relative">
                    <div class="mb-5 flex items-center justify-between">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <span class="rounded-full bg-slate-50 px-3 py-1 text-xs font-black text-slate-500">Item</span>
                    </div>
                    <p class="text-sm font-bold text-slate-400">Total Item Bahan</p>
                    <div class="mt-2 flex items-end gap-2">
                        <h4 class="text-4xl font-black tracking-tight text-slate-950">{{ $total_items }}</h4>
                        <span class="mb-1 text-sm font-bold text-slate-400">Macam</span>
                    </div>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-[2rem] border border-white/80 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/70">
                <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-rose-100/70 transition group-hover:scale-125"></div>
                <div class="relative">
                    <div class="mb-5 flex items-center justify-between">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-50 text-rose-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-black text-rose-600">Alert</span>
                    </div>
                    <p class="text-sm font-bold text-slate-400">Stok Kritis</p>
                    <div class="mt-2 flex items-end gap-2">
                        <h4 class="text-4xl font-black tracking-tight text-rose-600">{{ $critical_items }}</h4>
                        <span class="mb-1 text-sm font-bold text-slate-400">Item</span>
                    </div>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-[2rem] border border-slate-900 bg-slate-950 p-6 text-white shadow-xl shadow-slate-900/10 transition hover:-translate-y-1 hover:shadow-2xl hover:shadow-blue-600/20">
                <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-blue-500/30 blur-2xl transition group-hover:scale-125"></div>
                <div class="relative">
                    <div class="mb-5 flex items-center justify-between">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 text-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-black text-blue-100">Value</span>
                    </div>
                    <p class="text-sm font-bold text-slate-400">Estimasi Nilai Gudang</p>
                    <div class="mt-2 flex items-end gap-2">
                        <span class="mb-1 text-xl font-black text-slate-400">Rp</span>
                        <h4 class="text-3xl font-black tracking-tight">{{ number_format($total_value ?? 0, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('bahan.index') }}" method="GET" class="flex flex-col gap-4 rounded-[2rem] border border-white/80 bg-white p-4 shadow-sm md:flex-row md:items-center md:justify-between">
            <div class="relative w-full md:max-w-xl">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"></path>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm font-semibold text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" placeholder="Cari nama bahan baku...">
            </div>

            <div class="flex w-full flex-col gap-3 sm:flex-row md:w-auto">
                <select name="category" class="block w-full cursor-pointer rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-bold text-slate-600 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100 sm:w-52">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>

                <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-slate-950 px-5 py-3 text-sm font-black text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-blue-600">Cari</button>

                @if (request('search') || request('category'))
                    <a href="{{ route('bahan.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-rose-200 bg-rose-50 px-5 py-3 text-sm font-black text-rose-600 transition hover:bg-rose-100">Reset</a>
                @endif
            </div>
        </form>

        <div class="overflow-hidden rounded-[2rem] border border-white/80 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[920px] text-left text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50 text-xs uppercase tracking-[0.14em] text-slate-400">
                            <th class="px-6 py-4 font-black">Info Bahan Baku</th>
                            <th class="px-6 py-4 font-black">Kategori</th>
                            <th class="px-6 py-4 text-center font-black">Stok Saat Ini</th>
                            <th class="px-6 py-4 text-center font-black">Batas Min.</th>
                            <th class="px-6 py-4 text-center font-black">Status</th>
                            <th class="px-6 py-4 text-center font-black">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($raw_materials as $item)
                            @php $isCritical = $item->stock <= $item->min_stock; @endphp

                            <tr class="transition {{ $isCritical ? 'bg-rose-50/40 hover:bg-rose-50/70' : 'bg-white hover:bg-slate-50/80' }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl border border-slate-100 bg-slate-50 text-xl shadow-sm">
                                            {{ $item->category == 'Bahan Kering' ? '📦' : ($item->category == 'Bahan Basah' ? '🥛' : '🛍️') }}
                                        </div>
                                        <div class="min-w-0">
                                            <div class="truncate text-base font-black text-slate-950">{{ $item->name }}</div>
                                            <div class="mt-1 text-xs font-semibold text-slate-400">HPP: Rp {{ number_format($item->price_per_unit, 0, ',', '.') }} / {{ $item->unit }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-black text-slate-600">{{ $item->category }}</span>
                                </td>

                                <td class="px-6 py-4 text-center text-lg font-black {{ $isCritical ? 'text-rose-600' : 'text-slate-950' }}">
                                    {{ $item->stock + 0 }} <span class="text-xs font-semibold text-slate-400">{{ $item->unit }}</span>
                                </td>

                                <td class="px-6 py-4 text-center font-bold text-slate-500">{{ $item->min_stock + 0 }} {{ $item->unit }}</td>

                                <td class="px-6 py-4 text-center">
                                    @if ($isCritical)
                                        <span class="inline-flex rounded-full border border-rose-200 bg-rose-50 px-3 py-1 text-xs font-black text-rose-600">Kritis</span>
                                    @else
                                        <span class="inline-flex rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-black text-emerald-600">Aman</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" onclick="restockMaterial({{ $item->id }}, '{{ addslashes($item->name) }}', '{{ $item->unit }}')" data-modal-target="restock-modal" data-modal-toggle="restock-modal" class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 transition hover:bg-emerald-600 hover:text-white" title="Restock">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </button>

                                        <button type="button" onclick="editMaterial({{ $item->id }}, '{{ addslashes($item->name) }}', '{{ addslashes($item->category) }}', {{ $item->stock }}, {{ $item->min_stock }}, '{{ $item->unit }}', {{ $item->price_per_unit }})" data-modal-target="edit-modal" data-modal-toggle="edit-modal" class="flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 transition hover:bg-blue-600 hover:text-white" title="Edit">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>

                                        <button type="button" onclick="deleteMaterial({{ $item->id }}, '{{ addslashes($item->name) }}')" data-modal-target="delete-modal" data-modal-toggle="delete-modal" class="flex h-10 w-10 items-center justify-center rounded-2xl bg-rose-50 text-rose-600 transition hover:bg-rose-600 hover:text-white" title="Hapus">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-14 text-center">
                                    <div class="mx-auto flex max-w-sm flex-col items-center text-slate-400">
                                        <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-[1.5rem] bg-slate-50 text-3xl">📦</div>
                                        <p class="font-bold">Belum ada data stok bahan baku.</p>
                                        <p class="mt-1 text-sm">Tambahkan bahan baku untuk mulai mengelola inventaris gudang.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <datalist id="category-options">
        @foreach ($categories as $cat)
            <option value="{{ $cat }}"></option>
        @endforeach
    </datalist>

    <div id="crud-modal" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden bg-slate-950/50 backdrop-blur-sm md:inset-0">
        <div class="relative max-h-full w-full max-w-2xl p-4">
            <div class="relative rounded-[2rem] bg-white shadow-2xl shadow-slate-900/20">
                <div class="flex items-center justify-between border-b border-slate-100 p-5">
                    <div>
                        <h3 class="text-lg font-black text-slate-950">Tambah Bahan Baku</h3>
                        <p class="mt-1 text-sm font-semibold text-slate-400">Masukkan data bahan, stok awal, batas minimum, dan HPP.</p>
                    </div>
                    <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-slate-50 text-slate-400 transition hover:bg-slate-100 hover:text-slate-950" data-modal-toggle="crud-modal">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                        </svg>
                    </button>
                </div>

                <form class="p-5" action="{{ route('bahan.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2 sm:col-span-1">
                            <label class="mb-2 block text-sm font-bold text-slate-950">Nama Bahan <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label class="mb-2 block text-sm font-bold text-slate-950">Kategori <span class="text-rose-500">*</span></label>
                            <input list="category-options" name="category" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" placeholder="Pilih atau ketik kategori baru..." required autocomplete="off">
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label class="mb-2 block text-sm font-bold text-slate-950">Stok Awal <span class="text-rose-500">*</span></label>
                            <input type="number" step="0.01" name="stock" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label class="mb-2 block text-sm font-bold text-slate-950">Batas Minimum <span class="text-rose-500">*</span></label>
                            <input type="number" step="0.01" name="min_stock" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label class="mb-2 block text-sm font-bold text-slate-950">Satuan <span class="text-rose-500">*</span></label>
                            <select name="unit" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
                                <option value="Kg">Kg</option>
                                <option value="Gram">Gram</option>
                                <option value="Liter">Liter</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Box">Box</option>
                            </select>
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label class="mb-2 block text-sm font-bold text-slate-950">HPP per Satuan <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-sm font-black text-slate-400">Rp</div>
                                <input type="number" name="price_per_unit" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3 border-t border-slate-100 pt-5">
                        <button data-modal-hide="crud-modal" type="button" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-black text-slate-600 transition hover:bg-slate-50 hover:text-slate-950">Batal</button>
                        <button type="submit" class="rounded-2xl bg-blue-600 px-5 py-3 text-sm font-black text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700">Simpan Bahan</button>
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
                        <h3 class="text-lg font-black text-slate-950">Edit Bahan Baku</h3>
                        <p class="mt-1 text-sm font-semibold text-slate-400">Perbarui data bahan baku yang sudah tersimpan.</p>
                    </div>
                    <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-slate-50 text-slate-400 transition hover:bg-slate-100 hover:text-slate-950" data-modal-toggle="edit-modal">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                        </svg>
                    </button>
                </div>

                <form id="edit-form" class="p-5" action="" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2 sm:col-span-1">
                            <label class="mb-2 block text-sm font-bold text-slate-950">Nama Bahan</label>
                            <input type="text" name="name" id="edit-name" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label class="mb-2 block text-sm font-bold text-slate-950">Kategori</label>
                            <input list="category-options" name="category" id="edit-category" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" placeholder="Pilih atau ketik kategori baru..." required autocomplete="off">
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label class="mb-2 block text-sm font-bold text-slate-950">Stok</label>
                            <input type="number" step="0.01" name="stock" id="edit-stock" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label class="mb-2 block text-sm font-bold text-slate-950">Batas Min</label>
                            <input type="number" step="0.01" name="min_stock" id="edit-min" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label class="mb-2 block text-sm font-bold text-slate-950">Satuan</label>
                            <select name="unit" id="edit-unit" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
                                <option value="Kg">Kg</option>
                                <option value="Gram">Gram</option>
                                <option value="Liter">Liter</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Box">Box</option>
                            </select>
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label class="mb-2 block text-sm font-bold text-slate-950">HPP per Satuan</label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-sm font-black text-slate-400">Rp</div>
                                <input type="number" name="price_per_unit" id="edit-price" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3 border-t border-slate-100 pt-5">
                        <button data-modal-hide="edit-modal" type="button" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-black text-slate-600 transition hover:bg-slate-50 hover:text-slate-950">Batal</button>
                        <button type="submit" class="rounded-2xl bg-blue-600 px-5 py-3 text-sm font-black text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700">Update Bahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="restock-modal" tabindex="-1" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden bg-slate-950/50 backdrop-blur-sm md:inset-0">
        <div class="relative max-h-full w-full max-w-sm p-4">
            <div class="relative rounded-[2rem] bg-white shadow-2xl shadow-slate-900/20">
                <div class="p-6 text-center">
                    <div class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-[1.5rem] bg-emerald-50 text-emerald-600">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-black text-slate-950">Stok Masuk</h3>
                    <p id="restock-name" class="mb-5 mt-1 text-sm font-bold text-slate-400"></p>

                    <form id="restock-form" action="" method="POST">
                        @csrf
                        <div class="mb-6 flex items-center justify-center gap-2">
                            <input type="number" step="0.01" name="added_stock" class="w-28 rounded-2xl border border-slate-200 bg-slate-50 p-3 text-center text-xl font-black text-slate-950 outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-100" placeholder="0" required>
                            <span id="restock-unit" class="text-lg font-black text-slate-500"></span>
                        </div>
                        <div class="flex justify-center gap-2">
                            <button data-modal-hide="restock-modal" type="button" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-black text-slate-600 transition hover:bg-slate-50 hover:text-slate-950">Batal</button>
                            <button type="submit" class="rounded-2xl bg-emerald-600 px-5 py-3 text-sm font-black text-white shadow-lg shadow-emerald-600/20 transition hover:bg-emerald-700">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="delete-modal" tabindex="-1" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden bg-slate-950/50 backdrop-blur-sm md:inset-0">
        <div class="relative max-h-full w-full max-w-md p-4">
            <div class="relative rounded-[2rem] bg-white p-7 text-center shadow-2xl shadow-slate-900/20">
                <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-[1.5rem] bg-rose-50 text-rose-600">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                    </svg>
                </div>
                <h3 class="mb-2 text-lg font-black text-slate-950">Yakin ingin menghapus bahan ini?</h3>
                <p id="delete-name" class="mb-7 text-xl font-black text-rose-600"></p>
                <div class="flex items-center justify-center gap-3">
                    <button data-modal-hide="delete-modal" type="button" class="inline-flex rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-black text-slate-600 transition hover:bg-slate-50 hover:text-slate-950">Batal</button>
                    <form id="delete-form" action="" method="POST" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex rounded-2xl bg-rose-600 px-5 py-3 text-sm font-black text-white shadow-lg shadow-rose-600/20 transition hover:bg-rose-700">Ya, Hapus</button>
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