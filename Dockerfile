FROM php:7.3.11
RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo 
WORKDIR /app
COPY . /app
RUN composer install

##environment variable in GCP, port number
CMD php artisan serve --port=8001 
EXPOSE 8001