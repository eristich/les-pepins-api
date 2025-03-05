# Les Pépins - REST API

## Setup pour le developpement

### Outils nécessaire

- PHP >= 8.2
- Composer >= 2.7.1
- Symfony CLI >= 5.11.0
- Base de donnée Oracle (Local ou Docker)

### Commencer

```sh
cp .env.dev .env.dev.local
# Mofifier la variable DATABASE_URL dans .env.dev.local pour la connexion à la base de donnée
php bin/console doctrine:database:drop --force # pas obligatoire mais nécessaire parfois pour vider la base de donnée
php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load -n

symfony server:start
```