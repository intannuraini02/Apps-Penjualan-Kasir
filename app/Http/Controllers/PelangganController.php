<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Menangani pencarian
        $query = Pelanggan::query();

        // Jika ada query pencarian berdasarkan nama pelanggan
        if ($request->has('search') && $request->search != '') {
            $query->where('NamaPelanggan', 'like', '%' . $request->search . '%')
                ->orWhere('NomorTelepon', 'like', '%' . $request->search . '%');
        }

        // Ambil semua data pelanggan yang sesuai dengan query
        $pelanggans = $query->orderBy('created_at', 'desc')->paginate(10); // Menampilkan 10 data per halaman

        // Mengirim data pelanggan dan query pencarian ke view
        return view('pelanggans.index', compact('pelanggans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pelanggans.create');
    }

    // Method untuk menyimpan data pelanggan baru
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'NamaPelanggan' => 'required|string|max:255',
            'Alamat' => 'required|string',
            'NomorTelepon' => 'required|string',
        ]);

        // Menyimpan data pelanggan ke database
        Pelanggan::create([
            'NamaPelanggan' => $request->NamaPelanggan,
            'Alamat' => $request->Alamat,
            'NomorTelepon' => $request->NomorTelepon,
        ]);

        // Mengalihkan setelah berhasil menambahkan pelanggan
        return redirect()->route('pelanggans.index')->with('success', 'Pelanggan berhasil ditambahkan');
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Menemukan pelanggan berdasarkan ID
        $pelanggan = Pelanggan::findOrFail($id); 
        return view('pelanggans.edit', compact('pelanggan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Menemukan pelanggan berdasarkan ID
        $pelanggan = Pelanggan::findOrFail($id);

        // Validasi data input
        $request->validate([
            'NamaPelanggan' => 'required|string|max:255',
            'Alamat' => 'required|string',
            'NomorTelepon' => 'required|string',
        ]);

        // Update data pelanggan
        $pelanggan->update([
            'NamaPelanggan' => $request->NamaPelanggan,
            'Alamat' => $request->Alamat,
            'NomorTelepon' => $request->NomorTelepon,
        ]);

        // Redirect ke halaman daftar pelanggan setelah berhasil update
        return redirect()->route('pelanggans.index')->with('success', 'Penjualan berhasil ditambahkan.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Menemukan pelanggan berdasarkan ID
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        // Redirect ke halaman daftar pelanggan setelah berhasil menghapus
        return redirect()->route('pelanggans.index')->with('success', 'Penjualan berhasil dihapus');
    }
}
