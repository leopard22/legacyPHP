FROM php:5.4-apache

RUN apt-get update && apt-get install curl git -y \
 && docker-php-ext-install pdo pdo_mysql mysql \
 && echo 'date.timezone=Europe/Paris' > /usr/local/etc/php/conf.d/timezone.ini \
 && sed -i 's!/var/www/html!/root/public!g' /etc/apache2/apache2.conf \
 && sed -i 's!/var/www/!/root/public/!g' /etc/apache2/apache2.conf \
 && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
 && php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
 && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
 && php -r "unlink('composer-setup.php');" \
 && chmod -Rf 777 /root
WORKDIR /root