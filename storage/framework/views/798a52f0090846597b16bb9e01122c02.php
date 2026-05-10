<?php $__env->startSection('content'); ?>
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
                        <div class="user-name"><?php echo e(auth()->user()->name); ?></div>
                        <div class="user-role">
                            <?php if(auth()->user()->role === 'admin'): ?>
                                Administrator
                            <?php elseif(auth()->user()->role === 'kepsek'): ?>
                                Kepala Sekolah
                            <?php else: ?>
                                Guru Piket
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="page-content">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Dashboard</h1>
                <p class="page-subtitle">Selamat datang di sistem manajemen sekolah Eduspace</p>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value"><?php echo e($totalSiswa); ?></div>
                        <div class="stat-label">Total Siswa</div>
                        <div class="stat-trend positive">
                            <i class="fas fa-arrow-up"></i>
                            <span>+12%</span>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon success">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value"><?php echo e($totalGuru); ?></div>
                        <div class="stat-label">Total Guru</div>
                        <div class="stat-trend positive">
                            <i class="fas fa-arrow-up"></i>
                            <span>+5%</span>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon warning">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value"><?php echo e($totalPiket); ?></div>
                        <div class="stat-label">Jadwal Piket</div>
                        <div class="stat-trend neutral">
                            <i class="fas fa-minus"></i>
                            <span>0%</span>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon danger">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value"><?php echo e($totalKeterlambatan); ?></div>
                        <div class="stat-label">Keterlambatan</div>
                        <div class="stat-trend negative">
                            <i class="fas fa-arrow-down"></i>
                            <span>-8%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="charts-section">
                <h3 class="section-title">
                    <i class="fas fa-chart-line"></i>
                    Analitik Data
                </h3>
                <div class="charts-grid">
                    <!-- Line Chart -->
                    <div class="chart-card">
                        <div class="chart-header">
                            <h4>Trend Kehadiran</h4>
                            <div class="chart-controls">
                                <select class="form-select form-select-sm">
                                    <option>7 Hari Terakhir</option>
                                    <option>30 Hari Terakhir</option>
                                    <option>3 Bulan Terakhir</option>
                                </select>
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="attendanceChart" width="400" height="200"></canvas>
                        </div>
                    </div>

                    <!-- Bar Chart -->
                    <div class="chart-card">
                        <div class="chart-header">
                            <h4>Distribusi Pelanggaran</h4>
                            <div class="chart-controls">
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="violationChart" width="400" height="200"></canvas>
                        </div>
                    </div>

                    <!-- Pie Chart -->
                    <div class="chart-card">
                        <div class="chart-header">
                            <h4>Kategori Pelanggaran</h4>
                            <div class="chart-controls">
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-sync"></i>
                                </button>
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="categoryChart" width="400" height="200"></canvas>
                        </div>
                    </div>

                    <!-- Progress Chart -->
                    <div class="chart-card">
                        <div class="chart-header">
                            <h4>Progress Bulanan</h4>
                            <div class="chart-controls">
                                <span class="badge bg-success">+12%</span>
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="progressChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="content-grid">
                <!-- Quick Actions -->
                <div class="quick-actions">
                    <h3 class="section-title">
                        <i class="fas fa-bolt"></i>
                        Aksi Cepat
                    </h3>
                    <div class="action-grid">
                        <?php $__currentLoopData = $roleBasedData['quickActions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($action['route'] !== 'dashboard'): ?>
                        <a href="<?php echo e(route($action['route'])); ?>" class="action-item">
                            <div class="action-icon">
                                <i class="<?php echo e($action['icon']); ?>"></i>
                            </div>
                            <div class="action-content">
                                <h4><?php echo e($action['title']); ?></h4>
                                <p><?php echo e($action['description']); ?></p>
                            </div>
                        </a>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="recent-activities">
                    <h3 class="section-title">
                        <i class="fas fa-history"></i>
                        Aktivitas Terkini
                    </h3>
                    <div class="activity-list">
                        <?php if($recentIzin->count() > 0): ?>
                            <?php $__currentLoopData = $recentIzin->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $izin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="activity-item">
                                <div class="activity-icon success">
                                    <i class="fas fa-sign-out-alt"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title"><?php echo e($izin->siswa->nama); ?> - Izin Keluar</div>
                                    <div class="activity-meta"><?php echo e($izin->tanggal); ?> pukul <?php echo e($izin->waktu); ?></div>
                                </div>
                                <div class="activity-time"><?php echo e($izin->created_at->diffForHumans()); ?></div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="activity-item">
                                <div class="activity-icon info">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">Tidak ada izin keluar hari ini</div>
                                    <div class="activity-meta">Semua siswa hadir tepat waktu</div>
                                </div>
                                <div class="activity-time">Sekarang</div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if($recentKeterlambatan->count() > 0): ?>
                            <?php $__currentLoopData = $recentKeterlambatan->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keterlambatan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="activity-item">
                                <div class="activity-icon danger">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title"><?php echo e($keterlambatan->siswa->nama); ?> - Terlambat</div>
                                    <div class="activity-meta"><?php echo e($keterlambatan->durasi); ?> menit</div>
                                </div>
                                <div class="activity-time"><?php echo e($keterlambatan->created_at->diffForHumans()); ?></div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="activity-item">
                                <div class="activity-icon success">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">Tidak ada keterlambatan hari ini</div>
                                    <div class="activity-meta">Semua siswa hadir tepat waktu</div>
                                </div>
                                <div class="activity-time">Sekarang</div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Modern Purple-Blue Dashboard Styles -->
<style>
/* Enhanced CSS Variables */
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --accent-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --primary-color: #667eea;
    --secondary-color: #764ba2;
    --accent-color: #4facfe;
    --purple-dark: #5a67d8;
    --blue-light: #63b3ed;
    --card-shadow: 0 10px 30px rgba(102, 126, 234, 0.15);
    --card-shadow-hover: 0 20px 40px rgba(102, 126, 234, 0.25);
    --border-color: rgba(102, 126, 234, 0.1);
    --text-primary: #2d3748;
    --text-secondary: #718096;
    --bg-light: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
    --success-color: #48bb78;
    --warning-color: #ed8936;
    --danger-color: #f56565;
    --info-color: #4299e1;
    --glass-bg: rgba(255, 255, 255, 0.9);
    --glass-border: rgba(255, 255, 255, 0.2);
}

