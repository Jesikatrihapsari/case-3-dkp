<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - Katalog Produk Nusantara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }
    </style>
</head>
<body class="bg-[#5A3825] min-h-screen flex flex-col justify-between text-slate-100">

    <!-- Navbar Sederhana di Atas -->
    <header class="w-full max-w-6xl mx-auto px-6 py-6 flex justify-between items-center border-b border-amber-900/40">
        <div class="flex items-center space-x-2">
            <span class="bg-[#7A4D33] text-amber-100 text-xs px-3 py-1 rounded-full font-bold tracking-wider border border-[#9A6240]">
                TOKO PRIBADI
            </span>
        </div>
        <nav class="space-x-4 text-sm font-medium">
            <a href="{{ route('public.catalog') }}" class="text-amber-200 hover:text-white transition">Lihat Katalog</a>
            <a href="{{ route('login') }}" class="text-amber-200 hover:text-white transition">Masuk (Login)</a>
        </nav>
    </header>

    <!-- Hero Section -->
    <main class="flex-grow flex items-center justify-center px-4 py-12">
        <div class="max-w-3xl text-center space-y-6">
            
            <div class="inline-block bg-[#7A4D33]/60 backdrop-blur-md text-amber-200 text-xs px-4 py-1.5 rounded-full uppercase tracking-widest font-semibold border border-amber-800">
                Katalog & Koleksi Eksklusif
            </div>

            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-wide text-white leading-tight">
                Katalog Produk Berkualitas untuk Gaya Hidup Modern
            </h1>

            <p class="text-amber-100/80 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">
                Temukan berbagai pilihan produk terbaik kami yang dikurasi khusus dengan sentuhan estetika Nusantara. Kelola dan jelajahi produk dengan mudah dalam satu genggaman.
            </p>

            <!-- Tombol Navigasi Terpisah -->
            <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3">
                <!-- Tombol ke Katalog Publik (Lihat Produk Saja) -->
                <a href="{{ route('public.catalog') }}" class="w-full sm:w-auto bg-white hover:bg-amber-50 text-[#5A3825] font-bold py-4 px-8 rounded-full shadow-lg transition duration-200 text-sm tracking-wider uppercase">
                    Lihat Koleksi Produk &rarr;
                </a>
                
                <!-- Tombol ke Login Pengelola (Tambah, Edit, Hapus, Trash) -->
                <a href="{{ route('login') }}" class="w-full sm:w-auto bg-[#7A4D33] hover:bg-[#8D5B3C] text-amber-100 font-bold py-4 px-8 rounded-full shadow-lg transition duration-200 text-sm tracking-wider uppercase border border-[#9A6240]">
                    Masuk Pengelola
                </a>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full py-6 text-center text-amber-200/50 text-xs border-t border-amber-900/40">
        &copy; 2026 Katalog Produk Pribadi. All rights reserved.
    </footer>

</body>
</html>