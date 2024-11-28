#!/bin/bash

# Composer bağımlılıklarını kur (ilk defa çalıştırıldığında)
if [ ! -d "vendor" ]; then
    composer install --no-interaction --optimize-autoloader
fi

# .env dosyasını kopyala, eğer mevcut değilse
if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate
fi


# Key generate işlemi sadece ilk başlatmada yapılır
if ! php artisan key:generate; then
    echo "Artisan key:generate failed!"
    exit 1
fi

# Uygulama başlatma işlemi
php artisan serve --host=0.0.0.0 --port=8080
