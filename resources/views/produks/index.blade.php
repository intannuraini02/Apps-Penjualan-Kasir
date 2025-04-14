@extends('template')

@section('main-content')

<div class="container">
    
    <!-- Notifikasi Flash -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
            {{ session('error') }}
        </div>
    @endif

    <!-- Form pencarian -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Daftar Produk</h3>
        <form method="GET" action="{{ route('produks.index') }}" class="d-flex">
            <input type="text" class="form-control me-2" name="search" placeholder="Cari Nama Produk" value="{{ request()->search }}">
            <button class="btn btn-primary btn-custom" type="submit">
                <i class="fas fa-search"></i> Cari
            </button>
        </form>
    </div>

    <!-- Tombol Tambah Produk (Hanya Admin) -->
    @if(auth()->user()->role == 'Admin')
        <a href="{{ route('produks.create') }}" class="btn btn-success btn-custom mb-3">
            <i class="fas fa-plus"></i> Tambah Produk
        </a>
    @endif

    <!-- Tabel Daftar Produk -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            @if(auth()->user()->role == 'Admin') 
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produks as $produk)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $produk->NamaProduk }}</td>
                            <td>Rp {{ number_format($produk->Harga, 0, ',', '.') }}</td>
                            <td>{{ $produk->Stok }}</td>
                            
                            @if(auth()->user()->role == 'Admin') 
                            <td>
                                <a href="{{ route('produks.edit', $produk->ProdukID) }}" class="btn btn-warning btn-sm btn-custom">
                                    <i class="fas fa-edit"></i> 
                                </a>
                                <form action="{{ route('produks.destroy', $produk->ProdukID) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-custom" onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                        <i class="fas fa-trash"></i> 
                                    </button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @empty 
                        <tr>
                            <td colspan="{{ auth()->user()->role == 'Admin' ? 5 : 4 }}" class="text-center text-muted">
                                Tidak ada produk yang ditemukan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $produks->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Script untuk menghilangkan notifikasi setelah 5 detik -->
<script>
    setTimeout(function() {
        document.getElementById('success-alert')?.remove();
        document.getElementById('error-alert')?.remove();
    }, 5000);
</script>

@endsection
