<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function publicCatalog()
    {
        $products = Product::all();
        return view('products.public', compact('products'));
    }

    public function index()
    {
        if (!session()->has('login_id')) {
            return redirect()->route('login');
        }

        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        if (!session()->has('login_id')) {
            return redirect()->route('login');
        }

        return view('products.create');
    }

    public function store(Request $request)
    {
        if (!session()->has('login_id')) {
            return redirect()->route('login');
        }

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori'    => 'required|string|max:255',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'deskripsi'   => 'required|string',
            'foto_produk' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('foto_produk');

        if ($request->hasFile('foto_produk')) {
            $file = $request->file('foto_produk');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $filename);
            $data['foto_produk'] = $filename;
        }

        Product::create($data);

        Cache::forget('public_products');

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show(Product $product)
    {
        if (!session()->has('login_id')) {
            return redirect()->route('login');
        }

        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        if (!session()->has('login_id')) {
            return redirect()->route('login');
        }

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        if (!session()->has('login_id')) {
            return redirect()->route('login');
        }

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori'    => 'required|string|max:255',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'deskripsi'   => 'required|string',
            'foto_produk' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('foto_produk');

        if ($request->hasFile('foto_produk')) {
            if ($product->foto_produk && file_exists(public_path('uploads/products/' . $product->foto_produk))) {
                unlink(public_path('uploads/products/' . $product->foto_produk));
            }

            $file = $request->file('foto_produk');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $filename);
            $data['foto_produk'] = $filename;
        }

        $product->update($data);

        Cache::forget('public_products');

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if (!session()->has('login_id')) {
            return redirect()->route('login');
        }

        $product->delete();

        Cache::forget('public_products');

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus ke sampah!');
    }

    public function trash()
    {
        if (!session()->has('login_id')) {
            return redirect()->route('login');
        }

        $products = Product::onlyTrashed()->get();
        return view('products.trash', compact('products'));
    }

    public function restore($id)
    {
        if (!session()->has('login_id')) {
            return redirect()->route('login');
        }

        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();

        Cache::forget('public_products');

        return redirect()->route('products.trash')->with('success', 'Produk berhasil dipulihkan!');
    }

    public function forceDelete($id)
    {
        if (!session()->has('login_id')) {
            return redirect()->route('login');
        }

        $product = Product::withTrashed()->findOrFail($id);

        if ($product->foto_produk && file_exists(public_path('uploads/products/' . $product->foto_produk))) {
            unlink(public_path('uploads/products/' . $product->foto_produk));
        }

        $product->forceDelete();

        Cache::forget('public_products');

        return redirect()->route('products.trash')->with('success', 'Produk berhasil dihapus permanen!');
    }
}