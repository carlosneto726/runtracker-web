FROM php:8.3-fpm AS app

ARG user=username
ARG uid=1000

WORKDIR /var/www

RUN chmod -R 777 .

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    supervisor \
    nginx \
    build-essential \
    libaio1 \
    nano

# Node
RUN apt-get update && apt-get install -y \
    software-properties-common \
    npm

RUN npm install -g n && \
    n latest && \
    npm install -g npm@11

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

COPY ["package.json", "package-lock.json", "/var/www/"]
RUN npm install

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

COPY composer.json composer.lock ./
COPY --chmod=0777 . .
RUN composer update
RUN composer install
RUN php artisan key:generate \
    && php artisan jwt:secret \
    && npm run build


RUN chown -R $uid:$uid /var/www

EXPOSE 9000
CMD ["php-fpm"]

# Nginx
FROM nginx:latest AS nginx

COPY docker/nginx/laravel.conf /etc/nginx/conf.d/default.conf

COPY --from=app /var/www /var/www

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
