<?php

require 'vendor/autoload.php';

use Aws\Rds\RdsClient;
$client = RdsClient::factory(array(
'credentials' => array(
'key'    => 'AKIAIOWQFOCIR4RW633A',
'secret' => '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'),
'region'  => 'us-west-2',
'version' => 'latest'
));


$result = $client->describeDBInstances(array(
    'DBInstanceIdentifier' => 'jl-instance1',
));



$endpoint = ""; 


foreach ($result->getPath('DBInstances/*/Endpoint/Address') as $ep) {
    // Do something with the message
    echo "============". $ep . "================";
    $endpoint = $ep;
}



echo "school database";
$link = mysqli_connect($endpoint,"jatindb","Jlamba1db","awsDb") or die("Error " . mysqli_error($link));

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
/*
$delete_table = 'DELETE TABLE student';
$del_tbl = $link->query($delete_table);
if ($delete_table) {
        echo "Table student has been deleted";
}
else {
        echo "error!!";

}
*/

$create_table = 'CREATE TABLE IF NOT EXISTS student
(
    id INT NOT NULL AUTO_INCREMENT,
    Name VARCHAR(255),
    Age INT(32),
    PRIMARY KEY(id)
)';



$create_tbl = $link->query($create_table);
if ($create_table) {
	echo "Table is created or No error returned.";
}
else {
        echo "error!!";  
}

/* INSERT statement */
if (!($stmt = $link->prepare("INSERT INTO student (id, name, age) VALUES (NULL,?,?)"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

$id = 1;
$name = "Jatin";
$age = 24;

$stmt->bind_param("si",$name,$age);

if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}

printf("%d Row inserted.\n", $stmt->affected_rows);


/* explicit close recommended */
$stmt->close();

$link->real_query("SELECT * FROM student");
$res = $link->use_result();

echo "Result set order...\n";
while ($row = $res->fetch_assoc()) {
    echo " id = " . $row['id'] . "\n";
}

$link->close();
?>

