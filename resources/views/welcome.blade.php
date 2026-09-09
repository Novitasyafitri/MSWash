<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MSWash</title>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .backdrop { backdrop-filter: blur(6px); background: rgba(0,0,0,0.35); }
        html { scroll-behavior: smooth; }
    </style>
</head>

<body class="bg-gray-50">

<!-- NAVBAR -->
<!-- NAVBAR -->
<header class="bg-white shadow-md py-3 sticky top-0 z-50">

    <div class="w-full flex items-center justify-between px-5">

        <!-- LOGO -->
        <h1 class="text-2xl font-bold text-blue-900">MSWash</h1>

        <!-- DESKTOP MENU -->
        <nav class="hidden md:flex items-center gap-8 text-gray-700 font-medium">
            <a href="#beranda" class="hover:text-blue-800">Beranda</a>
            <a href="#layanan" class="hover:text-blue-800">Layanan</a>
            <a href="#kontak" class="hover:text-blue-800">Kontak</a>

            @guest
                <a href="{{ route('login') }}" 
                   class="px-4 py-2 bg-blue-700 text-white rounded-full hover:bg-blue-800">
                   Login
                </a>
            @endguest

            @auth
                <a href="{{ route('dashboard') }}" 
                   class="px-4 py-2 bg-blue-700 text-white rounded-full hover:bg-blue-800">
                   Dashboard
                </a>
            @endauth
        </nav>

        <!-- BUTTON HAMBURGER (HP only) -->
        <button id="menuBtn" class="md:hidden p-2 border rounded-lg" aria-label="Buka Menu">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

    </div>

    <!-- MENU MOBILE -->
    <div id="mobileMenu" class="hidden md:hidden bg-white border-t px-5 pb-4 space-y-3">

        <a href="#beranda" class="block py-2 border-b">Beranda</a>
        <a href="#layanan" class="block py-2 border-b">Layanan</a>
        <a href="#kontak" class="block py-2 border-b">Kontak</a>

        @guest
            <a href="{{ route('login') }}" 
               class="block text-center mt-2 px-4 py-2 bg-blue-700 text-white rounded-full">
               Login
            </a>
        @endguest

        @auth
            <a href="{{ route('dashboard') }}" 
               class="block text-center mt-2 px-4 py-2 bg-blue-700 text-white rounded-full">
               Dashboard
            </a>
        @endauth
    </div>
</header>

<script>
    const btn = document.getElementById("menuBtn");
    const menu = document.getElementById("mobileMenu");

    btn.addEventListener("click", () => {
        menu.classList.toggle("hidden");
    });
</script>


<!-- HERO SECTION -->
<section id="beranda" class="relative h-[88vh] flex items-center">
<img src="/cuci mobil.webp" class="absolute inset-0 w-full h-full object-cover" alt="Layanan Cuci Mobil MSWash" />
    <div class="absolute inset-0 backdrop"></div>

    <div class="relative container mx-auto px-5 flex items-center justify-between">

        <!-- TEXT KIRI -->
        <div class="text-white max-w-xl">
            <span class="px-4 py-2 bg-white/40 backdrop-blur-md rounded-full text-base tracking-wide mb-6 inline-block">
                Sistem Manajemen MSWash
            </span>

            <h2 class="text-5xl font-bold drop-shadow-md mb-6 leading-tight">
                Kelola Transaksi Carwash <br> Lebih Cepat & Efisien
            </h2>

            <p class="text-lg text-gray-200 leading-relaxed mb-8">
                Sistem manajemen operasional untuk usaha cuci kendaraan. 
                Catat transaksi otomatis, pantau laporan real-time, 
                dan tingkatkan produktivitas operasional.
            </p>

            <div>
                @guest
                    <a href="{{ route('login') }}" 
                       class="px-7 py-3 bg-blue-700 hover:bg-blue-800 text-white text-base rounded-xl shadow-lg transition">
                        Login
                    </a>
                @endguest

                @auth
                    <a href="{{ route('dashboard') }}" 
                       class="px-7 py-3 bg-blue-700 hover:bg-blue-800 text-white text-base rounded-xl shadow-lg transition">
                        Dashboard
                    </a>
                @endauth
            </div>
        </div>

        <!-- GAMBAR KANAN -->
        <div class="hidden md:block translate-y-12">
<img src="/cuci mobil.webp" class="w-80 h-56 object-cover rounded-2xl shadow-xl border border-white/30" fetchpriority="high" alt="Preview Aplikasi MSWash" />
</div>

    </div>
</section>

