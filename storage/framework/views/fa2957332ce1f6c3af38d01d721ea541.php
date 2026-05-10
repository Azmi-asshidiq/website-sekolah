<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- User Info Card -->
    <div class="card mb-4" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; border: none;"
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">
                        <i class="fas fa-user-circle me-2"></i>
                        <?php echo e(auth()->user()->name); ?>

                    </h5>
                    <p class="mb-0 opacity-75">
                        <i class="fas fa-briefcase me-1"></i>
                        <?php if(auth()->user()->role === 'admin'): ?>
                            Administrator
                        <?php elseif(auth()->user()->role === 'kepsek'): ?>
                            Kepala Sekolah
                        <?php else: ?>
                            Guru Piket
                        <?php endif; ?>
                    </p>
                </div>
                <div class="text-end">
                    <small class="opacity-75">Login Sebagai</small>
                    <div class="badge bg-white text-dark">
                        <?php echo e(strtoupper(auth()->user()->role)); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fas fa-exclamation-triangle me-2"></i>Data Pelanggaran
        </h2>
        <?php if(auth()->user()->role === 'admin' || auth()->user()->role === 'guru'): ?>
        <a href="<?php echo e(route('pelanggaran.create')); ?>" class="btn btn-primary" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); border: none; color: white;">
            <i class="fas fa-plus me-2"></i>Tambah Pelanggaran
        </a>
        <?php endif; ?>
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
                        <?php $__empty_1 = true; $__currentLoopData = $pelanggaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($item->tanggal->format('d/m/Y')); ?></td>
                            <td><?php echo e($item->siswa->nama); ?></td>
                            <td><?php echo e($item->siswa->kelas); ?></td>
                            <td>
                                <span class="badge bg-warning"><?php echo e($item->jenis_pelanggaran); ?></span>
                            </td>
                            <td>
                                <span class="badge bg-danger"><?php echo e($item->poin); ?> poin</span>
                            </td>
                            <td><?php echo e($item->sanksi ?: '-'); ?></td>
                            <td><?php echo e($item->guru?->nama ?: '-'); ?></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="<?php echo e(route('pelanggaran.show', $item)); ?>" class="btn btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php if(auth()->user()->role === 'admin' || auth()->user()->role === 'guru'): ?>
                                    <a href="<?php echo e(route('pelanggaran.edit', $item)); ?>" class="btn btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if(auth()->user()->role === 'admin'): ?>
                                    <form action="<?php echo e(route('pelanggaran.destroy', $item)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus data pelanggaran?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h2 class="mb-0" style="color: #64748b;">Edit Pelanggaran</h2>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <?php echo e($pelanggaran->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\website-sekolah\resources\views/pelanggaran/index.blade.php ENDPATH**/ ?>