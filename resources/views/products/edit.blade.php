<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#5A3825] min-h-screen py-10 px-4 flex flex-col items-center justify-center">

    <div class="w-full max-w-lg bg-white rounded-3xl p-8 shadow-2xl border border-slate-100">
        
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h1 class="text-lg font-bold text-[#5A3825] uppercase tracking-wider">Edit Produk</h1>
            <a href="{{ route('products.index') }}" class="text-xs font-semibold text-slate-500 hover:text-[#5A3825] transition">&larr; Kembali</a>
        </div>

        @if($errors->any())
            <div class="mb-5 p-3 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl text-xs">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-slate-700 text-xs font-bold uppercase tracking-wide mb-1.5">Nama Produk</label>
                <input type="text" name="nama_produk" value="{{ old('nama_produk', $product->nama_produk) }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#5A3825] text-sm">
            </div>

            <div>
                <label class="block text-slate-700 text-xs font-bold uppercase tracking-wide mb-1.5">Kategori</label>
                <input type="text" name="kategori" value="{{ old('kategori', $product->kategori) }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#5A3825] text-sm">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                     <label class="block text-slate-700 text-xs font-bold uppercase tracking-wide mb-1.5">Harga (Rp)</label>
                    <input type="number" name="harga" value="{{ old('harga', $product->harga) }}" required min="0" step="1" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#5A3825] text-sm" placeholder="Contoh: 150000">
                </div>
                <div>
                    <label class="block text-slate-700 text-xs font-bold uppercase tracking-wide mb-1.5">Stok</label>
                    <input type="number" name="stok" value="{{ old('stok', $product->stok) }}" required min="0" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#5A3825] text-sm">
                </div>
            </div>

            <div>
                <label class="block text-slate-700 text-xs font-bold uppercase tracking-wide mb-1.5">Deskripsi Produk</label>
                <textarea name="deskripsi" rows="3" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#5A3825] text-sm">{{ old('deskripsi', $product->deskripsi) }}</textarea>
            </div>

            <div>
                <label class="block text-slate-700 text-xs font-bold uppercase tracking-wide mb-1.5">Foto Saat Ini</label>
                @if($product->foto_produk)
                    <div class="mb-2">
                        <img src="{{ asset('uploads/products/' . $product->foto_produk) }}" alt="Foto" class="w-16 h-16 object-cover rounded-xl border shadow-sm">
                    </div>
                @else
                    <p class="text-[11px] text-slate-400 italic mb-2">Tidak ada foto.</p>
                @endif

                <label class="block text-slate-700 text-xs font-bold uppercase tracking-wide mb-1.5">Ganti Foto (Opsional)</label>
                <input type="file" name="foto_produk" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-amber-100 file:text-[#5A3825] hover:file:bg-amber-200 cursor-pointer">
            </div>

            <div class="flex items-center gap-3 pt-2">
                <a href="{{ route('products.index') }}" class="w-1/2 text-center py-3.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold uppercase tracking-wider transition">Batal</a>
                <button type="submit" class="w-1/2 py-3.5 rounded-full bg-[#5A3825] hover:bg-[#452A1C] text-white text-xs font-bold uppercase tracking-wider transition shadow-md">Perbarui</button>
            </div>
        </form>

    </div>

</body>
</html>