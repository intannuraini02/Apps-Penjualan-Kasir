<?php

namespace App\Models;
use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualans';
    protected $primaryKey = 'PenjualanID';
    protected $fillable = ['PelangganID', 'ProdukID', 'TanggalPenjualan', 'Jumlah', 'TotalHarga'];

    // Relasi ke pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'PelangganID', 'PelangganID');
    }
    public function produk()
    {
        return $this->belongsTo( Produk::class, 'ProdukID', 'ProdukID');
    }
}
