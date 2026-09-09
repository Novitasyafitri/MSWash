FROM php:8.2-apache

# Install ekstensi yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Salin semua file proyek
COPY . /var/www/html

# Masuk ke direktori kerja
WORKDIR /var/www/html

# Install dependensi Laravel (vendor)
RUN composer install --no-dev --optimize-autoloader

# Atur perizinan folder storage dan bootstrap
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Arahkan Apache DocumentRoot ke folder public Laravel
# Arahkan Apache DocumentRoot ke folder public Laravel dan izinkan rewrite .htaccess
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -s 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -s 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
RUN a2enmod rewrite
EXPOSE 80
CMD ["apache2-foreground"]