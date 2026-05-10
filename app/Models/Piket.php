<?php
// app/Models/Piket.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piket extends Model
{
    use HasFactory;

    protected $table = 'piket';
    protected $primaryKey = 'id_piket';
    
    protected $fillable = [
        'id_guru',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'semester',
        'tahun_ajaran',
        'is_active'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_mulai' => 'datetime',
        'jam_selesai' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }
}
