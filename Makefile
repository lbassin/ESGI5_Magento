all: initialize build-docker build-dependencies

open-project:
	source .env; open -g https://$$APP_SERVER_ALIAS

initialize:
	@sh ./magento/docker/bin/initializer.sh

setup-nfs:
	@sh ./magento/docker/bin/setup_native_nfs_docker_osx.sh

build-docker:
	@sh ./magento/docker/bin/builder.sh

build-dependencies:
	@sh ./magento/docker/bin/dependencies.sh

xdebug-status:
	docker-compose exec fpm xdebug status

xdebug-enable:
	docker-compose exec fpm xdebug enable

xdebug-disable:
	docker-compose exec fpm xdebug disable

magento-cmds:
	docker-compose exec fpm ./magento/src/bin/magento

cache-storage-flush:
	docker-compose exec cache-storage redis-cli flushall

cache-proxy-flush:
	docker-compose exec cache-proxy varnishadm "ban req.url ~ /"

install-npm:
	@sh ./magento/docker/bin/install_npm.sh

d-ps:
	docker ps

dc-stop:
	@sh ./magento/docker/bin/killer.sh

dc-ps:
	docker-compose ps

logs:
	@sh ./magento/docker/bin/logger.sh

logs-application:
	@sh ./magento/docker/bin/logger.sh application

logs-db:
	@sh ./magento/docker/bin/logger.sh db

logs-fpm:
	@sh ./magento/docker/bin/logger.sh fpm

logs-webserver:
	@sh ./magento/docker/bin/logger.sh webserver

logs-mail-catcher:
	@sh ./magento/docker/bin/logger.sh mail-catcher

logs-cache-proxy:
	@sh ./magento/docker/bin/logger.sh cache-proxy

logs-cache-storage:
	@sh ./magento/docker/bin/logger.sh cache-storage

bash:
	@sh ./magento/docker/bin/connector.sh

bash-application:
	@sh ./magento/docker/bin/connector.sh application

bash-db:
	@sh ./magento/docker/bin/connector.sh db

bash-fpm:
	@sh ./magento/docker/bin/connector.sh fpm

bash-webserver:
	@sh ./magento/docker/bin/connector.sh webserver

bash-mail-catcher:
	@sh ./magento/docker/bin/connector.sh mail-catcher

bash-cache-storage:
	@sh ./magento/docker/bin/connector.sh cache-storage

bash-cache-proxy:
	@sh ./magento/docker/bin/connector.sh cache-proxy
