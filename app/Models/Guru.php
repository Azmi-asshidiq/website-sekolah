<?php
// app/Models/Guru.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';
    protected $primaryKey = 'id_guru';
    
    protected $fillable = [
        'nama',
        'nip',
        'jabatan',
        'jenis_kelamin'
    ];

    public function getRouteKeyName()
    {
        return 'id_guru';
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('id_guru', $value)->firstOrFail();
    }

    public function piket(): HasMany
    {
        return $this->hasMany(Piket::class, 'id_guru');
    }

    public function izinKeluar(): HasMany
    {
        return $this->hasMany(IzinKeluar::class, 'id_guru');
    }

    public function keterlambatan(): HasMany
    {
        return $this->hasMany(Keterlambatan::class, 'id_guru');
    }

    public function pelanggaran(): HasMany
    {
        return $this->hasMany(Pelanggaran::class, 'id_guru');
    }

    public function jadwalPiket(): HasMany
    {
        return $this->hasMany(JadwalPiket::class, 'id_guru');
    }

    public function getJadwalHariIniAttribute(): ?JadwalPiket
    {
        return $this->jadwalPiket()
            ->where('hari', now()->format('l'))
            ->where('is_active', true)
            ->first();
    }
}
