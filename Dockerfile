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
RUN docker-php-ext-install pdo pdo_mysql bcmath zip

# Install Redis PHP extension
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:2.6.5 /usr/bin/composer /usr/local/bin/composer

# Copy composer.json and composer.lock to workdir & install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Copy other project files
COPY . .

# Expose port 9000 (if needed for PHP-FPM, uncomment if necessary)
# EXPOSE 9000

# Set the default command to run php-fpm
CMD ["php-fpm"]
