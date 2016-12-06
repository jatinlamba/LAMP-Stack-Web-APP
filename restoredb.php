
<?php
require 'vendor/autoload.php';
use Aws\Rds\RdsClient;
$client = RdsClient::factory(array(
'version' => 'latest',
'region'  => 'us-west-2'
));
$result = $client->describeDBInstances(array(
    'DBInstanceIdentifier' => 'jl-instance1',
));
$endpoint = $result['DBInstances'][0]['Endpoint']['Address'];
//print_r($endpoint);
$restore_file  = "/tmp/backup.sql";
$username      = "jlambadb";
$password      = "Jlamba1db";
$database_name = "school";
$cmd = "mysql -h {$endpoint} -u {$username} -p{$password} {$database_name} < $restore_file";
exec($cmd);
?>
