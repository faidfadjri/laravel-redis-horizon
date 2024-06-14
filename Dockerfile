# Use PHP 8.2
FROM php:8.2-fpm

# Install common php extension dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    docker-php-ext-install mysqli pdo pdo_mysql


# Set the working directory
WORKDIR /var/www/app

# Copy composer.json and composer.lock separately to leverage Docker cache
COPY composer.json composer.lock ./

# Install composer dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-scripts --no-autoloader

# Copy the rest of the application code
COPY . .

# Run composer with full optimizations
RUN composer dump-autoload --no-scripts --no-dev --optimize

# Set the default command to run php-fpm
CMD ["php-fpm"]
