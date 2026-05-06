@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- User Info Card -->
    <div class="card mb-4" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; border: none;"
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">
                        <i class="fas fa-user-circle me-2"></i>
                        {{ auth()->user()->name }}
                    </h5>
                    <p class="mb-0 opacity-75">
                        <i class="fas fa-briefcase me-1"></i>
                        @if(auth()->user()->role === 'admin')
                            Administrator
                        @elseif(auth()->user()->role === 'kepsek')
                            Kepala Sekolah
                        @else
                            Guru Piket
                        @endif
                    </p>
                </div>
                <div class="text-end">
                    <small class="opacity-75">Login Sebagai</small>
                    <div class="badge bg-white text-dark">
                        {{ strtoupper(auth()->user()->role) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fas fa-exclamation-triangle me-2"></i>Data Pelanggaran
        </h2>
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'guru')
        <a href="{{ route('pelanggaran.create') }}" class="btn btn-primary" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); border: none; color: white;">
            <i class="fas fa-plus me-2"></i>Tambah Pelanggaran
        </a>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Jenis Pelanggaran</th>
                            <th>Poin</th>
                            <th>Sanksi</th>
                            <th>Guru</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelanggaran as $item)
                        <tr>
                            <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                            <td>{{ $item->siswa->nama }}</td>
                            <td>{{ $item->siswa->kelas }}</td>
                            <td>
                                <span class="badge bg-warning">{{ $item->jenis_pelanggaran }}</span>
                            </td>
                            <td>
                                <span class="badge bg-danger">{{ $item->poin }} poin</span>
                            </td>
                            <td>{{ $item->sanksi ?: '-' }}</td>
                            <td>{{ $item->guru?->nama ?: '-' }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('pelanggaran.show', $item) }}" class="btn btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'guru')
                                    <a href="{{ route('pelanggaran.edit', $item) }}" class="btn btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endif
                                    @if(auth()->user()->role === 'admin')
                                    <form action="{{ route('pelanggaran.destroy', $item) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus data pelanggaran?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h2 class="mb-0" style="color: #64748b;">Edit Pelanggaran</h2>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{ $pelanggaran->links() }}
        </div>
    </div>
</div>
@endsection
