#!/usr/bin/env sh
# Lancement de l'application dans un conteneur Docker.

# buil de l'image
docker build -t php-dev .

# lancement du conteneur
docker run -ti --rm -v "$PWD/site":/usr/share/nginx/ -d -p 8888:80 --name sti_project --hostname sti php-dev

# démarrage de nginx et php
docker exec -u root sti_project service nginx start
docker exec -u root sti_project service php5-fpm start
