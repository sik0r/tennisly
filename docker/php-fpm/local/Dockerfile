FROM php:8.1-fpm
ARG TIMEZONE

RUN apt-get update && apt-get install -y git unzip openssl procps acl zlib1g-dev \
	wget zip cron gnupg gnupg2 \
	ca-certificates apt-transport-https \
        libfreetype6-dev \
        libjpeg62-turbo-dev libpng-dev  \
        libxml2-dev libzip-dev libonig-dev libxslt-dev libpq-dev

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set php.ini
COPY php-ini-overrides.ini $PHP_INI_DIR/conf.d/99-overrides.ini

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone
RUN printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini

# Install nodejs, npm
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get update && apt-get install -y nodejs

#Add jpeg support to GD
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Install extensions
RUN docker-php-ext-install pdo pgsql pdo_pgsql mysqli bcmath soap mbstring zip gd bcmath gettext xml xsl intl

# Install xdebug
#RUN pecl install xdebug \
#    && docker-php-ext-enable xdebug

## Install supervisor
#RUN apt-get install -y supervisor
#COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

## Install cron
#ADD crontab.ini /crontab.ini
#RUN apt-get install -y cron
#RUN crontab -u www-data -i /crontab.ini
