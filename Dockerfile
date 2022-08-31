FROM sander0542/laravel:9-php-8.1

#COPY .docker/root/ /

COPY --chown=www:www-data . /var/www
RUN chmod -R ug+w /var/www/storage

RUN composer install --no-interaction --no-dev --no-progress --no-suggest --optimize-autoloader

RUN npm ci && npm run build
