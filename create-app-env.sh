#!/bin/bash

echo "Creating My aws database"

aws rds create-db-instance \
    --db-name awsDb \
    --db-instance-identifier jl-instance1 \
    --allocated-storage 5 \
    --db-instance-class db.t2.micro \
    --engine MySQL \
    --master-username jatindb \
    --master-user-password Jlamba1db \
    --vpc-security-group-ids sg-998e44e0

aws rds wait db-instance-available --db-instance-identifier jl-instance1

echo "Database is succesfully created"
