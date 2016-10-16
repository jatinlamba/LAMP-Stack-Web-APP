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

## check if user has entered 5 parameters else error is given and the script is exited

if [ $# != 5 ]
then echo "Provide 5 arguments in the following order to run the script successfully!! 

 1 -- AMI-IMAGE ID 
 2 -- Key Name  
 3 -- Security Group 
 4 -- Launch Configuration 
 5 -- Count"
exit 1
fi

## Generating random and case sensitive string of 36b ASCII characters for obtaining unique client token

clientToken=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 36 | head -n 1)

## launch instances

aws ec2 run-instances --image-id $1 --key-name $2 --security-group-ids $3 --instance-type $instanceType --placement $placementZone --count $5 --user-data $File --client-token $clientToken

## Wait for instances to start
 
aws ec2 wait instance-running --filters "Name=client-token,Values=$clientToken"

## Create Load Balancer

aws elb create-load-balancer --load-balancer-name $loadBalancerName --listeners "Protocol=HTTP,LoadBalancerPort=80,InstanceProtocol=HTTP,InstancePort=80" --availability-zones $availabilityZone

## Retrieving instance Ids

instanceId=`aws ec2 describe-instances --filters "Name=instance-state-name,Values=running" --query 'Reservations[*].Instances[].InstanceId'`

## Register instances to the created Load Balanacer

aws elb register-instances-with-load-balancer --load-balancer-name $loadBalancerName --instances $instanceId
echo $instanceId

## Pausing the script till all the instances are in InService state in load balancer by using while loop

SOURCE="OutOfService"
flag="0"
while [ $flag != 0 ]
do
status=`aws elb describe-instance-health --load-balancer-name $loadBalancerName --query 'InstanceStates[*].State'`
if echo "$status" | grep -q "$SOURCE";
then
flag="0"
else
flag="1"
fi
done

## Create luanch configuration

aws autoscaling create-launch-configuration --launch-configuration-name $4 --key-name $2 --image-id $1 --instance-type $instanceType --security-groups $3 --user-data $File

## Create auto-scaling group

aws autoscaling create-auto-scaling-group --auto-scaling-group-name $autoScalingGrpName --launch-configuration-name $4 --availability-zones $availabilityZone --load-balancer-names $loadBalancerName --max-size 5 --min-size 0 --desired-capacity 3

echo "End of Script"
