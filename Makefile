setup:
	composer install
	php bin/console doctrine:database:create --env=dev --if-not-exists
	php bin/console doctrine:schema:update --env=dev --force

startup:
	php bin/console server:run
