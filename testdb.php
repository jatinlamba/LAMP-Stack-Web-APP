
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
$create_table = 'CREATE TABLE LOGIN_DETAILS
(
    username VARCHAR(50),
    password varchar(30)
)';

/* execute querry*/
$create_tbl = $link->query($create_table);
if ($create_table) {
        echo " Table Login Information Created Successfully <br/> ";
}
else {
        echo "error!!";
}

/* INSERT statement */
if (!($stmt = $link->prepare("INSERT INTO LOGIN_DETAILS (username, password) VALUES ('jlamba1@hawk.iit.edu','Nopassword'),('jhajek@hawk.iit.edu','Nopassword'),('Controller', 'Nopassword')"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
if (!$stmt->execute()) {
     echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
/* explicit close recommended */
$stmt->close();

$link->real_query("SELECT * FROM LOGIN_DETAILS");

$res = $link->use_result();

echo "Result set order...<br/>";

while ($row = $res->fetch_assoc()) {
    echo "<br/> name = " . $row["username"];
        echo "<br/> password = " . $row["password"];
}
$link->close();
?>
