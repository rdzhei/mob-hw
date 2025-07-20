FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git

RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash
RUN apt install symfony-cli

WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www/html

EXPOSE 80