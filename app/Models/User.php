<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'status',
        'id_catering', // ← PASTIKAN ADA
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // RELASI KE CATERING
    public function catering()
    {
        return $this->belongsTo(Catering::class, 'id_catering', 'id');
    }

    // RELASI KE PESANAN (sebagai pelanggan)
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'id_pelanggan', 'id');
    }
}