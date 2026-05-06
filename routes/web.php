<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\PiketController;
use App\Http\Controllers\IzinKeluarController;
use App\Http\Controllers\KeterlambatanController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\JadwalPiketController;
use App\Http\Controllers\QRScannerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Tampilkan halaman utama yang sederhana tanpa koneksi database
    return view('welcome');
});

// Simple test routes
Route::get('/simple-test', function() {
    return 'Simple test works!';
});

Route::get('/test-pelanggaran', function() {
    try {
        $siswa = \App\Models\Siswa::first();
        if (!$siswa) {
            return 'No siswa found in database';
        }
        
        $pelanggaran = new \App\Models\Pelanggaran();
        $pelanggaran->id_siswa = $siswa->id_siswa;
        $pelanggaran->id_guru = null;
        $pelanggaran->tanggal = now()->format('Y-m-d');
        $pelanggaran->jenis_pelanggaran = 'Test Pelanggaran';
        $pelanggaran->keterangan = 'Test Keterangan';
        $pelanggaran->sanksi = 'Test Sanksi';
        $pelanggaran->poin = 5;
        
        if ($pelanggaran->save()) {
            return 'SUCCESS: Pelanggaran created with ID: ' . $pelanggaran->id;
        } else {
            return 'ERROR: Failed to save pelanggaran';
        }
    } catch (Exception $e) {
        return 'ERROR: ' . $e->getMessage();
    }
});

Route::get('/test-db-connection', function() {
    $results = [];
    
    try {
        // Test database connection
        $results[] = "✅ Database Connection: OK";
        
        // Test tables exist
        $tables = \Illuminate\Support\Facades\DB::select("SELECT name FROM sqlite_master WHERE type='table'");
        $tableNames = array_column($tables, 'name');
        $results[] = "📊 Tables Found: " . implode(', ', $tableNames);
        
        // Check table structures
        $siswaColumns = \Illuminate\Support\Facades\DB::select("PRAGMA table_info(siswa)");
        $results[] = "🔍 Siswa Table Columns: " . implode(', ', array_column($siswaColumns, 'name'));
        
        $guruColumns = \Illuminate\Support\Facades\DB::select("PRAGMA table_info(guru)");
        $results[] = "🔍 Guru Table Columns: " . implode(', ', array_column($guruColumns, 'name'));
        
        // Test raw siswa data
        try {
            $rawSiswa = \Illuminate\Support\Facades\DB::select("SELECT * FROM siswa LIMIT 1");
            if ($rawSiswa) {
                $results[] = "📝 Raw Siswa Data: " . json_encode($rawSiswa[0]);
            } else {
                $results[] = "❌ No raw siswa data found";
            }
        } catch (Exception $e) {
            $results[] = "❌ Raw Siswa Error: " . $e->getMessage();
        }
        
        // Test raw guru data
        try {
            $rawGuru = \Illuminate\Support\Facades\DB::select("SELECT * FROM guru LIMIT 1");
            if ($rawGuru) {
                $results[] = "📝 Raw Guru Data: " . json_encode($rawGuru[0]);
            } else {
                $results[] = "❌ No raw guru data found";
            }
        } catch (Exception $e) {
            $results[] = "❌ Raw Guru Error: " . $e->getMessage();
        }
        
        // Test siswa model
        try {
            $siswaCount = \App\Models\Siswa::count();
            $results[] = "👨‍🎓 Siswa Count: " . $siswaCount;
            
            $siswa = \App\Models\Siswa::first();
            if ($siswa) {
                $results[] = "📝 Sample Siswa: " . $siswa->nama . " (ID: " . $siswa->id_siswa . ")";
                $results[] = "📝 Siswa NIS: " . $siswa->nis;
                $results[] = "📝 Siswa Kelas: " . $siswa->kelas;
            }
        } catch (Exception $e) {
            $results[] = "❌ Siswa Error: " . $e->getMessage();
        }
        
        // Test guru model
        try {
            $guruCount = \App\Models\Guru::count();
            $results[] = "👨‍🏫 Guru Count: " . $guruCount;
            
            $guru = \App\Models\Guru::first();
            if ($guru) {
                $results[] = "📝 Sample Guru: " . $guru->nama . " (ID: " . $guru->id_guru . ")";
                $results[] = "📝 Guru NIP: " . $guru->nip;
                $results[] = "📝 Guru Jabatan: " . $guru->jabatan;
            }
        } catch (Exception $e) {
            $results[] = "❌ Guru Error: " . $e->getMessage();
        }
        
        // Test pelanggaran data
        try {
            $pelanggaranCount = \App\Models\Pelanggaran::count();
            $results[] = "⚠️ Pelanggaran Count: " . $pelanggaranCount;
        } catch (Exception $e) {
            $results[] = "❌ Pelanggaran Error: " . $e->getMessage();
        }
        
        // Test create pelanggaran only if siswa exists
        try {
            $siswa = \App\Models\Siswa::first();
            if ($siswa) {
                $pelanggaran = new \App\Models\Pelanggaran();
                $pelanggaran->id_siswa = $siswa->id_siswa;
                $pelanggaran->id_guru = null;
                $pelanggaran->tanggal = now()->format('Y-m-d');
                $pelanggaran->jenis_pelanggaran = 'Database Test';
                $pelanggaran->keterangan = 'Testing database connection';
                $pelanggaran->sanksi = 'Test sanksi';
                $pelanggaran->poin = 1;
                
                if ($pelanggaran->save()) {
                    $results[] = "✅ Pelanggaran Test: SUCCESS (ID: " . $pelanggaran->id . ")";
                } else {
                    $results[] = "❌ Pelanggaran Test: Failed to save";
                }
            } else {
                $results[] = "❌ Pelanggaran Test: No siswa data found";
            }
        } catch (Exception $e) {
            $results[] = "❌ Pelanggaran Test: " . $e->getMessage();
        }
        
    } catch (Exception $e) {
        $results[] = "❌ Database Error: " . $e->getMessage();
    }
    
    return '<h2>Database Connection Test</h2><pre>' . implode("\n", $results) . '</pre>';
});

