@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h1 class="text-3xl font-black tracking-tight text-slate-950 md:text-4xl">Manajemen Voucher & Diskon</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">Buat, aktifkan, dan atur kode promo diskon nominal maupun persentase untuk outlet tokomu.</p>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row">
            <button data-modal-target="voucher-modal" data-modal-toggle="voucher-modal" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-blue-600 px-5 py-3 text-sm font-black text-white shadow-lg shadow-blue-600/20 transition hover:-translate-y-0.5 hover:bg-blue-700" type="button">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Voucher
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

    <div class="overflow-hidden rounded-[2rem] border border-white/80 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[980px] text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50 text-xs uppercase tracking-[0.14em] text-slate-400">
                        <th scope="col" class="px-6 py-4 font-black">Kode & Nama</th>
                        <th scope="col" class="px-6 py-4 font-black">Tipe Potongan</th>
                        <th scope="col" class="px-6 py-4 text-right font-black">Besar Diskon</th>
                        <th scope="col" class="px-6 py-4 text-right font-black">Min. Belanja</th>
                        <th scope="col" class="px-6 py-4 text-center font-black">Status</th>
                        <th scope="col" class="px-6 py-4 text-center font-black">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($vouchers as $voucher)
                    <tr class="bg-white transition hover:bg-slate-50/80">
                        <td class="px-6 py-4">
                            <div class="min-w-0">
                                <h3 class="truncate text-base font-black text-slate-950">{{ $voucher->name }}</h3>
                                <p class="mt-1 font-mono text-xs font-bold text-blue-600 uppercase tracking-widest">{{ $voucher->code }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-600">
                            {{ $voucher->type === 'fixed' ? 'Nominal (Rupiah)' : 'Persentase (%)' }}
                        </td>
                        <td class="px-6 py-4 text-right font-black text-slate-950">
                            {{ $voucher->type === 'fixed' ? 'Rp ' . number_format($voucher->value, 0, ',', '.') : $voucher->value . '%' }}
                        </td>
                        <td class="px-6 py-4 text-right font-black text-slate-950">
                            Rp {{ number_format($voucher->min_purchase, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if ($voucher->is_active)
                            <span class="inline-flex items-center rounded-full border border-emerald-100 bg-emerald-50 px-2.5 py-1 text-xs font-black text-emerald-600">
                                Aktif
                            </span>
                            @else
                            <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-100 px-2.5 py-1 text-xs font-black text-slate-400">
                                Nonaktif
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" 
                                        onclick="openEditModal({{ json_encode($voucher) }})" 
                                        class="rounded-xl border border-slate-200 bg-white p-2 text-slate-500 shadow-sm transition hover:bg-slate-50 hover:text-blue-600">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </button>
                                <form action="{{ route('voucher.destroy', $voucher->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus voucher ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-xl border border-rose-100 bg-rose-50 p-2 text-rose-500 shadow-sm transition hover:bg-rose-100 hover:text-rose-700">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center font-bold text-slate-400">
                            Belum ada voucher terdaftar di outlet ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tambah / Edit Modal -->
<div id="voucher-modal" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden bg-slate-950/40 backdrop-blur-sm md:inset-0">
    <div class="relative max-h-full w-full max-w-md p-4">
        <div class="relative rounded-[2rem] border border-white/80 bg-white shadow-2xl shadow-slate-900/20">
            <div class="flex items-center justify-between border-b border-slate-100 p-5">
                <div>
                    <h3 id="modal-title" class="text-lg font-black text-slate-950">Tambah Voucher</h3>
                    <p class="mt-1 text-sm font-semibold text-slate-400">Atur parameter voucher promo.</p>
                </div>
                <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-slate-50 text-slate-400 transition hover:bg-slate-100 hover:text-slate-950" data-modal-hide="voucher-modal">
                    <svg class="h-3.5 w-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                    </svg>
                </button>
            </div>

            <form id="voucher-form" action="{{ route('voucher.store') }}" method="POST" class="p-5">
                @csrf
                <div id="method-field"></div>
                
                <div class="space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-950">Kode Voucher (Kapital, tanpa spasi)</label>
                        <input type="text" name="code" id="input-code" required class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" placeholder="E.g., PROMO10K">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-950">Nama Voucher</label>
                        <input type="text" name="name" id="input-name" required class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" placeholder="E.g., Diskon Grand Opening">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="mb-2 block text-sm font-bold text-slate-950">Tipe Potongan</label>
                            <select name="type" id="input-type" class="block w-full cursor-pointer rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-bold text-slate-600 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                                <option value="fixed">Rupiah (Rp)</option>
                                <option value="percent">Persen (%)</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-bold text-slate-950">Nilai Potongan</label>
                            <input type="number" name="value" id="input-value" min="1" required class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" placeholder="E.g., 5000">
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-950">Minimal Belanja (Rp)</label>
                        <input type="number" name="min_purchase" id="input-min-purchase" min="0" value="0" required class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                    </div>

                    <label class="flex cursor-pointer items-center justify-between gap-4 rounded-[1.5rem] border border-slate-100 bg-slate-50 p-4">
                        <div>
                            <span class="block text-sm font-black text-slate-950">Aktifkan Voucher</span>
                            <span class="mt-1 block text-xs font-semibold text-slate-400">Voucher bisa langsung digunakan kasir.</span>
                        </div>
                        <input type="checkbox" name="is_active" id="input-active" value="1" class="peer sr-only" checked>
                        <div class="relative h-6 w-11 rounded-full bg-slate-200 transition peer-checked:bg-blue-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-100 after:absolute after:start-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-slate-300 after:bg-white after:transition-all after:content-[''] peer-checked:after:translate-x-full peer-checked:after:border-white rtl:peer-checked:after:-translate-x-full"></div>
                    </label>
                </div>

                <div class="mt-6 flex justify-end gap-2 border-t border-slate-100 pt-5">
                    <button type="button" class="rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-black text-slate-600 transition hover:bg-slate-100 hover:text-slate-950" data-modal-hide="voucher-modal">
                        Batal
                    </button>
                    <button type="submit" class="rounded-2xl bg-blue-600 px-5 py-2.5 text-sm font-black text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700">
                        Simpan Voucher
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditModal(voucher) {
        document.getElementById('modal-title').innerText = 'Edit Voucher';
        const form = document.getElementById('voucher-form');
        form.action = `/voucher/${voucher.id}`;
        
        document.getElementById('method-field').innerHTML = '<input type="hidden" name="_method" value="PUT">';
        
        document.getElementById('input-code').value = voucher.code;
        document.getElementById('input-name').value = voucher.name;
        document.getElementById('input-type').value = voucher.type;
        document.getElementById('input-value').value = voucher.value;
        document.getElementById('input-min-purchase').value = voucher.min_purchase;
        document.getElementById('input-active').checked = voucher.is_active;

        const modal = document.getElementById('voucher-modal');
        // Flowbite show logic helper
        const modalInstance = new Modal(modal);
        modalInstance.show();
    }

    // Reset form when clicking Close or opening add modal
    document.querySelector('[data-modal-target="voucher-modal"]').addEventListener('click', () => {
        document.getElementById('modal-title').innerText = 'Tambah Voucher';
        const form = document.getElementById('voucher-form');
        form.action = "{{ route('voucher.store') }}";
        document.getElementById('method-field').innerHTML = '';
        form.reset();
        document.getElementById('input-active').checked = true;
    });
</script>
@endsection
