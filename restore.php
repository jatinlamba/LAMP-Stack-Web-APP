<?php
$restore_file  = "/var/tmp/.sql";
$server_name   = "jl-instance1.cjuyoiserrk7.us-west-2.rds.amazonaws.com";
$username      = "jatindb";
$password      = "Jlamba1db";
$database_name = "school";
$cmd = "mysql -h {$server_name} -u {$username} -p{$password} {$database_name} < $restore_file";
exec($cmd);
?>
