<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengelola - Nusantara</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#5A3825] min-h-screen flex flex-col justify-between text-slate-100 font-sans">

    <!-- Header / Navbar Dashboard -->
    <header class="w-full max-w-6xl mx-auto px-4 sm:px-6 py-4 sm:py-6 flex flex-col sm:flex-row justify-between items-center gap-4 border-b border-amber-900/40">
        <div class="flex items-center space-x-3">
            <span class="bg-[#7A4D33] text-amber-100 text-xs px-3.5 py-1.5 rounded-full font-bold tracking-wider border border-[#9A6240]">
                ADMIN PENGELOLA
            </span>
        </div>

        <!-- Tombol Navigasi Atas (Beranda, Lihat Katalog, & Ikon Trash) -->
        <div class="flex items-center flex-wrap justify-center gap-3">
            <a href="{{ url('/') }}" class="bg-white/10 hover:bg-white/20 text-amber-100 text-xs px-4 py-2 rounded-xl font-medium transition border border-amber-800/60 flex items-center gap-1.5">
                &larr; Beranda Utama
            </a>
            <a href="{{ route('public.catalog') }}" target="_blank" class="bg-emerald-700 hover:bg-emerald-800 text-white text-xs px-4 py-2 rounded-xl font-medium transition shadow-md flex items-center gap-1.5">
                Lihat Katalog &rarr;
            </a>
            <!-- Ikon Tempat Sampah -->
            <a href="{{ route('products.trash') }}" title="Tempat Sampah" class="bg-rose-900/60 hover:bg-rose-900 text-rose-100 p-2.5 rounded-xl transition border border-rose-800 flex items-center justify-center shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </a>
        </div>

        <!-- Tombol Logout Polos Tanpa Kotak -->
        <div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-xs font-medium text-amber-200/80 hover:text-white transition tracking-wide underline underline-offset-4">
                    Logout
                </button>
            </form>
        </div>
    </header>

    <!-- Konten Utama Dashboard -->
    <main class="w-full max-w-6xl mx-auto px-4 sm:px-6 py-6 sm:py-8 flex-grow">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 sm:mb-8">
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold tracking-wide text-white">Kelola Produk</h1>
                <p class="text-xs text-amber-200/80 mt-1">Tambah, ubah, atau pantau produk yang tampil di toko Anda.</p>
            </div>
            <a href="{{ route('products.create') }}" class="w-full sm:w-auto text-center bg-white text-[#5A3825] hover:bg-amber-50 font-bold px-5 py-3 rounded-2xl text-xs uppercase tracking-wider transition shadow-lg flex items-center justify-center gap-2">
                + Tambah Produk Baru
            </a>
        </div>

        <!-- Notifikasi Sukses -->
        @if(session('success'))
            <div class="bg-emerald-500/20 border border-emerald-500 text-emerald-100 px-4 py-3 rounded-2xl text-xs mb-6 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Daftar Produk: Fleksibel untuk Berbagai Device -->
        <div class="bg-white rounded-3xl p-4 sm:p-6 shadow-xl text-slate-800">
            
            <!-- Tampilan Kartu Khusus untuk Perangkat Mobile / Layar Kecil -->
            <div class="block md:hidden space-y-4">
                @forelse($products as $product)
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 flex flex-col gap-3">
                        <div class="flex items-center space-x-3">
                            @if($product->foto_produk)
                                <img src="{{ asset('uploads/products/' . $product->foto_produk) }}" alt="Foto" class="w-14 h-14 object-cover rounded-xl shadow-sm flex-shrink-0">
                            @else
                                <div class="w-14 h-14 bg-slate-200 rounded-xl flex items-center justify-center text-[10px] text-slate-500 font-bold flex-shrink-0">N/A</div>
                            @endif
                            <div class="overflow-hidden">
                                <h3 class="text-xs font-bold text-slate-800 truncate">{{ $product->nama_produk }}</h3>
                                <p class="text-[11px] text-slate-500">Kategori: {{ $product->kategori }}</p>
                                <p class="text-xs font-extrabold text-[#7A4D33] mt-0.5">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="flex justify-between items-center border-t border-slate-200 pt-3 text-xs">
                            <span class="text-slate-600 font-medium">Stok: <b>{{ $product->stok }}</b></span>
                            <div class="space-x-2">
                                <a href="{{ route('products.edit', $product->id) }}" class="inline-block bg-amber-100 hover:bg-amber-200 text-[#5A3825] font-bold px-3 py-1.5 rounded-xl text-[11px] transition">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Pindahkan produk ini ke tempat sampah?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-rose-100 hover:bg-rose-200 text-rose-700 font-bold px-3 py-1.5 rounded-xl text-[11px] transition">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center py-8 text-slate-400 italic text-xs">Belum ada produk di database.</p>
                @endforelse
            </div>

            <!-- Tampilan Tabel Profesional untuk Tablet & Desktop -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                            <th class="pb-3 px-3">Foto</th>
                            <th class="pb-3 px-3">Nama Produk</th>
                            <th class="pb-3 px-3">Kategori</th>
                            <th class="pb-3 px-3">Harga</th>
                            <th class="pb-3 px-3">Stok</th>
                            <th class="pb-3 px-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse($products as $product)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3 px-3">
                                    @if($product->foto_produk)
                                        <img src="{{ asset('uploads/products/' . $product->foto_produk) }}" alt="Foto" class="w-12 h-12 object-cover rounded-xl shadow-sm">
                                    @else
                                        <div class="w-12 h-12 bg-slate-200 rounded-xl flex items-center justify-center text-[10px] text-slate-500 font-bold">N/A</div>
                                    @endif
                                </td>
                                <td class="py-3 px-3 font-bold text-slate-800">{{ $product->nama_produk }}</td>
                                <td class="py-3 px-3 text-slate-600">{{ $product->kategori }}</td>
                                <td class="py-3 px-3 font-extrabold text-[#7A4D33]">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                                <td class="py-3 px-3 text-slate-600">{{ $product->stok }}</td>
                                <td class="py-3 px-3 text-center space-x-2">
                                    <a href="{{ route('products.edit', $product->id) }}" class="inline-block bg-amber-100 hover:bg-amber-200 text-[#5A3825] font-bold px-3 py-1.5 rounded-xl text-[11px] transition">Edit</a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Pindahkan produk ini ke tempat sampah?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-rose-100 hover:bg-rose-200 text-rose-700 font-bold px-3 py-1.5 rounded-xl text-[11px] transition">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-slate-400 italic">Belum ada produk di database.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </main>

    <!-- Footer Minimalis -->
    <footer class="w-full py-6 text-center text-amber-200/50 text-xs border-t border-amber-900/40 px-4">
        <span>&copy; 2026 Katalog Produk Pribadi. All rights reserved.</span>
    </footer>

</body>
</html>