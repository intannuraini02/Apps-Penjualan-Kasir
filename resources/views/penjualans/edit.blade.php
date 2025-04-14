@extends('template')

@section('main-content')
<div class="container">
    <h2>Edit Penjualan</h2>

    <a href="{{ route('penjualans.index') }}" class="btn btn-secondary mb-3">Kembali</a>

    <!-- Menampilkan pesan error jika ada -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('penjualans.update', $penjualan->PenjualanID) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Pilih Pelanggan -->
        <div class="form-group">
            <label for="PelangganID">Pilih Pelanggan</label>
            <select name="PelangganID" id="PelangganID" class="form-control">
                <option value="">- Pelanggan Umum -</option>
                @foreach ($pelanggan as $pelanggan)
                    <option value="{{ $pelanggan->PelangganID }}" 
                        {{ $penjualan->PelangganID == $pelanggan->PelangganID ? 'selected' : '' }}>
                        {{ $pelanggan->NamaPelanggan }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Tanggal Penjualan -->
        <div class="form-group">
            <label for="TanggalPenjualan">Tanggal Penjualan</label>
            <input type="date" name="TanggalPenjualan" id="TanggalPenjualan" class="form-control" value="{{ $penjualan->TanggalPenjualan }}" required>
        </div>

        <!-- Total Harga -->
        <div class="form-group">
            <label for="TotalHarga">Total Harga</label>
            <input type="number" name="TotalHarga" id="TotalHarga" class="form-control" min="0" value="{{ $penjualan->TotalHarga }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
