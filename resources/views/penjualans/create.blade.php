@extends('template')

@section('main-content')
<div class="container mt-4">
    <h2>Tambah Penjualan</h2>

    <a href="{{ route('penjualans.index') }}" class="btn btn-secondary mb-3">Kembali</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('penjualans.store') }}" method="POST" class="input-fields">
        @csrf

        <div class="form-group normal">
            <label for="PelangganID">Pilih Pelanggan </label>
            <select name="PelangganID" id="PelangganID" class="form-control select2">
                <option value="">- Pelanggan Umum -</option>
                @foreach ($pelanggan as $pelangganItem)
                    <option value="{{ $pelangganItem->PelangganID }}">{{ $pelangganItem->NamaPelanggan }}</option>
                @endforeach
            </select>
        </div>

        <div id="produk-container">
            <div class="produk-group mb-2 active">
                <label for="ProdukID">Pilih Produk</label>
                <select name="ProdukID[]" class="form-control select2 produk-select" onchange="hitungTotal()">
                    <option value="">- Produk -</option>
                    @foreach ($produks as $produk)
                        <option value="{{ $produk->ProdukID }}" data-harga="{{ $produk->Harga }}">{{ $produk->NamaProduk }} - Rp {{ number_format($produk->Harga, 0, ',', '.') }}</option>
                    @endforeach
                </select>
                <input type="number" name="Jumlah[]" class="form-control mt-1 jumlah-input" placeholder="Jumlah" value="1" min="1" required onchange="hitungTotal()">
                <button type="button" class="btn btn-danger mt-1 remove-produk">Hapus</button>
            </div>
        </div>

        <button type="button" class="btn btn-success mt-2" id="tambah-produk">Tambah Produk</button>

        <div class="form-group date mt-3">
            <label for="TanggalPenjualan">Tanggal Penjualan</label>
            <input type="date" name="TanggalPenjualan" id="TanggalPenjualan" class="form-control" required>
        </div>

        <div class="form-group value mt-3">
            <label for="TotalHarga">Total Harga</label>
            <input type="number" name="TotalHarga" id="TotalHarga" class="form-control" min="0" required readonly>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
</div>

<!-- Tambahkan pustaka jQuery dan Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi Select2 untuk dropdown yang sudah ada
    $('.select2').select2();

    document.getElementById('tambah-produk').addEventListener('click', function() {
        let container = document.getElementById('produk-container');
        let newGroup = document.createElement('div');
        newGroup.classList.add('produk-group', 'mb-2', 'active');
        newGroup.innerHTML = `
            <label for="ProdukID">Pilih Produk</label>
            <select name="ProdukID[]" class="form-control select2 produk-select" onchange="hitungTotal()">
                <option value="">- Produk -</option>
                @foreach ($produks as $produk)
                    <option value="{{ $produk->ProdukID }}" data-harga="{{ $produk->Harga }}">{{ $produk->NamaProduk }} - Rp {{ number_format($produk->Harga, 0, ',', '.') }}</option>
                @endforeach
            </select>
            <input type="number" name="Jumlah[]" class="form-control mt-1 jumlah-input" placeholder="Jumlah" value="1" min="1" required onchange="hitungTotal()">
            <button type="button" class="btn btn-danger mt-1 remove-produk">Hapus</button>
        `;
        container.appendChild(newGroup);

        // Inisialisasi Select2 untuk dropdown yang baru ditambahkan
        $(newGroup).find('.select2').select2();
    });

    document.getElementById('produk-container').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-produk')) {
            event.target.closest('.produk-group').remove();
            hitungTotal();
        }
    });
});

function hitungTotal() {
    let total = 0;
    document.querySelectorAll('.produk-group').forEach(function(group) {
        let select = group.querySelector('.produk-select');
        let jumlah = group.querySelector('.jumlah-input');
        if (select.value && jumlah.value) {
            let harga = select.options[select.selectedIndex].getAttribute('data-harga');
            total += harga * jumlah.value;
        }
    });
    document.getElementById('TotalHarga').value = total;
}
</script>

<style>
    .input-fields {
        display: grid;
        gap: 16px;
        border: 1px solid #e0e0e0;
        padding: 20px;
        border-radius: 8px;
        background: #fff;
    }
    .form-group {
        display: flex;
        flex-direction: column;
    }
    .active input, .active select {
        border: 2px solid #007bff;
    }
    .value input {
        border: 2px solid #28a745;
    }
    .date input {
        border: 2px solid #17a2b8;
    }
    .btn-primary, .btn-secondary, .btn-danger, .btn-success {
        border-radius: 6px;
    }
    .select2-container {
        width: 100% !important;
    }
</style>
@endsection
