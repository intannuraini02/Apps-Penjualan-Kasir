@extends('template')

@section('main-content')
<h1>Tambah Pelanggan Baru</h1>

<!-- Form untuk menambahkan pelanggan -->
<form method="POST" action="{{ route('pelanggans.store') }}">
    @csrf
    <div class="form-group">
        <label for="NamaPelanggan">Nama Pelanggan</label>
        <input type="text" class="form-control" id="NamaPelanggan" name="NamaPelanggan" value="{{ old('NamaPelanggan') }}" required>
    </div>

    <div class="form-group">
        <label for="Alamat">Alamat</label>
        <textarea class="form-control" id="Alamat" name="Alamat" required>{{ old('Alamat') }}</textarea>
    </div>

    <div class="form-group">
        <label for="NomorTelepon">Nomor Telepon</label>
        <input type="number" class="form-control" id="NomorTelepon" name="NomorTelepon" value="{{ old('NomorTelepon') }}" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('pelanggans.index') }}" class="btn btn-secondary">Batal</a>
</form>
</div>
@endsection
