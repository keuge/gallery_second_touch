<?php
//error_reporting(E_ALL); ini_set('display_errors', 1);
?>
<!doctype html>
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/bootstrap.css.map">
<script src="/scripts/jquery-2.1.3.js"></script>
<body class="full">
<meta charset="utf-8">
<div class="grey-fox questions-form-background">
    <br><br>
    <a href=""><img src="img/logo.png"></a>
    <br><br><br><br>
    <br>
    <?php
    session_start();
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'model/ArrayQuestionsComponent.php';
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'model/Pages.php';
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'view/QAForm.php';
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'model/Answers.php';
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'view/Success.php';
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'model/createWord/PHPDocx_0.9.2.php';
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'model/Email.php';


    $questionsArrayMaker = new ArrayQuestionsComponent();
    $questionsArray = $questionsArrayMaker->getQuestionsFromFileToArray('files/questions.txt');

    $currentPageArrayQuestionsGetter = new Pages();
    $currentPageArrayQuestions = $currentPageArrayQuestionsGetter->getCurrentPageQuestions($questionsArray);

    $qaFormRenderer = new QAForm();
    $qaFormRenderer->renderQuestionForm($currentPageArrayQuestions);

    $answersSessionGetter = new Answers();
//Записываем в переменную все полученные из формы ответы
    $allAnswers = $answersSessionGetter->getAnswers($questionsArray);
//Если нажали на кнопку отправить в конце опроса, то отправляем письмо с заполненным опросником в формате docx
    if(!empty($_POST['submitAnswers']))
    {
        $_SESSION['sendAnswers'] = $answersSessionGetter->sessionId;
        $wordCreator = new WordDocument("$answersSessionGetter->fileName.docx");
        $wordCreator->assign($allAnswers);
        $wordCreator->create();
        $emailSender = new Email();
        $emailSender->sendEmailWithAttachment("$answersSessionGetter->fileName.docx", 'verravar@yandex.ru');

    }

    $successInfoRenderer = new Success();
    $successInfoRenderer->checkIfAllQuestionsWhereAnswered();

    ?>
</div>
</body>
</html>
