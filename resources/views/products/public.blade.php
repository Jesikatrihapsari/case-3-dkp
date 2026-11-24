<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Koleksi Nusantara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js untuk Keranjang & Modal -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @livewireStyles
</head>
<body class="bg-[#5A3825] min-h-screen flex flex-col justify-between text-slate-100 font-sans" x-data="{ openCart: false, cart: [] }">

    <!-- Header / Navbar -->
    <header class="w-full max-w-5xl mx-auto px-6 py-6 flex justify-between items-center border-b border-amber-900/40">
        <div class="flex items-center space-x-2">
            <a href="{{ url('/') }}" class="bg-[#7A4D33] text-amber-100 text-xs px-4 py-1.5 rounded-full font-bold tracking-wider border border-[#9A6240] hover:bg-[#8D5B3C] transition">
                &larr; Beranda
            </a>
        </div>
        <div class="flex items-center space-x-4">
            <!-- Tombol Keranjang Belanja -->
            <button @click="openCart = !openCart" class="relative bg-[#7A4D33] hover:bg-[#8D5B3C] text-amber-100 px-4 py-2 rounded-full text-xs font-bold border border-[#9A6240] transition flex items-center gap-2">
                Keranjang <span x-text="cart.reduce((sum, item) => sum + item.quantity, 0)" class="bg-white text-[#5A3825] px-1.5 py-0.5 rounded-full text-[10px]">0</span>
            </button>
            <a href="{{ route('login') }}" class="text-xs font-medium text-amber-200/80 hover:text-white transition tracking-wide underline underline-offset-4">
                Masuk Pengelola
            </a>
        </div>
    </header>

    <!-- Konten Utama: Memanggil Livewire -->
    <main class="w-full max-w-5xl mx-auto px-6 py-10 flex-grow">
        <div class="text-center space-y-2 mb-10">
            <h1 class="text-3xl font-extrabold tracking-wide text-white">KOLEKSI PRODUK</h1>
            <p class="text-xs text-amber-200/80 max-w-md mx-auto">Pilihan produk lokal berkualitas tinggi dengan kurasi terbaik untuk Anda.</p>
        </div>

        <!-- INI BAGIAN UTAMA: Memanggil Komponen Livewire -->
        @livewire('public-catalog')

    </main>

    <!-- Modal / Sidebar Keranjang Belanja (Alpine.js) -->
    <div x-show="openCart" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex justify-end" style="display: none;">
        <div @click.away="openCart = false" class="w-full max-w-md bg-white h-full p-6 text-slate-800 flex flex-col justify-between shadow-2xl">
            <div>
                <div class="flex justify-between items-center border-b pb-4 mb-4">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-[#5A3825]">Keranjang Belanja Anda</h2>
                    <button @click="openCart = false" class="text-slate-400 hover:text-slate-600 font-bold text-lg">&times;</button>
                </div>
                
                <div class="space-y-3 max-h-[60vh] overflow-y-auto pr-1">
                    <template x-for="(item, index) in cart" :key="index">
                        <div class="flex justify-between items-center bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <div>
                                <h4 class="text-xs font-bold text-slate-800" x-text="item.name"></h4>
                                <p class="text-[11px] text-slate-500" x-text="'Rp ' + item.price.toLocaleString('id-ID') + ' x ' + item.quantity"></p>
                            </div>
                            <button @click="cart.splice(index, 1)" class="text-rose-500 hover:text-rose-700 text-xs font-bold px-2 py-1">Hapus</button>
                        </div>
                    </template>
                    <p x-show="cart.length === 0" class="text-xs text-slate-400 italic text-center py-8">Keranjang belanja masih kosong.</p>
                </div>
            </div>

            <div class="border-t pt-4 space-y-3">
                <div class="flex justify-between items-center font-bold text-sm">
                    <span>Total:</span>
                    <span class="text-[#7A4D33]" x-text="'Rp ' + cart.reduce((sum, item) => sum + (item.price * item.quantity), 0).toLocaleString('id-ID')"></span>
                </div>
                <button @click="
                    if (cart.length === 0) { alert('Keranjang masih kosong!'); return; }
                    let msg = 'Halo, saya ingin memesan:%0A';
                    let total = 0;
                    cart.forEach(i => {
                        msg += `- ${i.name} (${i.quantity}x) - Rp ${(i.price * i.quantity).toLocaleString('id-ID')}%0A`;
                        total += i.price * i.quantity;
                    });
                    msg += `%0ATotal: Rp ${total.toLocaleString('id-ID')}`;
                    window.open(`https://wa.me/628123456789?text=${msg}`, '_blank');
                " class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3.5 rounded-2xl text-xs uppercase tracking-wider transition shadow-md">
                    Checkout via WhatsApp
                </button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="w-full py-6 text-center text-amber-200/50 text-xs border-t border-amber-900/40">
        &copy; 2026 Katalog Produk Pribadi. All rights reserved.
    </footer>

    @livewireScripts
</body>
</html>