@extends('layouts.app')

@section('content')
<div class="dashboard-content">
    <!-- Top Header -->
    <header class="top-header">
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Cari data..." class="search-input">
        </div>
        <div class="header-actions">
            <div class="notification-bell">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">3</span>
            </div>
            <div class="user-profile">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">Kepala Sekolah</div>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <div class="page-content">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Dashboard Kepsek</h1>
            <p class="page-subtitle">Selamat datang di sistem manajemen sekolah Eduspace</p>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $totalSiswa }}</h3>
                    <p>Total Siswa</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $totalGuru }}</h3>
                    <p>Total Guru</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $totalKeterlambatan }}</h3>
                    <p>Total Keterlambatan</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon secondary">
                    <i class="fas fa-sign-out-alt"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $totalIzin }}</h3>
                    <p>Total Izin Keluar</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <h3 class="section-title">
                <i class="fas fa-bolt"></i>
                Aksi Cepat
            </h3>
            <div class="action-grid">
                <a href="{{ route('pelanggaran.index') }}" class="action-item">
                    <div class="action-icon warning">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="action-content">
                        <h4>Pelanggaran</h4>
                        <p>Kelola pelanggaran siswa</p>
                    </div>
                </a>
                <a href="{{ route('pelanggaran.create') }}" class="action-item">
                    <div class="action-icon warning">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="action-content">
                        <h4>Tambah Pelanggaran</h4>
                        <p>Buat pelanggaran baru</p>
                    </div>
                </a>
                <a href="{{ route('pelanggaran.rekap') }}" class="action-item">
                    <div class="action-icon warning">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="action-content">
                        <h4>Rekap Pelanggaran</h4>
                        <p>Lihat rekap pelanggaran</p>
                    </div>
                </a>
            </div>
        </div>

            </div>
</div>

@section('scripts')
<script>
    // Simple dashboard without charts for kepsek
    console.log('Kepsek Dashboard loaded successfully');
</script>
@endsection
