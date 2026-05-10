<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0" style="color: var(--text-primary); font-weight: 600;">
            <i class="fas fa-exclamation-triangle me-2" style="color: var(--primary-color);"></i>
            Rekap Pelanggaran
        </h2>
        <div class="d-flex gap-2">
            <?php if(auth()->user()->role === 'guru'): ?>
                <a href="<?php echo e(route('pelanggaran.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Tambah Pelanggaran
                </a>
            <?php endif; ?>
            <button class="btn btn-outline-secondary" onclick="window.print()">
                <i class="fas fa-print me-1"></i>
                Cetak
            </button>
            <a href="<?php echo e(route('pelanggaran.index')); ?>" class="btn btn-primary">
                <i class="fas fa-arrow-left me-1"></i>
                Kembali
            </a>
        </div>
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
                            <h3 class="mb-0"><?php echo e($rekap->count()); ?></h3>
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
                                <i class="fas fa-exclamation-triangle text-warning"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-muted">Total Pelanggaran</h6>
                            <h3 class="mb-0"><?php echo e($rekap->sum('jumlah_pelanggaran')); ?></h3>
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
                            <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                                <i class="fas fa-times-circle text-danger"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-muted">Rata-rata Poin</h6>
                            <h3 class="mb-0"><?php echo e(number_format($rekap->avg('total_poin'), 1)); ?></h3>
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
                                <i class="fas fa-trophy text-success"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-muted">Tertinggi</h6>
                            <h3 class="mb-0"><?php echo e($rekap->max('total_poin')); ?></h3>
                        </div>
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
                Data Rekap Pelanggaran
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0">
                                <i class="fas fa-hashtag me-1"></i>
                                No
                            </th>
                            <th class="border-0">
                                <i class="fas fa-user me-1"></i>
                                Nama Siswa
                            </th>
                            <th class="border-0">
                                <i class="fas fa-list me-1"></i>
                                Jumlah Pelanggaran
                            </th>
                            <th class="border-0">
                                <i class="fas fa-star me-1"></i>
                                Total Poin
                            </th>
                            <th class="border-0">
                                <i class="fas fa-chart-bar me-1"></i>
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $rekap; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="align-middle"><?php echo e($index + 1); ?></td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
                                            <i class="fas fa-user text-primary" style="font-size: 12px;"></i>
                                        </div>
                                        <span><?php echo e($item->siswa->nama ?? '-'); ?></span>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="badge bg-warning text-dark"><?php echo e($item->jumlah_pelanggaran); ?></span>
                                </td>
                                <td class="align-middle">
                                    <span class="badge bg-danger"><?php echo e($item->total_poin); ?></span>
                                </td>
                                <td class="align-middle">
                                    <?php if($item->total_poin >= 50): ?>
                                        <span class="badge bg-danger">Kritis</span>
                                    <?php elseif($item->total_poin >= 30): ?>
                                        <span class="badge bg-warning text-dark">Peringatan</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Baik</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p class="mb-0">Tidak ada data pelanggaran</p>
                                        <small>Silakan tambahkan data pelanggaran terlebih dahulu</small>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\website-sekolah\resources\views/pelanggaran/rekap.blade.php ENDPATH**/ ?>