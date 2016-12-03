

<?php

session_start();

#echo "Your email is: " .  $_SESSION['username'];
$username = $_SESSION['username'];
#echo "\n" . md5($username);

$_SESSION['receipt'] = md5($username);
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
<div id="main">
<h1>Gallery </h1>
<a href="welcome.php"> Welcome </a> <a href="upload.php"> Upload </a>

<?php

$link = mysqli_connect("jl-instance1.cjuyoiserrk7.us-west-2.rds.amazonaws.com","jatindb","Jlamba1db","school",3306) or die("Error " . mysqli_error($link));

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: <br/> ", mysqli_connect_error());
    exit();
}

#echo "Your email is: " .  $_SESSION['username'];

$username = $_SESSION['username'];
$res = mysqli_query($link, "select * from ITEMS where username='$username'");

 while ($row = $res->fetch_assoc()) {
        $imageraw = $row['s3rawurl'];
    echo "<img src='$imageraw' >";
    echo "<br>";
}

$link->close();
?>
</body></html>
