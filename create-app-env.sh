#!/bin/bash

securityGrp='sg-998e44e0'
echo "security group is : $securityGrp"

availabilityZone='us-west-2b'
echo "availability zone is : $availabilityZone"

echo "Creating My aws database"

## creating database instance

aws rds create-db-instance \
    --db-name awsDb \
    --db-instance-identifier jl-instance1 \
    --allocated-storage 5 \
    --db-instance-class db.t2.micro \
    --engine MySQL \
    --master-username jatindb \
    --master-user-password Jlamba1db \
    --vpc-security-group-ids $securityGrp \
    --availability-zone $availabilityZone

echo "Waiting till the instance is available ........................"

## rds wait command till the instance is available"
aws rds wait db-instance-available --db-instance-identifier jl-instance1

echo "Database is succesfully created and Instance is launched successfully"
