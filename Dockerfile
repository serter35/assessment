# PHP'nin belirli bir sürümünü kullanıyoruz.
FROM php:8.2-fpm

# Gerekli sistem paketlerini yükle
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    git \
    unzip \
    netcat-openbsd \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# PHP Redis uzantısını yükle
RUN pecl install redis && docker-php-ext-enable redis

# Composer'ı kur
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Çalışma dizinini belirle
WORKDIR /var/www/html

# Laravel projenizi container'a kopyalayın
COPY . .

# Laravel için izinleri ayarla
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 8080 portunu aç
EXPOSE 8080

# entrypoint.sh dosyasını kopyala ve çalıştırılabilir hale getir
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# entrypoint olarak kullan
ENTRYPOINT ["sh", "/usr/local/bin/entrypoint.sh"]
