
<?php

echo "inside checklogin";
session_start(); // Starting Session
$error=''; // Variable To Store Error Message

echo "before if";
if (isset($_POST['submit'])) {
if (empty($_POST['username']) || empty($_POST['password'])) {
$error = "Username or Password is invalid";
}
else
{

echo"checking credentials";
// Define $username and $password
$username=$_POST['username'];
$password=$_POST['password'];



// Establishing Connection with Server by passing server_name, user_id and password as a parameter

echo "trying to establish connection";
$link = mysqli_connect("jl-instance1.cjuyoiserrk7.us-west-2.rds.amazonaws.com","jatindb","Jlamba1db","school",3306) or die("Error " . mysqli_error($link));

echo "checking connection";
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: <br/> ", mysqli_connect_error());
    exit();
}

echo "querry time";
$result = mysqli_query($link, "select * from LOGIN_DETAILS where password='$password' AND username='$username'");

echo "getting row count";
$row_cnt = mysqli_num_rows($result);

echo "$row_cnt checking row count";

if ($row_cnt == 1) {
$_SESSION['username']=$username; // Initializing Session
header("location: welcome.php"); // Redirecting To Other Page
} else {
$error = "Username or Password is invalid";
}
echo "closed connection";
mysqli_close($link); // Closing Connection
}
}
echo "exiting file";
?>
