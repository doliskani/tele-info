# Accepted values: 8.1 - 8.0
ARG PHP_VERSION=8.1

###########################################
# PHP dependencies
###########################################

FROM registry.toopmarket.com/public/composer as vendor
WORKDIR /var/www/html
COPY . .
RUN composer install \
  --no-dev \
  --no-interaction \
  --prefer-dist \
  --ignore-platform-reqs \
  --optimize-autoloader \
  --apcu-autoloader \
  --ansi \
  --no-scripts

###########################################
FROM registry.toopmarket.com/public/php-base:${PHP_VERSION}-apache

COPY --chown=php-user:php-user . .
COPY --chown=php-user:php-user --from=vendor /var/www/html/vendor vendor

RUN mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache &&\
  find /var/www/html -type f -exec chmod 664 {} \; &&\
  find /var/www/html -type d -exec chmod 775 {} \; &&\
  chmod -R 777 storage bootstrap/cache 

EXPOSE 80
