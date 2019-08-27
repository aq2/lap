# alpine apache with php7.3-fpm
# call it a LAP stack, why don't you?
#
# version 0.something

FROM alpine:3.5

RUN apk add --no-cache \
    apache2-proxy \
    php7 \
    php7-dom \
    php7-fpm \
    php7-xml \
    php7-json \
    php7-ctype \
    php7-common \
    php7-openssl \
    php7-opcache \
    php7-session \
    php7-mbstring \
    && mkdir /www \
    && mkdir /run/apache2 \
    && rm -rf /etc/init.d/* \
    && addgroup -g 1000 -S site \
    && adduser -G site -u 1000 -s /bin/sh -D site \
    && sed -rie 's|;error_log = log/php7/error.log|error_log = /dev/stdout|g' /etc/php7/php-fpm.conf


COPY run.sh /scripts/run.sh
COPY php.ini /etc/php7/php.ini
COPY mhsendmail /usr/bin/mhsendmail
COPY .htpasswd /etc/apache2/.htpasswd
COPY httpd.conf /etc/apache2/httpd.conf
COPY www.conf /etc/php7/php-fpm.d/www.conf
COPY proxy.conf /etc/apache2/conf.d/proxy.conf

RUN chmod -R 755 /scripts

ENV PS1='\n\e[1;34m\w \e[m  '

CMD ["/scripts/run.sh"]
