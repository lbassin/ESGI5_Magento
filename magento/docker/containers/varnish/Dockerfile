FROM centos:centos7
MAINTAINER Przemyslaw Ozgo linux@ozgo.info, Marcin Ryzycki marcin@m12.io

RUN yum update -y && \
yum install -y epel-release && \
yum install -y varnish && \
yum install -y libmhash-devel && \
yum clean all

ADD start.sh /start.sh
ADD varnish.vcl /etc/varnish/varnish.vcl

ENV VCL_CONFIG /etc/varnish/varnish.vcl
ENV CACHE_SIZE 256m
ENV VARNISHD_PARAMS -p default_ttl=3600 -p default_grace=3600

CMD /start.sh
EXPOSE 80