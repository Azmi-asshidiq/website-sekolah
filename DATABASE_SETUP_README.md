# Database Setup Guide for Website Sekolah

This guide will help you set up the complete database structure for your Laravel school management system.

## 📁 Files Created

1. **`create_database_tables.sql`** - Complete SQL script with all tables and sample data
2. **`setup_database.php`** - PHP script to execute the SQL setup
3. **`DATABASE_SETUP_README.md`** - This instruction file

## 🗄️ Database Tables Created

Based on your Laravel application features, the following tables will be created:

### Core Tables
- **`users`** - Authentication users (admin, guru, kepsek)
- **`siswa`** - Student information with QR code support
- **`guru`** - Teacher/staff information

### Academic Management
- **`pelanggaran`** - Student violations/infractions
- **`izin_keluar`** - Exit permits for students
- **`keterlambatan`** - Late arrival records
- **`piket`** - Daily duty assignments
- **`jadwal_piket`** - Duty schedule templates

### System Tables
- **`cache`** - Laravel cache
- **`jobs`** - Queue jobs
- **`failed_jobs`** - Failed queue jobs
- **`user_sessions`** - Custom session management

## 🚀 Quick Setup (Recommended)

### Option 1: Using PHP Setup Script
```bash
# Make sure Laragon is running
# Open terminal/command prompt in your project directory
cd c:\laragon\www\website-sekolah

# Run the setup script
php setup_database.php
```

### Option 2: Manual SQL Execution
```bash
# Using phpMyAdmin (via Laragon)
1. Open phpMyAdmin from Laragon interface
2. Create database: website_sekolah
3. Import file: create_database_tables.sql

# Using MySQL Command Line
mysql -u root -p website_sekolah < create_database_tables.sql
```

## 🔧 Configuration

### Database Configuration
Update your `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=website_sekolah
DB_USERNAME=root
DB_PASSWORD=
```

### Laravel Migration Sync
After database setup, run Laravel migrations:
```bash
php artisan migrate:fresh
```

## 👤 Sample Users Created

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@eduspace.com | password123 |
| Guru | guru@eduspace.com | password123 |
| Kepsek | kepsek@eduspace.com | password123 |

## 📊 Sample Data Included

- **5 Guru records** with various positions
- **10 Siswa records** across different classes
- **5 Pelanggaran records** with different violation types
- **3 Izin Keluar records** 
- **5 Keterlambatan records**
- **5 Jadwal Piket records** for weekly schedule
- **5 Piket assignments**

## 🎯 Features Supported

The database supports all features in your Laravel application:

### ✅ Student Management
- Student CRUD operations
- QR code generation for attendance
- Class and major tracking

### ✅ Teacher Management  
- Teacher profiles and positions
- Duty assignments
- Contact information

### ✅ Discipline System
- Violation tracking with points
- Sanctions management
- Monthly reports

### ✅ Attendance System
- Late arrival tracking
- Exit permit management
- Duty scheduling

### ✅ Reporting System
- Headmaster access to all reports
- Statistical summaries
- Monthly/annual reports

## 🔄 Next Steps

1. **Test the Application**
   ```bash
   php artisan serve
   # Visit: http://localhost:8000
   ```

2. **Login with Sample User**
   - Email: admin@eduspace.com
   - Password: password123

3. **Explore Features**
   - Add new students/guru
   - Create pelanggaran records
   - Manage izin keluar
   - View reports

## 🛠️ Troubleshooting

### Common Issues

**"Access denied for user 'root'@'localhost'"**
- Check MySQL credentials in setup script
- Ensure Laragon MySQL service is running

**"Database already exists"**
- The script handles this automatically
- Tables will be dropped and recreated

**"Laravel migration conflicts"**
- Run `php artisan migrate:fresh` after setup
- This ensures Laravel migrations are in sync

### Manual Database Reset
```sql
-- If you need to manually reset
DROP DATABASE IF EXISTS website_sekolah;
CREATE DATABASE website_sekolah;
-- Then run the setup script again
```

## 📞 Support

If you encounter issues:
1. Check Laragon services are running
2. Verify database credentials
3. Ensure file permissions are correct
4. Check Laravel .env configuration

## 🎉 Success Indicators

After successful setup, you should see:
- ✅ All 12 tables created
- ✅ Sample data populated
- ✅ Laravel application connects successfully
- ✅ Login works with sample users
- ✅ All features accessible based on user roles

---

**Ready to go!** Your school management system database is now complete with all necessary tables and sample data for testing.
