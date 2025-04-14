@extends('template')

@section('main-content')
<div class="container">

    <!-- Form Pencarian -->
    <form method="GET" action="{{ route('pelanggans.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Cari Nama atau Nomor Telepon" value="{{ request()->search }}">
            <button class="btn btn-primary" type="submit">Cari</button>
        </div>
    </form>

    <!-- Tombol Tambah Pelanggan -->
    @if(Auth::user()->role === 'Admin')
        <a href="{{ route('pelanggans.create') }}" class="btn btn-success mb-3">Tambah Pelanggan</a>
    @endif

    <!-- Tabel Daftar Pelanggan -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Daftar Pelanggan</div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Alamat</th>
                            <th>Nomor Telepon</th>
                            @if(Auth::user()->role == 'Admin')
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelanggans as $pelanggan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pelanggan->NamaPelanggan }}</td>
                                <td>{{ $pelanggan->Alamat }}</td>
                                <td>{{ $pelanggan->NomorTelepon }}</td>
                                @if(Auth::user()->role == 'Admin')
                                    <td>
                                        <a href="{{ route('pelanggans.edit', $pelanggan->PelangganID) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('pelanggans.destroy', $pelanggan->PelangganID) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ Auth::user()->role !== 'kasir' ? 5 : 4 }}" class="text-center">Data tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
