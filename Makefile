up:
	symfony server:start --port=8083

init-test:
	php bin/console --env=test --no-interaction doctrine:migrations:migrate
	php bin/console --env=test --no-interaction doctrine:fixtures:load

test:
	php bin/phpunit

install:
	composer install

init:
	php bin/console --env=test doctrine:database:create
	php bin/console doctrine:database:create

migration:
	php bin/console make:migration

migrate:
	php bin/console --no-interaction doctrine:migrations:migrate

fixtures:
	php bin/console --no-interaction doctrine:fixtures:load
