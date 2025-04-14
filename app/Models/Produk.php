<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produks';
    protected $primaryKey = 'ProdukID';
    protected $fillable = [
        'NamaProduk',
        'Harga',
        'Stok',
    ];
    
    
    
 }
