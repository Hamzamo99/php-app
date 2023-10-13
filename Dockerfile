# On utilise une image PHP 7 comme base
FROM php:7.4-apache-bullseye

# On installe wget, git, ffmpeg, et lsb-release
RUN apt-get update && apt-get install -y --no-install-recommends \
    git=1:2.30.2-1+deb11u2 \
    wget=1.21-1+deb11u1 \
    ffmpeg=7:4.3.6-0+deb11u1 \
    lsb-release

# Les extensions PHP nécessaires
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install sockets

ENV  COMPOSER_ALLOW_SUPERUSER=1

# On installe Composer
RUN curl --silent --show-error https://getcomposer.org/installer --output /tmp/composer-setup.php
RUN php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer -version=2.6.2


# On copie tous les fichiers de l'application dans le conteneur
COPY . /var/www/html

# Répertoire de travail
WORKDIR /var/www/html

# On installe les dépendances de l'application
RUN composer install


