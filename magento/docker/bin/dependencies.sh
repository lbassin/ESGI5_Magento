#!/usr/bin/env bash

set -e

# Test if Docker Compose is installed
if [ -f /.dockerenv ] && [ -z $(which docker-compose) ]; then
    echo "docker-compose is required."
    exit 1
fi

if [ -f magento/app/etc/env.php.dev ] && [ ! -f magento/app/etc/env.php ]; then
    set -x
    docker-compose exec fpm cp magento/app/etc/env.php.dev magento/app/etc/env.php
    set +x
fi

# Display command lines
set -x

docker-compose exec fpm pwd
docker-compose exec fpm composer install -o -d .
