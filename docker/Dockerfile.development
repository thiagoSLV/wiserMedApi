FROM php

RUN apt-get update &&\
	apt-get upgrade -y &&\ 
	apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

WORKDIR /var/www

CMD ["/var/www/application.sh"]