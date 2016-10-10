#!/bin/bash


loadBalancerName='itmo-544-jl'
echo "load balancer is : $loadBalancerName"

autoScalingLCN='jlserverlaunch'
echo "launch configuration name is : $autoScalingLCN"

autoScalingGrpName='jlwebserver'
echo "auto scaling group name is : $autoScalingGrpName"

ports='80'
echo "port is : $ports"

#Instance Id retreival

instanceId=`aws ec2 describe-instances --query 'Reservations[*].Instances[*].[InstanceId]' --filter Name=instance-state-name,Values=running`

##terminating instances

aws ec2 terminate-instances --instance-ids $instanceId --output text --query 'TerminatingInstances[*].CurrentState.Name'

##wait

aws ec2 wait instance-terminated --instance-ids $instanceId
echo $instanceId

##deregistering instances from load-balancer

aws elb deregister-instances-from-load-balancer --load-balancer-name $loadBalancerName --instances $instanceId

##deleting listeners

aws elb delete-load-balancer-listeners --load-balancer-name $loadBalancerName --load-balancer-ports $ports

##deleting load balancers

aws elb delete-load-balancer --load-balancer-name $loadBalancerName 

##updating autoscaling group

aws autoscaling update-auto-scaling-group --auto-scaling-group-name $autoScalingGrpName --launch-configuration-name $autoScalingLCN --min-size 0 --max-size 0

##deleting autoscaling group

aws autoscaling delete-auto-scaling-group --auto-scaling-group-name $autoScalingGrpName --force-delete  

##deleting launch configuration

aws autoscaling delete-launch-configuration --launch-configuration-name $autoScalingLCN

