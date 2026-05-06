<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Piket;
use App\Models\IzinKeluar;
use App\Models\Keterlambatan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
        ]);

        // Seed Guru
        $guru = Guru::create([
            'nip' => '197501011998031001',
            'nama' => 'Dr. Ahmad Syarif, M.Pd',
            'jabatan' => 'Kepala Sekolah'
        ]);
        
        Guru::create([
            'nip' => '197802022000031002',
            'nama' => 'Ibu Siti Aminah, S.Pd',
            'jabatan' => 'Wakil Kepala Sekolah'
        ]);
        
        Guru::create([
            'nip' => '198003032002031003',
            'nama' => 'Bapak Budi Santoso, S.Kom',
            'jabatan' => 'Guru Informatika'
        ]);
        
        // Seed Siswa
        $siswa = Siswa::create([
            'nis' => '2024001',
            'nama' => 'Andi Pratama',
            'kelas' => 'X IPA 1'
        ]);
        
        Siswa::create([
            'nis' => '2024002',
            'nama' => 'Bunga Citra',
            'kelas' => 'X IPA 1'
        ]);
        
        Siswa::create([
            'nis' => '2024003',
            'nama' => 'Citra Dewi',
            'kelas' => 'X IPA 2'
        ]);
        
        // Seed Piket
        Piket::create([
            'id_guru' => 2,
            'tanggal' => now()
        ]);
        
        Piket::create([
            'id_guru' => 3,
            'tanggal' => now()->addDay()
        ]);
        
        // Seed Izin Keluar
        IzinKeluar::create([
            'id_siswa' => 1,
            'id_guru' => 3,
            'alasan' => 'Ke toilet',
            'waktu_keluar' => now()->subHours(2),
            'waktu_kembali' => now()->subHours(2)->addMinutes(10),
            'status' => 'completed'
        ]);
        
        IzinKeluar::create([
            'id_siswa' => 2,
            'id_guru' => 3,
            'alasan' => 'Ke UKS (sakit)',
            'waktu_keluar' => now()->subHour(),
            'status' => 'approved'
        ]);
        
        // Seed Keterlambatan
        Keterlambatan::create([
            'id_siswa' => 3,
            'id_guru' => 2,
            'waktu_datang' => now()->setTime(7, 30),
            'keterangan' => 'Macet di jalan'
        ]);
    }
}
