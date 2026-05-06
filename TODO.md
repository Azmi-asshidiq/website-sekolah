# TODO: Fix All Errors in Laravel School Website

## Plan Steps (Prioritized: Syntax → Config → DB → Test)

✅ **Step 1:** Fix syntax error in `app/Http/Controllers/PelanggaranController.php` (misaligned create call)

✅ **Step 2:** Fix duplicate 'default' key in `config/database.php`, set to MySQL

✅ **Step 3:** Added missing imports to SiswaController, DashboardController

✅ **Step 4:** Added routeKeyName & resolveRouteBinding to Siswa, Guru models

✅ **Step 5:** RoleMiddleware already registered in bootstrap/app.php ✓

✅ **Step 6:** Clearing caches (Windows shell compatible) 

✅ **Step 7:** `php artisan migrate:fresh --seed` executed ✓ (MySQL)

**Pending:**
- **Step 8:** Test routes: `/simple-test`, login, `/dashboard` 
- **Step 9:** Check `storage/logs/laravel.log`
- **Step 10:** Complete
- **Step 8:** Test routes: `/simple-test`, login, `/dashboard`
- **Step 9:** Check `storage/logs/laravel.log`, fix remaining issues
- **Step 10:** Complete with `attempt_completion`
- **Step 7:** `php artisan migrate:fresh --seed` (MySQL)
- **Step 8:** Test routes: `/simple-test`, login, `/dashboard`
- **Step 9:** Check `storage/logs/laravel.log`, fix remaining issues
- **Step 10:** Complete with `attempt_completion`
- **Step 5:** Verify/register RoleMiddleware in `bootstrap/app.php`
- **Step 6:** Run `php artisan config:clear && php artisan route:clear && php artisan view:clear`
- **Step 7:** `php artisan migrate:fresh --seed` (MySQL)
- **Step 8:** Test routes: `/simple-test`, login, `/dashboard`
- **Step 9:** Check `storage/logs/laravel.log`, fix remaining issues
- **Step 10:** Complete with `attempt_completion`

**Progress:** Starting syntax fixes...
