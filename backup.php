<?php

$result=exec('mysqldump --user=jatindb --password=Jlamba1db --host= jl-instance1.cjuyoiserrk7.us-west-2.rds.amazonaws.com school -P 3306  > /var/tmp/BACKUP.sql');

if($result=='')
{
echo "Database backup is successfully saved at /var/tmp Folder";
}
else
{
}

?>