/* Dashboard Content Container */
.dashboard-content {
    padding: 0;
    margin: 0;
    background: transparent;
    min-height: 100vh;
    position: relative;
    width: 100%;
    max-width: 100%;
    overflow-x: hidden;
}

/* Enhanced Background Animation */
.dashboard-content::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 80%, rgba(102, 126, 234, 0.12) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(118, 75, 162, 0.12) 0%, transparent 50%),
        radial-gradient(circle at 40% 40%, rgba(79, 172, 254, 0.08) 0%, transparent 50%),
        linear-gradient(135deg, rgba(248, 250, 252, 0.9) 0%, rgba(241, 245, 249, 0.9) 100%);
    pointer-events: none;
    z-index: -1;
    animation: backgroundShift 20s ease-in-out infinite;
}

@keyframes backgroundShift {
    0%, 100% { transform: scale(1) rotate(0deg); }
    50% { transform: scale(1.05) rotate(1deg); }
}

/* Enhanced Top Header */
.top-header {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    padding: 1.5rem 2rem;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08), 0 2px 10px rgba(0, 0, 0, 0.05);
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    position: relative;
    z-index: 10;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    animation: slideDown 0.8s ease-out;
}

.top-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.02), rgba(118, 75, 162, 0.02));
    border-radius: 20px;
    z-index: -1;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Enhanced Search Bar */
