<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    // Menampilkan daftar penjualan dengan fitur pencarian
    public function index(Request $request)
    {
        $query = Penjualan::with(['pelanggan', 'produk']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('pelanggan', function ($q) use ($search) {
                $q->where('NamaPelanggan', 'like', "%$search%");
            })->orWhereHas('produk', function ($q) use ($search) {
                $q->where('NamaProduk', 'like', "%$search%");
            })->orWhere('TanggalPenjualan', 'like', "%$search%");
        }

        $penjualans = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('penjualans.index', compact('penjualans'));
    }

 // app/Http/Controllers/PenjualanController.php
 public function cetaklaporan(Request $request)
 {
     // Validasi tanggal
     $request->validate([
         'start_date' => 'required|date',
         'end_date' => 'required|date|after_or_equal:start_date',
     ]);
 
     // Ambil data penjualan berdasarkan rentang tanggal
     $startDate = $request->input('start_date');
     $endDate = $request->input('end_date');
 
     $penjualans = Penjualan::with(['pelanggan', 'produk'])
         ->whereBetween('TanggalPenjualan', [$startDate, $endDate])
         ->get();
 
     // Kirim data ke view
     return view('penjualans.cetak-Penjualan', compact('penjualans', 'startDate', 'endDate'));
 }
    
    // Menampilkan form tambah penjualan
    public function create()
    {
        $pelanggan = Pelanggan::all();
        $produks = Produk::all(); // Ambil produk
        return view('penjualans.create', compact('pelanggan', 'produks'));
    }

    // Menyimpan data penjualan baru
    public function store(Request $request)
    {
        $request->validate([
            'PelangganID'      => 'nullable|exists:pelanggans,PelangganID',
            'ProdukID'         => 'required|array',
            'ProdukID.*'       => 'required|exists:produks,ProdukID',
            'TanggalPenjualan' => 'required|date',
            'Jumlah'           => 'required|array',
            'Jumlah.*'         => 'required|integer|min:1',
            'TotalHarga'       => 'required|numeric|min:0',
        ]);

        // Cek stok untuk setiap produk
        foreach ($request->ProdukID as $index => $produkID) {
            $produk = Produk::findOrFail($produkID);

            if ($request->Jumlah[$index] > $produk->Stok) {
                return back()->withErrors(['Jumlah' => "Jumlah produk '{$produk->NamaProduk}' melebihi stok yang tersedia."])->withInput();
            }
        }

        // Simpan data penjualan dan kurangi stok
        foreach ($request->ProdukID as $index => $produkID) {
            $produk = Produk::findOrFail($produkID);

            Penjualan::create([
                'PelangganID'      => $request->PelangganID,
                'ProdukID'         => $produkID,
                'TanggalPenjualan' => $request->TanggalPenjualan,
                'Jumlah'           => $request->Jumlah[$index],
                'TotalHarga'       => $request->TotalHarga,
            ]);

            // Kurangi stok produk
            $produk->update(['Stok' => $produk->Stok - $request->Jumlah[$index]]);
        }

        return redirect()->route('penjualans.index')->with('success', 'Penjualan berhasil ditambahkan.');
    }


    // Menampilkan detail penjualan
public function show($id)
{
    $penjualan = Penjualan::with(['pelanggan', 'produk'])->findOrFail($id);

    return view('penjualans.show', compact('penjualan'));
}


    // Menampilkan form edit penjualan
    public function edit($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $pelanggan = Pelanggan::all();
        $produks = Produk::all(); // Ambil produk
        return view('penjualans.edit', compact('penjualan', 'pelanggan', 'produks'));
    }

    // Memperbarui data penjualan
    public function update(Request $request, $id)
    {
        $request->validate([
            'PelangganID'      => 'nullable|exists:pelanggans,PelangganID',
            'ProdukID'         => 'required|array',
            'ProdukID.*'       => 'required|exists:produks,ProdukID',
            'TanggalPenjualan' => 'required|date',
            'Jumlah'           => 'required|array',
            'Jumlah.*'         => 'required|integer|min:1',
            'TotalHarga'       => 'required|numeric|min:0',
        ]);

        $penjualan = Penjualan::findOrFail($id);

        // Kembalikan stok produk sebelumnya
        $produkLama = Produk::findOrFail($penjualan->ProdukID);
        $produkLama->update(['Stok' => $produkLama->Stok + $penjualan->Jumlah]);

        // Cek stok untuk produk baru
        foreach ($request->ProdukID as $index => $produkID) {
            $produk = Produk::findOrFail($produkID);

            if ($request->Jumlah[$index] > $produk->Stok) {
                return back()->withErrors(['Jumlah' => "Jumlah produk '{$produk->NamaProduk}' melebihi stok yang tersedia."])->withInput();
            }
        }

        // Update data penjualan dan stok produk
        foreach ($request->ProdukID as $index => $produkID) {
            $produk = Produk::findOrFail($produkID);

            $penjualan->update([
                'PelangganID'      => $request->PelangganID,
                'ProdukID'         => $produkID,
                'TanggalPenjualan' => $request->TanggalPenjualan,
                'Jumlah'           => $request->Jumlah[$index],
                'TotalHarga'       => $request->TotalHarga,
            ]);

            // Kurangi stok produk
            $produk->update(['Stok' => $produk->Stok - $request->Jumlah[$index]]);
        }

        return redirect()->route('penjualans.index')->with('success', 'Penjualan berhasil diperbarui.');
    }

    // Menghapus data penjualan
    public function destroy($id)
    {
        $penjualan = Penjualan::findOrFail($id);

        // Kembalikan stok produk
        $produk = Produk::findOrFail($penjualan->ProdukID);
        $produk->update(['Stok' => $produk->Stok + $penjualan->Jumlah]);

        $penjualan->delete();

        return redirect()->route('penjualans.index')->with('success', 'Penjualan berhasil dihapus.');
    }

   
    
}
