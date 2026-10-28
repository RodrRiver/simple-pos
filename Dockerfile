FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev libzip-dev libicu-dev \
    unzip git nodejs npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd zip intl bcmath pcntl sockets \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader

COPY package.json package-lock.json ./
RUN npm ci

COPY . .

RUN composer dump-autoload --optimize \
    && npm run build \
    && rm -rf node_modules

RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear

RUN mkdir -p storage/framework/{sessions,views,cache} \
    && mkdir -p storage/app/public \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 8080

CMD php artisan migrate --force --seed 2>/dev/null; php artisan storage:link 2>/dev/null; php artisan serve --host=0.0.0.0 --port=8080
