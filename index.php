

<?php
include('check.php'); // Includes Login Script
?>
<!DOCTYPE html>
<html>
<head>
<title>Welcome</title>
</head>
<body>
<div id="main">
<h1>Login Session </h1>
<div id="login">
<h2>Login Form</h2>
<form action="" method="post">
<label>UserName :</label>
<input id="username" name="username" placeholder="username" type="text">
<label>Password :</label>
<input id="password" name="password" placeholder="****" type="password">
<input name="submit" type="submit" value=" Login ">
<span><?php echo $error; ?></span>
</form>
</div>
</div>
</body>
</html>
