

<?php

session_start();

echo "Logged in as: " .  $_SESSION['username'];
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
<br>
<br>
<a href="welcome.php"> Home </a> | <a href="index.php"> Logout </a>
<?php
$link = mysqli_connect("jl-instance1.cjuyoiserrk7.us-west-2.rds.amazonaws.com","jatindb","Jlamba1db","school",3306) or die("Error " . mysqli_error($link));
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: <br/> ", mysqli_connect_error());
    exit();
}
$username = $_SESSION['username'];
$res = mysqli_query($link, "select * from ITEMS where username='$username'");
if ($res->num_rows > 0)
{
 while ($row = $res->fetch_assoc()) {
        $imageraw = $row['s3rawurl'];
        $imagefin =$row["s3finishedurl"];
    echo "<br>";
    echo  "<div style='padding-right:10px;float:left'><img src='". $imageraw . "' height=250 width=250 /> </div>";
         echo  "<div style='padding-right:10px;float:left'><img src='". $imagefin . "' height=250 width=250 /> </div>";
}
}
else
{
        echo "<br>";
        echo "<br>";
echo " Empty gallery! Use the Upload link to add some images to your gallery";
}

$link->close();
?>
</body></html>
