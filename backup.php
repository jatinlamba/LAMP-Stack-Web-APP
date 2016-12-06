

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
$res=exec('mysqldump --user=jatindb --password=Jlamba1db --host='.$endpoint.' school -P 3306  > /tmp/backup.sql');
if($res=='')
{
$success = "Database backup is successfully saved at /tmp location";
}
else
{
}
?>
<html>
<head>
<meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css">
<title>Db backup Page</title>
<style>
    body {
        color: navy !important;;
        background-color: lightblue !important;;
        font-family: "Comic Sans MS", cursive, sans-serif ;
    }
    </style>
</head>
<body>
<h2>Welcome to DB backup Page</h2><br/>
<?php
echo $success;
echo "<br/>";
?>
<br>
<a href="welcome.php" class="btn btn-primary"> BackToHome</a> 
<a href="admin.php" class="btn btn-primary"> Admin </a>
</body>
</html>
