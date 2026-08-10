<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Catering extends Model
{
    use HasFactory;

    protected $table = 'catering';

    protected $fillable = [
        'id_admin',
        'nama_catering',
        'deskripsi',
        'status',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_admin', 'id');
    }

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class, 'id_catering', 'id');
    }

    public function pakets(): HasMany
    {
        return $this->hasMany(Paket::class, 'id_catering', 'id');
    }
}
