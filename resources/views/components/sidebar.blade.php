<aside id="logo-sidebar" class="fixed left-0 top-0 z-40 h-screen w-64 -translate-x-full border-r border-slate-200 bg-white pt-20 transition-transform sm:translate-x-0" aria-label="Sidebar">
    <div class="flex h-full flex-col overflow-y-auto bg-white px-4 pb-4">
        <ul class="mt-4 flex-1 space-y-1.5 font-medium">
            <li class="px-2 pb-1 pt-2 text-xs font-black uppercase tracking-[0.16em] text-slate-400">General</li>

            <li class="relative">
                @if (request()->is('dashboard'))
                    <div class="absolute -left-4 bottom-2 top-2 w-1 rounded-r-full bg-blue-600"></div>
                @endif
                <a href="/dashboard" class="flex items-center rounded-2xl px-3 py-2.5 transition {{ request()->is('dashboard') ? 'bg-blue-50 text-blue-700 font-black' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-950 font-bold' }}">
                    <svg class="mr-3 h-5 w-5 {{ request()->is('dashboard') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span class="text-sm">Dashboard</span>
                </a>
            </li>

            <li class="relative">
                @if (request()->is('transaksi'))
                    <div class="absolute -left-4 bottom-2 top-2 w-1 rounded-r-full bg-blue-600"></div>
                @endif
                <a href="/transaksi" class="flex items-center rounded-2xl px-3 py-2.5 transition {{ request()->is('transaksi') ? 'bg-blue-50 text-blue-700 font-black' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-950 font-bold' }}">
                    <svg class="mr-3 h-5 w-5 {{ request()->is('transaksi') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    <span class="flex-1 whitespace-nowrap text-sm">Transaksi Kasir</span>
                    <span class="rounded-full bg-blue-100 px-2 py-0.5 text-[10px] font-black text-blue-700">NEW</span>
                </a>
            </li>

            <li class="px-2 pb-1 pt-6 text-xs font-black uppercase tracking-[0.16em] text-slate-400">Tools</li>

            <li class="relative">
                @if (request()->is('produk'))
                    <div class="absolute -left-4 bottom-2 top-2 w-1 rounded-r-full bg-blue-600"></div>
                @endif
                <a href="/produk" class="flex items-center rounded-2xl px-3 py-2.5 transition {{ request()->is('produk') ? 'bg-blue-50 text-blue-700 font-black' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-950 font-bold' }}">
                    <svg class="mr-3 h-5 w-5 {{ request()->is('produk') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span class="text-sm">Data Produk</span>
                </a>
            </li>

            <li class="relative">
                @if (request()->is('bahan-baku'))
                    <div class="absolute -left-4 bottom-2 top-2 w-1 rounded-r-full bg-blue-600"></div>
                @endif
                <a href="/bahan-baku" class="flex items-center rounded-2xl px-3 py-2.5 transition {{ request()->is('bahan-baku') ? 'bg-blue-50 text-blue-700 font-black' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-950 font-bold' }}">
                    <svg class="mr-3 h-5 w-5 {{ request()->is('bahan-baku') ? 'text-blue-600' : 'text-slate-400' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5h6a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z"></path>
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2H9V5Z"></path>
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11h6m-6 4h6"></path>
                    </svg>
                    <span class="flex-1 whitespace-nowrap text-sm">Stok Bahan Baku</span>
                    <span class="rounded-full bg-blue-100 px-2 py-0.5 text-[10px] font-black text-blue-700">PRO</span>
                </a>
            </li>

            <li>
                <button type="button" class="flex w-full items-center rounded-2xl px-3 py-2.5 transition {{ request()->is('laporan') || request()->is('riwayat') ? 'bg-blue-50 text-blue-700 font-black' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-950 font-bold' }}" aria-controls="dropdown-keuangan" data-collapse-toggle="dropdown-keuangan">
                    <svg class="mr-3 h-5 w-5 {{ request()->is('laporan') || request()->is('riwayat') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span class="flex-1 text-left text-sm">Analytics</span>
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"></path>
                    </svg>
                </button>

                <ul id="dropdown-keuangan" class="{{ request()->is('laporan') || request()->is('riwayat') ? '' : 'hidden' }} ml-6 mt-1 space-y-1 border-l border-slate-100 pl-3">
                    <li class="relative">
                        @if (request()->is('laporan'))
                            <div class="absolute -left-[13px] bottom-2 top-2 w-[2px] rounded-full bg-blue-600"></div>
                        @endif
                        <a href="/laporan" class="flex w-full items-center rounded-xl px-3 py-2 text-sm transition {{ request()->is('laporan') ? 'bg-blue-50 text-blue-700 font-black' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-950 font-bold' }}">Laba & Rugi</a>
                    </li>
                    <li class="relative">
                        @if (request()->is('riwayat'))
                            <div class="absolute -left-[13px] bottom-2 top-2 w-[2px] rounded-full bg-blue-600"></div>
                        @endif
                        <a href="/riwayat" class="flex w-full items-center rounded-xl px-3 py-2 text-sm transition {{ request()->is('riwayat') ? 'bg-blue-50 text-blue-700 font-black' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-950 font-bold' }}">Riwayat Invoice</a>
                    </li>
                </ul>
            </li>

            <li class="px-2 pb-1 pt-6 text-xs font-black uppercase tracking-[0.16em] text-slate-400">Support</li>

            <li class="relative">
                @if (request()->is('pengaturan'))
                    <div class="absolute -left-4 bottom-2 top-2 w-1 rounded-r-full bg-blue-600"></div>
                @endif
                <a href="/pengaturan" class="flex items-center rounded-2xl px-3 py-2.5 transition {{ request()->is('pengaturan') ? 'bg-blue-50 text-blue-700 font-black' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-950 font-bold' }}">
                    <svg class="mr-3 h-5 w-5 {{ request()->is('pengaturan') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="whitespace-nowrap text-sm">Settings</span>
                </a>
            </li>
        </ul>

        <div class="mt-auto border-t border-slate-100 pt-4">
            <p class="text-center text-xs font-semibold text-slate-400">&copy; 2026 KasirPro.</p>
        </div>
    </div>
</aside>