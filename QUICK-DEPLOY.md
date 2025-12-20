# 🚀 Quick Deploy ke Hostinger - Langkah Cepat

## ✅ Yang Sudah Ada:
- Domain
- .env sudah di-set

---

## 📝 Langkah-langkah (Copy-Paste Ready):

### 1️⃣ Upload File ke Server

**Via Git (RECOMMENDED):**
```bash
# Di server via SSH
cd ~/domains/laporankeuangan.chastegemilangmandiri.shop/public_html
git clone https://github.com/gabrielleantoinette/keuanganpajakchaste.git .
```

**Atau upload manual via File Manager** (semua file kecuali `node_modules/` dan `.env`)

---

### 2️⃣ Install Composer Dependencies

```bash
# Di server via SSH
composer install --no-dev --optimize-autoloader
```

---

### 3️⃣ Build Assets di LOCAL

```bash
# Di komputer lokal kamu
cd /Applications/XAMPP/xamppfiles/htdocs/KeuanganPajakChaste
npm install
npm run build
```

---

### 4️⃣ Upload Folder `public/build/` ke Server

Via File Manager, upload folder `public/build/` (dari local) ke `public_html/public/build/`

---

### 5️⃣ Set Permission & Clear Cache

```bash
# Di server via SSH
chmod -R 755 storage bootstrap/cache public
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan migrate --force
```

---

## ✅ Selesai! Buka website di browser.

---

## ⚠️ Checklist File Penting:

- [ ] `.htaccess` di root (redirect ke public/)
- [ ] `.htaccess` di `public/` (Laravel routing)
- [ ] `public/index.php`
- [ ] Folder `vendor/` (hasil composer install)
- [ ] Folder `public/build/` (hasil npm run build + upload)
- [ ] `.env` dengan konfigurasi benar

---

## 🔧 Jika Error:

**Error 500:**
- Cek: `tail -n 100 storage/logs/laravel.log`
- Enable debug: Set `APP_DEBUG=true` di `.env`

**CSS/JS tidak muncul:**
- Pastikan folder `public/build/` sudah di-upload
- Clear cache browser (Ctrl+F5)
