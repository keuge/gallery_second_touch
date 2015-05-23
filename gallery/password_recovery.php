<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body id="background">
<?php
session_start();
include  __DIR__.DIRECTORY_SEPARATOR.'/protected/config/db.php';
include  __DIR__.DIRECTORY_SEPARATOR.'/functions/search_errors.php';
if(!empty($_GET['recovery_login_confirm']))
{
    ?>
<div id='password_recovery_box'>
    <form action="" method="post">
        Новый пароль
        <br><br>
        <input class="reset_password_input" type="password" name="new_password" size="15">
        <br><br>
        <input class="reset_password_submit" type="submit" name="submit_new_password" value="Изменить пароль">
    </form>
    <div  id='back_to_index_from_recovery_box'><a href="index.php">Назад</a></div>
    </div>
    <?php
    echo '<br>';
    if(!empty($_POST['new_password']))
    {
        $recovery_login_confirm = $_GET['recovery_login_confirm'];
        $new_password = md5($_POST['new_password']);
        echo '<br>';
        $sql_password_change = "UPDATE users SET password='$new_password', reset_password=NULL WHERE reset_password='$recovery_login_confirm'";
        $do_sql_password_change = mysqli_query($link, $sql_password_change) or die(mysqli_error($link));
        ?>
<div class='email_changed'>Пароль изменен.</div>
        <div class='email_recover' ><meta http-equiv="Refresh" content="5; url=http://f7u12.ru/">Страница перезагрузится через 5 секунд.</div>
        <?php
    }
}
else
{
?>
<div id='password_recovery_box'>
    <form  action="" method="post">
            <label>Логин<br><br></label>
            <input class="reset_password_input" type="text" name="recovery_login"  size="15"/><br><br>
            <label>Почта<br><br></label>
            <input class="reset_password_input" type="text" name="recovery_email" size="15"/><br><br>
        <input class="restore_input" type="submit" name="submit" value="Восстановить">
    </form>
    <div  id='back_to_index_from_recovery_box'><a href="index.php">Назад</a></div>
        </div>
<?php
    if(!empty($_POST['recovery_login']) AND !empty ($_POST['recovery_email']))
    {

        $login_to_recover = $_POST['recovery_login'];
        $email_to_recover = $_POST['recovery_email'];
        $sql_recover_user_password = "SELECT * FROM users WHERE login='$login_to_recover'";
        $do_sql_recover_user_password = mysqli_query($link, $sql_recover_user_password) or die(mysqli_error($link));
        $show_sql_recover_user_password = mysqli_fetch_array($do_sql_recover_user_password);
        $reset_password_code = md5(uniqid(rand()));
        $sql_update_user_data = 'UPDATE users SET reset_password="'.$reset_password_code.'" WHERE login="'.$login_to_recover.'"';
        $do_update_user_data = mysqli_query($link, $sql_update_user_data);
        if($_POST['recovery_login'] == $show_sql_recover_user_password['login'] AND $_POST['recovery_email'] == $show_sql_recover_user_password['email'])
    {
        $to = $email_to_recover;
        $subject = "Восстановление доступа к учетной записи $login_to_recover";
        $header = "http://f7u12.ru/index.php восстановление доступа к учетной записи.";
        $message = "http://f7u12.ru/password_recovery.php?recovery_login_confirm=$reset_password_code";
        $sendmail = mail($to,$subject,$message,$header);
        ?>
        <div class='email_recover'>Если вы указали правильные данные, то вам на почту выслана ссылка для создания нового пароля.</div>
        <div class='email_recover' ><meta http-equiv="Refresh" content="5; url=http://f7u12.ru/">Страница перезагрузится через 5 секунд.</div>
        <?php
        ?>
    <?php
    }
    else
    {
        ?>
        <div class='email_recover'>Если вы указали правильные данные, то вам на почту выслана ссылка для создания нового пароля.</div>
<div class='email_recover'><meta http-equiv="Refresh" content="5; url=http://f7u12.ru/">Страница перезагрузится через 5 секунд.</div>
<?php

    }
}
}?>
</body>
</html>
