<?php
$link = mysqli_connect('localhost','f7u124ru','sergeyproject') or die('Could not connect: '.mysqli_error($link));
mysqli_select_db($link,'f7u124ru') or die(mysqli_error($link));
print_r(mysqli_error($link));
