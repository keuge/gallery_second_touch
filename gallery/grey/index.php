<!doctype html>
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="../scripts/jquery-2.1.3.js">
<body class="full">
<div class="grey-fox questions-form-background">
    <br><br>
    <a href="index.php"><img src="img/logo.png"></a>
    <br><br><br><br>
    <br>
    <?php
    session_start();
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'show_quiz.php';
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'send_answers.php';

//          file_put_contents("$sessionId.doc",$questionAnswer);

//        mail_attachment("$sessionId.doc", "/", "keugere@gmail.com", "keugere@gmail.com", "$sessionId", "keugere@gmail.com", "Сообщение от $sessionId", "$sessionAnswer");

    ?>
</div>
</body>
</html>