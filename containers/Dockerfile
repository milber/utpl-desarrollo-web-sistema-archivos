FROM php:8.3-apache

# 1. Instalar y activar la extensión mysqli
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# 2. Habilitar los módulos necesarios de Apache
RUN a2enmod headers rewrite

# 3. Modificar la directiva AllowOverride para que el .htaccess funcione de forma segura
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Exponer el puerto por defecto de Apache
EXPOSE 80