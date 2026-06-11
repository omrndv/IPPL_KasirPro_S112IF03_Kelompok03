<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KasirPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8'
                        },
                        ink: '#0f172a'
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif']
                    },
                    boxShadow: {
                        soft: '0 20px 60px rgba(15, 23, 42, 0.08)',
                        glow: '0 24px 80px rgba(37, 99, 235, 0.22)'
                    },
                    animation: {
                        float: 'float 6s ease-in-out infinite',
                        pulseSoft: 'pulseSoft 3s ease-in-out infinite'
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-12px)' }
                        },
                        pulseSoft: {
                            '0%, 100%': { transform: 'scale(1)', opacity: '.65' },
                            '50%': { transform: 'scale(1.05)', opacity: '.9' }
                        }
                    }
                }
            }
        };
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        .noise {
            background-image: radial-gradient(rgba(15, 23, 42, 0.08) 1px, transparent 1px);
            background-size: 22px 22px;
        }

        .glass {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .dashboard-grid {
            background-image:
                linear-gradient(rgba(148, 163, 184, .14) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148, 163, 184, .14) 1px, transparent 1px);
            background-size: 26px 26px;
        }

        .form-input:focus {
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }
    </style>
</head>
<body class="min-h-screen overflow-x-hidden bg-slate-50 font-sans text-slate-900 antialiased selection:bg-brand-100 selection:text-brand-700">
    <div class="fixed inset-0 -z-10 bg-[radial-gradient(circle_at_top_left,#dbeafe,transparent_34%),radial-gradient(circle_at_bottom_right,#cffafe,transparent_28%),linear-gradient(180deg,#f8fafc,#eef6ff)]"></div>
    <div class="noise fixed inset-0 -z-10 opacity-35"></div>
    <div class="fixed -top-32 left-1/3 -z-10 h-96 w-96 rounded-full bg-brand-300/35 blur-3xl animate-pulseSoft"></div>

    <header class="fixed left-0 right-0 top-0 z-50 px-4 pt-5 sm:px-6 lg:px-8">
        <nav class="glass mx-auto flex max-w-7xl items-center justify-between rounded-3xl border border-white/80 px-4 py-3 shadow-sm">
            <a href="/" class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-ink text-base font-black text-white shadow-sm">K</div>
                <div class="leading-tight">
                    <p class="text-base font-black tracking-tight text-ink">KasirPro</p>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-400">Smart POS</p>
                </div>
            </a>

            <div class="flex items-center gap-2">
                <a href="/" class="hidden rounded-2xl px-4 py-2 text-sm font-bold text-slate-500 transition hover:bg-white hover:text-ink sm:inline-flex">Beranda</a>
                <a href="/register" class="rounded-2xl bg-ink px-4 py-2 text-sm font-bold text-white transition hover:bg-brand-600">Daftar</a>
            </div>
        </nav>
    </header>

    <main class="min-h-screen px-4 pb-10 pt-28 sm:px-6 lg:px-8 lg:pt-32">
        <section class="mx-auto grid min-h-[calc(100vh-9rem)] w-full max-w-7xl items-center gap-10 lg:grid-cols-[1fr_460px] xl:grid-cols-[1fr_500px]">
            <div class="hidden lg:block">
                <div class="max-w-2xl">
                    <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-brand-100 bg-white/80 px-4 py-2 text-xs font-extrabold uppercase tracking-[0.18em] text-brand-700 shadow-sm">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-brand-500 opacity-60"></span>
                            <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-brand-600"></span>
                        </span>
                        POS modern untuk bisnis bertumbuh
                    </div>

                    <h1 class="text-5xl font-black leading-[1.05] tracking-tight text-ink xl:text-6xl">
                        Kelola toko lebih rapi dalam satu dashboard.
                    </h1>

                    <p class="mt-6 max-w-xl text-lg leading-8 text-slate-600">
                        Masuk ke KasirPro untuk memantau transaksi, stok, laporan, dan performa penjualan harian dengan tampilan yang simpel.
                    </p>
                </div>

                <div class="relative mt-10 max-w-xl">
                    <div class="absolute -inset-5 rounded-[2.5rem] bg-gradient-to-br from-brand-400/25 via-cyan-300/15 to-white blur-3xl"></div>

                    <div class="relative overflow-hidden rounded-[2rem] border border-white/80 bg-white shadow-soft animate-float">
                        <div class="flex items-center justify-between border-b border-slate-100 bg-slate-50/80 px-5 py-4">
                            <div class="flex items-center gap-2">
                                <span class="h-3 w-3 rounded-full bg-rose-400"></span>
                                <span class="h-3 w-3 rounded-full bg-amber-400"></span>
                                <span class="h-3 w-3 rounded-full bg-emerald-400"></span>
                            </div>
                            <div class="rounded-full bg-white px-3 py-1 text-xs font-bold text-slate-500 shadow-sm">Live Summary</div>
                        </div>

                        <div class="dashboard-grid p-6">
                            <div class="mb-5 flex items-center justify-between gap-4">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-400">Omzet hari ini</p>
                                    <h2 class="mt-1 text-3xl font-black text-ink">Rp 8.740.000</h2>
                                </div>
                                <div class="rounded-2xl bg-emerald-50 px-4 py-2 text-sm font-extrabold text-emerald-600">+24%</div>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-3">
                                <div class="rounded-3xl border border-slate-100 bg-white p-4 shadow-sm">
                                    <p class="text-xs font-bold text-slate-400">Transaksi</p>
                                    <p class="mt-2 text-2xl font-black text-ink">186</p>
                                </div>

                                <div class="rounded-3xl border border-slate-100 bg-white p-4 shadow-sm">
                                    <p class="text-xs font-bold text-slate-400">Stok aman</p>
                                    <p class="mt-2 text-2xl font-black text-ink">92%</p>
                                </div>

                                <div class="rounded-3xl border border-slate-100 bg-white p-4 shadow-sm">
                                    <p class="text-xs font-bold text-slate-400">Pelanggan</p>
                                    <p class="mt-2 text-2xl font-black text-ink">1.2K</p>
                                </div>
                            </div>

                            <div class="mt-4 rounded-3xl border border-slate-100 bg-white p-5 shadow-sm">
                                <div class="mb-5 flex items-center justify-between">
                                    <p class="font-black text-ink">Grafik Penjualan</p>
                                    <p class="rounded-full bg-brand-50 px-3 py-1 text-xs font-bold text-brand-600">7 Hari</p>
                                </div>
                                <div class="flex h-32 items-end gap-2">
                                    <div class="h-[38%] flex-1 rounded-t-xl bg-brand-100"></div>
                                    <div class="h-[58%] flex-1 rounded-t-xl bg-brand-200"></div>
                                    <div class="h-[44%] flex-1 rounded-t-xl bg-brand-100"></div>
                                    <div class="h-[74%] flex-1 rounded-t-xl bg-brand-300"></div>
                                    <div class="h-[62%] flex-1 rounded-t-xl bg-brand-200"></div>
                                    <div class="h-[86%] flex-1 rounded-t-xl bg-brand-500"></div>
                                    <div class="h-[100%] flex-1 rounded-t-xl bg-brand-600"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute -bottom-6 -right-3 rounded-3xl border border-white/80 bg-white/90 p-4 shadow-soft backdrop-blur">
                        <div class="flex items-center gap-3">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.15em] text-slate-400">Checkout berhasil</p>
                                <p class="text-sm font-black text-ink">QRIS Rp 145.000</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full lg:justify-self-end">
                <div class="mx-auto w-full max-w-md lg:mx-0">
                    <div class="mb-7 text-center lg:text-left">
                        <div class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-3xl bg-ink text-2xl font-black text-white shadow-soft lg:mx-0 lg:hidden">K</div>
                        <p class="mb-3 text-xs font-black uppercase tracking-[0.22em] text-brand-600">Welcome back</p>
                        <h1 class="text-3xl font-black tracking-tight text-ink sm:text-4xl">Masuk ke akunmu</h1>
                        <p class="mt-3 leading-7 text-slate-500">Lanjutkan kelola bisnis kamu di KasirPro.</p>
                    </div>

                    <div class="rounded-[2rem] border border-white/80 bg-white/90 p-6 shadow-soft backdrop-blur sm:p-8">
                        @if (session('success'))
                            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800" role="alert">
                                <span class="font-black">Mantap!</span> {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800" role="alert">
                                <span class="font-black">Gagal Login!</span> {{ session('error') }}
                            </div>
                        @endif

                        <form action="/login" method="POST" class="space-y-5">
                            @csrf

                            <div>
                                <label for="username" class="mb-2 block text-sm font-bold text-ink">Username / Email</label>
                                <input type="text" name="username" id="username" value="{{ old('username') }}" class="form-input block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4 text-sm font-semibold text-ink outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:bg-white" placeholder="Masukkan username atau email" required>
                                @error('username')
                                    <p class="mt-2 text-sm font-bold text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <div class="mb-2 flex items-center justify-between gap-3">
                                    <label for="password" class="block text-sm font-bold text-ink">Password</label>
                                    <a href="#" class="text-sm font-bold text-brand-600 transition hover:text-brand-800">Lupa?</a>
                                </div>
                                <div class="relative">
                                    <input type="password" name="password" id="password" class="form-input block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4 pr-12 text-sm font-semibold text-ink outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:bg-white" placeholder="••••••••" required>
                                    <button type="button" onclick="togglePassword('password', 'eye-icon-login')" class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 transition hover:text-brand-600 focus:outline-none" aria-label="Tampilkan password">
                                        <svg id="eye-icon-login" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.978 9.978 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm font-bold text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <label class="flex cursor-pointer items-center gap-3 text-sm font-semibold text-slate-500">
                                <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                                Ingat saya
                            </label>

                            <button type="submit" class="w-full rounded-2xl bg-brand-600 px-5 py-4 text-base font-black text-white shadow-lg shadow-brand-600/20 transition hover:-translate-y-0.5 hover:bg-brand-700 focus:outline-none focus:ring-4 focus:ring-brand-100">
                                Masuk ke Dashboard
                            </button>
                        </form>

                        <p class="mt-7 border-t border-slate-100 pt-6 text-center text-sm font-semibold text-slate-500">
                            Belum punya akun?
                            <a href="/register" class="font-black text-brand-600 transition hover:text-brand-800">Daftar sekarang</a>
                        </p>
                    </div>

                    <p class="mt-6 text-center text-xs font-semibold leading-6 text-slate-400 lg:text-left">
                        © 2026 KasirPro. Smart POS untuk bisnis bertumbuh.
                    </p>
                </div>
            </div>
        </section>
    </main>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.978 9.978 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>';
            }
        }
    </script>
</body>
</html>
