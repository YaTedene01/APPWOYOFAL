FROM php:8.2-fpm

WORKDIR /var/www/html

# Installation des extensions PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copie des fichiers du projet
COPY --chown=www-data:www-data . .

# Configuration du fichier d'environnement
COPY --chown=www-data:www-data .env.docker .env
EXPOSE 9000
# Debug et vérification
RUN set -x && \
    pwd && \
    ls -la && \
    ls -la .env && \
    chmod 644 .env
