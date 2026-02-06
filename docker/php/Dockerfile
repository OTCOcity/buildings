FROM php:7.1-apache

# --- Fix EOL Debian repos (buster) for old PHP images ---
RUN set -eux; \
  sed -i 's|http://deb.debian.org/debian|http://archive.debian.org/debian|g' /etc/apt/sources.list; \
  sed -i 's|http://security.debian.org/debian-security|http://archive.debian.org/debian-security|g' /etc/apt/sources.list; \
  sed -i '/buster-updates/d' /etc/apt/sources.list; \
  echo 'Acquire::Check-Valid-Until "false";' > /etc/apt/apt.conf.d/99no-check-valid-until; \
  echo 'Acquire::AllowInsecureRepositories "true";' > /etc/apt/apt.conf.d/99allow-insecure; \
  echo 'Acquire::AllowDowngradeToInsecureRepositories "true";' >> /etc/apt/apt.conf.d/99allow-insecure

# ------------------------------------------------
# System libraries
# ------------------------------------------------
RUN apt-get -o Acquire::Check-Valid-Until=false update && apt-get install -y --no-install-recommends \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    libxml2-dev \
    libmagickwand-dev \
    git \
    unzip \
  && rm -rf /var/lib/apt/lists/*

# ------------------------------------------------
# PHP core extensions
# ------------------------------------------------
RUN docker-php-ext-configure gd \
      --with-freetype-dir=/usr/include/ \
      --with-jpeg-dir=/usr/include/ \
  && docker-php-ext-install \
      gd \
      pdo \
      pdo_mysql \
      mysqli \
      mbstring \
      intl \
      zip \
      exif \
      bcmath \
      opcache

# ------------------------------------------------
# Imagick (через PECL)
# ------------------------------------------------
RUN pecl install imagick \
  && docker-php-ext-enable imagick

# ------------------------------------------------
# Xdebug 2.9.x (последний для PHP 7.1)
# ------------------------------------------------
RUN pecl install xdebug-2.9.8 \
  && docker-php-ext-enable xdebug

# Composer 1.7.2 ...
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
 && php composer-setup.php --version=1.7.2 --install-dir=/usr/local/bin --filename=composer \
 && php -r "unlink('composer-setup.php');" \
 && composer --version

COPY apache.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

COPY php.ini /usr/local/etc/php/conf.d/99-custom.ini

WORKDIR /var/www/app