.search-bar {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border: 2px solid rgba(102, 126, 234, 0.1);
    border-radius: 16px;
    padding: 0.875rem 1.25rem;
    display: flex;
    align-items: center;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.12);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    width: 400px;
    position: relative;
    overflow: hidden;
}

.search-bar::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: var(--primary-gradient);
    transition: left 0.6s ease;
    z-index: -1;
}

.search-bar:focus-within {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1), var(--card-shadow-hover);
    transform: translateY(-2px);
    width: 380px;
}

.search-bar:focus-within::before {
    left: 0;
}

.search-bar i {
    color: var(--primary-color);
    font-size: 16px;
    transition: all 0.3s ease;
}

.search-bar:focus-within i {
    color: white;
    transform: scale(1.1);
}

.search-input {
    border: none;
    background: none;
    outline: none;
    width: 100%;
    font-size: 15px;
    color: var(--text-primary);
    font-weight: 500;
    margin-left: 10px;
    transition: all 0.3s ease;
}

.search-bar:focus-within .search-input {
    color: white;
}

/* Header Actions */
.header-actions {
    display: flex;
    align-items: center;
    gap: 25px;
}

/* Modern Notification Bell */
.notification-bell {
    position: relative;
    cursor: pointer;
    color: var(--primary-color);
    font-size: 20px;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    padding: 12px;
    border-radius: 15px;
    background: rgba(102, 126, 234, 0.1);
    backdrop-filter: blur(10px);
}

.notification-bell:hover {
    background: var(--primary-gradient);
    color: white;
    transform: translateY(-3px) scale(1.1);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
}

.notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: var(--secondary-gradient);
    color: white;
    font-size: 10px;
    font-weight: 700;
    padding: 4px 8px;
    border-radius: 20px;
    animation: pulse 2s infinite;
    box-shadow: 0 4px 10px rgba(245, 87, 108, 0.4);
}

/* Modern User Profile */
.user-profile {
    display: flex;
    align-items: center;
    cursor: pointer;
    padding: 12px 20px;
    border-radius: 20px;
    background: var(--glass-bg);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border: 1px solid var(--glass-border);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    overflow: hidden;
}

.user-profile::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: var(--primary-gradient);
    transition: left 0.6s ease;
    z-index: 0;
}

.user-profile:hover {
    transform: translateY(-3px);
    box-shadow: var(--card-shadow-hover);
    border-color: var(--primary-color);
}

.user-profile:hover::before {
    left: 0;
}

.user-profile:hover .user-avatar,
.user-profile:hover .user-name,
.user-profile:hover .user-role {
    color: white;
}

.user-avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: var(--primary-gradient);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 18px;
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    position: relative;
    z-index: 2;
    transition: all 0.3s ease;
    border: 3px solid rgba(255, 255, 255, 0.3);
}

.user-avatar:hover {
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 12px 30px rgba(102, 126, 234, 0.4);
}

.user-info {
    text-align: right;
    margin-left: 15px;
    position: relative;
    z-index: 2;
}

.user-name {
    font-size: 16px;
    font-weight: 700;
    margin: 0 0 4px 0;
    color: var(--text-primary);
    transition: all 0.3s ease;
}

.user-role {
    font-size: 13px;
    color: var(--text-secondary);
    background: rgba(102, 126, 234, 0.1);
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 1px solid rgba(102, 126, 234, 0.2);
}

/* Modern Page Content */
.page-content {
    padding: 0;
    animation: fadeInUp 0.8s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.page-header {
    margin-bottom: 50px;
    text-align: center;
    position: relative;
}

.page-title {
    font-size: 42px;
    font-weight: 800;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0 0 20px 0;
    text-shadow: 0 4px 8px rgba(102, 126, 234, 0.2);
    letter-spacing: -1px;
    animation: titleGlow 3s ease-in-out infinite alternate;
}

@keyframes titleGlow {
    from {
        filter: brightness(1);
    }
    to {
        filter: brightness(1.2);
    }
}

.page-subtitle {
    color: var(--text-secondary);
    font-size: 20px;
    margin: 0 0 10px 0;
    font-weight: 500;
    opacity: 0.8;
}

/* Enhanced Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2.5rem;
}

/* Enhanced Stat Cards */
.stat-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 20px;
    padding: 2rem 1.5rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08), 0 2px 10px rgba(0, 0, 0, 0.05);
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    text-align: center;
    cursor: pointer;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.02), rgba(118, 75, 162, 0.02));
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: -1;
}

