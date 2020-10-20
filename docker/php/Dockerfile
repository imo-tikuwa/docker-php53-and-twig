FROM centos:6.10

ENV PHP_VERSION 5.3.3

RUN yum install -y \
        php \
        php-mbstring \
        zip \
        unzip \
        httpd && \
    yum clean all

RUN mkdir -p /app
WORKDIR /app

RUN mv /etc/php.ini /etc/php.ini.org
RUN mv /etc/httpd/conf/httpd.conf /etc/httpd/conf/httpd.conf.org
COPY php.ini /etc/php.ini
COPY httpd.conf /etc/httpd/conf/httpd.conf

RUN mkdir -p /app/lib && \
    curl -OL https://github.com/twigphp/Twig/archive/v1.36.0.zip && \
    unzip -q v1.36.0.zip && \
    mv Twig-1.36.0/lib/* /app/lib/ && \
    rm -fR Twig-1.36.0/ v1.36.0.zip

EXPOSE 80

CMD ["/usr/sbin/apachectl","-DFOREGROUND"]