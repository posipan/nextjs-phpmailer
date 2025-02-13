FROM php:8.3-apache

RUN a2enmod headers

COPY . /var/www/html/

RUN echo 'Header set Access-Control-Allow-Origin "*"' > /etc/apache2/conf-available/cors.conf \
    && echo 'Header set Access-Control-Allow-Methods "POST"' >> /etc/apache2/conf-available/cors.conf \
    && echo 'Header set Access-Control-Allow-Headers "Content-Type"' >> /etc/apache2/conf-available/cors.conf

RUN a2enconf cors

EXPOSE 80
