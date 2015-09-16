<?php

$questions = file("files/questions.txt");

foreach($questions as $key => $arrayQuestion)
{
    $keys[] .= $key;
    $arrayQuestions[] .= $arrayQuestion;
}

$keyAndQuestion = array_combine($keys, $arrayQuestions);
$sessionId = session_id();
$countKeys = count($keys);


if(empty($_SESSION['currentPage']) || !isset($_SESSION['currentPage']) || $_SESSION['currentPage'] <= 0)
{
   $_SESSION['currentPage'] = 1;
}
elseif(!empty($_SESSION['currentPage']))
{

    if(!empty($_GET['currentPage']))
    {
         $_SESSION['currentPage'] = $_GET['currentPage'];
    }

    if(!empty($_GET['previousPage']))
    {
        $_SESSION['currentPage'] =  $_SESSION['currentPage'] - 1;
    }
    elseif(!empty($_GET['nextPage']))
    {
        $_SESSION['currentPage'] = $_SESSION['currentPage'] + 1;
    }

    echo $_SESSION['currentPage'];
    $toQuestion = $_SESSION['currentPage'] * 4 - 1;
    $fromQuestion = $toQuestion - 3;


    for($i=$fromQuestion; $i<=$toQuestion;$i++)
    {

    $answer = 'answer' . $keys[$i];

    if(!empty($_GET["$answer"]))
    {
        $sessionAnswer[$answer] = $_SESSION["$answer"] = $_GET["$answer"];
    }
    elseif(!empty($_SESSION["$answer"]))
    {
        $sessionAnswer[$answer] = $_SESSION["$answer"];
    }


    ?>

<!--$this->render('views/form', array('arrayQuestions'=>$arrayQuestions))-->


    <form name="questionForm" action="index.php" method="get">
        <div class="question-block">
            <div class="question">
                <?php
                echo $arrayQuestions["$i"];
                ?>
            </div>
        </div>
        <br>
        <textarea name="answer<?php echo $keys[$i];?>"  class="form-control" ><?php echo $sessionAnswer["$answer"];?></textarea>
        <br>
        <?php
        if(!empty($sessionAnswer[$answer]))
        {
            $questionAnswer .= $arrayQuestions["$i"] .' '. $sessionAnswer[$answer] . '
    ';
        }
        }
        ?>
    <!--    <input type="hidden" name="currentPage" value="1">-->
        <?php
        if($toQuestion <= 3)
        {
            ?>
            <input name="nextPage" class="btn btn-warning" type="submit" value="Следующая страница" ><br><br>
        <?php
        }
        elseif($toQuestion >= 3 && $toQuestion <115)
        {
            ?>
            <input name="previousPage" class="btn btn-warning" type="submit" value="Предыдущая страница">
            <input name="nextPage" class="btn btn-warning" type="submit" value="Следующая страница" ><br><br>
        <?php
        }
    }
?>
<br />
</form>
<br />
<!--ob_start()     ob_end() ob_flush()-->
