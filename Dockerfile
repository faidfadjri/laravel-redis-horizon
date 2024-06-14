# Use PHP 8.2
FROM php:8.2.11-fpm

# Set the working directory
WORKDIR /var/www/app

# Install important libraries and tools
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    apt-utils \
    build-essential \
    git \
    curl \
    libcurl4 \
    libcurl4-openssl-dev \
    zlib1g-dev \
    libzip-dev \
    zip \
    unzip \
    libbz2-dev \
    locales \
    libmcrypt-dev \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    redis-tools \
    nano \
    wget \
    dialog \
    vim && \
    rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql bcmath zip pcntl

# Install Redis PHP extension
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:2.6.5 /usr/bin/composer /usr/local/bin/composer

# Copy all files
COPY . .

# Set permissions for Laravel storage and bootstrap cache
RUN chown -R www-data:www-data /var/www/app/storage \
    && chown -R www-data:www-data /var/www/app/bootstrap/cache \
    && chmod -R 775 /var/www/app/storage \
    && chmod -R 775 /var/www/app/bootstrap 

RUN composer install

# Set the default command to run php-fpm
CMD ["php-fpm"]
