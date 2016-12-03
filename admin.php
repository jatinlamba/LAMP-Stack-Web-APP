<?php
session_start();
$servername='jl-instance1.cjuyoiserrk7.us-west-2.rds.amazonaws.com';
$username = "jatindb";
$password = "Jlamba1db";
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$upload_status=$_POST["upload_select_status"];
//echo $upload_status;
if ( $upload_status == "On" )
{
echo "Upload On";
$sql_update_status="update school.controller set upload_status = 0 where upload_status= 1";
}
elseif ($upload_status == "blank" )
{
$sql_update_status="select upload_status from school.controller";
}
elseif ($upload_status == "Off" )
{
echo "Its Off";
$sql_update_status="update school.controller set upload_status= 1 where upload_status= 0";
}
if ($conn->query($sql_update_status) === TRUE) {
//    echo "Record updated successfully";
} else {
   //
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
<body>
<form action = "" method = "post">
Image Upload
<select name="upload_select_status">
  <option value="blank"> </option>
  <option value="On">ON</option>
  <option value="Off">OFF</option>
</select>
<input type="submit" value="Submit" /></br>
</form>
</body>
<br>
<br>
<a href="gallery.php"> Gallery </a> | <a href="backup.php"> Backup DB </a> |  <a href="index.php"> Logout </a>
</head>
</html>
