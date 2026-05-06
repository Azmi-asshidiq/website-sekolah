@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0" style="color: var(--text-primary); font-weight: 600;">
            <i class="fas fa-chalkboard-teacher me-2" style="color: var(--primary-color);"></i>
            Data Guru
        </h2>
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'guru')
            <a href="{{ route('guru.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Tambah Guru
            </a>
        @endif
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                <i class="fas fa-chalkboard-teacher text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-muted">Total Guru</h6>
                            <h3 class="mb-0">{{ $guru->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-success bg-opacity-10 p-3">
                                <i class="fas fa-user-check text-success"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-muted">Aktif</h6>
                            <h3 class="mb-0">{{ $guru->where('status', 'aktif')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                                <i class="fas fa-user-clock text-warning"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-muted">Cuti</h6>
                            <h3 class="mb-0">{{ $guru->where('status', 'cuti')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-info bg-opacity-10 p-3">
                                <i class="fas fa-calendar text-info"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-muted">Piket Hari Ini</h6>
                            <h3 class="mb-0">{{ $guru->where('status', 'piket')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Cari guru berdasarkan nama atau NIP..." id="searchInput">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="statusFilter">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="cuti">Cuti</option>
                        <option value="piket">Piket</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="text-end">
                        <small class="text-muted">Total: {{ $guru->count() }} guru</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0" style="color: var(--text-primary);">
                <i class="fas fa-table me-2" style="color: var(--primary-color);"></i>
                Data Guru
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="guruTable">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0">
                                <i class="fas fa-hashtag me-1"></i>
                                No
                            </th>
                            <th class="border-0">
                                <i class="fas fa-id-card me-1"></i>
                                NIP
                            </th>
                            <th class="border-0">
                                <i class="fas fa-user me-1"></i>
                                Nama
                            </th>
                            <th class="border-0">
                                <i class="fas fa-envelope me-1"></i>
                                Email
                            </th>
                            <th class="border-0">
                                <i class="fas fa-phone me-1"></i>
                                Telepon
                            </th>
                            <th class="border-0 text-center">
                                <i class="fas fa-cog me-1"></i>
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($guru as $index => $g)
                            <tr>
                                <td class="align-middle">{{ $index + 1 }}</td>
                                <td class="align-middle">
                                    <span class="badge bg-light text-dark">{{ $g->nip }}</span>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
                                            <i class="fas fa-user text-primary" style="font-size: 12px;"></i>
                                        </div>
                                        <span>{{ $g->nama }}</span>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="text-muted">{{ $g->email }}</span>
                                </td>
                                <td class="align-middle">
                                    <span class="text-muted">{{ $g->telepon }}</span>
                                </td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('guru.show', $g->id_guru) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'guru')
                                            <a href="{{ route('guru.edit', $g->id_guru) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                        @if(auth()->user()->role === 'admin')
                                            <form action="{{ route('guru.destroy', $g->id_guru) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus data guru ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="card-footer bg-white border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Menampilkan {{ $guru->firstItem() }} - {{ $guru->lastItem() }} dari {{ $guru->total() }} data
                    </div>
                    <div>
                        {{ $guru->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection('layouts.app')
