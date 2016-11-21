

<?php

session_start();

echo "Your email is: " .  $_SESSION['username'];
$username = $_SESSION['username'];
echo "\n" . md5($username);

$_SESSION['receipt'] = md5($username);
?>

<html>
<head><title>Hello app</title>
</head>
<body>
Gallery PHP
<a href="gallery.php"> Gallery </a> <a href="upload.php"> Upload </a>

<?php

echo "trying to establish connection";
$link = mysqli_connect("jl-instance1.cjuyoiserrk7.us-west-2.rds.amazonaws.com","jatindb","Jlamba1db","school",3306) or die("Error " . mysqli_error($link));
echo "checking connection";
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: <br/> ", mysqli_connect_error());
    exit();
}

echo "querry time";
echo "Your email is: " .  $_SESSION['username'];

$username = $_SESSION['username'];
$res = mysqli_query($link, "select * from ITEMS where username='$username'");

echo "Result set order...<br/>";

 while ($row = $res->fetch_assoc()) {
        $imageraw = $row['s3rawurl'];
    echo "<img src='$imageraw' >";
    echo "<br>";
}

$link->close();
?>
</body></html>
