<?php
require 'vendor/autoload.php';
echo "Starting Database<br />";
$link = mysqli_connect("jl-instance1.cjuyoiserrk7.us-west-2.rds.amazonaws.com","jatindb","Jlamba1db","school",3306) or die("Error " . mysqli_error($link));
/* check connection */
if (mysqli_connect_errno()) {
printf("Connect failed: %s <br/>", mysqli_connect_error());
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
	echo "Table is created or No error returned.<br />";
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
printf("%d Row inserted.<br />", $stmt->affected_rows);
/* explicit close recommended */
$stmt->close();
$link->real_query("SELECT * FROM students");
$res = $link->use_result();
echo "Result set order...<br />";
while ($row = $res->fetch_assoc()) {
    echo " Id = " . $row['id'] . "<br />";
	echo " Name = " . $row['Name'] . "<br />";
	echo " Age = " . $row['Age'] . "<br />";
}
$link->close();
?>

<html>
<head>
<meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css">
<title>Gallery Page</title>
<style>
    body {
        color: navy !important;;
        background-color: lightblue !important;;
        font-family: "Comic Sans MS", cursive, sans-serif ;
    }
    </style>
</head>
<body>

