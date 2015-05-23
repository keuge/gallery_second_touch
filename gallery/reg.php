<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="styles.css">
<script src="/scripts/jquery-2.1.3.js"></script>
</head>
<body id="background">
<?php
session_start();
include  __DIR__.DIRECTORY_SEPARATOR.'/functions/search_errors.php';
include  __DIR__.DIRECTORY_SEPARATOR.'/protected/config/db.php';
if (empty($_SESSION['login'])) //если не авторизованы, то предлагает авторизоваться
{

    ?>
<div id='register_box' >

<form id="submit" class="reg_input" action="reg.php" method="post">
    <p><input class="reg_input" type="text" name="login" value="<?php if(!empty($_POST['login'])){echo $_POST['login'];}?>" placeholder="Логин"/></p>
    <p><input class="reg_input"type="email" name="email" value="<?php if(!empty($_POST['email'])){echo $_POST['email'];}?>" placeholder="Почта"/></p>
    <p><input class="reg_input" type="password" name="password" value="<?php if(!empty($_POST['password'])){echo $_POST['password'];}?>" maxlength="13" placeholder="Пароль"></p>
    <p><input class="reg_input" type="password" name="password2" value="<?php if(!empty($_POST['password'])){echo $_POST['password'];}?>" maxlength="13" placeholder="Еще раз пароль"></p>
<!--    <a href=reg.php onclick="document.getElementById('submit').submit()" >отправить</a>-->
    <input id='register_box_input' type="submit" name="submit"  value="Зарегистрироваться">
</form>
    <div  id='register_box_input'><a href="index.php">Назад</a></div>
</div>
<br>
<?php
    if (isset($_POST['submit']))
    {
        if(isset($_POST['login']))
        {
            $login = $_POST['login'];

            if($login == '')
            {
                unset($login);
            }

        }
        if(isset($_POST['email']))
        {
            $email = $_POST['email'];

            if($email == '')
            {
                unset($email);
            }
        }
        if(empty($login) OR empty($email))
        {
            exit ( '<br><div class="auth_alert"> Не все поля были заполнены!!!</div>');
        }
        if(isset($_POST['password']))
        {
            if ($_POST['password'] !== $_POST['password2'])
            {
                exit ('<br><div class="auth_alert">Пароли не совпадают. Давай еще раз попробуем?</div>');
            }
            $password = $_POST['password'];
            if (preg_match("#.*^(?=.{8,20}).*$#", $password)){
//            echo "<div class='reg_input'></div>";
            } else {
                exit("<div class='auth_alert'>Пароль не безопасный. Нужно ввести не менее 8 символов.</div>");
            }

            if($password == '')
            {
                unset($password);
            }
        }
        $register_code =  md5(uniqid(rand()));
        //защита от взлома
        $login = stripslashes($login);
        $login = htmlspecialchars($login);
        $password = stripslashes($password);
        $password = htmlspecialchars($password);
        $email = stripslashes($email);
        $email = htmlspecialchars($email);

        $login = trim($login);
        $password = trim($password);
        $email = trim($email);
        //шифрование
        $password = md5($password);
        //проверка на существование пользователя
        $resultlogin = mysqli_query($link, "SELECT id FROM users WHERE login='$login'");
        $checklogin = mysqli_fetch_array($resultlogin);
        $resultemail = mysqli_query($link, "SELECT id FROM users WHERE email='$email'");
        $checkemail = mysqli_fetch_array($resultemail);
        if (!empty($checklogin['id']) OR !empty($checkemail['id']))
        {
            exit("<div class='auth_alert'> Такая почта или логин уже есть.</div>");
        }
        //если нету логина такого, то создаем нового пользователя
        $result2 = mysqli_query($link, "INSERT INTO users (login, email, password, register_code) VALUES('$login','$email','$password','$register_code')");
        if($result2 == 'TRUE')
        {
            $to = $email;
            $subject = "Подтверждение почты для $login";
            $header = "http://f7u12.ru подтверждение почты.";
            $message = "Нажмите на ссылку, чтобы зарегистрироваться ";
            $message.= "http://f7u12.ru/index.php?register_code=$register_code";
            $sendmail = mail($to,$subject,$message,$header);
            if($sendmail)
            {
                echo '<div class="auth_alert">Вам на почту отправлено письмо с подтверждением!</div>';
//            echo "<div class='auth_alert'> Все в порядке. Вы зарегистрированы, $login.</div>";
                echo '<meta http-equiv="Refresh" content="5; url=http://f7u12.ru/">';
            }
            else
            {
                echo '<br><div class="auth_alert">Не получилось отправить сообщение на почту</div>';
            }
        }
        else
        {
            echo '<br><div class="auth_alert">Что-то пошло не так. Вы не были зарегистрированы. </div>';
        }
        print_r(mysql_error());
    }
}
else
{
    echo '<meta http-equiv="Refresh" content="0; url=http://f7u12.ru/">';
}
?>
</body>
</html>