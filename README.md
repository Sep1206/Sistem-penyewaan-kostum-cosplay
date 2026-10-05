# Sistem Penyewaan Kostum Cosplay

Aplikasi web penyewaan kostum cosplay berbasis Laravel 12 (SQLite).

## Fitur
- **Admin**: CRUD kostum, aksesoris, customer, dan jadwal penyewaan (stok otomatis berkurang saat status "disewa" dan kembali saat dikembalikan/dihapus).
- **Customer**: daftar/login, melihat katalog, memesan kostum, melihat "Pesanan Saya" (menunggu persetujuan admin).
- Total harga dihitung di server: harga sewa × jumlah hari.

## Instalasi
```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite      # Windows: type nul > database\database.sqlite
php artisan migrate:fresh --seed
npm run build                       # atau: npm run dev
php artisan serve
```

## Akun demo
| Role     | Email                 | Password |
|----------|-----------------------|----------|
| Admin    | admin@cosplay.test    | password |
| Customer | customer@cosplay.test | password |

## Test
```bash
php artisan test
```
