<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<?php
include $_SERVER['DOCUMENT_ROOT'].'/project/functions/dbconnect.php';
$register_code_confirm = $_GET['register_code'];
$sql_confirm_email = "UPDATE users SET register_code=NULL WHERE register_code='$register_code_confirm'";
$do_sql_confirm_email = mysql_query($sql_confirm_email, $link) or die(mysql_error());
if($do_sql_confirm_email)
{
?>
<br><div class="confirm_alert">Ваш аккаунт активирован!</div>
<div class="auth_refresh_5"><meta http-equiv="Refresh" content="5; url=http://f7u12.ru/project/sky_request/gallery/">Страница перезагрузится через 5 секунд.</div>
<?php
}
else
{
?>
    <br><div class="confirm_alert">Ошибка при подтверждении почты!</div>
<?php
}
?>
</body>
</html>

