#!/bin/bash

# Jalankan migrasi ulang secara bersih, atau abaikan jika tabel sudah ada
php artisan migrate:fresh --force || php artisan migrate --force

# Masukkan data awal / akun pengguna
php artisan db:seed --force

# Jalankan web server Apache
exec apache2-foreground