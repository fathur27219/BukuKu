<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'username',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // 1 user bisa punya banyak transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function member()
    {
        return $this->hasOne(Member::class);
    }
}
