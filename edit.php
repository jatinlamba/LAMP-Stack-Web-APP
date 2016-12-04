

<?php
session_start();
require 'vendor/autoload.php';
$sqsclient = new Aws\Sqs\SqsClient([
    'region'  => 'us-west-2',
    'version' => 'latest'
]);
 $sqsresult = $sqsclient->getQueueUrl([
    'QueueName' => 'jatinSQS'
]);
$queueUrl = $sqsresult['QueueUrl'];
    $res = $sqsclient->receiveMessage(array(
        'QueueUrl' => $queueUrl,
    ));
    if ($res->getPath('Messages')) {
        foreach ($res->getPath('Messages') as $msg) {
            echo "Received Msg: ".$msg['Body'];
            $_SESSION['receipt']=$msg['Body'];

if ($_SESSION['receipt']!=null)
{
$servername='jl-instance1.cjuyoiserrk7.us-west-2.rds.amazonaws.com';
$username = "jatindb";
$password = "Jlamba1db";
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_select="select s3rawurl from school.ITEMS where receipt='{$_SESSION['receipt']}'";
$result= $conn->query($sql_select);
while($row = $result->fetch_assoc())

{

$s3_url=$row["s3rawurl"];
$stamp = imagecreatefrompng('/jlamba1/IIT-logo.png');
echo $s3_url;
$im = imagecreatefromjpeg($s3_url);
$marge_right=10;
$marge_bottom=10;
$sx = imagesx($stamp);
$sy = imagesy($stamp);
imagecopy($im,$stamp,imagesx($im) - $sx -$marge_right, imagesy($im) - $sy -$marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
imagepng($im,'/var/tmp/rendered.png');

$sharedConfig = [
    'region'  => 'us-west-2',
    'version' => 'latest',
	];
$sdk = new Aws\Sdk($sharedConfig);
$s3 = $sdk->createS3();
$key="finished_". $_SESSION['receipt'];
$result_upload = $s3->putObject([
    'Bucket'     => 'finished-jal',
    'Key'        => $key,
    'SourceFile' => '/var/tmp/rendered.png',
    'ACL'        => 'public-read'
]);
$url_rex = $result_upload['ObjectURL'];
echo $url_rex;

$receipt=$_SESSION['receipt'];
$servername='jl-instance1.cjuyoiserrk7.us-west-2.rds.amazonaws.com';
$username = "jatindb";
$password = "Jlamba1db";
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql_update_status="update school.ITEMS set s3finishedurl='{$url_rex}' where receipt='{$receipt}'";
if ($conn->query($sql_update_status) === TRUE) {
} else {
    echo "Error updating record: " . $conn->error;
}
$res = $sqsclient->deleteMessage(array(
                'QueueUrl'      => $queueUrl,
                'ReceiptHandle' => $msg['ReceiptHandle']
            ));

$snsclient = new Aws\Sns\SnsClient([
    'region'  => 'us-west-2',
    'version' => 'latest'
]);
$result_sns = $snsclient->publish(array(
    'TopicArn' => 'arn:aws:sns:us-west-2:513030886372:awscli',
    // Message is required
    'Message' => 'Final Image Is Ready for Display ' . $receipt .' URL : ' . $url_rex,
    'Subject' => 'IIT-logoStamp Gallery',
));
}
}
        }
}
echo "\n";
?>
