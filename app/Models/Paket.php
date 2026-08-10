<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paket extends Model
{
    use HasFactory;

    protected $table = 'paket';

    // Disable timestamps as they are not in the migration
    public $timestamps = false;

    protected $fillable = [
        'id_catering',
        'nama_paket',
        'harga',
    ];

    public function catering(): BelongsTo
    {
        return $this->belongsTo(Catering::class, 'id_catering', 'id');
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_paket', 'id_paket', 'id_menu');
    }
}
