#!/bin/bash

# Iniciar PHP-FPM en segundo plano
/usr/sbin/php-fpm --daemonize

# Iniciar Apache en primer plano
exec /usr/sbin/httpd -D FOREGROUND
