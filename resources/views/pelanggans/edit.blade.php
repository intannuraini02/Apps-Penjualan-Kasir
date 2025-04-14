@extends('template')

@section('main-content')
<h1>Edit Pelanggan</h1>

<!-- Form untuk mengedit data pelanggan -->
<form method="POST" action="{{ route('pelanggans.update', $pelanggan->PelangganID) }}">
    @csrf
    @method('PUT') <!-- Menandakan bahwa ini adalah request PUT untuk update data -->

    <div class="form-group">
        <label for="NamaPelanggan">Nama Pelanggan</label>
        <input type="text" class="form-control" id="NamaPelanggan" name="NamaPelanggan" value="{{ old('NamaPelanggan', $pelanggan->NamaPelanggan) }}" required>
    </div>

    <div class="form-group">
        <label for="Alamat">Alamat</label>
        <textarea class="form-control" id="Alamat" name="Alamat" required>{{ old('Alamat', $pelanggan->Alamat) }}</textarea>
    </div>

    <div class="form-group">
        <label for="NomorTelepon">Nomor Telepon</label>
        <input type="number" class="form-control" id="NomorTelepon" name="NomorTelepon" value="{{ old('NomorTelepon', $pelanggan->NomorTelepon) }}" required>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('pelanggans.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