.stat-card:hover::before {
    opacity: 1;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--primary-gradient);
    border-radius: 24px;
    opacity: 0;
    transition: all 0.6s ease;
    z-index: 0;
}

.stat-card::after {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    animation: float 6s ease-in-out infinite;
    z-index: 1;
}

@keyframes float {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    50% { transform: translate(-20px, -20px) rotate(180deg); }
}

.stat-card:hover {
    box-shadow: var(--card-shadow-hover);
    transform: translateY(-8px) scale(1.02);
    border-color: var(--primary-color);
}

.stat-card:hover::before {
    opacity: 0.1;
}

/* Enhanced Stat Icon */
.stat-icon {
    width: 70px;
    height: 70px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 28px;
    color: white;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    position: relative;
    z-index: 3;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 3px solid rgba(255, 255, 255, 0.3);
}

.stat-icon.primary { 
    background: var(--primary-gradient);
    box-shadow: 0 12px 24px rgba(102, 126, 234, 0.4);
}

.stat-icon.success { 
    background: linear-gradient(135deg, #48bb78, #38a169);
    box-shadow: 0 12px 24px rgba(72, 187, 120, 0.4);
}

.stat-icon.warning { 
    background: linear-gradient(135deg, #ed8936, #dd6b20);
    box-shadow: 0 12px 24px rgba(237, 137, 54, 0.4);
}

.stat-icon.danger { 
    background: linear-gradient(135deg, #f56565, #e53e3e);
    box-shadow: 0 12px 24px rgba(245, 101, 101, 0.4);
}

.stat-card:hover .stat-icon {
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 16px 32px rgba(0, 0, 0, 0.3);
}

.stat-content {
    text-align: center;
    position: relative;
    z-index: 3;
}

.stat-value {
    font-size: 42px;
    font-weight: 800;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0 0 10px 0;
    line-height: 1;
    transition: all 0.3s ease;
}

.stat-card:hover .stat-value {
    transform: scale(1.05);
}

.stat-label {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-secondary);
    margin: 0 0 15px 0;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    opacity: 0.8;
}

/* Modern Stat Trend */
.stat-trend {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.stat-trend::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.2);
    transition: left 0.5s ease;
}

.stat-trend:hover::before {
    left: 100%;
}

.stat-trend.positive {
    color: white;
    background: linear-gradient(135deg, #48bb78, #38a169);
    box-shadow: 0 4px 12px rgba(72, 187, 120, 0.3);
}

.stat-trend.negative {
    color: white;
    background: linear-gradient(135deg, #f56565, #e53e3e);
    box-shadow: 0 4px 12px rgba(245, 101, 101, 0.3);
}

.stat-trend.neutral {
    color: white;
    background: linear-gradient(135deg, #718096, #4a5568);
    box-shadow: 0 4px 12px rgba(113, 128, 150, 0.3);
}

.stat-trend:hover {
    transform: translateY(-2px) scale(1.05);
}

/* Charts Section */
.charts-section {
    margin-bottom: 40px;
}

.charts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
    margin-bottom: 40px;
}

.chart-card {
    background: var(--glass-bg);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid var(--glass-border);
    border-radius: 20px;
    padding: 25px;
    box-shadow: var(--card-shadow);
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
}

.chart-card:hover {
    box-shadow: var(--card-shadow-hover);
    transform: translateY(-5px);
    border-color: var(--primary-color);
}

.chart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.chart-header h4 {
    font-size: 16px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}

.chart-controls {
    display: flex;
    gap: 8px;
    align-items: center;
}

.chart-container {
    position: relative;
    height: 200px;
    width: 100%;
}

.chart-container canvas {
    width: 100% !important;
    height: 100% !important;
    max-height: 200px;
}

/* Modern Content Grid */
.content-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 40px;
    margin-bottom: 50px;
}

/* Enhanced Quick Actions */
.quick-actions {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08), 0 2px 10px rgba(0, 0, 0, 0.05);
    position: relative;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.quick-actions::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(79, 172, 254, 0.02), rgba(0, 242, 254, 0.02));
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: -1;
}

