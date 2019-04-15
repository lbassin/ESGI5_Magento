#!/usr/bin/env bash

set -e

if [ -f docker-compose.yml.dist ] && [ ! -f docker-compose.yml ]; then
    echo "Copying docker-compose.yml.dist file to docker-compose.yml"
    cp docker-compose.yml.dist docker-compose.yml
fi

if [ -f .env.dist ] && [ ! -f .env ]; then
    echo "Copying .env.dist file to .env"
    cp .env.dist .env
fi

## Hack for error "sed: : No such file or directory"
## https://github.com/meanbee/docker-magento2/blob/master/7.1-fpm/docker-entrypoint.sh
## https://unix.stackexchange.com/a/302709/327986
if [ -f /.dockerenv ]; then
    DOCKER_UID=`stat -c "%u" magento`
    # DOCKER_GID=`stat -c "%g" magento`
    sed -e "s/<uid>/$DOCKER_UID/g" .env > .env.tmp
    mv .env.tmp .env
else
    sed -i "" -e "s/<uid>/$UID/g" .env
fi

source .env

if ! grep -F "$APP_SERVER_NAME" /etc/hosts
then
    sudo sh -c "echo '#########  $APP_PROJECT_DIR_NAME  #########' >> /etc/hosts"
    sudo sh -c "echo '127.0.0.1       $APP_SERVER_NAME' >> /etc/hosts"
fi
