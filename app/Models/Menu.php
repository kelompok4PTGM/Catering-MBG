<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    
    // We disable timestamps because the migration doesn't have created_at/updated_at for menu
    public $timestamps = false;

    protected $fillable = [
        'id_catering',
        'kode_menu',
        'nama_menu',
        'harga',
        'stok',
    ];

    public function catering(): BelongsTo
    {
        return $this->belongsTo(Catering::class, 'id_catering', 'id');
    }

    public function pakets()
    {
        return $this->belongsToMany(Paket::class, 'menu_paket', 'id_menu', 'id_paket');
    }
}
