<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body id="background">
<?php
session_start();
if (empty($_SESSION['login'])) //если не авторизованы, то предлагает авторизоваться
{

?>
<div id='login_box'>
<form  action="login.php" method="post">
    <p>
    <label>Логин<br><br></label>
    <input  class="login_input" name="login" value="<?php if(!empty($_POST['login'])){echo $_POST['login'];}?>" type="text" size="15" maxlength="15">
    </p>
    <p>
    <label>Пароль<br><br></label>
    <input class="login_input" name="password" value="<?php if(!empty($_POST['password'])){echo $_POST['password'];}?>" type="password" size="15" maxlength="15">
    </p>
    <input class="login_submit" type="submit" name="submit" value="Войти">
    </form>
    <div id='back_to_index_from_login'><a href="index.php">Назад</a></div>
    <div id="forgot_password_box">
        <a name="forgot_password"href="password_recovery.php">Забыли пароль?</a></div>
</div>
<?php
}
else
{
    echo '<meta http-equiv="Refresh" content="0; url=http://f7u12.ru/project/sky_request/gallery/">';
}
?>
<?php
include __DIR__.DIRECTORY_SEPARATOR.'auth.php';?>
</body>
</html>
