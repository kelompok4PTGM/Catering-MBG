<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = [
        'id_pelanggan',
        'id_catering',
        'tanggal_pesanan',
        'status_pesanan',
        'total_harga',
        'created_at',
        'updated_at'
    ];

    // Relasi ke User (pelanggan)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_pelanggan');
    }

    // Relasi ke Catering
    public function catering()
    {
        return $this->belongsTo(Catering::class, 'id_catering');
    }
}