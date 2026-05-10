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
            <i class="fas fa-calendar-alt me-2"></i>Jadwal Piket Guru
        </h2>
        <?php if(auth()->user()->role === 'admin'): ?>
        <a href="<?php echo e(route('jadwal-piket.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Jadwal
        </a>
        <?php endif; ?>
    </div>

    <div class="card">
        <div class="card-body">
            <?php $__empty_1 = true; $__currentLoopData = $jadwalPiket; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $guruId => $jadwalList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="mb-4">
                <h5 class="text-primary mb-3">
                    <i class="fas fa-chalkboard-teacher me-2"></i><?php echo e($jadwalList->first()->guru->nama); ?>

                </h5>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Hari</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Semester</th>
                                <th>Tahun Ajaran</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $jadwalList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jadwal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($jadwal->hari_indo); ?></td>
                                <td><?php echo e($jadwal->jam_mulai ? $jadwal->jam_mulai->format('H:i') : '-'); ?></td>
                                <td><?php echo e($jadwal->jam_selesai ? $jadwal->jam_selesai->format('H:i') : '-'); ?></td>
                                <td><?php echo e($jadwal->semester); ?></td>
                                <td><?php echo e($jadwal->tahun_ajaran); ?></td>
                                <td>
                                    <?php if($jadwal->is_active): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Non-aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?php echo e(route('jadwal-piket.show', $jadwal)); ?>" class="btn btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php if(auth()->user()->role === 'admin'): ?>
                                        <a href="<?php echo e(route('jadwal-piket.edit', $jadwal)); ?>" class="btn btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('jadwal-piket.destroy', $jadwal)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus jadwal ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center py-4">
                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                <p class="text-muted">Belum ada jadwal piket</p>
                <?php if(auth()->user()->role === 'admin'): ?>
                <a href="<?php echo e(route('jadwal-piket.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Jadwal Pertama
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\website-sekolah\resources\views/jadwal-piket/index.blade.php ENDPATH**/ ?>