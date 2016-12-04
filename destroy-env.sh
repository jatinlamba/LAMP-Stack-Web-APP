#!/bin/bash

## Retrieving Auto-scaling Group Name
 
autoScalingGrpName=`aws autoscaling describe-auto-scaling-groups --query 'AutoScalingGroups[*].AutoScalingGroupName[]'`

echo "auto scaling group name is : $autoScalingGrpName"

## Retrieving Load Balancers Name

loadBalancerName=`aws autoscaling describe-load-balancers --auto-scaling-group-name $autoScalingGrpName --query 'LoadBalancers[*].LoadBalancerName[]'`

echo "load balancer is : $loadBalancerName"

## Retrieving Launch Configuration Name

autoScalingLCN=`aws autoscaling describe-auto-scaling-groups --auto-scaling-group-name $autoScaliningGrpName --query 'AutoScalingGroups[*].LaunchConfigurationName[]'`

echo "launch configuration name is : $autoScalingLCN"

## Retrieving the Port number 

ports=`aws elb describe-load-balancers --load-balancer-name $loadBalancerName --query 'LoadBalancerDescriptions[*].ListenerDescriptions[].Listener[].LoadBalancerPort[]'`

echo "port is : $ports"

## Retrieving rds db instances

dbInstances=`aws rds describe-db-instances --query 'DBInstances[*].[DBInstanceIdentifier]'`

echo "db instance is : $dbInstances"

## Retrieving sqs queues url

sqs_queue=$(aws sqs list-queues | awk '{print $2}')
echo $sqs_queue

## Retrieving sns arn

sns_topic_arn=$(aws sns list-topics | awk '{print $2}')
echo $sns_topic_arn

## Instance Id retreival

instanceId=`aws ec2 describe-instances --query 'Reservations[*].Instances[*].[InstanceId]' --filter Name=instance-state-name,Values=running`

## terminating instances

aws ec2 terminate-instances --instance-ids $instanceId --output text --query 'TerminatingInstances[*].CurrentState.Name'

## wait

aws ec2 wait instance-terminated --instance-ids $instanceId
echo $instanceId

## deregistering instances from load-balancer

aws elb deregister-instances-from-load-balancer --load-balancer-name $loadBalancerName --instances $instanceId

## deleting listeners

aws elb delete-load-balancer-listeners --load-balancer-name $loadBalancerName --load-balancer-ports $ports

## deleting load balancers

aws elb delete-load-balancer --load-balancer-name $loadBalancerName 

## updating autoscaling group

aws autoscaling update-auto-scaling-group --auto-scaling-group-name $autoScalingGrpName --launch-configuration-name $autoScalingLCN --min-size 0 --max-size 0

## deleting autoscaling group

aws autoscaling delete-auto-scaling-group --auto-scaling-group-name $autoScalingGrpName --force-delete  

## deleting launch configuration

aws autoscaling delete-launch-configuration --launch-configuration-name $autoScalingLCN

## deleting rds db instances

aws rds delete-db-instance --db-instance-identifier $dbInstances --skip-final-snapshot

## wait

aws rds wait db-instance-deleted --db-instance-identifier $dbInstances

## deleting buckets

aws s3 ls | awk '{print $3}' | while read bucket; do echo $bucket; aws s3 rb s3://$bucket --force; done;

## deleting sqs topics

aws sqs delete-queue --queue-url $sqs_queue

## deleting sns topics

aws sns delete-topic --topic-arn $sns_topic_arn

echo "Deletion Successful"
