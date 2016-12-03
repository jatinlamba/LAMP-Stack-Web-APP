

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
$create_table = 'CREATE TABLE IF NOT EXISTS ITEMS
(
    username VARCHAR(80),
    phone varchar(10),
    s3rawurl varchar(80),
    s3finishedurl varchar(80),
    issubscribed VARCHAR(20),
    status int,
    receipt VARCHAR(80)
)';

/* execute querry*/
$create_tbl = $link01->query($create_table);
if ($create_table) {
        echo " Table Items Created Successfully <br/> ";
}
else {
        echo "error!!";

}

$link01->close();
?>

