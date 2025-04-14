@extends('template')

@section('main-content')
<div class="container">
    <h2>Detail Penjualan</h2>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Tombol Tambah -->
    <a href="{{ route('detail_penjualan.create') }}" class="btn btn-primary mb-3">Tambah Detail Penjualan</a>

    <!-- Form Pencarian -->
    <form action="{{ route('detail_penjualan.index') }}" method="GET" class="mb-3">
        <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan Produk atau ID Penjualan" value="{{ request('search') }}">
    </form>

    <!-- Tabel Detail Penjualan -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>NO</th>
                <th>Nama Penjual</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detailPenjualans as $detailPenjualan)
            <tr>
                <td>{{ $loop->iteration }}</td> <!-- Gunakan $loop->iteration untuk nomor urut -->
                <td>{{ $detailPenjualan->penjualan->pelanggan->NamaPelanggan}}</td>
                <td>{{ $detailPenjualan->produk->NamaProduk }}</td>
                <td>{{ $detailPenjualan->Jumlah }}</td>
                <td>Rp {{ number_format($detailPenjualan->Subtotal, 0, ',', '.') }}</td>
                <td>
                    <a href="{{ route('detail_penjualan.show', $detailPenjualan->DetailPenjualanID) }}" class="btn btn-info btn-sm">Lihat</a>
                    <a href="{{ route('detail_penjualan.edit', $detailPenjualan->DetailPenjualanID) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('detail_penjualan.destroy', $detailPenjualan->DetailPenjualanID) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    {{ $detailPenjualans->links() }}
</div>
@endsection