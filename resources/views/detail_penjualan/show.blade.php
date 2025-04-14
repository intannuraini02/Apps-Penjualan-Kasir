
<div class="container">
    <h2>Detail Penjualan</h2>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <div class="card">
        <div class="card-body">
            <p class="card-text"><strong>Nama Penjual:</strong> {{ $detailPenjualan->penjualan->pelanggan->NamaPelanggan }}</p>
            <p class="card-text"><strong>Produk:</strong> {{ $detailPenjualan->produk->NamaProduk }}</p>
            <p class="card-text"><strong>Jumlah:</strong> {{ $detailPenjualan->Jumlah }}</p>
            <p class="card-text"><strong>Subtotal:</strong> Rp {{ number_format($detailPenjualan->subtotal, 0, ',', '.') }}</p>
            <a href="{{ route('detail_penjualan.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

