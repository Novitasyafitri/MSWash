#!/bin/bash
set -e

# Jalankan migrasi dan seeder ke TiDB/MySQL
php artisan migrate --force
php artisan db:seed --force

# Nyalakan web server Apache
exec apache2-foreground