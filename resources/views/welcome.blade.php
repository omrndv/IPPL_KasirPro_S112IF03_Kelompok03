<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KasirPro - Aplikasi Kasir Digital Terbaik</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            "50": "#eff6ff",
                            "100": "#dbeafe",
                            "200": "#bfdbfe",
                            "300": "#93c5fd",
                            "400": "#60a5fa",
                            "500": "#3b82f6",
                            "600": "#2563eb",
                            "700": "#1d4ed8",
                            "800": "#1e40af",
                            "900": "#1e3a8a"
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    },
                    animation: {
                        'gradient-x': 'gradient-x 3s ease infinite',
                        'blob': 'blob 7s infinite',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        'gradient-x': {
                            '0%, 100%': {
                                'background-size': '200% 200%',
                                'background-position': 'left center'
                            },
                            '50%': {
                                'background-size': '200% 200%',
                                'background-position': 'right center'
                            },
                        },
                        'blob': {
                            '0%': {
                                transform: 'translate(0px, 0px) scale(1)'
                            },
                            '33%': {
                                transform: 'translate(30px, -50px) scale(1.1)'
                            },
                            '66%': {
                                transform: 'translate(-20px, 20px) scale(0.9)'
                            },
                            '100%': {
                                transform: 'translate(0px, 0px) scale(1)'
                            },
                        },
                        'float': {
                            '0%, 100%': {
                                transform: 'translateY(0px)'
                            },
                            '50%': {
                                transform: 'translateY(-20px)'
                            },
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <style>
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.5, 0, 0, 1);
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</head>

<body class="bg-white text-gray-900 antialiased selection:bg-primary-200 selection:text-primary-900 overflow-x-hidden">

    <nav class="fixed w-full z-50 top-0 start-0 border-b border-gray-100 bg-white/80 backdrop-blur-md transition-all duration-300"
        id="navbar">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between p-4 lg:px-8">
            <a href="/" class="flex items-center space-x-2 group">
                <div
                    class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center text-white font-black text-xl shadow-sm group-hover:rotate-12 transition duration-300">
                    K</div>
                <span class="self-center text-2xl font-bold whitespace-nowrap tracking-tight">KasirPro</span>
            </a>

            <div class="flex md:order-2 space-x-3 md:space-x-4 items-center">
                <a href="/login"
                    class="text-gray-600 hover:text-gray-900 font-semibold text-sm px-2 py-2 transition hidden sm:block">Log
                    in</a>
                <a href="/register"
                    class="text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-bold rounded-xl text-sm px-5 py-2.5 text-center transition shadow-sm hover:shadow-primary-500/30 hover:-translate-y-0.5">Coba
                    Gratis</a>
            </div>

            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                <ul
                    class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 md:flex-row md:mt-0 md:border-0 md:bg-transparent">
                    <li><a href="#features"
                            class="block py-2 px-3 text-gray-600 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-primary-600 md:p-0 transition">Fitur</a>
                    </li>
                    <li><a href="#testimonials"
                            class="block py-2 px-3 text-gray-600 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-primary-600 md:p-0 transition">Testimoni</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="pt-32 pb-20 lg:pt-40 lg:pb-28 relative">
        <div
            class="absolute top-0 right-0 -z-10 w-[500px] h-[500px] bg-primary-200 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob translate-x-1/3">
        </div>
        <div
            class="absolute top-40 right-40 -z-10 w-[400px] h-[400px] bg-cyan-200 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob animation-delay-2000">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-8 items-center">

                <div class="max-w-2xl text-center lg:text-left mx-auto lg:mx-0 reveal" style="transition-delay: 100ms;">
                    <div
                        class="inline-flex items-center px-3 py-1 rounded-full bg-primary-50 text-primary-600 text-xs font-bold uppercase tracking-wider mb-6 border border-primary-100 shadow-sm hover:shadow-md transition cursor-default">
                        <span class="flex w-2 h-2 bg-primary-600 rounded-full mr-2 animate-ping"></span> KasirPro v1.0
                        Rilis
                    </div>
                    <h1
                        class="text-5xl md:text-6xl lg:text-7xl font-black text-gray-900 tracking-tight leading-[1.1] mb-6">
                        Kelola Toko Lebih <br />
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 via-cyan-500 to-primary-600 animate-gradient-x">Cepat
                            & Pintar</span>
                    </h1>
                    <p class="text-lg text-gray-500 mb-8 leading-relaxed reveal" style="transition-delay: 200ms;">
                        KasirPro adalah sistem Point of Sale (POS) modern yang dirancang untuk meningkatkan efisiensi
                        dan laba bisnis Anda, mulai dari UMKM hingga Enterprise.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start reveal"
                        style="transition-delay: 300ms;">
                        <a href="/register"
                            class="text-white bg-blue-500 hover:bg-blue-700 focus:ring-4 focus:ring-gray-300 font-bold rounded-xl text-lg px-8 py-4 text-center transition shadow-xl hover:shadow-2xl hover:-translate-y-1 flex justify-center items-center gap-2">
                            Mulai Gratis 30 Hari <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                        <a href="#features"
                            class="text-gray-600 bg-white border-2 border-gray-200 hover:bg-gray-50 hover:text-gray-900 font-bold rounded-xl text-lg px-8 py-4 text-center transition flex justify-center items-center hover:-translate-y-1">
                            Lihat Fitur
                        </a>
                    </div>
                </div>

                <div class="relative lg:h-[500px] flex justify-center lg:justify-end reveal"
                    style="transition-delay: 400ms;">
                    <div
                        class="absolute inset-0 bg-gradient-to-tr from-primary-300 to-cyan-300 blur-2xl opacity-20 rounded-full animate-pulse">
                    </div>

                    <div
                        class="relative w-full max-w-lg bg-white/90 backdrop-blur-sm rounded-2xl shadow-2xl border border-white/50 overflow-hidden z-10 animate-float">
                        <div class="bg-gray-50/80 border-b border-gray-100 px-4 py-3 flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-rose-400"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
                        </div>
                        <div class="p-6 bg-gray-50/50">
                            <div class="flex justify-between items-center mb-6">
                                <div class="w-32 h-6 bg-gray-200 rounded-md"></div>
                                <div
                                    class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 font-bold">
                                    K</div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div
                                    class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 transition hover:shadow-md cursor-pointer">
                                    <div class="w-16 h-3 bg-gray-200 rounded mb-2"></div>
                                    <div class="w-24 h-6 bg-gray-900 rounded"></div>
                                </div>
                                <div
                                    class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 transition hover:shadow-md cursor-pointer">
                                    <div class="w-16 h-3 bg-gray-200 rounded mb-2"></div>
                                    <div class="w-24 h-6 bg-primary-600 rounded"></div>
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 space-y-4">
                                <div class="flex justify-between items-center pb-3 border-b border-gray-50">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-blue-50 rounded-lg"></div>
                                        <div class="w-20 h-4 bg-gray-200 rounded"></div>
                                    </div>
                                    <div class="w-16 h-4 bg-gray-200 rounded"></div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-orange-50 rounded-lg"></div>
                                        <div class="w-24 h-4 bg-gray-200 rounded"></div>
                                    </div>
                                    <div class="w-16 h-4 bg-gray-200 rounded"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute -right-6 bottom-20 bg-white/90 backdrop-blur-md p-4 rounded-2xl shadow-xl border border-white z-20 animate-bounce"
                        style="animation-duration: 4s;">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center text-xl">
                                📈</div>
                            <div>
                                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">Laba Hari Ini
                                </p>
                                <p class="text-sm font-black text-gray-900">+ Rp 5.300.000</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="border-y border-gray-100 bg-gray-50/50 py-12 reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-8">Dipercaya Oleh 5,000+ Bisnis di
                Indonesia</p>
            <div
                class="flex flex-wrap justify-center gap-8 md:gap-16 opacity-50 grayscale hover:grayscale-0 hover:opacity-100 transition duration-700">
                <span class="text-xl font-bold text-gray-800 flex items-center gap-2"><span class="text-2xl">☕</span>
                    Bagus Café</span>
                <span class="text-xl font-bold text-gray-800 flex items-center gap-2"><span class="text-2xl">🏪</span>
                    Warung Makmur</span>
                <span class="text-xl font-bold text-gray-800 flex items-center gap-2"><span class="text-2xl">👗</span>
                    Butik Cantik</span>
                <span class="text-xl font-bold text-gray-800 flex items-center gap-2"><span class="text-2xl">🍔</span>
                    Burger Bang</span>
            </div>
        </div>
    </section>

    <section id="features" class="py-20 lg:py-28 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-2xl mx-auto mb-16 reveal">
                <h2 class="text-sm font-bold text-primary-600 uppercase tracking-widest mb-2">Fitur Unggulan</h2>
                <h3 class="text-3xl md:text-4xl lg:text-5xl font-black text-gray-900 tracking-tight">Semua yang Anda
                    Butuhkan untuk Sukses</h3>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white border border-gray-100 p-8 rounded-3xl shadow-sm hover:shadow-2xl hover:shadow-primary-500/10 transition-all duration-300 hover:-translate-y-2 group reveal"
                    style="transition-delay: 100ms;">
                    <div
                        class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Transaksi Kilat</h4>
                    <p class="text-gray-500 leading-relaxed text-sm">Proses pembayaran sangat cepat, responsif, dan
                        mudah dipahami oleh kasir baru sekalipun.</p>
                </div>

                <div class="bg-white border border-gray-100 p-8 rounded-3xl shadow-sm hover:shadow-2xl hover:shadow-emerald-500/10 transition-all duration-300 hover:-translate-y-2 group reveal"
                    style="transition-delay: 200ms;">
                    <div
                        class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Manajemen Stok</h4>
                    <p class="text-gray-500 leading-relaxed text-sm">Pantau ketersediaan produk secara real-time.
                        Dapatkan notifikasi saat stok menipis.</p>
                </div>

                <div class="bg-white border border-gray-100 p-8 rounded-3xl shadow-sm hover:shadow-2xl hover:shadow-purple-500/10 transition-all duration-300 hover:-translate-y-2 group reveal"
                    style="transition-delay: 300ms;">
                    <div
                        class="w-14 h-14 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-purple-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Laporan Otomatis</h4>
                    <p class="text-gray-500 leading-relaxed text-sm">Dapatkan insight laba rugi, tren penjualan produk
                        terlaris, dan grafik performa instan.</p>
                </div>

                <div class="bg-white border border-gray-100 p-8 rounded-3xl shadow-sm hover:shadow-2xl hover:shadow-rose-500/10 transition-all duration-300 hover:-translate-y-2 group reveal"
                    style="transition-delay: 400ms;">
                    <div
                        class="w-14 h-14 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-rose-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                            </path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Multi-Payment</h4>
                    <p class="text-gray-500 leading-relaxed text-sm">Terima pembayaran dari metode apa pun: Uang Tunai,
                        QRIS dinamis, hingga Kartu Kredit.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 pb-32">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 reveal">
            <div class="bg-gray-900 rounded-[3rem] p-10 md:p-16 text-center relative overflow-hidden shadow-2xl">
                <div
                    class="absolute top-0 right-0 w-80 h-80 bg-primary-600 rounded-full mix-blend-screen filter blur-[80px] opacity-50 animate-blob">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-80 h-80 bg-cyan-500 rounded-full mix-blend-screen filter blur-[80px] opacity-50 animate-blob animation-delay-4000">
                </div>

                <div class="relative z-10">
                    <h2 class="text-4xl md:text-5xl font-black text-white mb-6 tracking-tight">Siap Melangkah Lebih
                        Jauh?</h2>
                    <p class="text-gray-300 text-lg mb-10 max-w-2xl mx-auto leading-relaxed">Daftar sekarang dan
                        nikmati akses penuh ke seluruh fitur KasirPro. Beralih dari cara lama yang membingungkan.</p>
                    <a href="/register"
                        class="inline-flex items-center text-gray-900 bg-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-bold rounded-2xl text-lg px-8 py-4 transition shadow-xl hover:scale-105 duration-300">
                        Buat Akun Sekarang Gratis
                    </a>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-white border-t border-gray-100 pt-16 pb-8 text-center md:text-left">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center space-x-2">
                <div
                    class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center text-white font-black text-lg shadow-sm">
                    K</div>
                <span class="text-xl font-bold text-gray-900 tracking-tight">KasirPro</span>
            </div>
            <div class="text-sm text-gray-400 font-medium">
                &copy; 2026 KasirPro. Dibuat dengan Niat.
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Animasi Scroll Reveal
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.15
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.reveal').forEach((el) => {
                observer.observe(el);
            });

            // Efek Navbar Blur saat di-scroll
            window.addEventListener('scroll', function() {
                const navbar = document.getElementById('navbar');
                if (window.scrollY > 10) {
                    navbar.classList.add('shadow-sm');
                } else {
                    navbar.classList.remove('shadow-sm');
                }
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>

</html>
