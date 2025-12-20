# Checklist Upload ke Server

## ⚠️ PENTING: File yang HARUS Di-upload

### 1. Build Assets DULU (Wajib!)
```bash
npm run build
```
Ini menghasilkan folder `public/build/` yang **HARUS** di-upload!

### 2. File yang WAJIB di-upload ke server:

#### Folder & File Utama:
- ✅ `app/` (seluruh folder)
- ✅ `bootstrap/` (seluruh folder)
- ✅ `config/` (seluruh folder)
- ✅ `database/` (seluruh folder)
- ✅ `public/` (seluruh folder termasuk):
  - ✅ `public/.htaccess` ← **SANGAT PENTING!**
  - ✅ `public/index.php` ← **SANGAT PENTING!**
  - ✅ `public/build/` ← **SANGAT PENTING! Folder ini hasil dari npm run build**
- ✅ `resources/` (seluruh folder)
- ✅ `routes/` (seluruh folder)
- ✅ `storage/` (folder harus ada, bisa kosong)
- ✅ `vendor/` (seluruh folder - hasil composer install)
- ✅ `artisan`
- ✅ `composer.json`
- ✅ `.env` (edit sesuai server, jangan upload .env.example)
- ✅ `.gitignore`

#### File Build (HASIL npm run build):
```
public/build/
├── manifest.json          ← WAJIB!
└── assets/
    ├── app-9d4ed367.css  ← WAJIB!
    └── app-db6683bb.js   ← WAJIB!
```

### 3. File yang TIDAK perlu di-upload:
- ❌ `node_modules/`
- ❌ `.git/`
- ❌ `.env.example`
- ❌ `storage/logs/*` (tapi folder `storage/logs/` harus ada)

## Setup di Server

Setelah upload, jalankan di server:

```bash
# 1. Set permissions
chmod -R 755 storage bootstrap/cache
chmod -R 755 public

# 2. Edit .env (jika belum)
# Set:
APP_ENV=production
APP_DEBUG=false
APP_URL=https://laporankeuangan.chastegemilangmandiri.shop

# 3. Generate key (jika belum)
php artisan key:generate

# 4. Install dependencies (jika belum upload vendor/)
composer install --no-dev --optimize-autoloader

# 5. Run migrations
php artisan migrate --force

# 6. Clear semua cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear
```

## Troubleshooting CSS Tidak Muncul

Jika CSS masih tidak muncul:

1. **Cek apakah public/build/ ada di server:**
   ```bash
   ls -la public/build/assets/
   ```
   Harus ada file `.css` di sana

2. **Cek .htaccess ada:**
   ```bash
   ls -la public/.htaccess
   ```

3. **Cek manifest.json:**
   ```bash
   cat public/build/manifest.json
   ```

4. **Cek di browser:**
   - Buka Developer Tools (F12)
   - Tab Network
   - Refresh halaman
   - Cek apakah file CSS/JS return 404
   - Jika 404, berarti file tidak ada atau path salah

5. **Rebuild assets lagi:**
   ```bash
   npm run build
   # Upload lagi folder public/build/ ke server
   ```
