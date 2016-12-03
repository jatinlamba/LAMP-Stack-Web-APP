<?php
session_start();
echo "Logged in as: ";
echo $_SESSION['username'] . "\n";
$username = $_SESSION['username'];
$servername='jl-instance1.cjuyoiserrk7.us-west-2.rds.amazonaws.com';
$dbuser = "jatindb";
$password = "Jlamba1db";
$conn = new mysqli($servername, $dbuser, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql_upload_chk="select upload_status from school.controller";
$result_upload_ckh = $conn->query($sql_upload_chk);
$status = 0;
    while($row = $result_upload_ckh->fetch_assoc()) {
        $status=$row["upload"];
}
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
<?php
if($username == "controller" ) { 
?>
<br>
<br>
<a href="gallery.php"> Gallery </a> | <a href="upload.php"> Upload </a> | <a href="admin.php"> Admin </a> | <a href="index.php"> Logout </a> 
<?php
}
else
{ ?>
<br>
<br>
<a href="gallery.php"> Gallery </a> 
<a href="index.php"> Logout </a>
<?php
if ( $status == 0): ?>
<a href='upload.php' name='Upload'>Upload</a>
<?php else :?>
<br>
<br>
<p> Images disabled. Please contact Admin.   </p>
<?php endif;} ?>
</body>
</html>