.quick-actions:hover::before {
    opacity: 1;
}

.quick-actions::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: var(--accent-gradient);
    opacity: 0.05;
    transition: left 0.8s ease;
    z-index: 1;
}

.quick-actions:hover::before {
    left: 100%;
}

.quick-actions:hover {
    box-shadow: var(--card-shadow-hover);
    transform: translateY(-5px);
    border-color: var(--accent-color);
}

/* Modern Section Title */
.section-title {
    font-size: 24px;
    font-weight: 700;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0 0 25px 0;
    display: flex;
    align-items: center;
    gap: 12px;
    position: relative;
    z-index: 3;
}

.section-title i {
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-size: 22px;
}

/* Modern Action Grid */
.action-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
}

/* Modern Action Item */
.action-item {
    background: var(--glass-bg);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border: 1px solid var(--glass-border);
    border-radius: 20px;
    padding: 25px;
    text-decoration: none;
    color: var(--text-primary);
    transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    cursor: pointer;
}

.action-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: var(--accent-gradient);
    opacity: 0.1;
    transition: left 0.6s ease;
    z-index: 1;
}

.action-item:hover {
    border-color: var(--accent-color);
    background: var(--glass-bg);
    transform: translateY(-6px) scale(1.02);
    box-shadow: var(--card-shadow-hover);
}

.action-item:hover::before {
    left: 100%;
}

/* Modern Action Icon */
.action-icon {
    width: 65px;
    height: 65px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--primary-gradient);
    color: white;
    font-size: 20px;
    margin-right: 20px;
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    position: relative;
    z-index: 3;
    transition: all 0.4s ease;
    border: 3px solid rgba(255, 255, 255, 0.2);
}

.action-item:hover .action-icon {
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 12px 30px rgba(102, 126, 234, 0.4);
}

.action-content {
    flex: 1;
    position: relative;
    z-index: 3;
}

.action-content h4 {
    font-size: 18px;
    font-weight: 700;
    margin: 0 0 6px 0;
    color: var(--text-primary);
    transition: all 0.3s ease;
}

.action-content p {
    font-size: 14px;
    color: var(--text-secondary);
    margin: 0;
    line-height: 1.5;
    font-weight: 500;
}

.action-item:hover .action-content h4 {
    color: var(--primary-color);
    transform: translateX(3px);
}

/* Enhanced Recent Activities */
.recent-activities {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08), 0 2px 10px rgba(0, 0, 0, 0.05);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.recent-activities::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.02), rgba(118, 75, 162, 0.02));
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: -1;
}

.recent-activities:hover::before {
    opacity: 1;
}

.recent-activities:hover {
    box-shadow: var(--card-shadow-hover);
    transform: translateY(-5px);
}

.activity-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* Enhanced Activity Item */
.activity-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    position: relative;
    overflow: hidden;
}

.activity-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.03), rgba(118, 75, 162, 0.03));
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: -1;
}

.activity-item:hover::before {
    opacity: 1;
}

.activity-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: var(--primary-gradient);
    opacity: 0.05;
    transition: left 0.6s ease;
    z-index: 1;
}

.activity-item:hover {
    background: var(--glass-bg);
    border-color: var(--primary-color);
    transform: translateX(10px) scale(1.02);
    box-shadow: var(--card-shadow-hover);
}

.activity-item:hover::before {
    left: 100%;
}

/* Enhanced Activity Icon */
.activity-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
    position: relative;
    z-index: 3;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 3px solid rgba(255, 255, 255, 0.4);
}

