<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Sampah Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#5A3825] min-h-screen py-10 px-4 flex flex-col items-center justify-between">

    <!-- Header / Info di Atas -->
    <div class="w-full max-w-lg text-center mb-6">
        <div class="inline-block bg-rose-900 text-rose-100 text-xs px-3 py-1 rounded-full mb-2 font-medium tracking-wide border border-rose-800">
            ARSIP SAMPAH
        </div>
        <h1 class="text-white text-xl font-bold tracking-wider">PRODUK TERHAPUS</h1>
        <p class="text-amber-200/80 text-xs mt-1">Pulihkan produk atau hapus secara permanen dari sistem.</p>
    </div>

    <!-- Container Utama -->
    <div class="w-full max-w-lg space-y-4">

        @if(session('success'))
            <div class="p-3 bg-emerald-100 text-emerald-800 rounded-2xl text-center text-xs font-medium shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl p-6 shadow-2xl border border-slate-100 space-y-4">
            
            <div class="space-y-3 max-h-96 overflow-y-auto pr-1">
                @forelse($products as $item)
                    <div class="flex items-center justify-between bg-slate-50 p-3 rounded-2xl border border-slate-100 transition hover:bg-rose-50/30">
                        <div class="flex items-center space-x-3 overflow-hidden">
                            @if($item->foto_produk)
                                <img src="{{ asset('uploads/products/' . $item->foto_produk) }}" alt="Foto" class="w-10 h-10 object-cover rounded-xl shadow-sm flex-shrink-0">
                            @else
                                <div class="w-10 h-10 bg-slate-200 rounded-xl flex items-center justify-center text-[10px] text-slate-500 font-bold flex-shrink-0">IMG</div>
                            @endif
                            <div class="truncate">
                                <h3 class="text-xs font-bold text-slate-800 truncate">{{ $item->nama_produk }}</h3>
                                <p class="text-[11px] text-slate-500">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-1 flex-shrink-0">
                            <!-- Tombol Restore -->
                            <form action="{{ route('products.restore', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-2.5 py-1.5 rounded-xl text-[10px] font-medium transition shadow-sm">Pulihkan</button>
                            </form>

                            <!-- Tombol Hapus Permanen -->
                            <form action="{{ route('products.forceDelete', $item->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini secara permanen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white px-2.5 py-1.5 rounded-xl text-[10px] font-medium transition shadow-sm">Hapus</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-slate-400 text-xs italic py-6">Tidak ada produk di dalam sampah.</p>
                @endforelse
            </div>

            <!-- Tombol Kembali ke Katalog Utama -->
            <div class="pt-2">
                <a href="{{ route('products.index') }}" class="w-full bg-[#5A3825] hover:bg-[#452A1C] text-white font-semibold py-3.5 px-6 rounded-full shadow-md transition duration-200 flex items-center justify-center text-center tracking-wide text-xs uppercase">
                    &larr; Kembali ke Katalog Utama
                </a>
            </div>

        </div>

    </div>

    <!-- Footer Kecil -->
    <footer class="mt-6 text-amber-200/60 text-[11px] text-center tracking-wide">
        &copy; 2026 Katalog Produk Pribadi
    </footer>

</body>
</html>