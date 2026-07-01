@extends('layouts.app')

@section('content')
    @php
        $outletName = $outlet->name ?? 'KasirPro Outlet';
        $outletPhone = $outlet->phone ?? '0812-3456-7890';
        $outletAddress = $outlet->address ?? 'Alamat toko belum diatur';

        $taxEnabled = ($settings['tax_enabled'] ?? '1') == '1';
        $taxRate = $settings['tax_rate'] ?? 10;
        $targetSales = $settings['target_sales'] ?? 0;
        $receiptFooter = $settings['receipt_footer'] ?? "Terima kasih telah berkunjung!\nBarang yang sudah dibeli tidak dapat ditukar/dikembalikan.";

        $userName = $user->name ?? 'Admin KasirPro';
        $userEmail = $user->email ?? 'admin@kasirpro.com';
        $userRole = $user->role ?? 'owner';

        $roleLabel = match ($userRole) {
            'owner' => 'Owner',
            'admin' => 'Admin',
            'cashier' => 'Kasir',
            default => ucfirst($userRole),
        };

        $initials = collect(explode(' ', $userName))
            ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
            ->take(2)
            ->implode('');
    @endphp

    <div class="space-y-6">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-3xl font-black tracking-tight text-slate-950 md:text-4xl">
                    Pengaturan Sistem
                </h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                    Sesuaikan profil pengguna, informasi outlet, pengaturan pajak, dan format struk pelanggan.
                </p>
            </div>
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

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="space-y-6">
                <div class="overflow-hidden rounded-[2rem] border border-white/80 bg-white shadow-sm">
                    <div class="border-b border-slate-100 p-6">
                        <h2 class="text-lg font-black text-slate-950">Profil Pengguna</h2>
                        <p class="mt-1 text-sm font-semibold text-slate-400">
                            Kelola akun pengguna yang sedang login.
                        </p>
                    </div>

                    <div class="p-6">
                        <div class="mb-6 flex flex-col items-center text-center">
                            <div class="mb-4 flex h-20 w-20 items-center justify-center rounded-[2rem] bg-blue-50 text-2xl font-black text-blue-600 shadow-sm">
                                {{ $initials ?: 'AD' }}
                            </div>

                            <h3 class="text-lg font-black text-slate-950">
                                {{ $userName }}
                            </h3>

                            <p class="mt-1 text-sm font-semibold text-slate-400">
                                {{ $userEmail }}
                            </p>

                            <span class="mt-3 rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-xs font-black text-blue-700">
                                {{ $roleLabel }} · {{ $outletName }}
                            </span>
                        </div>

                        <form action="{{ route('settings.profile.update') }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label class="mb-2 block text-sm font-bold text-slate-950">
                                    Nama Tampilan
                                </label>
                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name', $userName) }}"
                                    required
                                    class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                >
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-bold text-slate-950">
                                    Email
                                </label>
                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email', $userEmail) }}"
                                    required
                                    class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                >
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-bold text-slate-950">
                                    Password Baru
                                </label>
                                <input
                                    type="password"
                                    name="password"
                                    placeholder="Kosongkan jika tidak diganti"
                                    class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                >
                            </div>

                            <button
                                type="submit"
                                class="w-full rounded-2xl bg-blue-600 px-5 py-3 text-sm font-black text-white shadow-lg shadow-blue-600/20 transition hover:-translate-y-0.5 hover:bg-blue-700"
                            >
                                Perbarui Profil
                            </button>
                        </form>
                    </div>
                </div>

                <div class="rounded-[2rem] border border-white/80 bg-slate-950 p-6 text-white shadow-xl shadow-slate-900/10">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>

                    <h3 class="text-lg font-black">Pengaturan Outlet Aman</h3>
                    <p class="mt-2 text-sm font-semibold leading-6 text-slate-400">
                        Informasi toko tersimpan per outlet, jadi setiap akun bisa punya identitas outlet masing-masing.
                    </p>
                </div>
            </div>

            <div class="space-y-6 xl:col-span-2">
                <div class="overflow-hidden rounded-[2rem] border border-white/80 bg-white shadow-sm">
                    <div class="border-b border-slate-100 p-6">
                        <h2 class="text-lg font-black text-slate-950">Informasi Outlet</h2>
                        <p class="mt-1 text-sm font-semibold text-slate-400">
                            Data ini akan digunakan sebagai identitas outlet dan struk transaksi.
                        </p>
                    </div>

                    <form action="{{ route('settings.store.update') }}" method="POST" class="p-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-bold text-slate-950">
                                    Nama Outlet / Toko
                                </label>
                                <input
                                    type="text"
                                    name="store_name"
                                    value="{{ old('store_name', $outletName) }}"
                                    required
                                    class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                >
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-bold text-slate-950">
                                    Nomor Telepon / WA
                                </label>
                                <input
                                    type="text"
                                    name="store_phone"
                                    value="{{ old('store_phone', $outletPhone) }}"
                                    required
                                    class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                >
                            </div>

                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-bold text-slate-950">
                                    Alamat Lengkap
                                </label>
                                <textarea
                                    name="store_address"
                                    rows="3"
                                    required
                                    class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                >{{ old('store_address', $outletAddress) }}</textarea>
                                <p class="mt-2 text-xs font-semibold text-slate-400">
                                    Alamat ini akan ditampilkan pada struk pelanggan.
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end border-t border-slate-100 pt-5">
                            <button
                                type="submit"
                                class="rounded-2xl bg-blue-600 px-5 py-3 text-sm font-black text-white shadow-lg shadow-blue-600/20 transition hover:-translate-y-0.5 hover:bg-blue-700"
                            >
                                Simpan Informasi Outlet
                            </button>
                        </div>
                    </form>
                </div>

                <div class="overflow-hidden rounded-[2rem] border border-white/80 bg-white shadow-sm">
                    <div class="border-b border-slate-100 p-6">
                        <h2 class="text-lg font-black text-slate-950">Pengaturan Transaksi & Struk</h2>
                        <p class="mt-1 text-sm font-semibold text-slate-400">
                            Atur pajak transaksi dan pesan footer struk.
                        </p>
                    </div>

                    <form action="{{ route('settings.receipt.update') }}" method="POST" class="p-6">
                        @csrf
                        @method('PUT')

                        <div class="space-y-5">
                            <label class="flex cursor-pointer items-center justify-between gap-4 rounded-[1.5rem] border border-slate-100 bg-slate-50 p-4">
                                <div>
                                    <span class="block text-sm font-black text-slate-950">
                                        Terapkan Pajak
                                    </span>
                                    <span class="mt-1 block text-xs font-semibold text-slate-400">
                                        Otomatis tambahkan pajak pada setiap transaksi.
                                    </span>
                                </div>

                                <input
                                    type="checkbox"
                                    name="tax_enabled"
                                    value="1"
                                    class="peer sr-only"
                                    {{ old('tax_enabled', $taxEnabled) ? 'checked' : '' }}
                                >

                                <div class="relative h-6 w-11 rounded-full bg-slate-200 transition peer-checked:bg-blue-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-100 after:absolute after:start-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-slate-300 after:bg-white after:transition-all after:content-[''] peer-checked:after:translate-x-full peer-checked:after:border-white rtl:peer-checked:after:-translate-x-full"></div>
                            </label>

                             <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <div>
                                    <label class="mb-2 block text-sm font-bold text-slate-950">
                                        Besaran Pajak (%)
                                    </label>
                                    <input
                                        type="number"
                                        name="tax_rate"
                                        min="0"
                                        max="100"
                                        step="0.01"
                                        value="{{ old('tax_rate', $taxRate) }}"
                                        required
                                        class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                    >
                                </div>

                                <div class="md:col-span-2">
                                    <label class="mb-2 block text-sm font-bold text-slate-950">
                                        Target Penjualan Bulanan (Rp)
                                    </label>
                                    <input
                                        type="number"
                                        name="target_sales"
                                        min="0"
                                        step="1000"
                                        value="{{ old('target_sales', $targetSales) }}"
                                        required
                                        class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                        placeholder="Contoh: 10000000"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="my-6 border-t border-slate-100"></div>

                        <div>
                            <label class="mb-2 block text-sm font-bold text-slate-950">
                                Pesan Footer Struk
                            </label>
                            <textarea
                                name="receipt_footer"
                                rows="3"
                                required
                                class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                            >{{ old('receipt_footer', $receiptFooter) }}</textarea>
                        </div>

                        <div class="mt-6 flex justify-end border-t border-slate-100 pt-5">
                            <button
                                type="submit"
                                class="rounded-2xl bg-blue-600 px-5 py-3 text-sm font-black text-white shadow-lg shadow-blue-600/20 transition hover:-translate-y-0.5 hover:bg-blue-700"
                            >
                                Simpan Pengaturan Struk
                            </button>
                        </div>
                    </form>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div class="rounded-[2rem] border border-white/80 bg-white p-5 shadow-sm">
                        <p class="text-xs font-black uppercase tracking-[0.16em] text-slate-400">Outlet</p>
                        <h3 class="mt-2 truncate text-2xl font-black text-slate-950">
                            {{ $outletName }}
                        </h3>
                    </div>

                    <div class="rounded-[2rem] border border-white/80 bg-white p-5 shadow-sm">
                        <p class="text-xs font-black uppercase tracking-[0.16em] text-slate-400">Tax Rate</p>
                        <h3 class="mt-2 text-2xl font-black text-slate-950">
                            {{ $taxEnabled ? $taxRate . '%' : 'Off' }}
                        </h3>
                    </div>

                    <div class="rounded-[2rem] border border-white/80 bg-white p-5 shadow-sm">
                        <p class="text-xs font-black uppercase tracking-[0.16em] text-slate-400">Role</p>
                        <h3 class="mt-2 text-2xl font-black text-slate-950">
                            {{ $roleLabel }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection