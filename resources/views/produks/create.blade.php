@extends('template')

@section('main-content')
<div class="container">
    <h1 class="mb-4">Tambah Produk Baru</h1>

    <!-- Form Tambah Produk -->
    <form method="POST" action="{{ route('produks.store') }}">
        @csrf
        <div class="form-group">
            <label for="NamaProduk">Nama Produk</label>
            <input type="text" class="form-control" id="NamaProduk" name="NamaProduk" value="{{ old('NamaProduk') }}" required>
        </div>

        <div class="form-group">
            <label for="Harga">Harga</label>
            <input type="number" class="form-control" id="Harga" name="Harga" value="{{ old('Harga') }}" required>
        </div>

        <div class="form-group">
            <label for="Stok">Stok</label>
            <input type="number" class="form-control" id="Stok" name="Stok" value="{{ old('Stok') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('produks.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection