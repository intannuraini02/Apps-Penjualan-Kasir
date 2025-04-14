@extends('template')

@section('main-content')
<div class="container d-flex justify-content-center align-items-center my-5">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .receipt {
            width: 400px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 20px;
            font-family: 'Arial', sans-serif;
            position: relative;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .receipt::before, .receipt::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #fff;
            border: 1px solid #ddd;
            top: -10px;
        }
        .receipt::before { left: 20px; }
        .receipt::after { right: 20px; }
        .header-text {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .smiley {
            font-size: 24px;
            color: #ffa500;
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 6px 0;
            font-size: 16px;
            position: relative;
        }
        .info-row span:first-child {
            width: 150px;
        }
        .info-row span:nth-child(2) {
            position: absolute;
            left: 160px;
        }
        .info-row span:last-child {
            margin-left: auto;
            text-align: right;
        }
        .product-item {
            margin-bottom: 8px;
            border-bottom: 1px dashed #bbb;
            padding-bottom: 8px;
        }
        .total-price {
            font-size: 20px;
            font-weight: bold;
            text-align: right;
        }
        .footer-text {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }

        /* CSS untuk menyembunyikan sidebar saat cetak */
        @media print {
            body * {
                visibility: hidden;
            }
            .receipt, .receipt * {
                visibility: visible;
            }
            .receipt {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .btn-print, .btn-back {
                display: none; /* Sembunyikan tombol saat cetak */
            }
        }
    </style>

    <div class="receipt">
        <div class="smiley">😊</div>
        <div class="header-text">
            Toko Sederhana 
            <p>Intan</p>
            <h6>Jl. Melati No. 23, Kel. Sukajaya, Kec. Sukabumi, Kota Bandung, Jawa Barat, 40121, Indonesia.</h6>
        </div>

        <div class="mb-3">
            <div class="info-row">
                <span><strong>Nama Pelanggan</strong></span>
                <span>:</span>
                <span>{{ $penjualan->pelanggan->NamaPelanggan ?? 'Umum' }}</span>
            </div>
            <div class="info-row">
                <span><strong>Tanggal</strong></span>
                <span>:</span>
                <span>{{ Carbon\Carbon::parse($penjualan->TanggalPenjualan)->format('d M Y') }}</span>
            </div>
        </div>

        <div class="product-item">
            <div class="info-row">
                <span><strong>Nama Produk</strong></span>
                <span>:</span>
                <span>{{ $penjualan->produk->NamaProduk }}</span>
            </div>
            <div class="info-row">
                <span><strong>Jumlah</strong></span>
                <span>:</span>
                <span>{{ $penjualan->Jumlah }}</span>
            </div>
            <div class="info-row">
                <span><strong>Harga Satuan</strong></span>
                <span>:</span>
                <span>Rp {{ number_format($penjualan->produk->Harga, 0, ',', '.') }}</span>
            </div>
            <div class="info-row">
                <span><strong>Total</strong></span>
                <span>:</span>
                <span>Rp {{ number_format($penjualan->Jumlah * $penjualan->produk->Harga, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="total-price">Total: Rp {{ number_format($penjualan->TotalHarga, 0, ',', '.') }}</div>

        <div class="footer-text">Terima kasih telah berbelanja! 😊</div>

        <div class="text-center mt-3">
            <button onclick="window.print()" class="btn btn-primary btn-sm btn-print">Cetak Struk</button>
            <a href="{{ route('penjualans.index') }}" class="btn btn-secondary btn-sm btn-back">Kembali</a>
        </div>
    </div>
</div>

<script>
    // Cetak otomatis saat halaman dimuat
    window.onload = function() {
        window.print();
    };
</script>
@endsection
