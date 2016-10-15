#!/bin/bash

echo "imageId is : $1"

echo "key name is : $2"

echo "security group is : $3"

echo "launch configuration name is : $4"

echo "count is : $5"

File='file://installapp.sh'
echo "script file is : $File"

instanceType='t2.micro'
echo "instance type is : $instanceType"

placementZone='AvailabilityZone=us-west-2b'
echo "placement zone is : $placementZone"

availabilityZone='us-west-2b'
echo "availability zone is : $availabilityZone"

subnetId='subnet-20436a44'
echo "subnet id is : $subnetId"

loadBalancerName='itmo-544-jl'
echo "load balancer is : $loadBalancerName"

autoScalingGrpName='jlwebserver'
echo "auto scaling group name is : $autoScalingGrpName"

## Logic to check if user entered has entered 5 parameters else give error and exit the script

if [ $# != 5 ]
then echo "To run this script, provide 5 arguments in the following order. 

 1. AMI-IMAGE ID 
 2. Key Name  
 3. Security Group 
 4. Launch Configuration 
 5. Count"
exit 1
fi

## Generating random and case sensitive string of 36b ASCII characters for obtaining unique clientToken

#clientToken= $(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 36 | head -n 1)

## AWS command to create ec2 instances

aws ec2 run-instances --image-id $1 --key-name $2 --security-group-ids $3 --instance-type t2.micro --placement $placementZone --count $5 --user-data $File 
#--client-token $clientToken 

#aws ec2 wait instance-running --filters "Name=client-token,Values=$clientToken"

## Create load balancer

aws elb create-load-balancer --load-balancer-name $loadBalancerName --listeners "Protocol=Http,LoadBalancerPort=80,InstanceProtocol=Http,InstancePort=80" --subnets $subnetId --security-groups $securityGroup

## Retrieving instance Ids

instanceId=`aws ec2 describe-instances --filters 'Name=instance-state-name,Values=pending' --query 'Reservations[*].Instances[].InstanceId'`

## Wait command till instances starts running

aws ec2 wait instance-running --instance-ids $instanceId
echo $instanceId

## register instances to the created Load Balanacer

aws elb register-instances-with-load-balancer --load-balancer-name $loadBalancerName --instances $instanceId

##create autoscale launch config

aws autoscaling create-launch-configuration --launch-configuration-name $4 --image-id $1 --key-name $2 --security-groups $3 --instance-type $instanceType --user-data $File 

##create autoscaling group

aws autoscaling create-auto-scaling-group --auto-scaling-group-name $autoScalingGrpName --launch-configuration-name $4 --load-balancer-name $loadBalancerName --availability-zones $availabilityZone --load-balancer-names $loadBalancerName --max-size 5 --min-size 0 --desired-capacity 3


