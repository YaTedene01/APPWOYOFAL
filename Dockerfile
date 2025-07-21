FROM php:8.2-apache

# Copie le code dans le conteneur
COPY ./public /var/www/html/

# Active les extensions PHP nécessaires (ajoute celles dont tu as besoin)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Donne les droits à Apache
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80