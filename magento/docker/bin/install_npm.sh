#!/usr/bin/env bash

set -e

# Test if Docker Compose is installed
if [ -f /.dockerenv ] && [ -z $(which docker-compose) ]; then
    echo "docker-compose is required."
    exit 1
fi

# Display command lines
set -x
docker-compose up -d fpm

docker-compose exec fpm cp package.json.sample package.json
docker-compose exec fpm cp Gruntfile.js.sample Gruntfile.js
docker-compose exec fpm npm install

# for fr theme
docker-compose exec fpm grunt exec:atomag_FR
docker-compose exec fpm grunt less:atomag_FR

# for us theme
docker-compose exec fpm grunt exec:atomag_US
docker-compose exec fpm grunt less:atomag_US
