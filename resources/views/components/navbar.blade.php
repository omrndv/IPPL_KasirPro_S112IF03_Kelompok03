@php
    $user = auth()->user();
    $outlet = $user->outlet ?? null;

    $userName = $user->name ?? 'Admin KasirPro';
    $userRole = $user->role ?? 'owner';
    $outletName = $outlet->name ?? ($userRole === 'superadmin' ? 'Sistem Utama' : 'Outlet belum diatur');

    $roleLabel = match ($userRole) {
        'superadmin' => 'Super Admin',
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

<nav class="fixed top-0 z-50 w-full border-b border-slate-200/70 bg-white/85 backdrop-blur-xl">
    <div class="px-4 py-3 lg:px-6">
        <div class="flex items-center justify-between gap-4">
            <div class="flex w-auto items-center justify-start gap-3 sm:w-64">
                <button
                    data-drawer-target="logo-sidebar"
                    data-drawer-toggle="logo-sidebar"
                    aria-controls="logo-sidebar"
                    type="button"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-500 shadow-sm transition hover:bg-slate-50 hover:text-slate-950 focus:outline-none focus:ring-4 focus:ring-blue-100 sm:hidden"
                >
                    <span class="sr-only">Buka sidebar</span>
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h10"></path>
                    </svg>
                </button>

                <a href="/dashboard" class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-950 text-base font-black text-white shadow-sm">
                        K
                    </div>
                    <div class="hidden leading-tight sm:block">
                        <span class="block text-lg font-black tracking-tight text-slate-950">KasirPro</span>
                        <span class="block text-[10px] font-bold uppercase tracking-[0.18em] text-slate-400">Smart POS</span>
                    </div>
                </a>
            </div>

            <div class="flex items-center gap-2 sm:gap-3">
                <div class="hidden items-center gap-2 rounded-2xl border border-blue-100 bg-blue-50 px-3 py-2 text-xs font-black text-blue-700 lg:flex">
                    <span class="h-2 w-2 rounded-full bg-blue-600"></span>
                    {{ $outletName }}
                </div>

                <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white py-1.5 pl-2 pr-2 shadow-sm sm:pr-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-2xl bg-blue-50 text-sm font-black text-blue-600">
                        {{ $initials ?: 'AD' }}
                    </div>

                    <div class="hidden max-w-[150px] text-left md:block">
                        <div class="truncate text-sm font-black leading-tight text-slate-950">
                            {{ $userName }}
                        </div>
                        <div class="truncate text-xs font-semibold text-slate-400">
                            {{ $roleLabel }} · {{ $outletName }}
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="ml-1">
                        @csrf
                        <button
                            type="submit"
                            class="flex h-9 w-9 items-center justify-center rounded-xl text-slate-400 transition hover:bg-rose-50 hover:text-rose-600"
                            title="Logout"
                        >
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>