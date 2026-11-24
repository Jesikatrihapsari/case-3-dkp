<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nusantara Store</title>
    
    <!-- Tailwind CSS (sesuaikan dengan setup asset Vite proyekmu) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Wajib ada untuk Livewire -->
    @livewireStyles
</head>
<body class="bg-[#FDFBF7] text-[#5A3825]">

    <!-- Bagian Header / Navbar sederhana jika ada -->
    <header class="bg-white shadow-sm py-4 px-6 mb-6">
        <h1 class="text-2xl font-bold text-center">Katalog Nusantara</h1>
    </header>

    <!-- Tempat konten utama (seperti halaman Livewire kita) akan tampil -->
    <main>
        @yield('content')
    </main>

    <!-- Wajib ada untuk Livewire -->
    @livewireScripts
</body>
</html>