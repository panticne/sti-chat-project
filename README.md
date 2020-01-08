# Application de messagerie

* **Date** : 15.01.2020
* **Auteurs** : Nikolaos Garanis, Nemanja Pantic.

## Initialisation de la base de données

La base de données peut être créée à partir du fichier `db/dump.sql` en exécutant le script `create_db.sh` qui se trouve à la racine du projet. La base de données `site/databases/database.sqlite` est alors créée.

### Administrateurs

Une fois la base de données créée, deux utilisateurs ont un accès administrateur. Leurs identifiants sont : `niko/ptRgA;KS:?dxYeY_` et `nemanja/sNbzsNPclmN$HPmA`.

### Utilisateurs

D'autres utilisateurs sont créés par défaut. Leur mot de passe (généré aléatoirement) peuvent être trouvés dans le fichier `db/dump.sql`.

## Lancement de l'application

L'application peut être lancée dans un conteneur Docker et sera disponible à  travers le port 8888 de la machine locale. Il suffit pour cela d'exécuter le script `start_app.sh` disponible à la racine du projet.

## Image Docker

Nous avons étendue l'image Docker fournie afin d'y modifier la configuration de PHP (voir le fichier `Dockerfile`), nous permettant de voir à l'écran les éventuelles erreurs et warnings PHP. Ces options ne doivent évidemment être utilisées que lors de la phase de développement.
