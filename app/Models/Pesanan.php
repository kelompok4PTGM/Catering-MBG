<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    public $timestamps = false;

    protected $fillable = [
        'id_pelanggan',
        'id_catering',
        'tanggal_pesanan',
        'status_pesanan',
        'total_harga',
    ];

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pelanggan', 'id');
    }

    public function catering(): BelongsTo
    {
        return $this->belongsTo(Catering::class, 'id_catering', 'id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id');
    }

    public function pembayaran(): HasOne
    {
        return $this->hasOne(Pembayaran::class, 'id_pesanan', 'id');
    }
}
