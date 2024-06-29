#!/usr/bin/env bash

if [ $# -gt 0 ]; then
    if [ "$1" == "php" ]; then
        shift 1
        docker compose exec -u $(id -u):$(id -g) php php "$@"
    elif [ "$1" == "console" ]; then
        shift 1
        docker compose exec -u $(id -u):$(id -g) php php bin/console "$@"
    elif [ "$1" == "composer" ]; then
        shift 1
        docker compose exec -u $(id -u):$(id -g) php composer "$@"
    elif [ "$1" == "qa" ]; then
        shift 1
        echo "Running php fixer..."
        docker compose exec php ./vendor/bin/php-cs-fixer fix --dry-run --diff
        echo "Running phpstan..."
        docker compose exec php ./vendor/bin/phpstan analyse
        echo "Running phpinsights..."
        docker compose exec php ./vendor/bin/phpinsights analyse --no-interaction
        echo "Running rector..."
        docker compose exec php ./vendor/bin/rector process --dry-run
    elif [ "$1" == "fix" ]; then
        shift 1
        echo "Running code style fix..."
        echo "Rector..."
        docker compose exec php ./vendor/bin/rector process
        echo "Phpinsights..."
        docker compose exec php ./vendor/bin/phpinsights --no-interaction --fix
        echo "Php fixer..."
        docker compose exec php ./vendor/bin/php-cs-fixer fix
    elif [ "$1" == "test" ]; then
        shift 1
        docker compose exec php ./vendor/bin/phpunit --testsuite Unit,Feature "$@"
    elif [ "$1" == "btest" ]; then
		shift 1
		docker compose exec php ./vendor/bin/phpunit --testsuite Browser "$@"
    elif [ "$1" == "coverage" ]; then
        shift 1
        docker compose exec php ./vendor/bin/phpunit --testsuite Unit,Feature --coverage-html public/reports
    else
        echo "Unknown command"
    fi
else
    echo "Unknown command"
fi
