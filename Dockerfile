FROM php:7.4-fpm as builder

RUN apt-get update
RUN apt-get install -y git zlib1g-dev libpng-dev gnupg2 unzip


RUN curl -sL https://deb.nodesource.com/gpgkey/nodesource.gpg.key | apt-key add -
RUN sh -c "echo deb https://deb.nodesource.com/node_14.x groovy main > /etc/apt/sources.list.d/nodesource.list"

RUN apt-get update
RUN apt-get install -y nodejs

RUN cd /tmp \
 && curl -OL https://getcomposer.org/download/1.10.20/composer.phar \
 && mv composer.phar /usr/local/bin/composer \
 && chmod u+x /usr/local/bin/composer

RUN docker-php-ext-install gd \
 && docker-php-ext-install bcmath

COPY . /app

WORKDIR /app

RUN composer install

RUN npm install --global yarn
RUN yarn install
RUN yarn encore production

##################################

FROM php:7.4-fpm

RUN apt-get update
RUN apt-get install -y zlib1g-dev libpng-dev

RUN docker-php-ext-install gd \
 && docker-php-ext-install bcmath

COPY --from=builder /app /app

WORKDIR /var/www