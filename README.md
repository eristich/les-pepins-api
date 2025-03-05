# Les Pépins - REST API

```sh
php bin/console doctrine:database:drop --force # forcer la suppression de la base de donnée
php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load -n

symfony server:start
```