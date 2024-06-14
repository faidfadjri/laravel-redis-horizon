# use PHP 8.2
FROM php:8.2.11-fpm

RUN docker-php-ext-install pdo pdo_mysql

# Update package manager and install useful tools
RUN apt-get update && apt-get -y install apt-utils nano wget dialog vim

# Install important libraries
RUN echo "Install important libraries"
RUN apt-get -y install --fix-missing \
    apt-utils \
    build-essential \
    git \
    curl \
    libcurl4 \
    libcurl4-openssl-dev \
    zlib1g-dev \
    libzip-dev \
    zip \
    libbz2-dev \
    locales \
    libmcrypt-dev \
    libicu-dev \
    libonig-dev \
    libxml2-dev

# Clean up
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Set the working directory
COPY . /var/www/app
WORKDIR /var/www/app

# install composer
COPY --from=composer:2.6.5 /usr/bin/composer /usr/local/bin/composer

# copy composer.json to workdir & install dependencies
COPY composer.json composer.lock ./
RUN composer install


EXPOSE 9000

# Set the default command to run php-fpm
CMD ["php-fpm"]
