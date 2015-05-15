<meta charset="utf-8">
<?php
$link = mysql_connect('localhost','f7u124ru','sergeyproject') or die('Could not connect: '.mysql_error());
mysql_select_db('f7u124ru',$link) or die(mysql_error());
print_r(mysql_error());
