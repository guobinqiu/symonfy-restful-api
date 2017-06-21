build:
  composer install
  php bin/console doctrine:database:create --env=dev
  php bin/console doctrine:schema:update --env=dev --force
