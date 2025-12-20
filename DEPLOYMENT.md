# Panduan Deployment ke Production

## Langkah-langkah Deploy ke Hosting

### 1. Build Assets untuk Production
```bash
# Pastikan Node.js dan npm sudah terinstall
npm install
npm run build
```

Ini akan menghasilkan file di `public/build/` yang berisi:
- `manifest.json`
- `assets/app-*.css`
- `assets/app-*.js`

### 2. Upload File ke Server
Upload semua file ke server **KECUALI**:
- `node_modules/`
- `.git/`
- `.env.example`
- `storage/logs/*` (tapi folder harus ada)

**PASTIKAN upload:**
- ✅ `public/build/` (folder dan semua isinya)
- ✅ `public/.htaccess`
- ✅ `public/index.php`
- ✅ `vendor/`
- ✅ Semua file lainnya

### 3. Setup di Server

#### a. Set Permissions
```bash
chmod -R 755 storage bootstrap/cache
chmod -R 755 public
```

#### b. Copy .env
```bash
cp .env.example .env
# Edit .env dengan konfigurasi server
```

#### c. Generate Key
```bash
php artisan key:generate
```

#### d. Setup Database
Edit `.env`:
```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://laporankeuangan.chastegemilangmandiri.shop

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=nama_database_server
DB_USERNAME=username_server
DB_PASSWORD=password_server
```

#### e. Run Migrations
```bash
php artisan migrate --force
```

#### f. Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### 4. Pastikan .htaccess Ada

File `public/.htaccess` harus ada untuk routing Laravel. Jika tidak ada, buat dengan isi seperti yang ada di repository.

### 5. Troubleshooting CSS Tidak Muncul

Jika CSS tidak muncul di production:

1. **Cek apakah assets sudah di-build:**
   ```bash
   ls -la public/build/assets/
   ```
   Harus ada file `.css` dan `.js`

2. **Pastikan APP_ENV=production di .env**

3. **Clear cache lagi:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

4. **Cek permission:**
   ```bash
   chmod -R 755 public/build
   ```

5. **Cek di browser console** apakah ada error 404 untuk file CSS/JS

6. **Cek manifest.json** ada di `public/build/manifest.json`

### 6. Struktur Folder yang Harus Ada

```
/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
│   ├── .htaccess          ← PENTING!
│   ├── index.php          ← PENTING!
│   ├── build/             ← PENTING! (hasil npm run build)
│   │   ├── manifest.json
│   │   └── assets/
│   │       ├── app-*.css
│   │       └── app-*.js
│   ├── favicon.svg
│   └── robots.txt
├── resources/
├── routes/
├── storage/               ← Harus writable (chmod 755)
├── vendor/                ← PENTING! (hasil composer install)
├── .env                   ← PENTING! (konfigurasi server)
├── artisan
└── composer.json
```

## Quick Checklist

- [ ] `npm run build` sudah dijalankan
- [ ] Folder `public/build/` di-upload ke server
- [ ] File `public/.htaccess` ada
- [ ] File `public/index.php` ada
- [ ] Folder `vendor/` di-upload (atau `composer install` di server)
- [ ] File `.env` sudah dikonfigurasi
- [ ] `APP_ENV=production` di .env
- [ ] `php artisan key:generate` sudah dijalankan
- [ ] `php artisan migrate` sudah dijalankan
- [ ] Permissions sudah benar (storage dan bootstrap/cache)
- [ ] Cache sudah di-clear
