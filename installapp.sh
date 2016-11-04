#!/bin/bash

echo "hello" > /home/ubuntu/hello.txt
 sudo apt-get update -y
 sudo apt-get install -y git apache2 mysql-server php libapache2-mod-php curl php-curl zip unzip 

sudo /etc/init.d/apache2 restart
php -r 'echo "\n\nYour PHP installation is working fine.\n\n\n";'

 curl -sS https://getcomposer.org/installer | php
 php composer.phar require aws/aws-sdk-php

 git clone git@github.com:illinoistech-itm/jlamba1.git

echo "end"
