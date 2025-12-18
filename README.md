# Aplikasi Keuangan Chaste

Aplikasi web untuk mengelola dan melacak pengeluaran harian menggunakan Laravel, MySQL, dan Tailwind CSS.

## Fitur

- ✅ Tambah pengeluaran baru
- ✅ Daftar semua pengeluaran
- ✅ Edit pengeluaran
- ✅ Hapus pengeluaran
- ✅ Statistik total dan pengeluaran bulan ini
- ✅ Kategorisasi pengeluaran
- ✅ UI modern dengan Tailwind CSS

## Persyaratan

- PHP >= 8.1
- Composer
- MySQL
- Node.js & NPM (untuk Tailwind CSS)

## Instalasi

1. Install dependencies PHP:
```bash
composer install
```

2. Install dependencies Node.js:
```bash
npm install
```

3. Copy file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Konfigurasi database di file `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=keuangan_pajak_chaste
DB_USERNAME=root
DB_PASSWORD=
```

6. Buat database MySQL:
```sql
CREATE DATABASE keuangan_pajak_chaste;
```

7. Jalankan migrasi:
```bash
php artisan migrate
```

8. Build assets Tailwind CSS (untuk development):
```bash
npm run dev
```

Atau untuk production:
```bash
npm run build
```

## Menjalankan Aplikasi

1. Pastikan Vite dev server berjalan (jika development):
```bash
npm run dev
```

2. Di terminal lain, jalankan Laravel server:
```bash
php artisan serve
```

3. Buka browser di: http://localhost:8000

## Struktur Proyek

- `app/Models/Expense.php` - Model untuk pengeluaran
- `app/Http/Controllers/ExpenseController.php` - Controller untuk CRUD pengeluaran
- `database/migrations/` - Migration untuk tabel expenses
- `resources/views/expenses/` - View untuk halaman pengeluaran
- `routes/web.php` - Definisi routes

## Lisensi

MIT
