#!/bin/bash

echo "hello" > /home/ubuntu/hello.txt
sudo apt-get update -y
sudo apt-get install -y apache2
sudo systemctl enable apache2
sudo systemctl start apache2

git clone git@github.com:illinoistech-itm/jlamba1.git

echo "end"
