<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meja Piket - Login System</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #8b5cf6;
            --success-color: #10b981;
            --info-color: #06b6d4;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --light-color: #f8fafc;
            --dark-color: #1e293b;
            --gradient-primary: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            --gradient-secondary: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4c1d95 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
        }
        
        .login-container {
            width: 100%;
            max-width: 1000px;
            display: flex;
            background: white;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            min-height: 550px;
        }
        
        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            position: relative;
        }
        
        .login-left::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.05" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
        }
        
        .login-right {
            flex: 1;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .main-logo {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            animation: float 3s ease-in-out infinite;
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
        }
        
        .main-logo i {
            font-size: 3rem;
            color: white;
        }
        
        
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        
        .login-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.8rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .login-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            line-height: 1.5;
            font-weight: 400;
        }
        
        .key-features {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.8rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .feature-item:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
        }
        
        .feature-item i {
            font-size: 1.2rem;
            color: white;
            width: 24px;
            text-align: center;
        }
        
        .feature-item span {
            color: white;
            font-weight: 500;
            font-size: 0.95rem;
        }
        
        .form-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }
        
        .form-subtitle {
            color: var(--secondary-color);
            margin-bottom: 1.5rem;
            font-weight: 400;
            font-size: 0.95rem;
        }
        
        .form-floating {
            margin-bottom: 1.2rem;
        }
        
        .form-control {
            border: 1.5px solid #e9ecef;
            border-radius: 12px;
            padding: 0.8rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            height: auto;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.15rem rgba(78, 115, 223, 0.2);
        }
        
        .form-floating > label {
            padding: 0.8rem;
        }
        
        .btn-login {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 40px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(102, 126, 234, 0.3);
            width: 100%;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .alert {
            border: none;
            border-radius: 8px;
            padding: 0.8rem;
            margin-bottom: 1.2rem;
            font-size: 0.9rem;
        }
        
        .alert-danger {
            background: rgba(231, 74, 59, 0.1);
            color: var(--danger-color);
            border: 1px solid rgba(231, 74, 59, 0.2);
        }
        
        .alert-success {
            background: rgba(28, 200, 138, 0.1);
            color: var(--success-color);
            border: 1px solid rgba(28, 200, 138, 0.2);
        }
        
        .input-error {
            color: var(--danger-color);
            font-size: 0.8rem;
            margin-top: 0.4rem;
        }
        
        .social-links {
            display: flex;
            justify-content: center;
            gap: 0.8rem;
            margin-top: 0.8rem;
        }
        
        .social-link {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(0, 123, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0077B5;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 123, 255, 0.2);
            font-size: 0.9rem;
        }
        
        .social-link:hover {
            background: #0077B5;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }
        
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .login-container {
                flex-direction: column;
                max-width: 450px;
                margin: 1rem;
                min-height: auto;
            }
            
            .login-left {
                padding: 1.5rem;
                min-height: auto;
            }
            
            .login-right {
                padding: 1.5rem;
            }
            
            .login-title-wrapper {
                gap: 8px;
            }
            
            .title-logo {
                width: 38px;
                height: 38px;
            }
            
            .title-logo i {
                font-size: 1.5rem;
            }
            
            .login-title {
                font-size: 1.8rem;
            }
            
            .main-logo {
                width: 80px;
                height: 80px;
            }
            
            .main-logo i {
                font-size: 2.5rem;
            }
            
            .login-title {
                font-size: 2rem;
            }
            
            .feature-item {
                padding: 0.6rem;
            }
            
            .feature-item i {
                font-size: 1.1rem;
            }
            
            .feature-item span {
                font-size: 0.9rem;
            }
        }
        
        @media (max-width: 576px) {
            .login-container {
                margin: 0.5rem;
                border-radius: 12px;
            }
            
            .login-left, .login-right {
                padding: 1.2rem;
            }
            
            .login-title-wrapper {
                gap: 6px;
            }
            
            .title-logo {
                width: 32px;
                height: 32px;
            }
            
            .title-logo i {
                font-size: 1.2rem;
            }
            
            .login-title {
                font-size: 1.5rem;
            }
            
            .form-title {
                font-size: 1.4rem;
            }
            
            .form-subtitle {
                font-size: 0.9rem;
            }
            
            .main-logo {
                width: 70px;
                height: 70px;
            }
            
            .main-logo i {
                font-size: 2rem;
            }
            
            .login-title {
                font-size: 1.8rem;
            }
            
            .login-subtitle {
                font-size: 0.9rem;
                margin-bottom: 1.5rem;
            }
            
            .feature-item {
                padding: 0.5rem;
                gap: 0.8rem;
            }
            
            .feature-item i {
                font-size: 1rem;
                width: 20px;
            }
            
            .feature-item span {
                font-size: 0.85rem;
            }
            
            
            .form-control {
                font-size: 0.9rem;
                padding: 0.7rem;
            }
            
            .btn-login {
                padding: 0.7rem 1.2rem;
                font-size: 0.95rem;
            }
        }
        
        @media (max-width: 400px) {
            .login-left, .login-right {
                padding: 1rem;
            }
            
            .login-title {
                font-size: 1.3rem;
            }
            
            .main-logo {
                width: 60px;
                height: 60px;
            }
            
            .main-logo i {
                font-size: 1.8rem;
            }
            
            .login-title {
                font-size: 1.6rem;
            }
            
            .login-subtitle {
                font-size: 0.85rem;
                margin-bottom: 1.2rem;
            }
            
            .feature-item {
                padding: 0.4rem;
                gap: 0.6rem;
            }
            
            .feature-item i {
                font-size: 0.9rem;
                width: 18px;
            }
            
            .feature-item span {
                font-size: 0.8rem;
            }
            
            .form-title {
                font-size: 1.2rem;
            }
            
            
            .social-link {
                width: 28px;
                height: 28px;
                font-size: 0.8rem;
            }
        }
        
        /* Icon Styling */
        .main-logo i, .feature-item i {
            font-style: normal;
            font-weight: normal;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Left Side - Branding -->
        <div class="login-left">
            <!-- Main Logo -->
            <div class="main-logo">
                <i class="fas fa-calendar-check"></i>
            </div>
            
            <h1 class="login-title">Meja Piket</h1>
            <p class="login-subtitle">
                Sistem Manajemen Jadwal Piket SMKN 1 Ciomas
            </p>
            
            <!-- Key Features -->
            <div class="key-features">
                <div class="feature-item">
                    <i class="fas fa-clock"></i>
                    <span>Jadwal Otomatis</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-users"></i>
                    <span>Manajemen Guru</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Presensi Digital</span>
                </div>
            </div>
        </div>
        
        <!-- Right Side - Login Form -->
        <div class="login-right">
            <!-- Session Status -->
            <?php if(session('status')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>
            
            <h2 class="form-title">Selamat Datang!</h2>
            <p class="form-subtitle">Silakan masuk ke akun Anda untuk melanjutkan</p>
            
            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>
                
                <!-- Email Address -->
                <div class="form-floating">
                    <input type="email" 
                           class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="email" 
                           name="email" 
                           value="<?php echo e(old('email')); ?>" 
                           placeholder="name@example.com" 
                           required 
                           autofocus 
                           autocomplete="username">
                    <label for="email">Email Address</label>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="input-error">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            <?php echo e($message); ?>

                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Password -->
                <div class="form-floating">
                    <input type="password" 
                           class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="password" 
                           name="password" 
                           placeholder="Password" 
                           required 
                           autocomplete="current-password">
                    <label for="password">Password</label>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="input-error">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            <?php echo e($message); ?>

                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Remember Me -->
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                    <label class="form-check-label" for="remember_me">
                        Ingat saya
                    </label>
                </div>

                <!-- Login Button -->
                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Masuk
                </button>
            </form>
            
            <div class="text-center mt-3">
                <small class="text-muted">
                    © 2024 Meja Piket. System SMKN 1 Ciomas
                </small>
                <div class="social-links mt-2">
                    <a href="https://id.linkedin.com/school/smkn1ciomas/" target="_blank" class="social-link" title="SMKN 1 Ciomas LinkedIn">
                        <i class="fab fa-linkedin"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Debug Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('=== LOGIN DEBUG ===');
            console.log('Current URL:', window.location.href);
            console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'));
            
            // Add form submit debugging
            const loginForm = document.querySelector('form[action="<?php echo e(route('login')); ?>"]');
            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    console.log('Form submitted');
                    console.log('Email:', document.getElementById('email').value);
                    console.log('Action:', this.action);
                });
            }
        });
    </script>
</body>
</html><?php /**PATH C:\laragon\www\website-sekolah\resources\views/auth/login.blade.php ENDPATH**/ ?>