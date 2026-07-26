FROM php:8.3-cli


RUN apt-get update \
    && apt-get install -y unzip git \
    && docker-php-ext-install pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . /app


RUN cp config.example.php config.php


RUN composer install --no-dev --optimize-autoloader


RUN chmod -R 777 templates_c

EXPOSE 80


CMD ["php", "-S", "0.0.0.0:80", "-t", "public", "public/index.php"]
