<!doctype html>
<link rel="stylesheet" href="css/bootstrap.css">
<script src="../scripts/jquery-2.1.3.js"></script>
<script src="js/parsley.js"></script>
<body class="full">
<div class="grey-fox questions-form-background">
    <br><br>
    <a href="index.php"><img src="img/logo.png"></a>
    <br><br><br><br>
    <br>
    <?php
    session_start();
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'model/ArrayQuestionsComponent.php';
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'model/Pages.php';
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'view/QAForm.php';
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'model/Answers.php';

    $questionsArrayMaker = new ArrayQuestionsComponent();
    $questionsArray = $questionsArrayMaker->getQuestionsFromFileToArray('files/questions.txt');

    $currentPageArrayQuestionsGetter = new Pages();
    $currentPageArrayQuestions = $currentPageArrayQuestionsGetter->getCurrentPageQuestions($questionsArray);

    $QAFormRenderer = new QAForm();
    $QAFormRenderer->renderQuestionForm($currentPageArrayQuestions);

    $answersSessionGetter = new Answers();
    $answersSessionGetter->getAnswers($questionsArray);

    ?>
</div>
</body>
</html>
