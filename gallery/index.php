<?php header("Content-Type: text/html; charset=utf-8");?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>imagebase</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <?php
    session_start();
include  __DIR__.DIRECTORY_SEPARATOR.'/functions/dbconnect.php';
    ?>
</head>
<body id="background">
<?php
// Проверяем, авторизованы ли мы
if (empty($_SESSION['login']) or empty($_SESSION['id'])) //если нет, то выводим меню, доступное для незарегистрированных пользователей
{
?>
<div>
<div class="menu_box" id='register_login_box'>
<a href='reg.php'>Регистрация</a>
<a href='login.php'>Вход</a>
    <br>
    </div>
    <?php
    if($_GET['register_code'] !== NULL)
    {
        include  __DIR__.DIRECTORY_SEPARATOR.'confirm_reg.php';
    }
    else
    {?>
        <div id="important_index_message">
            Картинки
            <br>
            тут!
        </div>
    <?php
    }
    ?>
<?php
}
else //если зареганы, то показываем меню
{
?>
<div class="auth_box" id='gallery_exit_box'>
            <a href="gallery.php">Галерея</a>
            <a href="exit.php">Выйти</a>
</div>
<?php
    echo " <div class='hello'>Привет, " . ' ' . $_SESSION['login']. '!<?div><br>';
}
?>
    </div>
</body>
</html>