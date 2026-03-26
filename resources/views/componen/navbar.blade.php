<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end w-64">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                    type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 mr-2">
                    <span class="sr-only">Buka sidebar</span>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                        </path>
                    </svg>
                </button>
                <a href="/dashboard" class="flex items-center ms-2">
                    <div
                        class="w-8 h-8 bg-blue-600 rounded flex items-center justify-center text-white font-bold text-xl mr-2">
                        K</div>
                    <span
                        class="self-center text-xl font-bold sm:text-2xl whitespace-nowrap text-gray-900 tracking-tight">KasirPro</span>
                </a>
            </div>

            <div class="hidden md:block flex-1 max-w-lg ml-8">
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text"
                        class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2"
                        placeholder="Search (Cmd + F)">
                </div>
            </div>

            <div class="flex items-center gap-4 ms-auto">
                <button class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                        </path>
                    </svg></button>

                <div class="flex items-center gap-3 border-l border-gray-200 pl-4">
                    <div
                        class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm">
                        AD</div>
                    <div class="hidden md:block text-left">
                        <div class="text-sm font-bold text-gray-900 leading-tight">Admin Kasir</div>
                        <div class="text-xs text-gray-500">Business</div>
                    </div>
                    <form action="{{ route('logout') ?? '/logout' }}" method="POST" class="ml-2">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-500 transition" title="Logout">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
