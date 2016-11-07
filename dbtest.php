<?php
require 'vendor/autoload.php';
<<<<<<< HEAD

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

=======
echo "begin database";
$link = mysqli_connect("jl-instance1.cjuyoiserrk7.us-west-2.rds.amazonaws.com:3306","jatindb","Jlamba1db","awsDb") or die("Error " . mysqli_error($link));
>>>>>>> 3f82105abe5dc8aa1ed61fa3ac6f057c52d25ff5
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$create_table = 'CREATE TABLE IF NOT EXISTS students
(
    id INT NOT NULL AUTO_INCREMENT,
    Name VARCHAR(255),
    Age INT(3),
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
if (!($stmt = $link->prepare("INSERT INTO students (Name, Age) VALUES ('Jatin', 24),('Raveena', 24),('Varun', 28),('Jasmine' , 23),('Jacqueline', 27)"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
printf("%d Row inserted.\n", $stmt->affected_rows);
/* explicit close recommended */
$stmt->close();
$link->real_query("SELECT * FROM students");
$res = $link->use_result();
echo "Result set order...\n";
while ($row = $res->fetch_assoc()) {
    echo " Id = " . $row['id'] . "\n";
	echo " Name = " . $row['Name'] . "\n";
	echo " Age = " . $row['Age'] . "\n";
}
$link->close();
?>⁠⁠⁠⁠
