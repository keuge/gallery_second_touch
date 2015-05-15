<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="styles.css">
<script src="/project/sky_request/gallery/functions/jquery-2.1.3.js"></script>
</head>
<body>
<?php
session_start();
if (isset($_POST['login']) OR isset($_POST['password']))
{
    $login = $_POST['login'];
    if ($login == '')
    {
        unset($login);
    }
    if (isset($_POST['password']))
    {
        $password = $_POST['password'];
        $password = md5($password);
        if($password == '')
        {
            unset ($password);
        }
    }
    if (empty ($login))
    {
        exit('<br><div  class="auth_alert" >Не введен логин!<br><br>
           <br></div>');
    }
    if ( empty($password))
    {
        exit('<br><div  class="auth_alert" >Не введен пароль!<br><br><br></div>');
    }
    $login = stripslashes($login);
    $login = htmlspecialchars($login);
    $password = stripslashes($password);
    $password = htmlspecialchars($password);
    //убираем пробелы
    $login = trim($login);
    $password = trim($password);

    include  __DIR__.DIRECTORY_SEPARATOR.'/functions/dbconnect.php';
    $sql_check_if_reg_code_null = mysql_query("SELECT register_code FROM users WHERE login='$login'",$link);
    $result = mysql_query("SELECT * FROM users WHERE login='$login' AND register_code is NULL",$link); //извлекаем из базы все данные о пользователе с введенным логином и подтсвержденной почтой
    $myrow = mysql_fetch_array($result);
    $check_if_reg_code_null = mysql_fetch_array($sql_check_if_reg_code_null);
    if($myrow['password'] !== $password)
    {
        echo '<br><div  class="auth_alert" >Пароль или логин неправильный!<br><br><br></div>';
    }
    else
    {
        if($myrow['password']==$password)
        {
            $_SESSION['login']=$myrow['login'];
            $_SESSION['id']=$myrow['id'];
//            echo "Вы зайшли на сайт! <a href='index.php'>Главная страница</a>";
            echo '<meta http-equiv="Refresh" content="0; url=http://f7u12.ru/project/sky_request/gallery/">';
        }
        else
        {
           echo '<br><div  class="auth_alert" >Пароль или логин не подошли!<br><br><br></div>';
        }
    }
    }
?>
</body>
</html>