{{-- resources/views/siswa/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0" style="color: var(--text-primary); font-weight: 600;">
            <i class="fas fa-graduation-cap me-2" style="color: var(--primary-color);"></i>
            Data Siswa
        </h2>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('siswa.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Tambah Siswa
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
                                <i class="fas fa-users text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-muted">Total Siswa</h6>
                            <h3 class="mb-0">{{ $siswa->count() }}</h3>
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
                            <h6 class="mb-0 text-muted">Kelas X</h6>
                            <h3 class="mb-0">{{ $siswa->where('kelas', 'X')->count() }}</h3>
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
                                <i class="fas fa-user-graduate text-warning"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-muted">Kelas XI</h6>
                            <h3 class="mb-0">{{ $siswa->where('kelas', 'XI')->count() }}</h3>
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
                                <i class="fas fa-school text-info"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-muted">Kelas XII</h6>
                            <h3 class="mb-0">{{ $siswa->where('kelas', 'XII')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    <!-- Search and Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Cari siswa berdasarkan nama atau NIS..." id="searchInput">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="kelasFilter">
                        <option value="">Semua Kelas</option>
                        <option value="X">Kelas X</option>
                        <option value="XI">Kelas XI</option>
                        <option value="XII">Kelas XII</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="text-end">
                        <small class="text-muted">Total: {{ $siswa->count() }} siswa</small>
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
                Data Siswa
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="siswaTable">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0">
                                <i class="fas fa-hashtag me-1"></i>
                                No
                            </th>
                            <th class="border-0">
                                <i class="fas fa-id-card me-1"></i>
                                NIS
                            </th>
                            <th class="border-0">
                                <i class="fas fa-user me-1"></i>
                                Nama
                            </th>
                            <th class="border-0">
                                <i class="fas fa-graduation-cap me-1"></i>
                                Kelas
                            </th>
                            <th class="border-0 text-center">
                                <i class="fas fa-cog me-1"></i>
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswa as $index => $s)
                            <tr>
                                <td class="align-middle">{{ $index + 1 }}</td>
                                <td class="align-middle">
                                    <span class="badge bg-light text-dark">{{ $s->nis }}</span>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
                                            <i class="fas fa-user text-primary" style="font-size: 12px;"></i>
                                        </div>
                                        <span>{{ $s->nama }}</span>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="badge bg-info">{{ $s->kelas }}</span>
                                </td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('siswa.show', $s->id_siswa) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(auth()->user()->role === 'admin')
                                            <a href="{{ route('siswa.edit', $s->id_siswa) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $s->id_siswa }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
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
                            Menampilkan {{ $siswa->firstItem() }} - {{ $siswa->lastItem() }} dari {{ $siswa->total() }} data
                        </div>
                        <div>
                            {{ $siswa->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function(e) {
    const searchValue = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#siswaTable tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Filter functionality
document.getElementById('kelasFilter').addEventListener('change', function(e) {
    const filterValue = e.target.value;
    const rows = document.querySelectorAll('#siswaTable tbody tr');
    
    rows.forEach(row => {
        const kelas = row.querySelector('td:nth-child(4) .badge').textContent;
        if (filterValue === '' || kelas === filterValue) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Delete confirmation
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data siswa ini?')) {
        // You can implement the actual delete functionality here
        console.log('Delete siswa with ID:', id);
    }
}
</script>

        <!-- Custom CSS -->
        <style>
        .table-primary {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
        }
        
        .table-primary th {
            border: none !important;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        
        .hover-row {
            transition: all 0.3s ease;
        }
        
        .hover-row:hover {
            background-color: #f8f9fc !important;
            transform: translateX(2px);
        }
        
        .btn-action {
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
        }
        
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .avatar-sm {
            width: 40px;
            height: 40px;
            font-size: 0.875rem;
        }
        
        .input-group-text {
            border: none;
        }
        
        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        
        .pagination .page-link {
            color: #4e73df;
            border: 1px solid #dee2e6;
            margin: 0 2px;
            border-radius: 0.375rem;
        }
        
        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            border-color: #4e73df;
        }
        
        .pagination .page-link:hover {
            color: #224abe;
            background-color: #f8f9fc;
        }
        </style>
