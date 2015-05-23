<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
include __DIR__.DIRECTORY_SEPARATOR.'/protected/config/db.php';
$register_code_confirm = $_GET['register_code'];
$sql_confirm_email = "UPDATE users SET register_code=NULL WHERE register_code='$register_code_confirm'";
$do_sql_confirm_email = mysqli_query($link, $sql_confirm_email) or die(mysqli_error($link));
if($do_sql_confirm_email)
{
?>
<br><div class="confirm_alert">Ваш аккаунт активирован!</div>
<div class="auth_refresh_5"><meta http-equiv="Refresh" content="5; url=http://f7u12.ru/">Страница перезагрузится через 5 секунд.</div>
<?php
}
else
{
?>
    <br><div class="confirm_alert">Ошибка при подтверждении почты!</div>
<?php
}
?>
