<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KasirPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-white text-gray-900 antialiased min-h-screen flex">

    <div
        class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-600 to-blue-900 relative overflow-hidden items-center justify-center p-12">
        <div class="absolute inset-0 opacity-10"
            style="background-image: radial-gradient(white 2px, transparent 2px); background-size: 30px 30px;"></div>

        <div class="relative z-10 text-white max-w-lg">
            <div
                class="w-16 h-16 bg-white rounded-xl flex items-center justify-center text-blue-700 font-black text-4xl mb-8 shadow-lg">
                K</div>

            <h1 class="text-4xl font-bold mb-4 leading-tight">Kelola Bisnis Lebih Cerdas & Cepat.</h1>
            <p class="text-blue-100 text-lg leading-relaxed">KasirPro membantu Anda memantau penjualan, stok gudang, dan
                laporan laba rugi secara real-time hanya dalam satu layar.</p>

            <div class="mt-10 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-5 shadow-2xl max-w-xs">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 bg-green-400/20 rounded-full flex items-center justify-center text-green-400 text-xl">
                        📈</div>
                    <div>
                        <div class="text-blue-100 text-xs uppercase tracking-wider font-semibold mb-0.5">Laba Hari Ini
                        </div>
                        <div class="text-xl font-bold">Rp 5.300.000</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12">
        <div class="w-full max-w-md">

            <div class="lg:hidden mb-8 flex justify-start">
                <div
                    class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center text-white font-black text-2xl shadow-md">
                    K</div>
            </div>

            <h2 class="text-3xl font-bold text-gray-900 tracking-tight mb-2">Selamat Datang!</h2>
            <p class="text-gray-500 mb-8">Silakan masukkan email dan password Anda untuk melanjutkan.</p>

            @if (session('success'))
                <div class="p-4 mb-6 text-sm text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center"
                    role="alert">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <div><span class="font-bold">Mantap!</span> {{ session('success') }}</div>
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 mb-6 text-sm text-rose-800 rounded-xl bg-rose-50 border border-rose-200 flex items-center"
                    role="alert">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <div><span class="font-bold">Gagal Login!</span> {{ session('error') }}</div>
                </div>
            @endif

            <form action="/login" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="username" class="block mb-2 text-sm font-semibold text-gray-900">Username /
                        Email</label>
                    <input type="text" name="username" id="username" value="{{ old('username') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full p-3.5 transition"
                        placeholder="Masukkan username Anda" required>
                    @error('username')
                        <p class="mt-1.5 text-sm text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-sm font-semibold text-gray-900">Password</label>
                        <a href="#"
                            class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition">Lupa
                            Password?</a>
                    </div>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full p-3.5 pr-12 transition"
                            placeholder="••••••••" required>

                        <button type="button" onclick="togglePassword('password', 'eye-icon-login')"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-blue-600 focus:outline-none transition">
                            <svg id="eye-icon-login" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.978 9.978 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18">
                                </path>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-sm text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                    class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-bold rounded-xl text-md px-5 py-3.5 text-center transition shadow-sm mt-4">
                    Masuk ke Dashboard
                </button>
            </form>

            <p class="text-sm text-center text-gray-500 font-medium mt-8 border-t border-gray-100 pt-8">
                Belum punya akun? <a href="/register"
                    class="text-blue-600 hover:text-blue-800 font-bold hover:underline transition">Daftar sekarang</a>
            </p>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            } else {
                input.type = 'password';
                icon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.978 9.978 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>';
            }
        }
    </script>
</body>

</html>
