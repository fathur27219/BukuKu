<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_buku',
        'judul',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'stok',
        'kategori',
        'jenis',
        'deskripsi',
        'gambar'
    ];

    // 1 buku bisa punya banyak transaksi
    public function Transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
