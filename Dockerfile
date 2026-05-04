FROM php:8.2-apache

# Activează mod_rewrite pentru URL-uri curate
RUN a2enmod rewrite

# Copiază toate fișierele în directorul web
COPY . /var/www/html/

# Setează permisiuni
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Expune portul 80
EXPOSE 80
