@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 pb-12">
    <!-- Header -->
    <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-black tracking-tight text-slate-950 md:text-4xl">Dashboard Super Admin</h1>
            <p class="mt-2 text-sm leading-6 text-slate-500">Kelola seluruh akun pengguna dan outlet terdaftar di sistem KasirPro secara terpusat.</p>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
    <div class="mb-6 flex items-center rounded-2xl border border-emerald-100 bg-emerald-50 p-4 text-emerald-800">
        <svg class="mr-3 h-5 w-5 shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div class="text-sm font-bold">{{ session('success') }}</div>
    </div>
    @endif

    @if (session('error'))
    <div class="mb-6 flex items-center rounded-2xl border border-rose-100 bg-rose-50 p-4 text-rose-800">
        <svg class="mr-3 h-5 w-5 shrink-0 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div class="text-sm font-bold">{{ session('error') }}</div>
    </div>
    @endif

    @if ($errors->any())
    <div class="mb-6 rounded-2xl border border-rose-100 bg-rose-50 p-4 text-rose-800">
        <div class="flex items-center mb-2">
            <svg class="mr-3 h-5 w-5 shrink-0 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <div class="text-sm font-bold">Terjadi kesalahan input data:</div>
        </div>
        <ul class="list-disc pl-8 text-xs font-semibold space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Metrics Cards Grid -->
    <div class="mb-8 grid grid-cols-2 gap-4 lg:grid-cols-4">
        <!-- Card: Total Users -->
        <div class="rounded-[2rem] border border-white bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.16em] text-slate-400">Total Akun</p>
                    <h3 class="mt-2 text-3xl font-black text-slate-950">{{ $totalUsers }}</h3>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-2xl">👥</div>
            </div>
            <div class="mt-4 border-t border-slate-50 pt-3 text-xs text-slate-400">
                <span class="font-bold text-blue-600">{{ $superadminsCount }}</span> Super Admin ·
                <span class="font-bold text-slate-700">{{ $ownersCount }}</span> Owner
            </div>
        </div>

        <!-- Card: Total Outlets -->
        <div class="rounded-[2rem] border border-white bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.16em] text-slate-400">Total Outlet</p>
                    <h3 class="mt-2 text-3xl font-black text-slate-950">{{ $totalOutlets }}</h3>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-2xl">🏪</div>
            </div>
            <div class="mt-4 border-t border-slate-50 pt-3 text-xs text-slate-400">
                Tempat bisnis yang saat ini aktif terdaftar.
            </div>
        </div>

        <!-- Card: Active Admins -->
        <div class="rounded-[2rem] border border-white bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.16em] text-slate-400">Pengelola Admin</p>
                    <h3 class="mt-2 text-3xl font-black text-slate-950">{{ $adminsCount }}</h3>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-2xl">🔑</div>
            </div>
            <div class="mt-4 border-t border-slate-50 pt-3 text-xs text-slate-400">
                Akun yang memiliki hak akses kelola master.
            </div>
        </div>

        <!-- Card: Active Cashiers -->
        <div class="rounded-[2rem] border border-white bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.16em] text-slate-400">Karyawan Kasir</p>
                    <h3 class="mt-2 text-3xl font-black text-slate-950">{{ $cashiersCount }}</h3>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-purple-50 text-2xl">💼</div>
            </div>
            <div class="mt-4 border-t border-slate-50 pt-3 text-xs text-slate-400">
                Karyawan yang bertugas melayani transaksi POS.
            </div>
        </div>
    </div>

    <!-- Dual Tabbed Panel -->
    <div class="rounded-[2rem] border border-white bg-white p-6 shadow-sm">
        <!-- Tab Headers -->
        <div class="mb-6 border-b border-slate-100 pb-3">
            <ul class="flex flex-wrap -mb-px text-sm font-bold text-center" id="dashboard-tab-list" data-tabs-toggle="#dashboard-tab-content" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg transition hover:text-blue-600 focus:outline-none" id="users-tab" data-tabs-target="#users-panel" type="button" role="tab" aria-controls="users-panel" aria-selected="true">
                        👥 Manajemen Akun Pengguna
                    </button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg transition hover:text-blue-600 focus:outline-none" id="outlets-tab" data-tabs-target="#outlets-panel" type="button" role="tab" aria-controls="outlets-panel" aria-selected="false">
                        🏪 Manajemen Outlet Terdaftar
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tab Panels -->
        <div id="dashboard-tab-content">
            <!-- TAB 1: USER MANAGEMENT -->
            <div class="hidden" id="users-panel" role="tabpanel" aria-labelledby="users-tab">
                <!-- Filters Row -->
                <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <form action="{{ route('superadmin.dashboard') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full lg:max-w-2xl">
                        <!-- Search Input -->
                        <div class="relative flex-1 min-w-[200px]">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 py-2.5 pl-11 pr-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" placeholder="Cari nama, username, email...">
                        </div>

                        <!-- Role Filter -->
                        <select name="role" class="rounded-2xl border border-slate-200 bg-slate-50 py-2.5 px-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                            <option value="">Semua Role</option>
                            <option value="superadmin" {{ request('role') == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                            <option value="owner" {{ request('role') == 'owner' ? 'selected' : '' }}>Owner</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="cashier" {{ request('role') == 'cashier' ? 'selected' : '' }}>Cashier</option>
                        </select>

                        <!-- Outlet Filter -->
                        <select name="outlet_id" class="rounded-2xl border border-slate-200 bg-slate-50 py-2.5 px-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                            <option value="">Semua Outlet</option>
                            @foreach ($outlets as $outlet)
                                <option value="{{ $outlet->id }}" {{ request('outlet_id') == $outlet->id ? 'selected' : '' }}>{{ $outlet->name }}</option>
                            @endforeach
                        </select>

                        <button type="submit" class="rounded-2xl bg-slate-900 px-5 py-2.5 text-sm font-black text-white hover:bg-slate-800 transition">
                            Cari
                        </button>
                        @if (request()->filled('search') || request()->filled('role') || request()->filled('outlet_id'))
                            <a href="{{ route('superadmin.dashboard') }}" class="rounded-2xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-black text-slate-600 hover:bg-slate-50 transition">
                                Reset
                            </a>
                        @endif
                    </form>

                    <!-- Add User Action -->
                    <button type="button" data-modal-target="add-user-modal" data-modal-toggle="add-user-modal" class="inline-flex items-center gap-2 rounded-2xl bg-blue-600 px-5 py-3 text-sm font-black text-white shadow-lg shadow-blue-600/20 hover:bg-blue-700 transition">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        <span>Tambah Pengguna</span>
                    </button>
                </div>

                <!-- Users Table -->
                <div class="overflow-x-auto rounded-3xl border border-slate-100">
                    <table class="w-full text-left text-sm text-slate-500">
                        <thead class="bg-slate-50 text-xs font-black uppercase tracking-wider text-slate-400">
                            <tr>
                                <th scope="col" class="px-6 py-4">Nama Pengguna</th>
                                <th scope="col" class="px-6 py-4">Role</th>
                                <th scope="col" class="px-6 py-4">Outlet Terhubung</th>
                                <th scope="col" class="px-6 py-4">Bergabung Pada</th>
                                <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($users as $user)
                            <tr class="hover:bg-slate-50/50 transition duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-sm font-black text-blue-600">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <div class="truncate text-base font-black text-slate-950">{{ $user->name }}</div>
                                            <div class="mt-0.5 text-xs font-semibold text-slate-400">@ {{ $user->username }} · {{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($user->role === 'superadmin')
                                        <span class="inline-flex rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-xs font-black text-blue-700">Super Admin</span>
                                    @elseif ($user->role === 'owner')
                                        <span class="inline-flex rounded-full border border-slate-200 bg-slate-100 px-3 py-1 text-xs font-black text-slate-700">Owner</span>
                                    @elseif ($user->role === 'admin')
                                        <span class="inline-flex rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-black text-emerald-700">Admin</span>
                                    @else
                                        <span class="inline-flex rounded-full border border-purple-200 bg-purple-50 px-3 py-1 text-xs font-black text-purple-700">Kasir</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if ($user->role === 'superadmin')
                                        <span class="text-xs font-bold italic text-slate-400">- Seluruh Outlet -</span>
                                    @else
                                        <span class="text-sm font-bold text-slate-700">{{ $user->outlet->name ?? 'Tidak Terhubung' }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-xs font-semibold text-slate-400">
                                    {{ $user->created_at ? $user->created_at->format('d M Y, H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Action: Edit -->
                                        <button type="button" 
                                            class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600 transition hover:bg-blue-600 hover:text-white" 
                                            title="Edit Pengguna" 
                                            data-modal-target="edit-user-modal" 
                                            data-modal-toggle="edit-user-modal"
                                            onclick="editUser({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->username) }}', '{{ addslashes($user->email) }}', '{{ $user->role }}', '{{ $user->outlet_id }}')">
                                            <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>

                                        <!-- Action: Reset Password -->
                                        <button type="button" 
                                            class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-50 text-amber-600 transition hover:bg-amber-600 hover:text-white" 
                                            title="Reset Password" 
                                            data-modal-target="password-user-modal" 
                                            data-modal-toggle="password-user-modal"
                                            onclick="resetPassword({{ $user->id }}, '{{ addslashes($user->name) }}')">
                                            <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        </button>

                                        <!-- Action: Delete -->
                                        @if ($user->id !== auth()->id())
                                        <button type="button" 
                                            class="flex h-9 w-9 items-center justify-center rounded-xl bg-rose-50 text-rose-600 transition hover:bg-rose-600 hover:text-white" 
                                            title="Hapus Pengguna" 
                                            data-modal-target="delete-user-modal" 
                                            data-modal-toggle="delete-user-modal"
                                            onclick="deleteUser({{ $user->id }}, '{{ addslashes($user->name) }}')">
                                            <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-semibold">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="text-4xl mb-3">🔍</div>
                                        <div>Tidak ada akun pengguna yang ditemukan.</div>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $users->links() }}
                </div>
            </div>

            <!-- TAB 2: OUTLET MANAGEMENT -->
            <div class="hidden" id="outlets-panel" role="tabpanel" aria-labelledby="outlets-tab">
                <!-- Header Actions -->
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-black text-slate-950">Daftar Outlet KasirPro</h3>
                        <p class="text-xs font-semibold text-slate-400">Total terdaftar {{ $totalOutlets }} outlet di sistem.</p>
                    </div>

                    <button type="button" data-modal-target="add-outlet-modal" data-modal-toggle="add-outlet-modal" class="inline-flex items-center gap-2 rounded-2xl bg-amber-500 px-5 py-3 text-sm font-black text-white shadow-lg shadow-amber-500/20 hover:bg-amber-600 transition">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        <span>Tambah Outlet Baru</span>
                    </button>
                </div>

                <!-- Outlets Table -->
                <div class="overflow-x-auto rounded-3xl border border-slate-100">
                    <table class="w-full text-left text-sm text-slate-500">
                        <thead class="bg-slate-50 text-xs font-black uppercase tracking-wider text-slate-400">
                            <tr>
                                <th scope="col" class="px-6 py-4">ID</th>
                                <th scope="col" class="px-6 py-4">Nama Outlet</th>
                                <th scope="col" class="px-6 py-4">Telepon</th>
                                <th scope="col" class="px-6 py-4">Alamat</th>
                                <th scope="col" class="px-6 py-4">Tanggal Dibuat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($outlets as $out)
                            <tr class="hover:bg-slate-50/50 transition duration-150">
                                <td class="px-6 py-4 font-bold text-slate-900">#{{ $out->id }}</td>
                                <td class="px-6 py-4 font-black text-slate-950">{{ $out->name }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-slate-700">{{ $out->phone ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-slate-500 max-w-xs truncate" title="{{ $out->address }}">{{ $out->address ?? '-' }}</td>
                                <td class="px-6 py-4 text-xs font-semibold text-slate-400">{{ $out->created_at ? $out->created_at->format('d M Y') : '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-semibold">
                                    Tidak ada data outlet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- MODAL: ADD USER -->
<!-- ============================================== -->
<div id="add-user-modal" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden bg-slate-950/40 backdrop-blur-sm md:inset-0">
    <div class="relative max-h-full w-full max-w-md p-4">
        <div class="relative rounded-[2rem] border border-white bg-white shadow-2xl">
            <div class="flex items-center justify-between border-b border-slate-100 p-5">
                <div>
                    <h3 class="text-lg font-black text-slate-950">Tambah Pengguna Baru</h3>
                    <p class="mt-1 text-sm font-semibold text-slate-400">Buat akun untuk kasir, admin, atau owner baru.</p>
                </div>
                <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-slate-50 text-slate-400 hover:bg-slate-100 hover:text-slate-950" data-modal-hide="add-user-modal">
                    <svg class="h-3.5 w-3.5" aria-hidden="true" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                    </svg>
                </button>
            </div>

            <form action="{{ route('superadmin.users.store') }}" method="POST" class="p-5">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-950">Nama Lengkap</label>
                        <input type="text" name="name" required class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" placeholder="Contoh: Budi Santoso">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-950">Username</label>
                        <input type="text" name="username" required class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" placeholder="Contoh: budi_s">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-950">Email</label>
                        <input type="email" name="email" required class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" placeholder="Contoh: budi@gmail.com">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-950">Password</label>
                        <input type="password" name="password" required class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" placeholder="Minimal 8 karakter">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="mb-2 block text-sm font-bold text-slate-950">Role</label>
                            <select name="role" id="add-user-role" onchange="toggleAddOutletSelect()" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                                <option value="cashier">Kasir</option>
                                <option value="admin">Admin</option>
                                <option value="owner">Owner</option>
                                <option value="superadmin">Super Admin</option>
                            </select>
                        </div>

                        <div id="add-user-outlet-container">
                            <label class="mb-2 block text-sm font-bold text-slate-950">Outlet</label>
                            <select name="outlet_id" id="add-user-outlet" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                                @foreach ($outlets as $outlet)
                                    <option value="{{ $outlet->id }}">{{ $outlet->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-3 border-t border-slate-100 pt-5">
                    <button data-modal-hide="add-user-modal" type="button" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-black text-slate-600 hover:bg-slate-50 transition">Batal</button>
                    <button type="submit" class="rounded-2xl bg-blue-600 px-5 py-3 text-sm font-black text-white hover:bg-blue-700 shadow-lg shadow-blue-600/20 transition">Buat Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- MODAL: EDIT USER -->
<!-- ============================================== -->
<div id="edit-user-modal" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden bg-slate-950/40 backdrop-blur-sm md:inset-0">
    <div class="relative max-h-full w-full max-w-md p-4">
        <div class="relative rounded-[2rem] border border-white bg-white shadow-2xl">
            <div class="flex items-center justify-between border-b border-slate-100 p-5">
                <div>
                    <h3 class="text-lg font-black text-slate-950">Edit Data Pengguna</h3>
                    <p class="mt-1 text-sm font-semibold text-slate-400">Ubah informasi akun yang sudah terdaftar.</p>
                </div>
                <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-slate-50 text-slate-400 hover:bg-slate-100 hover:text-slate-950" data-modal-hide="edit-user-modal">
                    <svg class="h-3.5 w-3.5" aria-hidden="true" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                    </svg>
                </button>
            </div>

            <form id="edit-user-form" action="" method="POST" class="p-5">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-950">Nama Lengkap</label>
                        <input type="text" name="name" id="edit-name" required class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-950">Username</label>
                        <input type="text" name="username" id="edit-username" required class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-950">Email</label>
                        <input type="email" name="email" id="edit-email" required class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="mb-2 block text-sm font-bold text-slate-950">Role</label>
                            <select name="role" id="edit-role" onchange="toggleEditOutletSelect()" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                                <option value="cashier">Kasir</option>
                                <option value="admin">Admin</option>
                                <option value="owner">Owner</option>
                                <option value="superadmin">Super Admin</option>
                            </select>
                        </div>

                        <div id="edit-outlet-container">
                            <label class="mb-2 block text-sm font-bold text-slate-950">Outlet</label>
                            <select name="outlet_id" id="edit-outlet" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                                @foreach ($outlets as $outlet)
                                    <option value="{{ $outlet->id }}">{{ $outlet->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-3 border-t border-slate-100 pt-5">
                    <button data-modal-hide="edit-user-modal" type="button" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-black text-slate-600 hover:bg-slate-50 transition">Batal</button>
                    <button type="submit" class="rounded-2xl bg-blue-600 px-5 py-3 text-sm font-black text-white hover:bg-blue-700 shadow-lg shadow-blue-600/20 transition">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- MODAL: RESET PASSWORD -->
<!-- ============================================== -->
<div id="password-user-modal" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden bg-slate-950/40 backdrop-blur-sm md:inset-0">
    <div class="relative max-h-full w-full max-w-md p-4">
        <div class="relative rounded-[2rem] border border-white bg-white shadow-2xl">
            <div class="flex items-center justify-between border-b border-slate-100 p-5">
                <div>
                    <h3 class="text-lg font-black text-slate-950">Reset Password</h3>
                    <p class="mt-1 text-sm font-semibold text-slate-400">Ganti password untuk pengguna: <span id="reset-password-target" class="font-bold text-blue-600"></span></p>
                </div>
                <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-slate-50 text-slate-400 hover:bg-slate-100 hover:text-slate-950" data-modal-hide="password-user-modal">
                    <svg class="h-3.5 w-3.5" aria-hidden="true" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                    </svg>
                </button>
            </div>

            <form id="password-user-form" action="" method="POST" class="p-5">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-950">Password Baru</label>
                        <input type="password" name="password" required class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" placeholder="Minimal 8 karakter">
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-3 border-t border-slate-100 pt-5">
                    <button data-modal-hide="password-user-modal" type="button" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-black text-slate-600 hover:bg-slate-50 transition">Batal</button>
                    <button type="submit" class="rounded-2xl bg-amber-500 px-5 py-3 text-sm font-black text-white hover:bg-amber-600 shadow-lg shadow-amber-500/20 transition">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- MODAL: ADD OUTLET -->
<!-- ============================================== -->
<div id="add-outlet-modal" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden bg-slate-950/40 backdrop-blur-sm md:inset-0">
    <div class="relative max-h-full w-full max-w-md p-4">
        <div class="relative rounded-[2rem] border border-white bg-white shadow-2xl">
            <div class="flex items-center justify-between border-b border-slate-100 p-5">
                <div>
                    <h3 class="text-lg font-black text-slate-950">Tambah Outlet Baru</h3>
                    <p class="mt-1 text-sm font-semibold text-slate-400">Tambahkan lokasi cabang atau franchise baru.</p>
                </div>
                <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-slate-50 text-slate-400 hover:bg-slate-100 hover:text-slate-950" data-modal-hide="add-outlet-modal">
                    <svg class="h-3.5 w-3.5" aria-hidden="true" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                    </svg>
                </button>
            </div>

            <form action="{{ route('superadmin.outlets.store') }}" method="POST" class="p-5">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-950">Nama Outlet</label>
                        <input type="text" name="name" required class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" placeholder="Contoh: Outlet Dago">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-950">Nomor Telepon</label>
                        <input type="text" name="phone" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" placeholder="Contoh: 022-123456">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-950">Alamat Outlet</label>
                        <textarea name="address" rows="3" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" placeholder="Masukkan alamat lengkap cabang..."></textarea>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-3 border-t border-slate-100 pt-5">
                    <button data-modal-hide="add-outlet-modal" type="button" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-black text-slate-600 hover:bg-slate-50 transition">Batal</button>
                    <button type="submit" class="rounded-2xl bg-amber-500 px-5 py-3 text-sm font-black text-white hover:bg-amber-600 shadow-lg shadow-amber-500/20 transition">Tambah Outlet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- MODAL: DELETE USER CONFIRMATION -->
<!-- ============================================== -->
<div id="delete-user-modal" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden bg-slate-950/40 backdrop-blur-sm md:inset-0">
    <div class="relative max-h-full w-full max-w-md p-4">
        <div class="relative rounded-[2rem] border border-white bg-white shadow-2xl">
            <div class="flex items-center justify-between border-b border-slate-100 p-5">
                <h3 class="text-lg font-black text-slate-950">Konfirmasi Hapus Pengguna</h3>
                <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-slate-50 text-slate-400 hover:bg-slate-100 hover:text-slate-950" data-modal-hide="delete-user-modal">
                    <svg class="h-3.5 w-3.5" aria-hidden="true" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                    </svg>
                </button>
            </div>

            <div class="p-6 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-rose-50 text-3xl">⚠️</div>
                <h3 class="mb-5 text-lg font-bold text-slate-600">Apakah Anda yakin ingin menghapus akun pengguna <span id="delete-user-target" class="font-black text-rose-600"></span>?</h3>
                <p class="mb-6 text-xs font-semibold text-slate-400">Tindakan ini tidak dapat dibatalkan. Data riwayat transaksi atau outlet yang dihubungkan dengan pengguna ini tetap aman.</p>
                
                <form id="delete-user-form" action="" method="POST" class="flex justify-center gap-3">
                    @csrf
                    @method('DELETE')
                    <button data-modal-hide="delete-user-modal" type="button" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-black text-slate-600 hover:bg-slate-50 transition">Batal</button>
                    <button type="submit" class="rounded-2xl bg-rose-600 px-5 py-3 text-sm font-black text-white hover:bg-rose-700 transition">Ya, Hapus Akun</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle outlet field in user creation modal depending on role selection
    function toggleAddOutletSelect() {
        const role = document.getElementById('add-user-role').value;
        const container = document.getElementById('add-user-outlet-container');
        const select = document.getElementById('add-user-outlet');
        if (role === 'superadmin') {
            container.style.display = 'none';
            select.disabled = true;
        } else {
            container.style.display = 'block';
            select.disabled = false;
        }
    }

    // Toggle outlet field in user editing modal depending on role selection
    function toggleEditOutletSelect() {
        const role = document.getElementById('edit-role').value;
        const container = document.getElementById('edit-outlet-container');
        const select = document.getElementById('edit-outlet');
        if (role === 'superadmin') {
            container.style.display = 'none';
            select.disabled = true;
        } else {
            container.style.display = 'block';
            select.disabled = false;
        }
    }

    // Populate and open user edit modal
    function editUser(id, name, username, email, role, outletId) {
        document.getElementById('edit-user-form').action = '/superadmin/users/' + id;
        document.getElementById('edit-name').value = name;
        document.getElementById('edit-username').value = username;
        document.getElementById('edit-email').value = email;
        document.getElementById('edit-role').value = role;
        
        const outletSelect = document.getElementById('edit-outlet');
        if (outletId) {
            outletSelect.value = outletId;
        } else if (outletSelect.options.length > 0) {
            outletSelect.selectedIndex = 0;
        }
        
        toggleEditOutletSelect();
    }

    // Populate and open reset password modal
    function resetPassword(id, name) {
        document.getElementById('password-user-form').action = '/superadmin/users/' + id + '/password';
        document.getElementById('reset-password-target').innerText = name;
    }

    // Populate and open delete confirmation modal
    function deleteUser(id, name) {
        document.getElementById('delete-user-form').action = '/superadmin/users/' + id;
        document.getElementById('delete-user-target').innerText = name;
    }

    // Initialize toggle functions on load
    window.onload = function() {
        toggleAddOutletSelect();
    };
</script>
@endsection
