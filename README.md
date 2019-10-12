# Application de messagerie

* **Date** : 16.10.2019
* **Auteurs** : Nikolaos Garanis, Samuel Mettler.

## Lancement de l'application

L'application peut être lancée dans un containeur Docker et sera disponible à  travers le port 8888 de la machine locale. Il suffit pour cela d'exécuter le script `script.sh` disponible à la racine du projet.

## Création de la base de données

La base de données peut être créée à partir du fichier `site/databases/dump.sql` en exécutant le script `create_db.sh`. La base de données `database.sqlite` est créée.

## Image Docker

Nous avons étendue l'image Docker fournie afin d'y modifier la configuration de PHP (voir le fichier `Dockerfile`), nous permettant de voir à l'écran les éventuelles erreurs et warnings PHP. Ces options ne doivent évidemment être utilisées que lors de la phase de développement.
