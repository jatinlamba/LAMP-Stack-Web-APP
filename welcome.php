
<?php

session_start();

echo $_SESSION['username'] . "\n";

$username = $_SESSION['username'];

?>
<html>
<head>
<meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css">
<title>WELCOME</title>
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
<h1>Welcome </h1>
<hr />
<a href="gallery.php"> Gallery </a> | <a href="upload.php"> Upload </a>
</body>
</html>
