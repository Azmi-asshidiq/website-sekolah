<?php
// app/Models/Siswa.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';
    
    protected $fillable = [
        'nis',
        'nama',
        'kelas',
        'jurusan',
        'jenis_kelamin',
        'qr_code',
        'qr_code_data'
    ];

    protected $casts = [
        'qr_code_data' => 'array',
    ];

    public function getRouteKeyName()
    {
        return 'id_siswa';
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('id_siswa', $value)->firstOrFail();
    }

    public function izinKeluar(): HasMany
    {
        return $this->hasMany(IzinKeluar::class, 'id_siswa');
    }

    public function keterlambatan(): HasMany
    {
        return $this->hasMany(Keterlambatan::class, 'id_siswa');
    }

    public function pelanggaran(): HasMany
    {
        return $this->hasMany(Pelanggaran::class, 'id_siswa');
    }

    public function getTotalPoinAttribute(): int
    {
        return $this->pelanggaran()->sum('poin');
    }

    public function generateQrCode(): string
    {
        $data = [
            'nis' => $this->nis,
            'nama' => $this->nama,
            'kelas' => $this->kelas,
            'jurusan' => $this->jurusan,
        ];

        return base64_encode(json_encode($data));
    }
}
