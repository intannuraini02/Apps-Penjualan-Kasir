@extends('template')

@section('main-content')
<div class="container">

    <!-- Form Pencarian -->
    <form method="GET" action="{{ route('penjualans.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari Nama Pelanggan atau Tanggal" value="{{ request('search') }}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
        </div>
    </form>

    <!-- Tombol Tambah dan Cetak -->
    <a href="{{ route('penjualans.create') }}" class="btn btn-success mb-3">
        <i class="fas fa-plus"></i> Tambah Penjualan
    </a>
   <!-- Form for Date Range Selection -->
<!-- resources/views/penjualans/index.blade.php -->
<!-- resources/views/penjualans/index.blade.php -->
<form method="GET" action="{{ route('laporan.penjualan.cetak') }}" class="mb-3">
    <div class="row">
        <div class="col-md-5">
            <label for="start_date">Tanggal Mulai</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required>
        </div>
        <div class="col-md-5">
            <label for="end_date">Tanggal Selesai</label>
            <input type="date" name="end_date" id="end_date" class="form-control" required>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary mt-4">
                <i class="fas fa-print"></i> Cetak Laporan
            </button>
        </div>
    </div>
</form>
    <!-- Notifikasi -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="flash-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="flash-error">
            <i class="fas fa-times-circle"></i> {{ session('error') }}
        </div>
    @endif

    <!-- Tabel Daftar Penjualan -->
    <div class="card">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-list"></i> Daftar Penjualan</div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Nama Produk</th>
                            <th> Tanggal Penjualan</th>
                            <th> Jumlah</th>
                            <th>Total Harga</th>
                            @if(auth()->user()->role !== 'Kasir')
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penjualans as $penjualan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $penjualan->pelanggan->NamaPelanggan ?? '' }}</td>
                            <td>{{ $penjualan->produk->NamaProduk ?? '' }}</td>
                            <td>{{ $penjualan->TanggalPenjualan }}</td>
                            <td>{{ $penjualan->Jumlah }}</td>
                            <td>Rp {{ number_format($penjualan->TotalHarga, 0, ',', '.') }}</td>
                            @if(auth()->user()->role !== 'Kasir')
                                <td>
                                    <a href="{{ route('penjualans.show', $penjualan->PenjualanID) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> 
                                    </a>
                                    <a href="{{ route('penjualans.edit', $penjualan->PenjualanID) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> 
                                    </a>
                                    <form action="{{ route('penjualans.destroy', $penjualan->PenjualanID) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus penjualan ini?')">
                                            <i class="fas fa-trash"></i> 
                                        </button>
                                    </form>
                                </td>
                            @else
                                <td>
                                    <a href="{{ route('penjualans.show', $penjualan->PenjualanID) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role !== 'Kasir' ? 7 : 6 }}" class="text-center">
                                <i class="fas fa-exclamation-circle"></i> Data tidak ditemukan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Script Agar Notifikasi Hilang Otomatis -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            let successMessage = document.getElementById('flash-success');
            let errorMessage = document.getElementById('flash-error');

            if (successMessage) {
                successMessage.style.transition = 'opacity 1s';
                successMessage.style.opacity = '0';
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 1000);
            }

            if (errorMessage) {
                errorMessage.style.transition = 'opacity 1s';
                errorMessage.style.opacity = '0';
                setTimeout(function() {
                    errorMessage.style.display = 'none';
                }, 1000);
            }
        }, 5000); // Hilang setelah 5 detik
    });
</script>

@endsection
