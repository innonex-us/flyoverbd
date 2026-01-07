# Deployment Checklist - MySQL Key Length Fix

## Files That Must Be Updated on Server

### Critical Files (Required):
1. **`database/migrations/0001_01_01_000000_create_users_table.php`**
   - Line 28 must have: `$table->string('email', 191)->primary();`
   - Line 36 must have: `$table->string('id', 191)->primary();`

2. **`database/migrations/0001_01_01_000001_create_cache_table.php`**
   - Line 16 must have: `$table->string('key', 191)->primary();`
   - Line 24 must have: `$table->string('key', 191)->primary();`

3. **`database/migrations/0001_01_01_000002_create_jobs_table.php`**
   - Line 28 must have: `$table->string('id', 191)->primary();`

4. **`app/Providers/AppServiceProvider.php`**
   - Must have: `Schema::defaultStringLength(191);` in the `boot()` method

## Verification Commands (Run on Server)

```bash
# Check password_reset_tokens migration
grep -n "string('email'" database/migrations/0001_01_01_000000_create_users_table.php
# Should show: 28:                $table->string('email', 191)->primary();

# Check AppServiceProvider
grep -A 2 "defaultStringLength" app/Providers/AppServiceProvider.php
# Should show: Schema::defaultStringLength(191);
```

## Deployment Steps

1. **Upload all updated migration files to server**
2. **Upload updated AppServiceProvider.php**
3. **Clear Laravel caches on server:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan route:clear
   php artisan view:clear
   ```
4. **Run migrations:**
   ```bash
   php artisan migrate --force
   ```

## If Migration Still Fails

If you still get the error after deploying, the server might have:
- Old cached migration files
- Different file permissions
- The migration table might need to be reset (if safe to do so)

**Last Resort - Manual Fix:**
If the migration file on server still doesn't work, you can manually edit it on the server:
- Find line with: `$table->string('email')->primary();`
- Change to: `$table->string('email', 191)->primary();`

