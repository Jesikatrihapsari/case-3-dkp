<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PublicCatalog extends Component
{
    public $search = '';

    public function render()
    {
        $keyword = trim($this->search);
        try {
            $products = Product::query()
                ->when($keyword !== '', function ($query) use ($keyword) {
                    $query->where('nama_produk', 'like', '%' . $keyword . '%');
                })
                ->latest() // produk terbaru tampil paling atas
                ->get()
                ->toBase();
        } catch (\Exception $e) {
            Log::error('Gagal memuat produk: ' . $e->getMessage());
            $products = collect();
        }

        $dummyProducts = collect([
            (object) [
                'nama_produk' => 'COKLAT',
                'harga' => 850000,
                'foto_produk' => null,
                'dummy_foto' => 'https://images.unsplash.com/photo-1549007994-cb92caebd54b?auto=format&fit=crop&q=80&w=500',
                'deskripsi' => 'Coklat pilihan berkualitas tinggi dengan cita rasa khas Nusantara.',
            ],
            (object) [
                'nama_produk' => 'PUNAWAKAN - Indonesian Souvenir Box',
                'harga' => 120000,
                'foto_produk' => null,
                'dummy_foto' => 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?auto=format&fit=crop&q=80&w=500',
                'deskripsi' => 'Kotak suvenir eksklusif khas Indonesia untuk berbagai acara spesial.',
            ],
            (object) [
                'nama_produk' => 'KOPI NUSANTARA',
                'harga' => 150000,
                'foto_produk' => null,
                'dummy_foto' => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&q=80&w=500',
                'deskripsi' => 'Biji kopi pilihan dari berbagai daerah di Nusantara dengan aroma yang khas.',
            ],
        ]);

        if ($keyword !== '') {
            $lowerKeyword = mb_strtolower($keyword);
            $dummyProducts = $dummyProducts->filter(function ($item) use ($lowerKeyword) {
                return str_contains(mb_strtolower($item->nama_produk), $lowerKeyword);
            });
        }

    
        $allProducts = $products->concat($dummyProducts)->values();

        return view('livewire.public-catalog', [
            'products' => $allProducts,
        ]);
    }
}