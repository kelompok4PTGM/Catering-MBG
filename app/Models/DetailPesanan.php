<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPesanan extends Model
{
    use HasFactory;

    protected $table = 'detail_pesanan';

    public $timestamps = false;

    protected $fillable = [
        'id_pesanan',
        'id_menu',
        'id_paket',
        'jumlah',
        'subtotal',
    ];

    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id');
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'id_menu', 'id');
    }

    public function paket(): BelongsTo
    {
        return $this->belongsTo(Paket::class, 'id_paket', 'id');
    }
}
