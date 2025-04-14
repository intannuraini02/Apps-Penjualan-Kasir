<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailPenjualan;
use App\Models\Penjualan;
use App\Models\Produk;

class DetailPenjualanController extends Controller
{
    // Menampilkan daftar detail penjualan dengan fitur pencarian
    public function index(Request $request)
    {
        $query = DetailPenjualan::with(['penjualan', 'produk']);
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('produk', function ($q) use ($search) {
                $q->where('NamaProduk', 'like', "%$search%");
            })->orWhereHas('penjualan', function ($q) use ($search) {
                $q->where('PenjualanID', 'like', "%$search%");
            });
        }
        
        // Urutkan data terbaru di atas dan paginasi
        $detailPenjualans = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('detail_penjualan.index', compact('detailPenjualans'));
    }

    // Menampilkan form untuk menambah detail penjualan
    public function create()
    {
        $penjualans = Penjualan::all(); // Ambil semua data penjualan
        $produks = Produk::all();         // Ambil semua data produk
        return view('detail_penjualan.create', compact('penjualans', 'produks'));
    }

    // Menyimpan detail penjualan baru
    public function store(Request $request)
    {
        $request->validate([
            'PenjualanID' => 'required|exists:penjualans,PenjualanID',
            'ProdukID'    => 'required|exists:produks,ProdukID',
            'jumlah'      => 'required|integer|min:1',
        ]);

        // Cari produk berdasarkan ProdukID untuk mendapatkan harga
        $produk = Produk::find($request->ProdukID);
        if (!$produk) {
            return redirect()->route('detail_penjualan.create')
                             ->with('error', 'Produk tidak ditemukan.');
        }

        // Hitung subtotal: Harga produk x jumlah
        $subtotal = $produk->Harga * $request->jumlah;

        // Simpan data detail penjualan
        DetailPenjualan::create([
            'PenjualanID' => $request->PenjualanID,
            'ProdukID'    => $request->ProdukID,
            'Jumlah'      => $request->jumlah,  // Pastikan menggunakan 'Jumlah' sesuai dengan kolom di DB
            'Subtotal'    => $subtotal,
        ]);

        return redirect()->route('detail_penjualan.index')
                         ->with('success', 'Detail Penjualan berhasil ditambahkan');
    }

    // Menampilkan detail satu data penjualan
    public function show($id)
    {
        $detailPenjualan = DetailPenjualan::findOrFail($id);
        return view('detail_penjualan.show', compact('detailPenjualan'));
    }

    // Menampilkan form edit untuk detail penjualan
    public function edit($id)
    {
        // Ambil data detail penjualan berdasarkan ID
        $detailPenjualan = DetailPenjualan::findOrFail($id);
        // Ambil semua data penjualan dan produk untuk dropdown pada form edit
        $penjualans = Penjualan::all();
        $produks = Produk::all();
        
        return view('detail_penjualan.edit', compact('detailPenjualan', 'penjualans', 'produks'));
    }

    // Memproses update data detail penjualan
    public function update(Request $request, $id)
    {
        $request->validate([
            'PenjualanID' => 'required|exists:penjualans,PenjualanID',
            'ProdukID'    => 'required|exists:produks,ProdukID',
            'jumlah'      => 'required|integer|min:1',
        ]);

        // Cari data detail penjualan yang akan diupdate
        $detailPenjualan = DetailPenjualan::findOrFail($id);

        // Cari produk untuk mendapatkan harga produk yang terbaru
        $produk = Produk::find($request->ProdukID);
        if (!$produk) {
            return redirect()->route('detail_penjualan.edit', $id)
                             ->with('error', 'Produk tidak ditemukan.');
        }

        // Hitung subtotal baru
        $subtotal = $produk->Harga * $request->jumlah;

        // Update data detail penjualan
        $detailPenjualan->update([
            'PenjualanID' => $request->PenjualanID,
            'ProdukID'    => $request->ProdukID,
            'Jumlah'      => $request->jumlah,
            'Subtotal'    => $subtotal,
        ]);

        return redirect()->route('detail_penjualan.index')
                         ->with('success', 'Detail Penjualan berhasil diperbarui');
    }

    // Menghapus data detail penjualan
    public function destroy($id)
    {
        $detailPenjualan = DetailPenjualan::findOrFail($id);
        $detailPenjualan->delete();

        return redirect()->route('detail_penjualan.index')
                         ->with('success', 'Detail Penjualan berhasil dihapus');
    }
}
