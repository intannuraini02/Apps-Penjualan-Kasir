<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $produks = Produk::when($search, function ($query) use ($search) {
            return $query->where('NamaProduk', 'like', "%{$search}%");
        })->paginate(10); // Gunakan paginate() bukan all()

        return view('produks.index', compact('produks'));
    }

    public function create()
    {
        return view('produks.create'); // Sesuaikan dengan nama file Blade template form tambah produk
    }

    public function store(Request $request)
    {
        $request->validate([
            'NamaProduk' => 'required|string|max:255',
            'Harga' => 'required|numeric|min:0',
            'Stok' => 'required|integer|min:0',
        ]);

        // Cek apakah produk dengan NamaProduk yang sama sudah ada
        $existingProduk = Produk::where('NamaProduk', $request->NamaProduk)->first();

        if ($existingProduk) {
            // Jika produk sudah ada, tambahkan stoknya
            $existingProduk->update([
                'Stok' => $existingProduk->Stok + $request->Stok,
                'Harga' => $request->Harga,
            ]);

            return redirect()->route('produks.index')->with('success', 'Stok produk berhasil diperbarui');
        } else {
            // Jika tidak ada, buat produk baru
            Produk::create([
                'NamaProduk' => $request->NamaProduk,
                'Harga' => $request->Harga,
                'Stok' => $request->Stok,
            ]);

            return redirect()->route('produks.index')->with('success', 'Produk berhasil ditambahkan');
        }
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produks.edit', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'NamaProduk' => 'required|string|max:255',
            'Harga' => 'required|numeric|min:0',
            'Stok' => 'required|integer|min:0',
        ]);

        $produk->update([
            'NamaProduk' => $request->NamaProduk,
            'Harga' => $request->Harga,
            'Stok' => $request->Stok,
        ]);

        return redirect()->route('produks.index')->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('produks.index')->with('success', 'Produk berhasil dihapus');
    }

    // Tambahkan method ini untuk dashboard
    public function dashboard()
    {
        $totalProduk = Produk::count(); // Menghitung total produk
        return view('dashboard', compact('totalProduk'));
    }
}
