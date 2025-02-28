# Menggunakan image PHP resmi dengan Apache
FROM php:8.3-apache

# Mengaktifkan mod_rewrite untuk Apache
RUN a2enmod rewrite

# Install dependencies seperti ekstensi PHP yang diperlukan
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd pdo pdo_mysql

# Mengatur direktori kerja
WORKDIR /var/www/html

# Copy composer.phar ke dalam container
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install composer dependencies
COPY . /var/www/html
RUN composer install --no-dev --optimize-autoloader
# RUN php artisan migrate

# Mengatur volume untuk folder storage dan bootstrap/cache Laravel
VOLUME ["/var/www/html/storage", "/var/www/html/bootstrap/cache"]

# Set permission folder untuk storage dan cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache