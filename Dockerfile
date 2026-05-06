FROM kevinfelipe/php74-oci8-mysql

# Corregir el DocumentRoot (esta imagen parece apuntar a /public por defecto)
ENV APACHE_DOCUMENT_ROOT /var/www/html
RUN sed -ri -e 's!/var/www/html/public!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html/public!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install gd zip bcmath mysqli pdo pdo_mysql

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Asegurar AllowOverride All para .htaccess
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Configurar PHP
RUN echo "short_open_tag = On" > /usr/local/etc/php/conf.d/docker-php-short-tags.ini

# Copiar el código
COPY . /var/www/html/

# Permisos
RUN chown -R www-data:www-data /var/www/html/

EXPOSE 80

CMD ["apache2-foreground"]
