@extends('template')

@section('main-content')

<div class="container">
    <h1>Edit Produk</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('produks.update', $produk->ProdukID) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="NamaProduk">Nama Produk</label>
            <input type="text" class="form-control" id="NamaProduk" name="NamaProduk" value="{{ old('NamaProduk', $produk->NamaProduk) }}" required>
        </div>

        <div class="form-group">
            <label for="Harga">Harga</label>
            <input type="number" class="form-control" id="Harga" name="Harga" value="{{ old('Harga', $produk->Harga) }}" required>
        </div>

        <div class="form-group">
            <label for="Stok">Stok</label>
            <input type="number" class="form-control" id="Stok" name="Stok" value="{{ old('Stok', $produk->Stok) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('produks.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection