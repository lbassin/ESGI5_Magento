# Agence Dn'D - Atol / Magento 2
============================================

## Makefile
Contains few commands to manage containers.
Please read it !

## Project installation
```bash
make all
make install
```

## Auth
```json
{
  "http-basic": {
    "repo.magento.com": {
      "username": "7ec70692b6182047dbaf2a94c5590508",
      "password": "6d69e2906a211f9a5d16392d9c659ad5"
    },
    "composer.amasty.com": {
      "username": "6655ea8c8d098d177e7fe054ed319320",
      "password": "afba417f58a51af78dacdc13ded9065a"
    },
    "dist.aheadworks.com": {
      "username": "AAAAB3NzaC1yc2EAAAADAQABAAABAQDPc26FFUWB0LO0w3fQfBUVYHfSn+ga6lUU",
      "password": "MIIEowIBAAKCAQEAz3NuhRVFgdCztMN30HwVFWB30p/oGupVFDNUfgu3LF8OpAvi"
    }
  }
}
```

## Redis
```bash
make cache-storage-flush
```
```bash
docker-compose exec cache-storage redis-cli flushall
```

## DB
```bash
docker-compose exec db bash
mysqldump --single-transaction --opt --events --routines --verbose -u atomag -p atomag | gzip > /docker-entrypoint-initdb.d/dump-test.sql.gz
```

### Start Docker
```bash
docker-compose up -d
```

### Install Magento dependencies
```bash
make build-dependencies
```

### Set Magento production mode
```bash
make magento-cmds deploy:mode:set production
```
```bash
docker-compose exec fpm bin/magento deploy:mode:set production
```

### Front installation

```bash
make install-npm
```
This make command run these commands :
```bash
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
```
If for any reason something bad happens, connect to container, remove node_module and try again from ```docker-compose exec fpm npm install```

If it still doesn't work, "c'ay leu vii" so ask Foster or Akira for help.
