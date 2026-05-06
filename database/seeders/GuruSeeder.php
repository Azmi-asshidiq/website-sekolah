<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $guru = [
            ['nip' => '198001012001121001', 'nama' => 'Budi Santoso', 'jabatan' => 'Guru Piket'],
            ['nip' => '198002022001122002', 'nama' => 'Siti Nurhaliza', 'jabatan' => 'Guru Piket'],
            ['nip' => '198003032001123003', 'nama' => 'Ahmad Fauzi', 'jabatan' => 'Guru Piket'],
            ['nip' => '198004042001124004', 'nama' => 'Dewi Lestari', 'jabatan' => 'Guru Piket'],
            ['nip' => '198005052001125005', 'nama' => 'Eko Prasetyo', 'jabatan' => 'Guru Piket'],
        ];

        foreach ($guru as $data) {
            Guru::create($data);
        }
    }
}