.activity-icon.success { 
    background: linear-gradient(135deg, #48bb78, #38a169);
    color: white;
    box-shadow: 0 6px 16px rgba(72, 187, 120, 0.3);
}

.activity-icon.danger { 
    background: linear-gradient(135deg, #f56565, #e53e3e);
    color: white;
    box-shadow: 0 6px 16px rgba(245, 101, 101, 0.3);
}

.activity-icon.info { 
    background: var(--accent-gradient);
    color: white;
    box-shadow: 0 6px 16px rgba(79, 172, 254, 0.3);
}

.activity-item:hover .activity-icon {
    transform: scale(1.1) rotate(5deg);
}

.activity-content {
    flex: 1;
    position: relative;
    z-index: 3;
}

.activity-title {
    font-size: 16px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 6px 0;
    transition: all 0.3s ease;
}

.activity-meta {
    font-size: 14px;
    color: var(--text-secondary);
    margin: 0;
    line-height: 1.5;
    font-weight: 500;
}

.activity-item:hover .activity-title {
    color: var(--primary-color);
    transform: translateX(3px);
}

.activity-time {
    font-size: 13px;
    color: var(--text-secondary);
    margin: 0;
    font-weight: 600;
    background: rgba(102, 126, 234, 0.1);
    padding: 4px 10px;
    border-radius: 12px;
    border: 1px solid rgba(102, 126, 234, 0.2);
    transition: all 0.3s ease;
}

.activity-item:hover .activity-time {
    background: var(--primary-gradient);
    color: white;
    border-color: transparent;
}

/* Enhanced Pulse Animation */
@keyframes pulse {
    0%, 100% {
        transform: scale(1);
        opacity: 1;
        box-shadow: 0 4px 10px rgba(245, 87, 108, 0.4);
    }
    50% {
        transform: scale(1.15);
        opacity: 0.9;
        box-shadow: 0 8px 20px rgba(245, 87, 108, 0.6);
    }
}


/* Modern Responsive Design */
@media (max-width: 1200px) {
    .content-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
    }
    
    .page-title {
        font-size: 36px;
    }
}

@media (max-width: 768px) {
    .dashboard-content {
        padding: 0;
    }
    
    .top-header {
        padding: 15px 20px;
        flex-direction: column;
        gap: 15px;
        border-radius: 15px;
        margin-bottom: 20px;
    }
    
    .search-bar {
        width: 100%;
        padding: 12px 20px;
        border-radius: 12px;
    }
    
    .search-bar:focus-within {
        width: 100%;
    }
    
    .header-actions {
        width: 100%;
        justify-content: space-between;
    }
    
    .user-info {
        display: none;
    }
    
    .page-title {
        font-size: 24px;
    }
    
    .page-subtitle {
        font-size: 14px;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
        gap: 15px;
        margin-bottom: 25px;
    }
    
    .stat-card {
        padding: 20px;
        border-radius: 15px;
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        font-size: 20px;
    }
    
    .stat-value {
        font-size: 28px;
    }
    
    .charts-grid {
        grid-template-columns: 1fr;
        gap: 15px;
        margin-bottom: 25px;
    }
    
    .chart-card {
        padding: 20px;
        border-radius: 15px;
    }
    
    .chart-container {
        height: 150px;
    }
    
    .chart-header h4 {
        font-size: 14px;
    }
    
    .content-grid {
        grid-template-columns: 1fr;
        gap: 20px;
        margin-bottom: 25px;
    }
    
    .quick-actions, .recent-activities {
        padding: 20px;
        border-radius: 15px;
    }
    
    .action-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .action-item {
        padding: 15px;
        border-radius: 12px;
    }
    
    .action-icon {
        width: 40px;
        height: 40px;
        font-size: 16px;
        margin-right: 12px;
    }
    
    .activity-item {
        padding: 15px;
        gap: 12px;
        border-radius: 12px;
    }
    
    .activity-icon {
        width: 40px;
        height: 40px;
        font-size: 14px;
    }
    
    .section-title {
        font-size: 18px;
        margin-bottom: 15px;
    }
}
</style>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- JavaScript -->
<script>
// Real-time clock
function updateClock() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('id-ID', { 
        hour: '2-digit', 
        minute: '2-digit' 
    });
    const dateString = now.toLocaleDateString('id-ID', { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    });
    
    const timeElement = document.getElementById('currentTime');
    const dateElement = document.getElementById('currentDate');
    
    if (timeElement) timeElement.textContent = timeString;
    if (dateElement) dateElement.textContent = dateString;
}

