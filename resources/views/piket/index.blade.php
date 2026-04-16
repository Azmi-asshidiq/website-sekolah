@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #6366f1; font-weight: 700;">
                <i class="fas fa-calendar-check me-2"></i>
                Jadwal Piket Guru
            </h2>
            <p class="text-muted mb-0">Kelola dan monitor jadwal piket guru harian</p>
        </div>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('piket.create') }}" class="btn btn-primary" style="border-radius: 10px; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #6366f1, #8b5cf6); border: none;">
                <i class="fas fa-plus me-2"></i>
                Tambah Jadwal
            </a>
        @endif
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                <i class="fas fa-calendar-alt text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-muted">Total Jadwal</h6>
                            <h3 class="mb-0">{{ $piket->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-success bg-opacity-10 p-3">
                                <i class="fas fa-clock text-success"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-muted">Hari Ini</h6>
                            <h3 class="mb-0">{{ $piket->where('tanggal', now()->format('Y-m-d'))->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                                <i class="fas fa-calendar-week text-warning"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-muted">Minggu Ini</h6>
                            <h3 class="mb-0">{{ $piket->whereBetween('tanggal', [now()->startOfWeek()->format('Y-m-d'), now()->endOfWeek()->format('Y-m-d')])->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-info bg-opacity-10 p-3">
                                <i class="fas fa-users text-info"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-muted">Guru Piket</h6>
                            <h3 class="mb-0">{{ $piket->pluck('id_guru')->unique()->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4" style="border-radius: 15px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text" style="border-radius: 10px 0 0 10px; background: #f8fafc; border-color: #e2e8f0;">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control" id="searchInput" placeholder="Cari guru atau tanggal..." style="border-radius: 0 10px 10px 0; border-color: #e2e8f0;">
                    </div>
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" id="filterDate" style="border-radius: 10px; border-color: #e2e8f0;">
                </div>
                <div class="col-md-3">
                    <button class="btn btn-outline-secondary w-100" onclick="clearFilters()" style="border-radius: 10px;">
                        <i class="fas fa-times me-2"></i>Reset Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card" style="border-radius: 15px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);">
        <div class="card-header bg-white border-0 py-3" style="border-radius: 15px 15px 0 0;">
            <h5 class="mb-0" style="color: #1e293b; font-weight: 600;">
                <i class="fas fa-list me-2" style="color: #6366f1;"></i>
                Daftar Jadwal Piket
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="piketTable">
                    <thead>
                        <tr>
                            <th style="border-bottom: 2px solid #e2e8f0; color: #64748b; font-weight: 600;">
                                <i class="fas fa-user me-2"></i>Nama Guru
                            </th>
                            <th style="border-bottom: 2px solid #e2e8f0; color: #64748b; font-weight: 600;">
                                <i class="fas fa-briefcase me-2"></i>Jabatan
                            </th>
                            <th style="border-bottom: 2px solid #e2e8f0; color: #64748b; font-weight: 600;">
                                <i class="fas fa-calendar me-2"></i>Tanggal
                            </th>
                            <th style="border-bottom: 2px solid #e2e8f0; color: #64748b; font-weight: 600;">
                                <i class="fas fa-clock me-2"></i>Status
                            </th>
                            <th style="border-bottom: 2px solid #e2e8f0; color: #64748b; font-weight: 600;">
                                <i class="fas fa-cogs me-2"></i>Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($piket as $p)
                            <tr class="table-row-hover" style="transition: all 0.2s ease;">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-user-tie text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $p->guru->nama }}</div>
                                            <small class="text-muted">{{ $p->guru->email ?? '-' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info bg-opacity-10 text-info" style="padding: 0.5rem 1rem; border-radius: 20px;">
                                        {{ $p->guru->jabatan }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $p->tanggal->format('d F Y') }}</div>
                                    <small class="text-muted">{{ $p->tanggal->format('l') }}</small>
                                </td>
                                <td>
                                    @if($p->tanggal->format('Y-m-d') == now()->format('Y-m-d'))
                                        <span class="badge bg-success" style="padding: 0.5rem 1rem; border-radius: 20px;">
                                            <i class="fas fa-check-circle me-1"></i>Hari Ini
                                        </span>
                                    @elseif($p->tanggal->format('Y-m-d') > now()->format('Y-m-d'))
                                        <span class="badge bg-warning" style="padding: 0.5rem 1rem; border-radius: 20px;">
                                            <i class="fas fa-clock me-1"></i>Akan Datang
                                        </span>
                                    @else
                                        <span class="badge bg-secondary" style="padding: 0.5rem 1rem; border-radius: 20px;">
                                            <i class="fas fa-check me-1"></i>Selesai
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if(auth()->user()->role === 'admin')
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('piket.edit', $p) }}" class="btn btn-sm btn-outline-primary" style="border-radius: 8px;">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('piket.destroy', $p) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 8px;" onclick="return confirm('Yakin ingin menghapus jadwal piket ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-muted">
                                            <i class="fas fa-lock me-1"></i>Tidak ada akses
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-calendar-times fa-3x mb-3"></i>
                                        <h5>Belum ada jadwal piket</h5>
                                        <p>Jadwal piket guru belum tersedia</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $piket->links() }}
            </div>
        </div>
    </div>
</div>

<style>
.table-row-hover:hover {
    background-color: rgba(99, 102, 241, 0.05);
    transform: scale(1.01);
    box-shadow: 0 2px 8px rgba(99, 102, 241, 0.1);
}

.form-control:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
}

.btn-outline-primary:hover {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border-color: #6366f1;
    transform: translateY(-2px);
}

.btn-outline-danger:hover {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    border-color: #ef4444;
    transform: translateY(-2px);
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.badge {
    font-weight: 500;
}

.table th {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    position: sticky;
    top: 0;
    z-index: 10;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const filterDate = document.getElementById('filterDate');
    const table = document.getElementById('piketTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

    // Search functionality
    searchInput.addEventListener('input', function() {
        filterTable();
    });

    // Date filter functionality
    filterDate.addEventListener('change', function() {
        filterTable();
    });

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const filterDateValue = filterDate.value;

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.getElementsByTagName('td');
            
            if (cells.length === 0) continue; // Skip empty rows
            
            let showRow = true;
            
            // Search filter
            if (searchTerm) {
                const guruName = cells[0].textContent.toLowerCase();
                const jabatan = cells[1].textContent.toLowerCase();
                const dateText = cells[2].textContent.toLowerCase();
                
                if (!guruName.includes(searchTerm) && 
                    !jabatan.includes(searchTerm) && 
                    !dateText.includes(searchTerm)) {
                    showRow = false;
                }
            }
            
            // Date filter
            if (filterDateValue && showRow) {
                const dateCell = cells[2];
                const dateText = dateCell.textContent.trim();
                
                // Extract date from text (format: "d F Y")
                const dateMatch = dateText.match(/(\d{1,2})\s+(\w+)\s+(\d{4})/);
                if (dateMatch) {
                    const [, day, month, year] = dateMatch;
                    const monthNames = {
                        'januari': '01', 'februari': '02', 'maret': '03', 'april': '04',
                        'mei': '05', 'juni': '06', 'juli': '07', 'agustus': '08',
                        'september': '09', 'oktober': '10', 'november': '11', 'desember': '12'
                    };
                    const monthNum = monthNames[month.toLowerCase()];
                    if (monthNum) {
                        const formattedDate = `${year}-${monthNum}-${day.padStart(2, '0')}`;
                        if (formattedDate !== filterDateValue) {
                            showRow = false;
                        }
                    }
                }
            }
            
            row.style.display = showRow ? '' : 'none';
        }
    }

    // Add animation to cards
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('fade-in');
    });
});

// Clear filters function
function clearFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('filterDate').value = '';
    
    const event = new Event('input');
    document.getElementById('searchInput').dispatchEvent(event);
}

// Add CSS animation
const style = document.createElement('style');
style.textContent = `
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .fade-in {
        animation: fade-in 0.6s ease-out forwards;
    }
`;
document.head.appendChild(style);
</script>
@endsection
