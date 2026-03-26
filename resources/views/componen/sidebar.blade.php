<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-4 pb-4 overflow-y-auto bg-white flex flex-col">

        <ul class="space-y-1.5 font-medium mt-4 flex-1">

            <li class="px-2 pt-2 pb-1 text-xs font-bold text-gray-400 uppercase tracking-wider">General</li>

            <li class="relative">
                @if (request()->is('dashboard'))
                    <div class="absolute left-[-16px] top-1 bottom-1 w-1 bg-blue-600 rounded-r-md"></div>
                @endif

                <a href="/dashboard"
                    class="flex items-center p-2.5 rounded-lg group transition {{ request()->is('dashboard') ? 'text-blue-700 bg-blue-50 font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->is('dashboard') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    <span class="text-sm">Dashboard</span>
                </a>
            </li>

            <li class="relative">
                @if (request()->is('transaksi'))
                    <div class="absolute left-[-16px] top-1 bottom-1 w-1 bg-blue-600 rounded-r-md"></div>
                @endif
                <a href="/transaksi"
                    class="flex items-center p-2.5 rounded-lg group transition {{ request()->is('transaksi') ? 'text-blue-700 bg-blue-50 font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->is('transaksi') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 033 3z">
                        </path>
                    </svg>
                    <span class="text-sm flex-1 whitespace-nowrap">Transaksi Kasir</span>
                    <span
                        class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-semibold text-blue-700 bg-blue-100 rounded-full">New</span>
                </a>
            </li>

            <li class="px-2 pt-6 pb-1 text-xs font-bold text-gray-400 uppercase tracking-wider">Tools</li>

            <li class="relative">
                @if (request()->is('produk'))
                    <div class="absolute left-[-16px] top-1 bottom-1 w-1 bg-blue-600 rounded-r-md"></div>
                @endif
                <a href="/produk"
                    class="flex items-center p-2.5 rounded-lg group transition {{ request()->is('produk') ? 'text-blue-700 bg-blue-50 font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->is('produk') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span class="text-sm">Data Produk</span>
                </a>
            </li>

            <li>
                <button type="button"
                    class="flex items-center w-full p-2.5 transition duration-75 rounded-lg group {{ request()->is('laporan') || request()->is('riwayat') ? 'text-blue-700 font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }}"
                    aria-controls="dropdown-keuangan" data-collapse-toggle="dropdown-keuangan">
                    <svg class="w-5 h-5 mr-3 {{ request()->is('laporan') || request()->is('riwayat') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                    <span class="flex-1 text-sm text-left">Analytics</span>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <ul id="dropdown-keuangan"
                    class="{{ request()->is('laporan') || request()->is('riwayat') ? '' : 'hidden' }} py-2 space-y-1 ml-6 border-l-2 border-gray-100">
                    <li class="relative">
                        @if (request()->is('laporan'))
                            <div class="absolute left-[-2px] top-1 bottom-1 w-[2px] bg-blue-600"></div>
                        @endif
                        <a href="/laporan"
                            class="flex items-center w-full p-2.5 rounded-lg pl-4 text-sm transition {{ request()->is('laporan') ? 'text-blue-700 font-semibold bg-blue-50/50' : 'text-gray-500 hover:text-gray-900' }}">Laba
                            & Rugi</a>
                    </li>
                    <li class="relative">
                        @if (request()->is('riwayat'))
                            <div class="absolute left-[-2px] top-1 bottom-1 w-[2px] bg-blue-600"></div>
                        @endif
                        <a href="/riwayat"
                            class="flex items-center w-full p-2.5 rounded-lg pl-4 text-sm transition {{ request()->is('riwayat') ? 'text-blue-700 font-semibold bg-blue-50/50' : 'text-gray-500 hover:text-gray-900' }}">Riwayat
                            Invoice</a>
                    </li>
                </ul>
            </li>

            <li class="px-2 pt-6 pb-1 text-xs font-bold text-gray-400 uppercase tracking-wider">Support</li>

            <li class="relative">
                @if (request()->is('pengaturan'))
                    <div class="absolute left-[-16px] top-1 bottom-1 w-1 bg-blue-600 rounded-r-md"></div>
                @endif
                <a href="/pengaturan"
                    class="flex items-center p-2.5 rounded-lg group transition {{ request()->is('pengaturan') ? 'text-blue-700 bg-blue-50 font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->is('pengaturan') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="text-sm whitespace-nowrap">Settings</span>
                </a>
            </li>
        </ul>

        <div class="mt-auto pt-4 border-t border-gray-100 mb-2">
            <p class="text-center text-xs text-gray-400">&copy; 2026 KasirPro Kelompok 3.</p>
        </div>
    </div>
</aside>
