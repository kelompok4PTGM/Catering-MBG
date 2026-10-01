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
        'foto',
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

    public function ulasans(): HasMany
    {
        return $this->hasMany(Ulasan::class, 'id_catering', 'id')->latest();
    }

    public function getAverageRatingAttribute(): float
    {
        $avg = $this->relationLoaded('ulasans')
            ? $this->ulasans->avg('rating')
            : $this->ulasans()->avg('rating');

        return $avg ? (float) number_format($avg, 1, '.', '') : 0.0;
    }

    public function getTotalUlasanAttribute(): int
    {
        return $this->relationLoaded('ulasans')
            ? $this->ulasans->count()
            : $this->ulasans()->count();
    }
}