updateClock();
setInterval(updateClock, 1000);

// Initialize Charts
function initCharts() {
    // Attendance Trend Chart
    const attendanceCtx = document.getElementById('attendanceChart');
    if (attendanceCtx) {
        new Chart(attendanceCtx, {
            type: 'line',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [{
                    label: 'Hadir',
                    data: [95, 92, 98, 94, 96, 85, 90],
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Terlambat',
                    data: [5, 8, 2, 6, 4, 15, 10],
                    borderColor: '#f56565',
                    backgroundColor: 'rgba(245, 101, 101, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            boxWidth: 12,
                            padding: 10,
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            }
        });
    }

    // Violation Distribution Chart
    const violationCtx = document.getElementById('violationChart');
    if (violationCtx) {
        new Chart(violationCtx, {
            type: 'bar',
            data: {
                labels: ['Kelas X', 'Kelas XI', 'Kelas XII'],
                datasets: [{
                    label: 'Pelanggaran Ringan',
                    data: [12, 19, 8],
                    backgroundColor: '#48bb78'
                }, {
                    label: 'Pelanggaran Sedang',
                    data: [8, 11, 6],
                    backgroundColor: '#ed8936'
                }, {
                    label: 'Pelanggaran Berat',
                    data: [2, 3, 1],
                    backgroundColor: '#f56565'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            boxWidth: 12,
                            padding: 10,
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            }
        });
    }

    // Category Chart
    const categoryCtx = document.getElementById('categoryChart');
    if (categoryCtx) {
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Kedisiplinan', 'Kerapian', 'Sopan Santun', 'Lainnya'],
                datasets: [{
                    data: [35, 25, 30, 10],
                    backgroundColor: [
                        '#667eea',
                        '#48bb78',
                        '#ed8936',
                        '#718096'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 8,
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            }
        });
    }

    // Progress Chart
    const progressCtx = document.getElementById('progressChart');
    if (progressCtx) {
        new Chart(progressCtx, {
            type: 'radar',
            data: {
                labels: ['Hadir', 'Disiplin', 'Kerapian', 'Sopan', 'Prestasi'],
                datasets: [{
                    label: 'Bulan Ini',
                    data: [85, 78, 92, 88, 76],
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.2)',
                    pointBackgroundColor: '#667eea',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: '#667eea'
                }, {
                    label: 'Bulan Lalu',
                    data: [78, 82, 85, 82, 70],
                    borderColor: '#48bb78',
                    backgroundColor: 'rgba(72, 187, 120, 0.2)',
                    pointBackgroundColor: '#48bb78',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: '#48bb78'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            boxWidth: 12,
                            padding: 10,
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                scales: {
                    r: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            stepSize: 20,
                            font: {
                                size: 9
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        pointLabels: {
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            }
        });
    }
}

// Initialize charts when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initCharts();
});

// Search functionality
document.querySelector('.search-input')?.addEventListener('keyup', function(e) {
    const searchValue = e.target.value.toLowerCase();
    // Implement search functionality here
    console.log('Searching for:', searchValue);
});

// Notification click
document.querySelector('.notification-bell')?.addEventListener('click', function() {
    // Implement notification panel here
    console.log('Notification clicked');
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\website-sekolah\resources\views/dashboard.blade.php ENDPATH**/ ?>