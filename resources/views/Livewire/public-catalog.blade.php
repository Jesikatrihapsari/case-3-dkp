<div>
    <div class="w-full" x-data="{ search: '' }">
        <div class="mb-8 flex justify-center">
            <div class="w-full max-w-md">
                <input 
                    type="text" 
                    x-model="search" 
                    placeholder="Cari nama produk..." 
                    class="w-full px-4 py-3 rounded-2xl bg-white/20 border border-amber-900/40 text-white placeholder-amber-200/80 focus:outline-none focus:ring-2 focus:ring-amber-500 text-xs shadow-inner"
                >
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $product)
                @php
                    $nama = $product->nama_produk ?? $product->name ?? '';
                    $harga = $product->harga ?? 0;
                    $deskripsi = $product->deskripsi ?? '';
                    
                    // Memperbaiki path foto agar membaca folder uploads/products/ sesuai controller
                    $foto = $product->foto_produk 
                        ? asset('uploads/products/' . $product->foto_produk) 
                        : ($product->dummy_foto ?? 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&q=80&w=500');
                @endphp

                <div 
                    x-show="search === '' || '{{ strtolower($nama) }}'.includes(search.toLowerCase())"
                    class="bg-white/10 border border-amber-900/30 rounded-3xl p-4 flex flex-col justify-between shadow-lg backdrop-blur-md"
                >
                    <div>
                        <div class="w-full h-48 rounded-2xl overflow-hidden mb-4 bg-amber-950/20 cursor-pointer"
                             @click="selectedProduct = { name: '{{ addslashes($nama) }}', price: {{ $harga }}, description: '{{ addslashes($deskripsi) }}', image: '{{ $foto }}' }">
                            <img src="{{ $foto }}" alt="{{ $nama }}" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-sm font-bold text-white mb-1 cursor-pointer"
                            @click="selectedProduct = { name: '{{ addslashes($nama) }}', price: {{ $harga }}, description: '{{ addslashes($deskripsi) }}', image: '{{ $foto }}' }">
                            {{ $nama }}
                        </h3>
                        <!-- Format Rupiah Lengkap -->
                        <p class="text-xs text-amber-200/90 font-semibold mb-3">Rp {{ number_format($harga, 0, ',', '.') }}</p>
                        <p class="text-[11px] text-amber-100/70 line-clamp-2 mb-4">{{ $deskripsi }}</p>
                    </div>
                    
                    <button 
                        @click="let found = cart.find(i => i.name === '{{ addslashes($nama) }}'); if (found) { found.quantity++; } else { cart.push({ name: '{{ addslashes($nama) }}', price: {{ $harga }}, quantity: 1 }); }"
                        class="w-full bg-[#7A4D33] hover:bg-[#8D5B3C] text-amber-100 font-bold py-2.5 rounded-xl text-xs uppercase tracking-wider transition border border-[#9A6240] shadow"
                    >
                        Tambah ke Keranjang
                    </button>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal Detail Produk -->
    <div x-show="selectedProduct" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4" style="display: none;">
        <div @click.away="selectedProduct = null" class="bg-white w-full max-w-lg rounded-3xl p-6 text-slate-800 shadow-2xl relative flex flex-col max-h-[90vh] overflow-y-auto">
            <button @click="selectedProduct = null" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 font-bold text-xl">&times;</button>

            <template x-if="selectedProduct">
                <div class="space-y-4">
                    <div class="w-full h-64 bg-slate-100 rounded-2xl overflow-hidden shadow-inner">
                        <img :src="selectedProduct.image" :alt="selectedProduct.name" class="w-full h-full object-cover">
                    </div>

                    <div>
                        <h2 class="text-lg font-bold text-slate-900" x-text="selectedProduct.name"></h2>
                        <p class="text-sm font-extrabold text-[#7A4D33] mt-1" x-text="'Rp ' + selectedProduct.price.toLocaleString('id-ID')"></p>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Deskripsi Produk</h4>
                        <p class="text-xs text-slate-600 leading-relaxed" x-text="selectedProduct.description"></p>
                    </div>

                    <div class="pt-4 border-t flex gap-3">
                        <button @click="selectedProduct = null" class="w-1/2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold py-3 rounded-2xl text-xs uppercase transition">
                            Tutup
                        </button>
                        <button @click="
                            let found = cart.find(i => i.name === selectedProduct.name);
                            if (found) { found.quantity++; } 
                            else { cart.push({ name: selectedProduct.name, price: selectedProduct.price, quantity: 1 }); }
                            selectedProduct = null;
                        " class="w-1/2 bg-[#7A4D33] hover:bg-[#633e28] text-amber-100 font-bold py-3 rounded-2xl text-xs uppercase tracking-wider transition shadow-md">
                            Masukkan Keranjang
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>