FROM centos:6.10

ENV PHP_VERSION 5.3.3
ENV APP_DIR /app

RUN yum install -y \
        php \
        php-mbstring \
        zip \
        unzip \
        httpd && \
    yum clean all

RUN mkdir -p $APP_DIR
WORKDIR $APP_DIR

RUN mv /etc/php.ini /etc/php.ini.org
RUN mv /etc/httpd/conf/httpd.conf /etc/httpd/conf/httpd.conf.org
COPY php.ini /etc/php.ini
COPY httpd.conf /etc/httpd/conf/httpd.conf

RUN mkdir -p $APP_DIR/lib && \
    curl -OL https://github.com/twigphp/Twig/archive/v1.36.0.zip && \
    unzip -q v1.36.0.zip && \
    mv Twig-1.36.0/lib/* $APP_DIR/lib/ && \
    rm -fR Twig-1.36.0/ v1.36.0.zip

EXPOSE 80

CMD ["/usr/sbin/apachectl","-DFOREGROUND"]