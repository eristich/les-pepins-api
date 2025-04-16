# Les Pépins - REST API

## Setup pour le developpement

### Outils nécessaire

- [PHP >= 8.2](https://www.apachefriends.org/fr/index.html)
- [Composer >= 2.7.1](https://getcomposer.org/download/)
- [Symfony CLI >= 5.11.0](https://symfony.com/download)
- MySQL >= 7 (Voir docker compose file)

### Commencer

```sh
# lancer le gestionnaire de base de donnée MySQL dans Docker
docker compose up -d

# Installer les dépendance de l'application php dans ./vendor
composer install

# Copier le fichier de configuration dans une version non commitable par Git
# Mofifier la variable DATABASE_URL dans .env.dev.local pour la connexion à une base de donnée spécifique
cp .env.dev .env.dev.local

# Pas obligatoire mais nécessaire parfois pour vider la base de donnée (équivalent de : DROP DATABASE <db>)
php bin/console doctrine:database:drop --force

# Créer la base de donnée si elle n'existe pas (equivalent de : CREATE DATABASE IF NOT EXISTS <db>)
php bin/console doctrine:database:create --if-not-exists

# Force la création des schemas/table de la base de donnée
php bin/console doctrine:schema:update --force

# Charge des fausses données de test dans la base de donnée 
php bin/console doctrine:fixtures:load -n

# Lancer le serveur Symfony en écoute
symfony server:start

# Une documentation des routes API est disponible à ce chemin : /api/v1/doc
```

## Exemples de commandes

```sh
# Mofifier ou créer une l'entitée <Question> (entitée = Table)
php bin/console make:entity Question

# Créer un nouveau controller (controller = collection de route api)
php bin/console make:controller QuestionController
```