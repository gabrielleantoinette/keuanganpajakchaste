# Fix untuk Hosting yang Document Root Bukan Folder Public

## Masalah:
Hosting biasanya document root langsung ke folder project, bukan ke `public/`. Laravel memerlukan document root mengarah ke folder `public/`.

## Solusi untuk Hostinger:

### Opsi 1: Buat .htaccess di Root (RECOMMENDED)

Buat file `.htaccess` di **root directory** (satu level di atas `public/`) dengan isi:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

Ini akan mengarahkan semua request ke folder `public/`.

### Opsi 2: Ubah Document Root (jika bisa)

Di cPanel Hostinger, ubah document root ke folder `public_html/public` (jika ada opsi ini).

## File .htaccess yang Harus Ada:

### 1. `.htaccess` di ROOT (untuk redirect ke public/)
**Path:** `/public_html/.htaccess`
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

### 2. `.htaccess` di PUBLIC (untuk Laravel routing)
**Path:** `/public_html/public/.htaccess`
```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

## Checklist:

- [ ] File `.htaccess` ada di ROOT (untuk redirect)
- [ ] File `.htaccess` ada di `public/` (untuk Laravel routing)
- [ ] File `public/index.php` ada
- [ ] Folder `vendor/` ada
- [ ] File `.env` sudah dikonfigurasi dengan benar
- [ ] Permission storage dan bootstrap/cache sudah benar (755)
