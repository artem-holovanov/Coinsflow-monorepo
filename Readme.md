# Coinsflow-monorepo

### Installation:
1) `docker compose up -d --build`

2) `docker compose exec product-php bash`
execute set of commands

3) `docker compose exec order-php bash`
execute set of commands

#### Set of commands:
```
composer install
composer dump-autoload --optimize --classmap-authoritative
php bin/console messenger:stop-workers
php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:migrations:migrate --allow-no-migration -n
```

Hosts:
* Order → http://localhost:8081
* Product → http://localhost:8082
* RabbitMQ → http://localhost:15672 (guest/guest)
