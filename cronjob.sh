

#!/bin/bash

echo "hello" > /home/ubuntu/hello.txt

  sudo apt-get update -y
  sudo apt-get install -y apache2
  sudo systemctl enable apache2
  sudo systemctl start apache2
  sudo apt-get install php5 php5-mysql php5-gd curl php5-curl zip unzip git -y
  sudo apt-get install libapache2-mod-php5 -y
  sudo apt-get install php5-cli -y
  sudo apt-get install mysql-client -y
  sudo service apache2 restart

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
  sudo cp jlamba1/edit.php /var/www/html

  echo "Place the cron job in /var/spool/cron folder..."
(crontab -1 2>/dev/null; echo "* * * * * /usr/bin/php /var/www/html/edit.php") | crontab -
sleep 30
echo "Apache server Restarting";
sudo service apache2 restart
echo "Cron job Done";
 echo "end"
