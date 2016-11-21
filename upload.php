

<?php

session_start();
?>
<html>
<head><title>Best Page Ever</title></head>
<body>
<a href="gallery.php"> Gallery </a> <a href="upload.php"> Upload </a>
<h1> World</h1>


<form enctype="multipart/form-data" action="uploader.php" method="POST">
    <!-- MAX_FILE_SIZE must precede the file input field -->
    <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />

<input type="file" name="userfile" />
<input type="submit" value="submit" />
</form>

</body>
</html>
