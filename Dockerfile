FROM kevinfelipe/php74-oci8-mysql

# Corregir el DocumentRoot (esta imagen parece apuntar a /public por defecto)
ENV APACHE_DOCUMENT_ROOT /var/www/html
RUN sed -ri -e 's!/var/www/html/public!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html/public!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# La imagen base ya trae gd, zip, pdo, pdo_mysql y oci8.
# Solo falta bcmath (usado por los barcodes PDF417/QR de las constancias).
# NOTA: sin apt-get porque el repo bullseye está EOL (404 en sus paquetes de seguridad).
RUN docker-php-ext-install bcmath

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
