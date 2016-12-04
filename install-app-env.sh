#!/bin/bash

echo "Bucket 1 is : $1"

echo "Bucket 2 is : $2"

securityGrp='sg-998e44e0'
echo "security group is : $securityGrp"

availabilityZone='us-west-2b'
echo "availability zone is : $availabilityZone"

echo "Creating My aws database"

## creating database instance

aws rds create-db-instance \
    --db-name school \
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

echo "Database is successfully created and Instance is launched successfully"

## SNS queue created

aws sns create-topic --name awscli

## aws sns subscribe --topic-arn  --protocol email --notification-endpoint lamba.vicky@gmail.com

##SQS queue created

aws sqs create-queue --queue-name jatinSQS

## creating s3 buckets

aws s3 mb s3://$1 --region us-west-2
aws s3 mb s3://$2 --region us-west-2

echo "buckets created successfully" 
