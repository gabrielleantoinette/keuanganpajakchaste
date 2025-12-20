# Deploy ke Hostinger dari Awal - Step by Step

## ✅ Yang Sudah Ada:
- ✅ Domain sudah di-set
- ✅ .env sudah di-set dengan APP_KEY dan database

## 📋 Langkah-langkah Deploy:

### STEP 1: Upload File ke Server

**Via File Manager Hostinger atau Git:**

#### Opsi A: Via Git (RECOMMENDED)
```bash
# Di server via SSH
cd ~/domains/laporankeuangan.chastegemilangmandiri.shop/public_html

# Clone repository
git clone https://github.com/gabrielleantoinette/keuanganpajakchaste.git .

# Atau jika sudah ada folder, pull saja
git pull origin main
```

#### Opsi B: Via File Manager
Upload semua file dan folder ke `public_html/` kecuali:
- ❌ `node_modules/` (jangan upload)
- ❌ `.env` (sudah ada di server)
- ✅ Upload semua file lainnya

---

### STEP 2: Pastikan File Penting Ada

Di server, pastikan file/folder ini ada:

**Di ROOT (`public_html/`):**
- ✅ `.htaccess` (untuk redirect ke public/)
- ✅ `.env` (sudah ada, dengan konfigurasi benar)
- ✅ `artisan`
- ✅ `composer.json`
- ✅ Folder `app/`, `bootstrap/`, `config/`, `database/`, `public/`, `resources/`, `routes/`, `storage/`

**Di `public/`:**
- ✅ `.htaccess` (Laravel routing)
- ✅ `index.php`

---

### STEP 3: Install Composer Dependencies

```bash
# Di server via SSH
cd ~/domains/laporankeuangan.chastegemilangmandiri.shop/public_html

# Install dependencies
composer install --no-dev --optimize-autoloader
```

Tunggu sampai selesai (biasanya 2-5 menit).

---

### STEP 4: Build Assets di LOCAL

**Di komputer lokal kamu:**

```bash
# Pastikan di folder project
cd /Applications/XAMPP/xamppfiles/htdocs/KeuanganPajakChaste

# Install npm dependencies (jika belum)
npm install

# Build assets untuk production
npm run build
```

Ini akan membuat folder `public/build/` dengan file CSS dan JS.

---

### STEP 5: Upload Folder `public/build/` ke Server

**Via File Manager Hostinger:**

1. Buka File Manager
2. Masuk ke folder `public_html/public/`
3. Upload folder `build/` (dari local `public/build/`)

Pastikan strukturnya:
```
public_html/public/build/
├── assets/
│   ├── app-xxxxxxxx.css
│   └── app-xxxxxxxx.js
└── manifest.json
```

---

### STEP 6: Set Permission

```bash
# Di server via SSH
cd ~/domains/laporankeuangan.chastegemilangmandiri.shop/public_html

# Set permission untuk storage dan cache
chmod -R 755 storage bootstrap/cache
chmod -R 755 public

# Pastikan folder storage dan bootstrap/cache writable
chmod -R 775 storage bootstrap/cache
```

---

### STEP 7: Clear Cache

```bash
# Di server via SSH
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear
```

---

### STEP 8: Run Migration (Jika Perlu)

```bash
# Di server via SSH
php artisan migrate --force
```

**PENTING:** `--force` diperlukan karena APP_ENV=production.

---

### STEP 9: Test

1. Buka browser: `https://laporankeuangan.chastegemilangmandiri.shop`
2. Seharusnya muncul halaman login
3. Jika error, cek langkah troubleshooting di bawah

---

## 🔧 Troubleshooting

### Error 500 Internal Server Error

1. **Enable debug mode sementara:**
   Edit `.env`, ubah:
   ```
   APP_DEBUG=true
   APP_ENV=local
   ```
   Refresh browser untuk lihat error detail.

2. **Cek error log:**
   ```bash
   tail -n 100 storage/logs/laravel.log
   ```

3. **Cek apakah vendor/ ada:**
   ```bash
   ls -la vendor/
   ```
   Jika tidak ada, jalankan: `composer install --no-dev --optimize-autoloader`

4. **Cek permission:**
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```

### Error 403 Forbidden

1. **Pastikan .htaccess ada:**
   - Di root: `.htaccess` (redirect ke public/)
   - Di public: `public/.htaccess` (Laravel routing)

2. **Cek permission:**
   ```bash
   chmod 644 .htaccess
   chmod 644 public/.htaccess
   ```

### CSS/JS Tidak Muncul

1. **Pastikan folder `public/build/` ada dan lengkap:**
   ```bash
   ls -la public/build/
   ```

2. **Pastikan sudah build di local dan upload ke server**

3. **Clear cache browser (Ctrl+F5 atau Cmd+Shift+R)**

---

## ✅ Checklist Final

- [ ] Semua file ter-upload ke server
- [ ] Folder `vendor/` ada (hasil composer install)
- [ ] Folder `public/build/` ada dan lengkap
- [ ] File `.htaccess` ada di root dan `public/`
- [ ] File `.env` sudah dikonfigurasi dengan benar
- [ ] Permission `storage/` dan `bootstrap/cache/` sudah benar (755 atau 775)
- [ ] Cache sudah di-clear
- [ ] Migration sudah di-run (jika perlu)
- [ ] Website bisa diakses di browser

---

## 🚀 Quick Command Summary (Copy-Paste)

```bash
# Di server via SSH - Jalankan semua ini:
cd ~/domains/laporankeuangan.chastegemilangmandiri.shop/public_html

# Install dependencies
composer install --no-dev --optimize-autoloader

# Set permission
chmod -R 755 storage bootstrap/cache public

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Migration (jika perlu)
php artisan migrate --force

# Test
php artisan route:list
```

---

## 📝 Catatan Penting:

1. **NPM tidak tersedia di Hostinger** - Build assets harus di LOCAL, lalu upload folder `public/build/`
2. **.env tidak boleh di-upload ke Git** - Pastikan sudah ada di server dengan konfigurasi benar
3. **Storage dan cache harus writable** - Set permission 755 atau 775
4. **Setelah deploy, set APP_DEBUG=false** di `.env` untuk production

---

Selesai! Website kamu seharusnya sudah bisa diakses. 🎉
