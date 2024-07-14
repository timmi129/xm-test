
post_update: cache_clear postgres_migrate
post_init: cache_clear postgres_migrate

reset: cache_remove postgres_reset post_init

postgres_reset: postgres_drop postgres_create postgres_migrate

start: start-containers composer migrate fixtures

postgres_drop:
	make exec service="api" command="bin/console doctrine:database:drop --force --if-exists"

db-drop:
	make exec service="api" command="bin/console doctrine:schema:drop --full-database --force"

fixtures:
	make exec service="api" command="bin/console doctrine:fixtures:load --no-interaction"

create:
	make exec service="api" command="bin/console doctrine:database:create --if-not-exists"

migrate:
	make exec service="api" command="bin/console doctrine:migrations:migrate -n --all-or-nothing --allow-no-migration --no-debug"

migrate-diff:
	make exec service="api" command="bin/console doctrine:migrations:diff"

test-unit:
	make exec service="api" command="./vendor/phpunit/phpunit/phpunit  --testsuite 'Unit Test Suite'"

composer:
	make exec service="api" command="composer install"

reset-db: db-drop migrate fixtures

test:
	make exec service="api" command="vendor/bin/codecept run --steps -n"

permission_fix:
	make exec service="api" command="mkdir -m 0777 -p var/cache"
	make exec service="api" command="mkdir -m 0777 -p var/log"
	make exec service="api" command="chmod -R 0777 var/log var/cache"

cache_clear:
	make exec service="api" command="bin/console cache:clear -n -e $(APP_ENV)"

cache_remove:
	make exec service="api" command="rm -rf var/cache/*"

start-containers:
	docker-compose -f docker-compose.yml up --build -d

stop:
	docker-compose -f docker-compose.yml stop

remove:
	docker-compose -f docker-compose.yml down --remove-orphans -v

exec:
	docker-compose -f docker-compose.yml exec $(EXEC_OPTIONS) $(service) $(command)

init: start-containers post_init
update: post_update
start: start-containers

reset: reset
test: test

phpcs:
	make exec service="api" command="./vendor/bin/php-cs-fixer --config=.php-cs-fixer.dist.php fix -v --diff --dry-run ./src ./tests"

phpcsfix:
	make exec service="api" command="./vendor/bin/php-cs-fixer --config=.php-cs-fixer.dist.php fix ./src ./tests"

bash:
	docker exec -it xm-api /bin/bash

.PHONY: init
