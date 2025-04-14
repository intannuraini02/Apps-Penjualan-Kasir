<?php

namespace App\Models;

use App\Models\Penjualan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
  protected $table = 'pelanggans'; 
  protected $primaryKey = 'PelangganID'; // Sesuaikan dengan nama kolom primary key Anda
 
     protected $fillable = [
         'NamaPelanggan', 
         'Alamat', 
         'NomorTelepon'
     ];

     public function penjualan()
     {
        return $this->hasMany(Penjualan::class, 'PenjualanID', 'PenjualanID');
     }
}