Route::get('/create-sample-pelanggaran', function() {
    try {
        $siswa = \App\Models\Siswa::all();
        $results = [];
        
        if ($siswa->isEmpty()) {
            return "❌ No siswa data found. Please seed siswa data first.";
        }
        
        // Create sample pelanggaran data
        $sampleData = [
            [
                'id_siswa' => $siswa[0]->id_siswa,
                'id_guru' => null,
                'tanggal' => now()->subDays(2)->format('Y-m-d'),
                'jenis_pelanggaran' => 'Terlambat',
                'keterangan' => 'Terlambat 15 menit masuk kelas',
                'sanksi' => 'Membersihkan kelas',
                'poin' => 5
            ],
            [
                'id_siswa' => $siswa[1]->id_siswa ?? $siswa[0]->id_siswa,
                'id_guru' => null,
                'tanggal' => now()->subDays(1)->format('Y-m-d'),
                'jenis_pelanggaran' => 'Tidak Memakai Seragam',
                'keterangan' => 'Tidak menggunakan seragam lengkap',
                'sanksi' => 'Surat peringatan',
                'poin' => 10
            ],
            [
                'id_siswa' => $siswa[2]->id_siswa ?? $siswa[0]->id_siswa,
                'id_guru' => null,
                'tanggal' => now()->format('Y-m-d'),
                'jenis_pelanggaran' => 'Menggunakan HP di Kelas',
                'keterangan' => 'Main HP saat pelajaran berlangsung',
                'sanksi' => 'HP disita selama seminggu',
                'poin' => 15
            ]
        ];
        
        foreach ($sampleData as $data) {
            \App\Models\Pelanggaran::create($data);
            $results[] = "✅ Created: " . $data['jenis_pelanggaran'] . " (Poin: " . $data['poin'] . ")";
        }
        
        return '<h2>Sample Pelanggaran Created!</h2><pre>' . implode("\n", $results) . '</pre><br><a href="/pelanggaran" class="btn btn-primary">View Pelanggaran List</a>';
        
    } catch (Exception $e) {
        return "❌ Error: " . $e->getMessage();
    }
});

