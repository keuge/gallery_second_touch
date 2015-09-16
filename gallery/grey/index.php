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
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'model/arrayQuestions.php';
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'model/QA.php';
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'view/QAForm.php';



    $makeArrayQuestions = new ArrayQuestionsComponent();
    $makeArrayQuestions->getQuestionsFromFileToArray('files/questions.txt');
    $keys = $makeArrayQuestions->keys;

    $_SESSION['currentPage'] = 1;
    $genQA = new QA();
    $genQA->getQA($_SESSION['currentPage'],$_GET['currentPage'], $_GET['previousPage'], $_GET['nextPage'], $keys);

    $showQAForm = new QAForm();


    $array;
    $someViewClassObject->renderQuestionForm($array);

//    $showQAForm->getQAForm($makeArrayQuestions, );

    ?>
</div>
</body>
</html>