<!-- FITUR -->
<section id="layanan" class="py-20 bg-gradient-to-b from-blue-50 to-white">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold text-blue-900 mb-5 font-Poppins">
            Mengapa Memilih <span class="text-blue-600">MSWash?</span>
        </h2>

        <p class="text-lg text-gray-700 max-w-3xl mx-auto mb-16 leading-relaxed font-Inter">
            <span class="font-semibold text-blue-900">MSWash</span> adalah sistem manajemen operasional carwash 
            yang dirancang khusus untuk usaha cuci kendaraan.  
            Transaksi tercatat otomatis, laporan keuangan tampil real-time, 
            dan pengelolaan pelanggan serta stok berjalan lebih efisien.  
            Solusi profesional untuk digitalisasi UMKM carwash di era modern.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Card 1 -->
            <div class="p-8 rounded-2xl shadow-xl border border-white/30 bg-white/40 backdrop-blur-xl hover:scale-105 transition cursor-pointer">
                <img src="efisien.jpg" class="w-16 mx-auto mb-4" alt="Efisien" width="64" height="64" fetchpriority="high">
                <h2 class="text-xl font-semibold text-blue-900 mb-2">Efisien</h2>
                <p class="text-gray-700 text-sm leading-relaxed font-Inter">
                    Operasional lebih cepat dan sederhana tanpa proses manual.
                </p>
            </div>

            <!-- Card 2 -->
            <div class="p-8 rounded-2xl shadow-xl border border-white/30 bg-white/40 backdrop-blur-xl hover:scale-105 transition cursor-pointer">
                <img src="akurat.jpg" class="w-16 mx-auto mb-4" alt="Akurat" width="64" height="64" fetchpriority="high">
                <h2 class="text-xl font-semibold text-blue-900 mb-2">Cepat & Akurat</h2>
                <p class="text-gray-700 text-sm leading-relaxed font-Inter">
                    Transaksi tercatat otomatis dengan hasil yang presisi.
                </p>
            </div>

            <!-- Card 3 -->
            <div class="p-8 rounded-2xl shadow-xl border border-white/30 bg-white/40 backdrop-blur-xl hover:scale-105 transition cursor-pointer">
                <img src="pelanggan.jpg" class="w-16 mx-auto mb-4" alt="Manajemen Pelanggan" width="64" height="64" fetchpriority="high">
                <h2 class="text-xl font-semibold text-blue-900 mb-2">Manajemen Pelanggan</h2>
                <p class="text-gray-700 text-sm leading-relaxed font-Inter">
                    Catat pelanggan tetap dan riwayat layanan secara otomatis.
                </p>
            </div>

            <!-- Card 4 -->
            <div class="p-8 rounded-2xl shadow-xl border border-white/30 bg-white/40 backdrop-blur-xl hover:scale-105 transition cursor-pointer">
                <img src="realtime2.jpg" class="w-16 mx-auto mb-4" alt="Data Real-time" width="64" height="64" fetchpriority="high">
                <h2 class="text-xl font-semibold text-blue-900 mb-2">Data Real-time</h2>
                <p class="text-gray-700 text-sm leading-relaxed font-Inter">
                    Laporan keuangan dan grafik tersedia langsung tanpa menunggu.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- KONTAK (Versi Elegan Premium) -->
<section id="kontak" class="pt-10 pb-24 bg-gradient-to-b from-gray-100 to-gray-200">

    <div class="container mx-auto px-5 text-center">

        <!-- Judul -->
        <h2 class="text-4xl md:text-5xl font-extrabold text-gray-800 mb-4">
            Kontak Kami
        </h2>

        <!-- Garis dekorasi -->
        <div class="h-1 w-20 bg-blue-600 mx-auto mb-6 rounded-full"></div>

        <!-- Subtext -->
        <p class="text-gray-600 text-lg max-w-2xl mx-auto mb-14 leading-relaxed">
            Butuh bantuan atau ingin mengetahui lebih lanjut tentang MSWash?
            Kami siap membantu Anda kapan saja.
        </p>

<!-- Card Container -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-10 mt-10">

    <!-- CARD 1 — LOKASI -->
    <div class="bg-white p-10 rounded-2xl shadow-lg border border-gray-200">
        <div class="w-14 h-14 mx-auto mb-5 flex items-center justify-center bg-blue-100 rounded-full">
            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 2C8.134 2 5 5.134 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.866-3.134-7-7-7z"></path>
            </svg>
        </div>

        <h2 class="text-xl font-semibold text-gray-800 mb-2 text-center">Lokasi</h2>

        <p class="text-gray-600 text-sm leading-relaxed text-center">
            <a href="https://www.google.com/maps?q=F4CG+3WR,+Gg.+Siaga,+Senggoro,+Bengkalis,+Riau"
               target="_blank" class="hover:text-blue-600 transition font-medium">
                F4CG+3WR, Gg. Siaga, Senggoro, Bengkalis, Riau
            </a>
        </p>
    </div>


    <!-- CARD 2 — INSTAGRAM -->
<!-- CARD 2 — INSTAGRAM -->
    <div class="bg-white p-10 rounded-2xl shadow-lg border border-gray-200">
        <!-- Wadah pembungkus lingkaran dan penengah -->
        <div class="w-14 h-14 mx-auto mb-5 flex items-center justify-center bg-pink-100 rounded-full">
            <img src="https://cdn-icons-png.flaticon.com/32/2111/2111463.png" class="w-7 h-7 object-contain" alt="Instagram Logo">
        </div>

        <h2 class="text-xl font-semibold text-gray-800 mb-2 text-center">Instagram</h2>

        <p class="text-gray-600 text-sm leading-relaxed text-center">
            <a href="https://instagram.com/ziaga.carwash" 
               target="_blank" class="hover:text-blue-600 transition font-medium">
                @ziaga.carwash
            </a>
        </p>
    </div>


    <!-- CARD 3 — TIKTOK -->
    <div class="bg-white p-10 rounded-2xl shadow-lg border border-gray-200">
        <!-- Wadah pembungkus lingkaran dan penengah -->
        <div class="w-14 h-14 mx-auto mb-5 flex items-center justify-center bg-gray-100 rounded-full">
            <img src="https://cdn-icons-png.flaticon.com/32/3046/3046121.png" class="w-7 h-7 object-contain" alt="TikTok Logo">
        </div>

        <h2 class="text-xl font-semibold text-gray-800 mb-2 text-center">TikTok</h2>

        <p class="text-gray-600 text-sm leading-relaxed text-center">
            <a href="https://www.tiktok.com/@ziaga.carwash" 
               target="_blank" class="hover:text-blue-600 transition font-medium">
                @ziaga.carwash
            </a>
        </p>
    </div>
</div>

        </div>

    </div>
</section>


</body>
</html>