Route::get('/test-auth', function() {
    $user = auth()->user();
    if ($user) {
        return 'Logged in as: ' . $user->name . ' (role: ' . $user->role . ')<br>' .
               'Direct links:<br>' .
               '<a href="/pelanggaran/create" style="color:blue;">📝 Create Pelanggaran (Original Form)</a><br>' .
               '<a href="/pelanggaran" style="color:blue;">📋 List Pelanggaran</a><br>' .
               '<a href="/create-sample-pelanggaran" style="color:blue;">🎯 Create Sample Data</a><br>' .
               '<a href="/pelanggaran/create-test" style="color:blue;">🧪 Test Form (Simple)</a><br>' .
               '<a href="/test-db-connection" style="color:blue;">🔍 Test Database Connection</a><br>' .
               '<a href="/dashboard" style="color:blue;">🏠 Dashboard</a>';
    } else {
        return 'Not logged in. Available users:<br>' .
               'Admin: admin@eduspace.com / password123<br>' .
               'Guru: guru@eduspace.com / password123<br>' .
               'Kepsek: kepsek@eduspace.com / password123';
    }
});

// Test pelanggaran without middleware - simple form
Route::get('/pelanggaran/create-test', function() {
    if (!auth()->check()) {
        return 'Please login first';
    }
    
    $siswa = \App\Models\Siswa::all();
    $html = '<h2>Tambah Pelanggaran (Test)</h2>';
    $html .= '<form method="POST" action="/pelanggaran/store-test">';
    $html .= csrf_field();
    $html .= '<div style="margin: 10px 0;">';
    $html .= '<label>Siswa: </label>';
    $html .= '<select name="id_siswa" required>';
    $html .= '<option value="">-- Pilih Siswa --</option>';
    foreach ($siswa as $s) {
        $html .= '<option value="' . $s->id_siswa . '">' . $s->nama . ' - ' . $s->kelas . '</option>';
    }
    $html .= '</select>';
    $html .= '</div>';
    
    $html .= '<div style="margin: 10px 0;">';
    $html .= '<label>Tanggal: </label>';
    $html .= '<input type="date" name="tanggal" value="' . now()->format('Y-m-d') . '" required>';
    $html .= '</div>';
    
    $html .= '<div style="margin: 10px 0;">';
    $html .= '<label>Jenis Pelanggaran: </label>';
    $html .= '<select name="jenis_pelanggaran" required>';
    $html .= '<option value="Terlambat">Terlambat</option>';
    $html .= '<option value="Tidak Masuk Tanpa Keterangan">Tidak Masuk Tanpa Keterangan</option>';
    $html .= '<option value="Lainnya">Lainnya</option>';
    $html .= '</select>';
    $html .= '</div>';
    
    $html .= '<div style="margin: 10px 0;">';
    $html .= '<label>Poin: </label>';
    $html .= '<input type="number" name="poin" value="5" min="0" max="100" required>';
    $html .= '</div>';
    
    $html .= '<div style="margin: 10px 0;">';
    $html .= '<label>Keterangan: </label>';
    $html .= '<textarea name="keterangan"></textarea>';
    $html .= '</div>';
    
    $html .= '<div style="margin: 10px 0;">';
    $html .= '<label>Sanksi: </label>';
    $html .= '<textarea name="sanksi"></textarea>';
    $html .= '</div>';
    
    $html .= '<button type="submit" style="background: #667eea; color: white; padding: 10px 20px; border: none; border-radius: 5px;">Simpan</button>';
    $html .= '</form>';
    
    return $html;
})->middleware('auth');

Route::post('/pelanggaran/store-test', function(\Illuminate\Http\Request $request) {
    if (!auth()->check()) {
        return 'Please login first';
    }
    
    try {
        $pelanggaran = \App\Models\Pelanggaran::create([
            'id_siswa' => $request->id_siswa,
            'id_guru' => null,
            'tanggal' => $request->tanggal,
            'jenis_pelanggaran' => $request->jenis_pelanggaran,
            'keterangan' => $request->keterangan,
            'sanksi' => $request->sanksi,
            'poin' => $request->poin,
        ]);
        
        return '<h2>SUCCESS!</h2><p>Pelanggaran created with ID: ' . $pelanggaran->id . '</p><a href="/pelanggaran/create-test">Add Another</a> | <a href="/test-auth">Back to Test</a>';
    } catch (Exception $e) {
        return '<h2>ERROR:</h2><p>' . $e->getMessage() . '</p><a href="/pelanggaran/create-test">Try Again</a>';
    }
})->middleware('auth');

Route::get('/session-check', function() {
    return session()->has('user')
        ? 'Session exists: ' . session('user')['name']
        : 'No session found';
});

Route::get('/auth-check', function() {
    return auth()->check()
        ? 'Authenticated as: ' . auth()->user()->name . ' (Role: ' . auth()->user()->role . ')'
        : 'Not authenticated';
});

