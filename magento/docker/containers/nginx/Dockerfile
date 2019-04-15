FROM debian:jessie

MAINTAINER Dnd <tech@dnd.fr>

RUN apt-get update && apt-get install -y nginx nginx-extras vim supervisor procps

ADD cert/* /etc/nginx/ssl/

ARG APP_PROJECT_TYPE

ADD bin/* /usr/local/bin/
ADD conf/vhost.magento.conf /etc/nginx/sites-available/
ADD conf/vhost.magento_ssl.conf /etc/nginx/sites-available/

RUN ln -s /etc/nginx/sites-available/vhost.magento.conf /etc/nginx/sites-enabled/magento
RUN ln -s /etc/nginx/sites-available/vhost.magento_ssl.conf /etc/nginx/sites-enabled/magento_ssl
RUN rm /etc/nginx/sites-enabled/default

EXPOSE 80 443

#Copy supervisord.conf
COPY conf/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

ENV UPLOAD_MAX_FILESIZE 64M
ENV FPM_HOST fpm
ENV FPM_PORT 9000
ENV MAGENTO_ROOT /var/www/project/magento
ENV MAGENTO_RUN_MODE developer

RUN ["chmod", "+x", "/usr/local/bin/docker-environment"]

ENTRYPOINT ["/usr/local/bin/docker-environment"]

RUN usermod -u 1000 www-data

RUN echo Europe/Paris | tee /etc/timezone && dpkg-reconfigure --frontend noninteractive tzdata

CMD ["/usr/bin/supervisord"]
