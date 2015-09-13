<?php


$questions = file_get_contents("questions.txt");
$separatedText =  explode("\n",$questions);

foreach($separatedText as $key => $arrayQuestion)
{
    $sessionId = session_id();
    $realQuestionNumber = $key + 1;
    $answer = 'answer' . $realQuestionNumber;
    $_SESSION['currentPage'];

    if(!empty($_POST["$answer"]))
    {
        $sessionAnswer[$answer] = $_SESSION["$answer"] = $_POST["$answer"];
    }
    elseif(!empty($_SESSION["$answer"]))
    {
        $sessionAnswer[$answer] = $_SESSION["$answer"];
    }

    if($key<=3)
    {
        ?>
        <form name="questionForm" action="index.php" method="post">
        <div class="question-block">
            <a name="answer<?php echo $realQuestionNumber;?>"></a>
            <div class="question">
                <?php
                echo $arrayQuestion;
                ?>
            </div>
        </div>
        <br>
        <textarea name="answer<?php echo $realQuestionNumber;?>"  class="form-control "><?php echo $sessionAnswer["$answer"];?></textarea>
        <br>
        <?php
        if(!empty($sessionAnswer[$answer]))
        {
            $questionAnswer .= $arrayQuestion .' '. $sessionAnswer[$answer] . '
';
        }

        if($key == 3)
        {
            ?>
            <input class="btn btn-warning" type="submit" ><br><br>
                <?php
            }
        elseif($key %4 == 0 && $key>=5)
        {
            ?>
            <input class="btn btn-warning" type="submit">
            <input class="btn btn-warning" type="submit"><br><br>
                <?php
            }
    }
}
print_r($allAnswers);
?>

    <br>
<!--    <input class="btn btn-default" type="submit"/>-->
</form>
    <br>
<?
