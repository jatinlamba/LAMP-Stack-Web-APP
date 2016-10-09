#!/bin/bash

File='file://installapp.sh'
echo "script file is : $File"

imageId='ami-06b94666'
echo "imageId is : $imageId"

keyName='inclass'
echo "key name is : $keyName"

securityGroup='sg-998e44e0'
echo "security group is : $securityGroup"

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

autoScalingLCN='jlserverlaunch'
echo "launch configuration name is : $autoScalingLCN"

autoScalingGrpName='jlwebserver'
echo "auto scaling group name is : $autoScalingGrpName"


## Create load balancer

aws elb create-load-balancer --load-balancer-name $loadBalancerName --listeners "Protocol=Http,LoadBalancerPort=80,InstanceProtocol=Http,InstancePort=80" --subnets $subnetId --security-groups $securityGroup

##create autoscale launch config

aws autoscaling create-launch-configuration --launch-configuration-name $autoScalingLCN --image-id $imageId --key-name $keyName --security-groups $securityGroup --instance-type $instanceType --user-data $File 

##create autoscaling group

aws autoscaling create-auto-scaling-group --auto-scaling-group-name $autoScalingGrpName --launch-configuration-name $autoScalingLCN --availability-zones $availabilityZone --load-balancer-names $loadBalancerName --max-size 5 --min-size 1 --desired-capacity 3

