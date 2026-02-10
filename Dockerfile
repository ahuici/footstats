FROM php:8.2-apache

# Instalar extensiones necesarias para MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilitar mod_rewrite si lo necesitas
RUN a2enmod rewrite

# Copiar el código al DocumentRoot
COPY . /var/www/html

# Establecer el directorio de trabajo
WORKDIR /var/www/html
