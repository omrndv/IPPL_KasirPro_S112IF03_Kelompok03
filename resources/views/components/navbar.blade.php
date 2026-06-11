<nav class="fixed top-0 z-50 w-full border-b border-slate-200/70 bg-white/85 backdrop-blur-xl">
    <div class="px-4 py-3 lg:px-6">
        <div class="flex items-center justify-between gap-4">
            <div class="flex w-auto items-center justify-start gap-3 sm:w-64">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-500 shadow-sm transition hover:bg-slate-50 hover:text-slate-950 focus:outline-none focus:ring-4 focus:ring-blue-100 sm:hidden">
                    <span class="sr-only">Buka sidebar</span>
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h10"></path>
                    </svg>
                </button>

                <a href="/dashboard" class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-950 text-base font-black text-white shadow-sm">K</div>
                    <div class="hidden leading-tight sm:block">
                        <span class="block text-lg font-black tracking-tight text-slate-950">KasirPro</span>
                        <span class="block text-[10px] font-bold uppercase tracking-[0.18em] text-slate-400">Smart POS</span>
                    </div>
                </a>
            </div>

            <div class="hidden flex-1 md:block md:max-w-lg lg:ml-4">
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 py-2.5 pl-11 pr-4 text-sm font-semibold text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" placeholder="Search menu, invoice, produk...">
                    <div class="pointer-events-none absolute inset-y-0 right-0 hidden items-center pr-3 lg:flex">
                        <span class="rounded-lg border border-slate-200 bg-white px-2 py-1 text-[10px] font-black uppercase tracking-wider text-slate-400">Cmd K</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2 sm:gap-3">
                <button type="button" class="hidden h-10 w-10 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-500 shadow-sm transition hover:bg-slate-50 hover:text-slate-950 md:inline-flex" title="Search">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                <button type="button" class="relative flex h-10 w-10 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-500 shadow-sm transition hover:bg-slate-50 hover:text-slate-950" title="Notifikasi">
                    <span class="absolute right-2.5 top-2.5 h-2 w-2 rounded-full bg-blue-600 ring-2 ring-white"></span>
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </button>

                <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white py-1.5 pl-2 pr-2 shadow-sm sm:pr-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-2xl bg-blue-50 text-sm font-black text-blue-600">AD</div>
                    <div class="hidden text-left md:block">
                        <div class="text-sm font-black leading-tight text-slate-950">Admin Kasir</div>
                        <div class="text-xs font-semibold text-slate-400">Business</div>
                    </div>

                    <form action="{{ route('logout') ?? '/logout' }}" method="POST" class="ml-1">
                        @csrf
                        <button type="submit" class="flex h-9 w-9 items-center justify-center rounded-xl text-slate-400 transition hover:bg-rose-50 hover:text-rose-600" title="Logout">
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