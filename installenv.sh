#!/bin/bash

sudo apt-get update -y
sudo apt-get install -y apache2
sudo apt-get install -y git

sudo systemctl enable apache2
sudo systemctl start apache2

sudo git clone https://github.com/jatinlamba/S3.git   
sudo mv /S3/boostrap-website/font-awesome /var/www/html
sudo mv /S3/boostrap-website/fonts /var/www/html
sudo mv /S3/boostrap-website/pdf /var/www/html
sudo mv /S3/boostrap-website/teachers /var/www/html
sudo mv /S3/boostrap-website/LISENSE /var/www/html
sudo mv /S3/boostrap-website/README.MD /var/www/html
sudo mv /S3/boostrap-website/css /var/www/html
sudo mv /S3/boostrap-website/index.html /var/www/html
sudo mv /S3/boostrap-website/program.html /var/www/html

