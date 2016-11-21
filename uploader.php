

<?php

session_start();
require 'vendor/autoload.php';

$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-west-2'
]);


// have to hard code this here because index.php doesn't exist
echo "\n" . $_SESSION['username'] ."\n";

// Retrieve the POSTED file information (location, name, etc, etc)

$uploaddir = '/tmp/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

#echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "File is valid, and was successfully uploaded.\n";
} else {
    echo "Possible file upload attack!\n";
}

echo 'Here is some more debugging info:';
print_r($_FILES);


// Upload file to S3 bucket
$s3result = $s3->putObject([
    'ACL' => 'public-read',
     'Bucket' => 'raw-jal',
      'Key' =>  basename($_FILES['userfile']['name']),
      'SourceFile' => $uploadfile


// Retrieve URL of uploaded Object
]);

$url=$s3result['ObjectURL'];
echo "\n". "This is your URL: " . $url ."\n";
/* create connection */
$link = mysqli_connect("jl-instance1.cjuyoiserrk7.us-west-2.rds.amazonaws.com","jatindb","Jlamba1db","school",3306) or die("Error " . mysqli_error($link));

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: <br/> ", mysqli_connect_error());
    exit();
}

// code to insert new record
/* Prepared statement, stage 1: prepare */
if (!($stmt = $link->prepare("INSERT INTO ITEMS (username, phone, s3rawurl, s3finishedurl, status, issubscribed, receipt
) VALUES (?, ?, ?, ?, ?, ?, ?)"))) {
    echo "Prepare failed: (" . $stmt->errno . ") " . $stmt->error;
}

$username=$_SESSION['username'];
$phone='3125361006';
$finishedurl=' ';
$status=0;
$issubscribed='0';
$receipt=md5($url);

// prepared statements will not accept literals (pass by reference) in bind_params, you need to declare variables
$stmt->bind_param('ssssiss', $username, $phone, $url ,$finishedurl, $status, $issubscribed, $receipt );

if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}

printf("%d Row inserted.\n", $stmt->affected_rows);


/* explicit close recommended */
$stmt->close();

// SELECT *

$link->real_query("SELECT * FROM items");
$res = $link->use_result();

echo "Result set order...\n";
while ($row = $res->fetch_assoc()) {
    echo " id = " . $row['id'] . "\n";
}


$link->close();

// PUT MD5 hash of raw URL to SQS QUEUE
$sqsclient = new Aws\Sqs\SqsClient([
            'region'  => 'us-west-2',
            'version' => 'latest'
        ]);

        // Code to retrieve the Queue URLs
        $sqsresult = $sqsclient->getQueueUrl([
            'QueueName' => 'inclassSQS', // REQUIRED
        ]);

        $queueUrl = $sqsresult->get('QueueUrl');
        echo "$queueUrl";

        //echo $sqsresult['QueueURL'];
        //$queueUrl = $sqsresult['QueueURL'];

        $sqsresult = $sqsclient->sendMessage([
            'MessageBody' => $receipt, // REQUIRED
            'QueueUrl' => $queueUrl // REQUIRED
        ]);

        echo $sqsresult['MessageId'];
?>
