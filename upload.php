
<?php

session_start();
?>
<html>
<head>
<meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css">
<title>Upload Page</title>
<style>
    body {
        color: navy !important;;
        background-color: lightblue !important;;
        font-family: "Comic Sans MS", cursive, sans-serif ;
    }
    </style>
</head>
<body>
<a href="gallery.php"> Gallery </a> <a href="welcome.php"> Welcome </a>
<h1> Upload </h1>


<form enctype="multipart/form-data" action="uploader.php" method="POST">
    <!-- MAX_FILE_SIZE must precede the file input field -->
    <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />

<input type="file" name="userfile" />
<input type="submit" value="submit" />
</form>

</body>
</html>