Route::get('/siswa-test', function() {
    return view('siswa.create');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/test-route', fn() => 'Route test successful')->name('test.route');
    Route::get('/middleware-test', fn() => 'Middleware test successful')->middleware('role:admin');
    Route::get('/middleware-siswa', [SiswaController::class, 'create'])->middleware('role:admin');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Test dashboard data
    Route::get('/test-dashboard', function() {
        try {
            $totalSiswa = \App\Models\Siswa::count();
            $totalGuru = \App\Models\Guru::count();
            $totalPiket = \App\Models\Piket::count();
            $totalKeterlambatan = \App\Models\Keterlambatan::count();
            $totalPelanggaran = \App\Models\Pelanggaran::count();
            $totalIzin = \App\Models\IzinKeluar::count();
            
            return "Dashboard data test successful: Siswa: $totalSiswa, Guru: $totalGuru, Piket: $totalPiket, Keterlambatan: $totalKeterlambatan, Pelanggaran: $totalPelanggaran, Izin: $totalIzin";
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    });

    // ================= SISWA =================
    Route::get('siswa/create', [SiswaController::class, 'create'])->middleware('role:admin')->name('siswa.create');
    Route::post('siswa', [SiswaController::class, 'store'])->middleware('role:admin')->name('siswa.store');
    Route::resource('siswa', SiswaController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('siswa/{siswa}/edit', [SiswaController::class, 'edit'])->middleware('role:admin')->name('siswa.edit');
    Route::put('siswa/{siswa}', [SiswaController::class, 'update'])->middleware('role:admin')->name('siswa.update');
    Route::delete('siswa/{siswa}', [SiswaController::class, 'destroy'])->middleware('role:admin')->name('siswa.destroy');

    // ================= GURU =================
    Route::get('guru/create', [GuruController::class, 'create'])->middleware('role:admin,guru')->name('guru.create');
    Route::post('guru', [GuruController::class, 'store'])->middleware('role:admin,guru')->name('guru.store');
    Route::resource('guru', GuruController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('guru/{guru}/edit', [GuruController::class, 'edit'])->middleware('role:admin,guru')->name('guru.edit');
    Route::put('guru/{guru}', [GuruController::class, 'update'])->middleware('role:admin,guru')->name('guru.update');
    Route::delete('guru/{guru}', [GuruController::class, 'destroy'])->middleware('role:admin,guru')->name('guru.destroy');

    // ================= PIKET =================
    Route::get('piket/create', [PiketController::class, 'create'])->middleware('role:admin')->name('piket.create');
    Route::post('piket', [PiketController::class, 'store'])->middleware('role:admin')->name('piket.store');
    Route::resource('piket', PiketController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('piket/{piket}/edit', [PiketController::class, 'edit'])->middleware('role:admin')->name('piket.edit');
    Route::put('piket/{piket}', [PiketController::class, 'update'])->middleware('role:admin')->name('piket.update');
    Route::delete('piket/{piket}', [PiketController::class, 'destroy'])->middleware('role:admin')->name('piket.destroy');

    // ================= IZIN KELUAR =================
    Route::get('izin-keluar/create', [IzinKeluarController::class, 'create'])->middleware('role:guru')->name('izin-keluar.create');
    Route::post('izin-keluar', [IzinKeluarController::class, 'store'])->middleware('role:guru')->name('izin-keluar.store');
    Route::resource('izin-keluar', IzinKeluarController::class)->except(['create', 'store', 'edit', 'update', 'destroy'])->middleware('role:guru');
    Route::get('izin-keluar/{izinKeluar}/edit', [IzinKeluarController::class, 'edit'])->middleware('role:guru')->name('izin-keluar.edit');
    Route::put('izin-keluar/{izinKeluar}', [IzinKeluarController::class, 'update'])->middleware('role:guru')->name('izin-keluar.update');
    Route::delete('izin-keluar/{izinKeluar}', [IzinKeluarController::class, 'destroy'])->middleware('role:guru')->name('izin-keluar.destroy');

    // ================= KETERLAMBATAN =================
    Route::get('keterlambatan/create', [KeterlambatanController::class, 'create'])->middleware('role:guru')->name('keterlambatan.create');
    Route::post('keterlambatan', [KeterlambatanController::class, 'store'])->middleware('role:guru')->name('keterlambatan.store');
    Route::resource('keterlambatan', KeterlambatanController::class)->except(['create', 'store', 'edit', 'update', 'destroy'])->middleware('role:guru');
    Route::get('keterlambatan/{keterlambatan}/edit', [KeterlambatanController::class, 'edit'])->middleware('role:guru')->name('keterlambatan.edit');
    Route::put('keterlambatan/{keterlambatan}', [KeterlambatanController::class, 'update'])->middleware('role:guru')->name('keterlambatan.update');
    Route::delete('keterlambatan/{keterlambatan}', [KeterlambatanController::class, 'destroy'])->middleware('role:guru')->name('keterlambatan.destroy');

    // ================= PELANGGARAN =================
    Route::get('pelanggaran/create', [PelanggaranController::class, 'create'])->middleware('role:admin,guru')->name('pelanggaran.create');
    Route::post('pelanggaran', [PelanggaranController::class, 'store'])->middleware('role:admin,guru')->name('pelanggaran.store');
    Route::get('pelanggaran/rekap', [PelanggaranController::class, 'rekap'])->middleware('role:admin,guru')->name('pelanggaran.rekap');
    Route::resource('pelanggaran', PelanggaranController::class)->except(['create', 'store', 'edit', 'update', 'destroy'])->middleware('role:admin,guru');
    Route::get('pelanggaran/{pelanggaran}/edit', [PelanggaranController::class, 'edit'])->middleware('role:admin,guru')->name('pelanggaran.edit');
    Route::put('pelanggaran/{pelanggaran}', [PelanggaranController::class, 'update'])->middleware('role:admin,guru')->name('pelanggaran.update');
    Route::delete('pelanggaran/{pelanggaran}', [PelanggaranController::class, 'destroy'])->middleware('role:admin,guru')->name('pelanggaran.destroy');

    // ================= JADWAL PIKET =================
    Route::get('jadwal-piket/create', [JadwalPiketController::class, 'create'])->middleware('role:admin,guru')->name('jadwal-piket.create');
    Route::post('jadwal-piket', [JadwalPiketController::class, 'store'])->middleware('role:admin,guru')->name('jadwal-piket.store');
    Route::get('jadwal-piket/hari-ini', [JadwalPiketController::class, 'getJadwalHariIni'])->name('jadwal-piket.hari-ini');
    Route::resource('jadwal-piket', JadwalPiketController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('jadwal-piket/{jadwalPiket}/edit', [JadwalPiketController::class, 'edit'])->middleware('role:admin,guru')->name('jadwal-piket.edit');
    Route::put('jadwal-piket/{jadwalPiket}', [JadwalPiketController::class, 'update'])->middleware('role:admin,guru')->name('jadwal-piket.update');
    Route::delete('jadwal-piket/{jadwalPiket}', [JadwalPiketController::class, 'destroy'])->middleware('role:admin,guru')->name('jadwal-piket.destroy');

    // ================= QR =================
    Route::post('/api/qr-scan', [QRScannerController::class, 'scan'])->middleware('role:admin,guru')->name('qr.scan');
    Route::get('/api/qr-generate/{siswa}', [QRScannerController::class, 'generateQr'])->middleware('role:admin,guru')->name('qr.generate');

    // ================= LAPORAN (KEPALA SEKOLAH) =================
    Route::get('laporan/siswa', [SiswaController::class, 'laporan'])->middleware('role:kepsek')->name('laporan.siswa');
    Route::get('laporan/guru', [GuruController::class, 'laporan'])->middleware('role:kepsek')->name('laporan.guru');
    Route::get('laporan/piket', [PiketController::class, 'laporan'])->middleware('role:kepsek')->name('laporan.piket');
    Route::get('laporan/izin', [IzinKeluarController::class, 'laporan'])->middleware('role:kepsek')->name('laporan.izin');
    Route::get('laporan/keterlambatan', [KeterlambatanController::class, 'laporan'])->middleware('role:kepsek')->name('laporan.keterlambatan');
    Route::get('laporan/pelanggaran', [PelanggaranController::class, 'laporan'])->middleware('role:kepsek')->name('laporan.pelanggaran');

    // ================= AUTH =================
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
    });

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// logout fallback
Route::get('logout', function() {
    return redirect()->route('login')->with('message', 'Please use the logout button.');
})->name('logout.get');

// profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';