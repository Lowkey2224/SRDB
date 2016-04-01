.PHONY: hello all deploy clear install ci test test-functional checkstyle-ci checkstyle count-code security-check

hello:
	@echo "Hi there, have a look at the other targets :)"

all: install clear ide-helper database-completely-new gulp test

deploy:
	php composer.phar install
	php artisan -vvv config:clear

clear:
	php app/console -vvv cache:clear
	php app/console -vvv config:clear

install:
	php composer.phar install

ci:
	php composer.phar validate --strict
	php composer.phar install
	make test
	make security-check
	make checkstyle-ci

test:
	php vendor/bin/phpunit --testsuite ohl
	php vendor/bin/phpunit --testsuite ohl-importer-passat

test-functional:
	php vendor/bin/paratest --testsuite functional --phpunit=vendor/bin/phpunit -p 4




# This will fail on first checkstyle error.
checkstyle-ci:
	php vendor/bin/php-cs-fixer fix --dry-run

# This will correct checkstyle.
checkstyle:
	php vendor/bin/php-cs-fixer fix || true


count-code:
	cloc app/ src/ database/
	cloc resources/

security-check:
	php vendor/bin/security-checker security:check
