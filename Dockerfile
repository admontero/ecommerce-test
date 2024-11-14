FROM php:8.2-fpm

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    libzip-dev \
    libonig-dev \
    libicu-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl intl

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    libonig5 \
    && rm -rf /var/lib/apt/lists/*

RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/*

WORKDIR /var/www

COPY . /var/www

EXPOSE 9000

CMD ["php-fpm"]
