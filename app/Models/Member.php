<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'kode_anggota',
        'nama',
        'kelas',
        'telepon'   ,
        'alamat',
        'is_active',
        'user_id'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
