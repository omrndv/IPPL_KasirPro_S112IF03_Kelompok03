<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kata Sandi Baru - KasirPro</title>
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
                <a href="/login" class="rounded-2xl bg-ink px-4 py-2 text-sm font-bold text-white transition hover:bg-brand-600">Masuk</a>
            </div>
        </nav>
    </header>

    <main class="min-h-screen px-4 pb-10 pt-28 sm:px-6 lg:px-8 lg:pt-32">
        <section class="mx-auto grid min-h-[calc(100vh-9rem)] w-full max-w-7xl items-center gap-10 lg:grid-cols-[1fr_460px] xl:grid-cols-[1fr_500px]">
            <!-- Hero Left Side -->
            <div class="hidden lg:block">
                <div class="max-w-2xl">
                    <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-brand-100 bg-white/80 px-4 py-2 text-xs font-extrabold uppercase tracking-[0.18em] text-brand-700 shadow-sm">
                        🔒 Pembaruan Keamanan
                    </div>
                    <h1 class="text-5xl font-black leading-[1.05] tracking-tight text-ink xl:text-6xl">
                        Atur kata sandi baru Anda.
                    </h1>
                    <p class="mt-6 max-w-xl text-lg leading-8 text-slate-600">
                        Pilih kata sandi yang kuat dan aman dengan kombinasi karakter, angka, dan simbol. Kata sandi minimal harus 8 karakter.
                    </p>
                </div>
            </div>

            <!-- Form Right Side -->
            <div class="w-full lg:justify-self-end">
                <div class="mx-auto w-full max-w-md lg:mx-0">
                    <div class="mb-7 text-center lg:text-left">
                        <div class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-3xl bg-ink text-2xl font-black text-white shadow-soft lg:mx-0 lg:hidden">K</div>
                        <p class="mb-3 text-xs font-black uppercase tracking-[0.22em] text-brand-600">Reset Password</p>
                        <h1 class="text-3xl font-black tracking-tight text-ink sm:text-4xl">Sandi Baru</h1>
                        <p class="mt-3 leading-7 text-slate-500">Silakan buat kata sandi baru untuk akun Anda.</p>
                    </div>

                    <div class="rounded-[2rem] border border-white/80 bg-white/90 p-6 shadow-soft backdrop-blur sm:p-8">
                        @if (session('success'))
                            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800" role="alert">
                                <span class="font-black">Verifikasi Berhasil!</span> {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800" role="alert">
                                <span class="font-black">Gagal!</span> {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                            @csrf

                            <div>
                                <label for="password" class="mb-2 block text-sm font-bold text-ink">Kata Sandi Baru</label>
                                <div class="relative">
                                    <input type="password" name="password" id="password" class="form-input block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4 pr-12 text-sm font-semibold text-ink outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:bg-white" placeholder="Min. 8 karakter" required autofocus>
                                    <button type="button" onclick="togglePassword('password', 'eye-icon-pass')" class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 transition hover:text-brand-600 focus:outline-none" aria-label="Tampilkan password">
                                        <svg id="eye-icon-pass" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.978 9.978 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm font-bold text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="mb-2 block text-sm font-bold text-ink">Konfirmasi Kata Sandi</label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-input block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4 pr-12 text-sm font-semibold text-ink outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:bg-white" placeholder="Ulangi kata sandi baru" required>
                                    <button type="button" onclick="togglePassword('password_confirmation', 'eye-icon-confirm')" class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 transition hover:text-brand-600 focus:outline-none" aria-label="Tampilkan password">
                                        <svg id="eye-icon-confirm" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.978 9.978 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="w-full rounded-2xl bg-brand-600 px-5 py-4 text-base font-black text-white shadow-lg shadow-brand-600/20 transition hover:-translate-y-0.5 hover:bg-brand-700 focus:outline-none focus:ring-4 focus:ring-brand-100">
                                Perbarui Kata Sandi
                            </button>
                        </form>
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
