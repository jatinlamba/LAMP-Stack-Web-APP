#!/bin/bash

echo "hello" > /home/ubuntu/hello.txt

  

# sudo apt-get install php php-mysql mysql-client php-gd php-cli curl php-curl zip unzip git libapache2-mod-php -y 

#  sudo service apache2 restart
sudo apt-get install python-software-properties
sudo add-apt-repository ppa:ondrej/php-7.0
sudo apt-get update
sudo apt-get purge php5-fpm
sudo apt-get install php7.0-cli php7.0-common libapache2-mod-php7.0 php7.0 php7.0-mysql php7.0-fpm php7.0-curl php7.0-gd php7.0-bz2
cd /var/www/html/
sudo wget https://files.phpmyadmin.net/phpMyAdmin/4.5.3.1/phpMyAdmin-4.5.3.1-all-languages.zip
sudo apt-get install unzip git 
sudo unzip phpMyAdmin-4.5.3.1-all-languages.zip
sudo mv phpMyAdmin-4.5.3.1-all-languages/ phpmyadmin/
sudo mkdir -m 777 phpmyadmin/config/
sudo /etc/init.d/apache2 restart
  
  php -r 'echo "\n\nYour PHP installation is working fine.\n\n\n";'

##  Installing AWS-PHP-SDK via composer

  export COMPOSER_HOME=/root && /usr/bin/composer.phar self-update 1.0.0-alpha11
  curl -sS https://getcomposer.org/installer | php
  php composer.phar require aws/aws-sdk-php

##  Cloning my git repository

  sudo git clone git@github.com:illinoistech-itm/jlamba1.git
  sudo cp -r vendor/ /var/www/html
  sudo cp jlamba1/s3test.php /var/www/html
  sudo cp jlamba1/dbtest.php /var/www/html
  sudo cp jlamba1/testdb.php /var/www/html
  sudo cp jlamba1/check.php /var/www/html
  sudo cp jlamba1/index.php /var/www/html
  sudo cp jlamba1/welcome.php /var/www/html
  sudo cp jlamba1/gallery.php /var/www/html
  sudo cp jlamba1/upload.php /var/www/html
  sudo cp jlamba1/uploader.php /var/www/html
  sudo cp jlamba1/backup.php /var/www/html
  sudo cp jlamba1/uploadcontrol.php /var/www/html
  sudo cp jlamba1/admin.php /var/www/html
  sudo cp jlamba1/dbitems.php /var/www/html
 echo "end"
