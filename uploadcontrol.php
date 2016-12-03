<?php
require 'vendor/autoload.php';
/* create connection */
$link = mysqli_connect("jl-instance1.cjuyoiserrk7.us-west-2.rds.amazonaws.com","jatindb","Jlamba1db","school",3306) or die("Error " . mysqli_error($link));
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: <br/> ", mysqli_connect_error());
    exit();
}
/* create Table */
$create_table = 'CREATE TABLE IF NOT EXISTS controller
(
    upload_status int(5) 
)';
/* execute querry*/
$create_tbl = $link->query($create_table);
if ($create_table) {
        echo " Table controller Created Successfully <br/> ";
}
else {
        echo "error!!";
}
/* INSERT statement */
if (!($stmt = $link->prepare("INSERT INTO controller (upload_status) VALUES (1)"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
if (!$stmt->execute()) {
     echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
/* explicit close recommended */
$stmt->close();
$link->close();
?>
