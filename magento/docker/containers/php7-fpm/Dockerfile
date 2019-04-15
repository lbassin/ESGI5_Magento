FROM php:7.1-fpm

LABEL maintainer = "Agence Dn'D <contact@dnd.fr>"

ARG APP_PROJECT_DIR_NAME
ARG HOST_USER_ID

WORKDIR /var/www/project/magento

RUN apt-get update
RUN apt-get install -y sudo
RUN apt-get install -y wget
RUN apt-get install -y unzip
RUN apt-get install -y cron
RUN apt-get install -y curl
RUN apt-get install -y git
RUN apt-get install -y libmcrypt-dev
RUN apt-get install -y libicu-dev
RUN apt-get install -y libxml2-dev libxslt1-dev
RUN apt-get install -y libfreetype6-dev
RUN apt-get install -y libjpeg62-turbo-dev
RUN apt-get install -y libpng-dev
RUN apt-get install -y vim
RUN apt-get install -y supervisor
RUN apt-get install -y procps
RUN apt-get install -y mysql-client
RUN apt-get install -y gnupg1
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-configure hash --with-mhash
RUN docker-php-ext-install -j$(nproc) mcrypt intl xsl gd zip pdo_mysql opcache soap bcmath json iconv sockets
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN pecl install -o -f xdebug && docker-php-ext-enable xdebug
RUN echo "xdebug.remote_enable=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_port=9009" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_connect_back=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_host=docker.for.mac.host.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.max_nesting_level=1000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN chmod 666 /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini


# PHP config
ADD conf/php.ini /usr/local/etc/php
ADD conf/project.pool.conf /usr/local/etc/php/pool.d/

COPY bin/* /usr/local/bin/
RUN chmod +x /usr/local/bin/start
RUN chmod +x /usr/local/bin/xdebug

#disable Xdebug
RUN sed -i -e '1 s/^/;/g' /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# install mhsendmail
RUN wget -O /usr/sbin/mhsendmail  https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64
RUN chmod +x /usr/sbin/mhsendmail

RUN usermod -u $HOST_USER_ID www-data
RUN chown -R www-data:www-data /var/www/

RUN echo Europe/Paris | tee /etc/timezone && dpkg-reconfigure --frontend noninteractive tzdata

RUN chown www-data:www-data /var/www/

#Copy supervisord.conf
COPY conf/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Activate www-data cron
ADD crontab/www-data /var/spool/cron/crontabs/
RUN chown www-data:crontab /var/spool/cron/crontabs/www-data
RUN chmod 600 /var/spool/cron/crontabs/www-data
RUN mkdir -p /var/lib/php/session && chown -R www-data:www-data /var/lib/php/session

RUN curl https://files.magerun.net/n98-magerun2.phar -o /usr/local/bin/n98-magerun2
RUN chmod +x /usr/local/bin/n98-magerun2

RUN echo "www-data:docker" | chpasswd && adduser www-data sudo
RUN echo "www-data ALL=(root) NOPASSWD:ALL" > /etc/sudoers.d/www-data && chmod 0440 /etc/sudoers.d/www-data

USER www-data

RUN echo "alias la='ls -lah'" >> ~/.bashrc
RUN echo "alias debugphp='XDEBUG_CONFIG=\"idekey=PHPSTORM\" PHP_IDE_CONFIG=\"serverName=$APP_PROJECT_DIR_NAME\" php'" >> ~/.bashrc

CMD ["/usr/local/bin/start"]
