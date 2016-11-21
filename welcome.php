

<?php

session_start();

echo $_SESSION['username'] . "\n";

$username = $_SESSION['username'];

?>
<html>
<head><title>WELCOME</title>
</head>
<body>
<hr />
<a href="gallery.php"> Gallery </a> | <a href="upload.php"> Upload </a>
</body>
</html>
