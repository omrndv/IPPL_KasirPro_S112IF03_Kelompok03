<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>KasirPro - Aplikasi Kasir Modern untuk Bisnis Bertumbuh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#172554'
                        },
                        ink: '#0f172a'
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif']
                    },
                    boxShadow: {
                        soft: '0 20px 70px rgba(15, 23, 42, 0.10)',
                        glow: '0 24px 80px rgba(37, 99, 235, 0.28)'
                    },
                    animation: {
                        float: 'float 6s ease-in-out infinite',
                        pulseSoft: 'pulseSoft 3s ease-in-out infinite',
                        marquee: 'marquee 24s linear infinite'
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-14px)' }
                        },
                        pulseSoft: {
                            '0%, 100%': { transform: 'scale(1)', opacity: '.7' },
                            '50%': { transform: 'scale(1.05)', opacity: '.95' }
                        },
                        marquee: {
                            '0%': { transform: 'translateX(0)' },
                            '100%': { transform: 'translateX(-50%)' }
                        }
                    }
                }
            }
        };
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <style>
        .noise {
            background-image: radial-gradient(rgba(15, 23, 42, 0.08) 1px, transparent 1px);
            background-size: 22px 22px;
        }
        .reveal {
            opacity: 0;
            transform: translateY(26px);
            transition: opacity .8s ease, transform .8s ease;
        }
        .reveal.show {
            opacity: 1;
            transform: translateY(0);
        }
        .glass {
            background: rgba(255, 255, 255, 0.78);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }
        .dashboard-grid {
            background-image:
                linear-gradient(rgba(148, 163, 184, .15) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148, 163, 184, .15) 1px, transparent 1px);
            background-size: 28px 28px;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased overflow-x-hidden selection:bg-brand-100 selection:text-brand-800">
    <header class="fixed top-0 left-0 right-0 z-50 px-4 pt-4">
        <nav id="navbar" class="glass mx-auto max-w-7xl rounded-3xl border border-white/70 px-4 py-3 shadow-sm transition-all duration-300">
            <div class="flex items-center justify-between gap-4">
                <a href="#" class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-ink text-lg font-black text-white shadow-lg shadow-slate-900/10">K</div>
                    <div class="leading-tight">
                        <p class="text-lg font-black tracking-tight text-ink">KasirPro</p>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">Smart POS</p>
                    </div>
                </a>

                <div class="hidden items-center gap-1 rounded-2xl bg-white/60 p-1 text-sm font-semibold text-slate-600 lg:flex">
                    <a href="#fitur" class="rounded-xl px-4 py-2 transition hover:bg-white hover:text-ink">Fitur</a>
                    <a href="#solusi" class="rounded-xl px-4 py-2 transition hover:bg-white hover:text-ink">Solusi</a>
                    <a href="#harga" class="rounded-xl px-4 py-2 transition hover:bg-white hover:text-ink">Harga</a>
                    <a href="#faq" class="rounded-xl px-4 py-2 transition hover:bg-white hover:text-ink">FAQ</a>
                </div>

                <div class="hidden items-center gap-3 sm:flex">
                    <a href="/login" class="rounded-2xl px-4 py-2.5 text-sm font-bold text-slate-600 transition hover:bg-white hover:text-ink">Masuk</a>
                    <a href="/register" class="rounded-2xl bg-ink px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-slate-900/15 transition hover:-translate-y-0.5 hover:bg-brand-600">Coba Gratis</a>
                </div>

                <button id="menuBtn" class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-slate-800 shadow-sm lg:hidden" aria-label="Buka menu">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16" />
                    </svg>
                </button>
            </div>

            <div id="mobileMenu" class="hidden border-t border-slate-100 pt-4 mt-4 lg:hidden">
                <div class="flex flex-col gap-2 text-sm font-bold text-slate-600">
                    <a href="#fitur" class="rounded-2xl px-4 py-3 hover:bg-white">Fitur</a>
                    <a href="#solusi" class="rounded-2xl px-4 py-3 hover:bg-white">Solusi</a>
                    <a href="#harga" class="rounded-2xl px-4 py-3 hover:bg-white">Harga</a>
                    <a href="#faq" class="rounded-2xl px-4 py-3 hover:bg-white">FAQ</a>
                    <a href="/login" class="rounded-2xl px-4 py-3 hover:bg-white">Masuk</a>
                    <a href="/register" class="rounded-2xl bg-ink px-4 py-3 text-center text-white">Coba Gratis</a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section class="relative overflow-hidden pt-36 pb-20 sm:pt-40 lg:pt-48 lg:pb-28">
            <div class="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top_left,#dbeafe,transparent_34%),radial-gradient(circle_at_top_right,#cffafe,transparent_28%),linear-gradient(180deg,#f8fafc,#eef6ff)]"></div>
            <div class="noise absolute inset-0 -z-10 opacity-40"></div>
            <div class="absolute -top-28 left-1/2 -z-10 h-80 w-80 -translate-x-1/2 rounded-full bg-brand-300/40 blur-3xl animate-pulseSoft"></div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid items-center gap-14 lg:grid-cols-[1fr_0.95fr]">
                    <div class="mx-auto max-w-3xl text-center lg:mx-0 lg:text-left reveal">
                        <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-brand-100 bg-white/80 px-4 py-2 text-xs font-extrabold uppercase tracking-[0.18em] text-brand-700 shadow-sm">
                            <span class="relative flex h-2.5 w-2.5">
                                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-brand-500 opacity-60"></span>
                                <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-brand-600"></span>
                            </span>
                            POS modern untuk UMKM Indonesia
                        </div>
                        <h1 class="text-5xl font-black tracking-tight text-ink sm:text-6xl lg:text-7xl leading-[1.03]">
                            Jualan lebih rapi, laporan lebih jelas, bisnis makin naik.
                        </h1>
                        <p class="mx-auto mt-7 max-w-2xl text-lg leading-8 text-slate-600 lg:mx-0">
                            KasirPro membantu pemilik bisnis mengelola transaksi, stok, pelanggan, dan laporan penjualan dalam satu dashboard yang cepat, simpel, dan enak dipakai setiap hari.
                        </p>
                        <div class="mt-9 flex flex-col justify-center gap-3 sm:flex-row lg:justify-start">
                            <a href="/register" class="group inline-flex items-center justify-center gap-2 rounded-2xl bg-brand-600 px-7 py-4 text-base font-extrabold text-white shadow-glow transition hover:-translate-y-1 hover:bg-brand-700">
                                Mulai Gratis 30 Hari
                                <svg class="h-5 w-5 transition group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                            <a href="#harga" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-7 py-4 text-base font-extrabold text-slate-700 shadow-sm transition hover:-translate-y-1 hover:border-slate-300 hover:text-ink">
                                Lihat Paket Harga
                            </a>
                        </div>
                        <div class="mt-8 flex flex-wrap items-center justify-center gap-5 text-sm font-semibold text-slate-500 lg:justify-start">
                            <span class="flex items-center gap-2"><span class="text-emerald-500">✓</span> Tanpa kartu kredit</span>
                            <span class="flex items-center gap-2"><span class="text-emerald-500">✓</span> Setup cepat</span>
                            <span class="flex items-center gap-2"><span class="text-emerald-500">✓</span> Support ramah</span>
                        </div>
                    </div>

                    <div class="relative reveal lg:pl-4" style="transition-delay:120ms">
                        <div class="absolute -inset-6 rounded-[2.5rem] bg-gradient-to-br from-brand-400/30 via-cyan-300/20 to-white blur-3xl"></div>
                        <div class="relative overflow-hidden rounded-[2rem] border border-white/80 bg-white shadow-soft animate-float">
                            <div class="flex items-center justify-between border-b border-slate-100 bg-slate-50/80 px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="h-3 w-3 rounded-full bg-rose-400"></span>
                                    <span class="h-3 w-3 rounded-full bg-amber-400"></span>
                                    <span class="h-3 w-3 rounded-full bg-emerald-400"></span>
                                </div>
                                <div class="rounded-full bg-white px-3 py-1 text-xs font-bold text-slate-500 shadow-sm">Live Dashboard</div>
                            </div>

                            <div class="dashboard-grid p-5 sm:p-6">
                                <div class="mb-5 flex items-center justify-between gap-4">
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-400">Penjualan hari ini</p>
                                        <h3 class="mt-1 text-3xl font-black text-ink">Rp 8.740.000</h3>
                                    </div>
                                    <div class="rounded-2xl bg-emerald-50 px-4 py-2 text-sm font-extrabold text-emerald-600">+24%</div>
                                </div>

                                <div class="grid gap-4 sm:grid-cols-3">
                                    <div class="rounded-3xl border border-slate-100 bg-white p-4 shadow-sm">
                                        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-2xl bg-brand-50 text-brand-600">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 12v-2" /></svg>
                                        </div>
                                        <p class="text-xs font-bold text-slate-400">Transaksi</p>
                                        <p class="mt-1 text-xl font-black text-ink">186</p>
                                    </div>
                                    <div class="rounded-3xl border border-slate-100 bg-white p-4 shadow-sm">
                                        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-2xl bg-orange-50 text-orange-600">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" /></svg>
                                        </div>
                                        <p class="text-xs font-bold text-slate-400">Stok aman</p>
                                        <p class="mt-1 text-xl font-black text-ink">92%</p>
                                    </div>
                                    <div class="rounded-3xl border border-slate-100 bg-white p-4 shadow-sm">
                                        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-2xl bg-violet-50 text-violet-600">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M9 20H4v-2a3 3 0 015.356-1.857M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        </div>
                                        <p class="text-xs font-bold text-slate-400">Pelanggan</p>
                                        <p class="mt-1 text-xl font-black text-ink">1.2K</p>
                                    </div>
                                </div>

                                <div class="mt-4 grid gap-4 lg:grid-cols-[1.2fr_0.8fr]">
                                    <div class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm">
                                        <div class="mb-5 flex items-center justify-between">
                                            <p class="font-black text-ink">Grafik Penjualan</p>
                                            <p class="rounded-full bg-brand-50 px-3 py-1 text-xs font-bold text-brand-600">7 Hari</p>
                                        </div>
                                        <div class="flex h-40 items-end gap-2">
                                            <div class="h-[38%] flex-1 rounded-t-xl bg-brand-100"></div>
                                            <div class="h-[58%] flex-1 rounded-t-xl bg-brand-200"></div>
                                            <div class="h-[44%] flex-1 rounded-t-xl bg-brand-100"></div>
                                            <div class="h-[74%] flex-1 rounded-t-xl bg-brand-300"></div>
                                            <div class="h-[62%] flex-1 rounded-t-xl bg-brand-200"></div>
                                            <div class="h-[86%] flex-1 rounded-t-xl bg-brand-500"></div>
                                            <div class="h-[100%] flex-1 rounded-t-xl bg-brand-600"></div>
                                        </div>
                                    </div>
                                    <div class="rounded-3xl border border-slate-100 bg-ink p-5 text-white shadow-sm">
                                        <p class="mb-5 font-black">Produk Terlaris</p>
                                        <div class="space-y-4">
                                            <div>
                                                <div class="mb-2 flex justify-between text-sm"><span>Kopi Susu</span><span>82%</span></div>
                                                <div class="h-2 rounded-full bg-white/10"><div class="h-2 w-[82%] rounded-full bg-white"></div></div>
                                            </div>
                                            <div>
                                                <div class="mb-2 flex justify-between text-sm"><span>Roti Bakar</span><span>64%</span></div>
                                                <div class="h-2 rounded-full bg-white/10"><div class="h-2 w-[64%] rounded-full bg-cyan-300"></div></div>
                                            </div>
                                            <div>
                                                <div class="mb-2 flex justify-between text-sm"><span>Matcha</span><span>48%</span></div>
                                                <div class="h-2 rounded-full bg-white/10"><div class="h-2 w-[48%] rounded-full bg-emerald-300"></div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="absolute -bottom-7 -left-2 hidden rounded-3xl border border-white/80 bg-white/90 p-4 shadow-soft backdrop-blur md:block">
                            <div class="flex items-center gap-3">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.15em] text-slate-400">Checkout berhasil</p>
                                    <p class="text-sm font-black text-ink">QRIS Rp 145.000</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="border-y border-slate-200/70 bg-white py-8">
            <div class="mx-auto max-w-7xl overflow-hidden px-4 sm:px-6 lg:px-8">
                <div class="flex min-w-max animate-marquee items-center gap-10 text-slate-400">
                    <p class="text-sm font-extrabold uppercase tracking-[0.22em]">Dipercaya bisnis kuliner</p>
                    <p class="text-xl font-black text-slate-500">Kedai Nusantara</p>
                    <p class="text-xl font-black text-slate-500">Bagus Café</p>
                    <p class="text-xl font-black text-slate-500">FreshMart</p>
                    <p class="text-xl font-black text-slate-500">Urban Laundry</p>
                    <p class="text-xl font-black text-slate-500">Toko Makmur</p>
                    <p class="text-sm font-extrabold uppercase tracking-[0.22em]">Dipercaya bisnis kuliner</p>
                    <p class="text-xl font-black text-slate-500">Kedai Nusantara</p>
                    <p class="text-xl font-black text-slate-500">Bagus Café</p>
                    <p class="text-xl font-black text-slate-500">FreshMart</p>
                    <p class="text-xl font-black text-slate-500">Urban Laundry</p>
                    <p class="text-xl font-black text-slate-500">Toko Makmur</p>
                </div>
            </div>
        </section>

        <section id="fitur" class="py-20 lg:py-28">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto mb-14 max-w-2xl text-center reveal">
                    <p class="mb-3 text-sm font-black uppercase tracking-[0.2em] text-brand-600">Fitur unggulan</p>
                    <h2 class="text-4xl font-black tracking-tight text-ink sm:text-5xl">Semua kebutuhan toko, dibuat simpel.</h2>
                    <p class="mt-5 text-lg leading-8 text-slate-600">Didesain supaya kasir cepat paham, owner gampang memantau, dan operasional harian jadi lebih rapi.</p>
                </div>

                <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                    <article class="reveal rounded-[2rem] border border-slate-200 bg-white p-7 shadow-sm transition hover:-translate-y-2 hover:shadow-soft">
                        <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50 text-brand-600">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </div>
                        <h3 class="text-xl font-black text-ink">Transaksi Super Cepat</h3>
                        <p class="mt-3 leading-7 text-slate-600">Input produk, diskon, pajak, dan pembayaran dibuat ringkas supaya antrean tidak numpuk.</p>
                    </article>

                    <article class="reveal rounded-[2rem] border border-slate-200 bg-white p-7 shadow-sm transition hover:-translate-y-2 hover:shadow-soft" style="transition-delay:80ms">
                        <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" /></svg>
                        </div>
                        <h3 class="text-xl font-black text-ink">Stok Real-Time</h3>
                        <p class="mt-3 leading-7 text-slate-600">Stok otomatis berkurang setelah transaksi dan memberi peringatan saat barang mulai menipis.</p>
                    </article>

                    <article class="reveal rounded-[2rem] border border-slate-200 bg-white p-7 shadow-sm transition hover:-translate-y-2 hover:shadow-soft" style="transition-delay:160ms">
                        <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-violet-50 text-violet-600">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10" /></svg>
                        </div>
                        <h3 class="text-xl font-black text-ink">Laporan Otomatis</h3>
                        <p class="mt-3 leading-7 text-slate-600">Pantau omzet, laba, produk terlaris, hingga performa harian tanpa hitung manual.</p>
                    </article>

                    <article class="reveal rounded-[2rem] border border-slate-200 bg-white p-7 shadow-sm transition hover:-translate-y-2 hover:shadow-soft">
                        <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-orange-50 text-orange-600">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                        </div>
                        <h3 class="text-xl font-black text-ink">Multi Payment</h3>
                        <p class="mt-3 leading-7 text-slate-600">Terima tunai, transfer, QRIS, dan e-wallet dengan pencatatan yang tetap rapi.</p>
                    </article>

                    <article class="reveal rounded-[2rem] border border-slate-200 bg-white p-7 shadow-sm transition hover:-translate-y-2 hover:shadow-soft" style="transition-delay:80ms">
                        <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-cyan-50 text-cyan-600">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M9 20H4v-2a3 3 0 015.356-1.857M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </div>
                        <h3 class="text-xl font-black text-ink">Data Pelanggan</h3>
                        <p class="mt-3 leading-7 text-slate-600">Simpan histori belanja pelanggan untuk promo, membership, dan retensi bisnis.</p>
                    </article>

                    <article class="reveal rounded-[2rem] border border-slate-200 bg-ink p-7 text-white shadow-soft transition hover:-translate-y-2" style="transition-delay:160ms">
                        <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 text-white">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4" /></svg>
                        </div>
                        <h3 class="text-xl font-black">Aman & Terkontrol</h3>
                        <p class="mt-3 leading-7 text-slate-300">Atur role kasir, admin, dan owner supaya akses data tetap aman sesuai kebutuhan.</p>
                    </article>
                </div>
            </div>
        </section>

        <section id="solusi" class="bg-white py-20 lg:py-28">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid items-center gap-12 lg:grid-cols-2">
                    <div class="reveal">
                        <p class="mb-3 text-sm font-black uppercase tracking-[0.2em] text-brand-600">Kenapa KasirPro?</p>
                        <h2 class="text-4xl font-black tracking-tight text-ink sm:text-5xl">Bukan cuma aplikasi kasir, tapi partner operasional harian.</h2>
                        <p class="mt-5 text-lg leading-8 text-slate-600">KasirPro dibuat untuk mengurangi pekerjaan manual yang sering bikin data berantakan. Dari transaksi pertama sampai laporan tutup toko, semuanya bisa dicek dengan lebih cepat.</p>

                        <div class="mt-9 space-y-4">
                            <div class="flex gap-4 rounded-3xl border border-slate-200 bg-slate-50 p-5">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white text-brand-600 shadow-sm">01</div>
                                <div>
                                    <h3 class="font-black text-ink">Kasir lebih cepat adaptasi</h3>
                                    <p class="mt-1 text-slate-600">Tampilan bersih dan alur checkout dibuat mudah dipahami.</p>
                                </div>
                            </div>
                            <div class="flex gap-4 rounded-3xl border border-slate-200 bg-slate-50 p-5">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white text-brand-600 shadow-sm">02</div>
                                <div>
                                    <h3 class="font-black text-ink">Owner bisa pantau dari mana saja</h3>
                                    <p class="mt-1 text-slate-600">Ringkasan omzet, stok, dan performa tersedia dalam dashboard.</p>
                                </div>
                            </div>
                            <div class="flex gap-4 rounded-3xl border border-slate-200 bg-slate-50 p-5">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white text-brand-600 shadow-sm">03</div>
                                <div>
                                    <h3 class="font-black text-ink">Data lebih rapi untuk ambil keputusan</h3>
                                    <p class="mt-1 text-slate-600">Cari produk laris, jam ramai, dan potensi peningkatan profit.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="reveal rounded-[2.5rem] bg-slate-100 p-4 shadow-inner" style="transition-delay:120ms">
                        <div class="rounded-[2rem] bg-white p-6 shadow-soft">
                            <div class="mb-6 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-bold text-slate-400">Ringkasan toko</p>
                                    <h3 class="text-2xl font-black text-ink">Outlet Pusat</h3>
                                </div>
                                <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-black text-emerald-600">Online</span>
                            </div>

                            <div class="space-y-4">
                                <div class="rounded-3xl bg-slate-50 p-5">
                                    <div class="mb-3 flex justify-between text-sm font-bold text-slate-500"><span>Target omzet</span><span>78%</span></div>
                                    <div class="h-3 rounded-full bg-slate-200"><div class="h-3 w-[78%] rounded-full bg-brand-600"></div></div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="rounded-3xl border border-slate-100 p-5">
                                        <p class="text-sm font-bold text-slate-400">Profit bersih</p>
                                        <p class="mt-2 text-2xl font-black text-ink">Rp 3.1jt</p>
                                    </div>
                                    <div class="rounded-3xl border border-slate-100 p-5">
                                        <p class="text-sm font-bold text-slate-400">Produk low stock</p>
                                        <p class="mt-2 text-2xl font-black text-orange-500">12</p>
                                    </div>
                                </div>
                                <div class="rounded-3xl border border-slate-100 p-5">
                                    <div class="mb-4 flex items-center justify-between">
                                        <p class="font-black text-ink">Aktivitas terbaru</p>
                                        <a href="#" class="text-sm font-bold text-brand-600">Lihat semua</a>
                                    </div>
                                    <div class="space-y-3 text-sm">
                                        <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3"><span>Transaksi #INV-2031</span><strong>Rp 86.000</strong></div>
                                        <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3"><span>Stok Kopi Susu update</span><strong>+48</strong></div>
                                        <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3"><span>Member baru</span><strong>Rani</strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="harga" class="py-20 lg:py-28">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto mb-14 max-w-2xl text-center reveal">
                    <p class="mb-3 text-sm font-black uppercase tracking-[0.2em] text-brand-600">Paket harga</p>
                    <h2 class="text-4xl font-black tracking-tight text-ink sm:text-5xl">Pilih paket yang cocok untuk bisnismu.</h2>
                    <p class="mt-5 text-lg leading-8 text-slate-600">Mulai dari toko kecil sampai cabang yang mulai berkembang. Bisa upgrade kapan saja.</p>
                </div>

                <div class="grid gap-6 lg:grid-cols-3">
                    <div class="reveal rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
                        <p class="text-sm font-black uppercase tracking-[0.2em] text-slate-400">Starter</p>
                        <h3 class="mt-4 text-4xl font-black text-ink">Gratis</h3>
                        <p class="mt-3 text-slate-600">Cocok untuk coba sistem dan transaksi kecil.</p>
                        <a href="/register" class="mt-7 inline-flex w-full justify-center rounded-2xl border border-slate-200 px-5 py-3.5 font-black text-ink transition hover:bg-slate-50">Mulai Sekarang</a>
                        <ul class="mt-7 space-y-4 text-sm font-semibold text-slate-600">
                            <li>✓ 1 outlet</li>
                            <li>✓ 1 akun kasir</li>
                            <li>✓ 100 transaksi/bulan</li>
                            <li>✓ Laporan basic</li>
                        </ul>
                    </div>

                    <div class="reveal relative rounded-[2rem] border-2 border-brand-600 bg-ink p-8 text-white shadow-glow" style="transition-delay:100ms">
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2 rounded-full bg-brand-600 px-4 py-2 text-xs font-black uppercase tracking-[0.18em] text-white">Paling populer</div>
                        <p class="text-sm font-black uppercase tracking-[0.2em] text-brand-200">Growth</p>
                        <h3 class="mt-4 text-4xl font-black">Rp 79rb<span class="text-base font-bold text-slate-400">/bulan</span></h3>
                        <p class="mt-3 text-slate-300">Untuk bisnis yang mulai ramai dan butuh laporan lengkap.</p>
                        <a href="/register" class="mt-7 inline-flex w-full justify-center rounded-2xl bg-white px-5 py-3.5 font-black text-ink transition hover:-translate-y-0.5 hover:bg-brand-50">Coba Gratis</a>
                        <ul class="mt-7 space-y-4 text-sm font-semibold text-slate-200">
                            <li>✓ 3 outlet</li>
                            <li>✓ 5 akun staff</li>
                            <li>✓ Transaksi unlimited</li>
                            <li>✓ Laporan profit & stok</li>
                            <li>✓ Support prioritas</li>
                        </ul>
                    </div>

                    <div class="reveal rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm" style="transition-delay:200ms">
                        <p class="text-sm font-black uppercase tracking-[0.2em] text-slate-400">Business</p>
                        <h3 class="mt-4 text-4xl font-black text-ink">Rp 149rb<span class="text-base font-bold text-slate-400">/bulan</span></h3>
                        <p class="mt-3 text-slate-600">Untuk bisnis dengan banyak cabang dan tim lebih besar.</p>
                        <a href="/register" class="mt-7 inline-flex w-full justify-center rounded-2xl border border-slate-200 px-5 py-3.5 font-black text-ink transition hover:bg-slate-50">Hubungi Sales</a>
                        <ul class="mt-7 space-y-4 text-sm font-semibold text-slate-600">
                            <li>✓ Outlet unlimited</li>
                            <li>✓ Staff unlimited</li>
                            <li>✓ Export laporan</li>
                            <li>✓ Role permission</li>
                            <li>✓ Bantuan onboarding</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white py-20 lg:py-28">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-6 lg:grid-cols-3">
                    <div class="reveal lg:col-span-1">
                        <p class="mb-3 text-sm font-black uppercase tracking-[0.2em] text-brand-600">Testimoni</p>
                        <h2 class="text-4xl font-black tracking-tight text-ink">Dipakai owner yang ingin bisnisnya lebih terkontrol.</h2>
                    </div>
                    <div class="reveal rounded-[2rem] border border-slate-200 bg-slate-50 p-7" style="transition-delay:80ms">
                        <p class="leading-8 text-slate-700">“Sebelumnya laporan masih manual di buku. Setelah pakai KasirPro, omzet harian dan stok bisa dicek lebih cepat. Kasir juga gampang adaptasi.”</p>
                        <div class="mt-6 flex items-center gap-3">
                            <div class="h-11 w-11 rounded-full bg-brand-100"></div>
                            <div><p class="font-black text-ink">Adit</p><p class="text-sm text-slate-500">Owner Kedai Kopi</p></div>
                        </div>
                    </div>
                    <div class="reveal rounded-[2rem] border border-slate-200 bg-slate-50 p-7" style="transition-delay:160ms">
                        <p class="leading-8 text-slate-700">“Yang paling terasa itu stok jadi nggak sering miss. Tinggal cek dashboard, langsung kelihatan produk mana yang harus restock.”</p>
                        <div class="mt-6 flex items-center gap-3">
                            <div class="h-11 w-11 rounded-full bg-cyan-100"></div>
                            <div><p class="font-black text-ink">Maya</p><p class="text-sm text-slate-500">Pemilik Toko Retail</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="faq" class="py-20 lg:py-28">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <div class="mb-12 text-center reveal">
                    <p class="mb-3 text-sm font-black uppercase tracking-[0.2em] text-brand-600">FAQ</p>
                    <h2 class="text-4xl font-black tracking-tight text-ink sm:text-5xl">Pertanyaan yang sering muncul.</h2>
                </div>

                <div class="space-y-4">
                    <details class="reveal group rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-black text-ink">Apakah cocok untuk UMKM kecil?<span class="text-brand-600 transition group-open:rotate-45">+</span></summary>
                        <p class="mt-4 leading-7 text-slate-600">Cocok. Paket Starter bisa dipakai untuk mencoba alur transaksi dan laporan basic sebelum upgrade ke paket berbayar.</p>
                    </details>
                    <details class="reveal group rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-black text-ink">Bisa dipakai banyak kasir?<span class="text-brand-600 transition group-open:rotate-45">+</span></summary>
                        <p class="mt-4 leading-7 text-slate-600">Bisa. Paket Growth dan Business mendukung beberapa akun staff dengan akses yang bisa disesuaikan.</p>
                    </details>
                    <details class="reveal group rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-black text-ink">Apakah ada laporan laba dan stok?<span class="text-brand-600 transition group-open:rotate-45">+</span></summary>
                        <p class="mt-4 leading-7 text-slate-600">Ada. Dashboard menampilkan ringkasan penjualan, produk terlaris, stok menipis, dan performa toko.</p>
                    </details>
                </div>
            </div>
        </section>

        <section class="px-4 pb-20 sm:px-6 lg:px-8">
            <div class="reveal mx-auto max-w-7xl overflow-hidden rounded-[2.5rem] bg-ink px-6 py-16 text-center shadow-soft sm:px-10 lg:py-20 relative">
                <div class="absolute -top-24 left-1/2 h-72 w-72 -translate-x-1/2 rounded-full bg-brand-500/40 blur-3xl"></div>
                <div class="relative z-10 mx-auto max-w-3xl">
                    <p class="mb-4 text-sm font-black uppercase tracking-[0.22em] text-brand-200">Mulai sekarang</p>
                    <h2 class="text-4xl font-black tracking-tight text-white sm:text-5xl">Ubah cara tokomu bekerja jadi lebih modern.</h2>
                    <p class="mx-auto mt-5 max-w-2xl text-lg leading-8 text-slate-300">Coba KasirPro gratis dan rasakan sendiri operasional yang lebih rapi, cepat, dan mudah dipantau.</p>
                    <div class="mt-9 flex flex-col justify-center gap-3 sm:flex-row">
                        <a href="/register" class="rounded-2xl bg-white px-7 py-4 font-black text-ink transition hover:-translate-y-1 hover:bg-brand-50">Coba Gratis 30 Hari</a>
                        <a href="#harga" class="rounded-2xl border border-white/20 px-7 py-4 font-black text-white transition hover:-translate-y-1 hover:bg-white/10">Bandingkan Paket</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="border-t border-slate-200 bg-white py-10">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-5 px-4 text-center sm:px-6 md:flex-row md:text-left lg:px-8">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-ink font-black text-white">K</div>
                <div>
                    <p class="font-black text-ink">KasirPro</p>
                    <p class="text-sm text-slate-500">Aplikasi kasir modern untuk bisnis bertumbuh.</p>
                </div>
            </div>
            <p class="text-sm font-semibold text-slate-400">© 2026 KasirPro. All rights reserved.</p>
        </div>
    </footer>

    <script>
        const menuBtn = document.getElementById('menuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const navbar = document.getElementById('navbar');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        document.querySelectorAll('#mobileMenu a').forEach(link => {
            link.addEventListener('click', () => mobileMenu.classList.add('hidden'));
        });

        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                navbar.classList.add('shadow-soft');
                navbar.classList.remove('shadow-sm');
            } else {
                navbar.classList.remove('shadow-soft');
                navbar.classList.add('shadow-sm');
            }
        });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.14 });

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    </script>
</body>
</html>