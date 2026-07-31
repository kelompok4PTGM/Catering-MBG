<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    public $timestamps = false;

    protected $fillable = [
        'id_pesanan',
        'tanggal_bayar',
        'metode_pembayaran',
        'jumlah_bayar',
        'status_pembayaran',
    ];

    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id');
    }
}
