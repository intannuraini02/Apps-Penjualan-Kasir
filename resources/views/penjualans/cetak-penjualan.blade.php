<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Laporan Penjualan</h2>
    <p style="text-align: center;">Periode: {{ $startDate }} hingga {{ $endDate }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Nama Produk</th>
                <th>Tanggal Penjualan</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penjualans as $penjualan)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $penjualan->pelanggan->NamaPelanggan ?? 'Tidak Ada Data' }}</td>
                <td>{{ $penjualan->produk->NamaProduk ?? 'Tidak Ada Data' }}</td>
                <td>{{ $penjualan->TanggalPenjualan }}</td>
                <td>{{ $penjualan->Jumlah }}</td>
                <td>Rp {{ number_format($penjualan->TotalHarga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        // Cetak otomatis saat halaman dimuat
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>