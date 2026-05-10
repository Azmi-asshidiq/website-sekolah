# Emergency Fix for Memory & Performance Issues

## 🚨 Current Issues:
- Out of memory errors
- Paging file too small
- Execution timeout (30s)
- MySQL connection refused

## 🛠️ Immediate Actions Required:

### 1. Restart Laragon Completely
```
1. Open Laragon
2. Click "Stop All"
3. Wait 10 seconds
4. Click "Start All"
5. Wait for all services to start (green)
```

### 2. Clear All Laravel Caches (Manual)
Delete these folders manually:
- `storage/framework/cache/` (delete all files inside)
- `storage/framework/views/` (delete all files inside)
- `bootstrap/cache/` (delete all files inside)

### 3. Check Services Status
In Laragon, ensure these are GREEN:
- Apache/Nginx
- MySQL
- Redis (if used)

### 4. Test Simple Database Connection
Open: `http://localhost/website-sekolah/show_db_simple.php`

### 5. If Still Failing - Use Alternative
Open: `http://localhost/website-sekolah/fix_memory_issue.php`

## 🎯 Quick Test Checklist:
- [ ] Laragon services running (all green)
- [ ] Can access phpMyAdmin
- [ ] Database `sekolah_db` exists
- [ ] Users table has 3 records
- [ ] Siswa table has 10 records
- [ ] Can login with admin@eduspace.com / password123

## 📱 Alternative Access Points:
- Database Viewer: `show_db_simple.php`
- User Management: `create_user_manual.php`
- Memory Fix: `fix_memory_issue.php`
- Login Test: `verify_login.php`

## 🔧 If Database Issues:
1. Open phpMyAdmin: http://localhost/phpmyadmin
2. Login: root / root
3. Create database: `sekolah_db`
4. Import: `database_sekolah_baru.sql`

## 🚀 Final Test:
After all fixes, try:
- http://127.0.0.1:8000/login
- Email: admin@eduspace.com
- Password: password123

---
**Follow these steps in order for best results!**
