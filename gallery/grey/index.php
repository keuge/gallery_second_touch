<!doctype html>
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/bootstrap.css.map">
<script src="/scripts/jquery-2.1.3.js"></script>
<script src="js/jd.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<body class="full">
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

    $questionsArrayMaker = new ArrayQuestionsComponent();
    $questionsArray = $questionsArrayMaker->getQuestionsFromFileToArray('files/questions.txt');

    $currentPageArrayQuestionsGetter = new Pages();
    $currentPageArrayQuestions = $currentPageArrayQuestionsGetter->getCurrentPageQuestions($questionsArray);

    $QAFormRenderer = new QAForm();
    $QAFormRenderer->renderQuestionForm($currentPageArrayQuestions);

    $answersSessionGetter = new Answers();
    $answersSessionGetter->getAnswers($questionsArray);

    $successInfoRenderer = new Success();
    $successInfoRenderer->checkIfAllQuestionsWhereAnswered();

    ?>
</div>
</body>
</html>
