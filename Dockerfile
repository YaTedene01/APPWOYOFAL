# Utilise l'image PHP-FPM
FROM php:8.3-fpm

# Installer les dépendances système + extensions PHP
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier les fichiers de l'application
COPY . .

# Configurer les permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

# Commande pour démarrer le serveur PHP intégré
CMD ["php", "-S", "0.0.0.0:80", "-t", "public"]
