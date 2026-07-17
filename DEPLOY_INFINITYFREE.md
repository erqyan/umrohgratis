# ============================================
# Panduan Deploy Laravel ke InfinityFree
# ============================================

## Persiapan di Lokal

### 1. Generate APP_KEY (jika belum)
```bash
cd ~/umroh/sutech
php artisan key:generate
```

### 2. Build Frontend Assets
```bash
npm install
npm run build
```

### 3. Install lftp (untuk upload FTP)
```bash
sudo apt install lftp -y
```

### 4. Jalankan Deploy Script
```bash
./deploy-infinityfree.sh <FTP_PASSWORD_ANDA>
```

---

## Struktur Folder di InfinityFree

```
/                          ← Root server
├── .htaccess              ← Redirect ke htdocs
├── .env                   ← Environment variables
├── app/                   ← Laravel app
├── bootstrap/
├── config/
├── database/
├── resources/
├── routes/
├── storage/
│   └── app/
│       └── public/        ← File uploads (bukti, foto, dll)
├── vendor/
├── artisan
├── composer.json
├── composer.lock
└── htdocs/                ← Web Root (public Laravel)
    ├── .htaccess
    ├── index.php
    ├── build/
    ├── assets/
    ├── css/
    ├── js/
    └── images/
```

---

## Upload Manual dengan FileZilla

### 1. Install FileZilla
```bash
sudo apt install filezilla -y
```

### 2. Koneksi FTP
- **Host:** ftpupload.net
- **Port:** 21
- **User:** if0_42427373
- **Password:** (password akun InfinityFree)
- **Protocol:** FTP
- **Encryption:** Use plain FTP

### 3. Upload Files

**Panel Kiri (Local):** `~/umroh/sutech/`
**Panel Kanan (Remote):** `/`

#### Upload ke Root Server:
```
app/
bootstrap/
config/
database/
resources/
routes/
storage/
vendor/
artisan
composer.json
composer.lock
.htaccess
.env
```

#### Upload ke htdocs/:
```
public/ → htdocs/
```

---

## Edit index.php

Setelah upload, edit `htdocs/index.php`:

Ganti:
```php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
```

Menjadi:
```php
require __DIR__.'/../../vendor/autoload.php';
$app = require_once __DIR__.'/../../bootstrap/app.php';
```

---

## Environment Variables (.env)

Buat file `.env` di root server dengan isi:

```env
APP_NAME=SmartUmrah
APP_ENV=production
APP_KEY=your-app-key-here
APP_DEBUG=false
APP_URL=http://umroh.infinityfreeapp.com

APP_LOCALE=id
APP_FALLBACK_LOCALE=id
APP_FAKER_LOCALE=id_ID

DB_CONNECTION=pgsql
DB_HOST=aws-1-ap-northeast-2.pooler.supabase.com
DB_PORT=6543
DB_DATABASE=postgres
DB_USERNAME=postgres.asppwcdlfkjfgnexzkej
DB_PASSWORD=your-database-password-here
DB_SSLMODE=require

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

FILESYSTEM_DISK=local
QUEUE_CONNECTION=database
CACHE_STORE=database

MAIL_MAILER=log
MAIL_FROM_ADDRESS="no-reply@umroh.infinityfreeapp.com"
MAIL_FROM_NAME="${APP_NAME}"

SUPABASE_URL=https://asppwcdlfkjfgnexzkej.supabase.co
SUPABASE_PUBLISHABLE_KEY=sb_publishable_t_8zMgAB-ymVKuy7kEy1rQ_14kDV5fa
SUPABASE_SECRET_KEY=your-supabase-secret-key-here
```

---

## Troubleshooting

### Error 500
- Cek file `.env` ada di root server
- Cek permission folder `storage/` (755 atau 777)
- Cek `APP_KEY` sudah terisi

### CSS/JS tidak muncul
- Pastikan folder `public/build/` di-upload ke `htdocs/build/`
- Jalankan `npm run build` dulu sebelum upload

### Database Error
- Pastikan `DB_SSLMODE=require` di `.env`
- Cek koneksi ke Supabase dari panel MySQL Databases

### Session Error
- Pastikan tabel `sessions` ada di database Supabase
- Cek `SESSION_DRIVER=database` di `.env`
