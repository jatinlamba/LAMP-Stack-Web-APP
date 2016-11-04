#!/bin/bash

echo "hello" > /home/ubuntu/hello.txt
 sudo apt-get update -y
 sudo apt-get install -y apache2
 sudo systemctl enable apache2
 sudo systemctl start apache2

 sudo apt-get -y install mysql-server 
 sudo apt-get -y install php libapache2-mod-php
 sudo /etc/init.d/apache2 restart
 php -r 'echo "\n\nYour PHP installation is working fine.\n\n\n";'
 sudo apt-get install -y curl
 sudo apt-get install -y php-curl
 sudo apt-get install -y zip
 sudo apt-get install -y unzip
 sudo apt-get install -y git

 curl -sS https://getcomposer.org/installer | php
 php composer.phar require aws/aws-sdk-php

 git clone git@github.com:illinoistech-itm/jlamba1.git

echo "end"
