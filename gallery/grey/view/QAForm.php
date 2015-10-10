<?php
session_start();
//вывод формы с вопросами
class QAForm
{
    public function renderQuestionForm($questionsArray)
    {
        if(!empty($questionsArray))
        {
            echo '<form data-toggle="validator" action="" method="post">';
            if(!empty($_SESSION['percentQuestion']))
            {
                $percentQuestion = $_SESSION['percentQuestion'].'%';
            }
            else
            {
                $percentQuestion = 1 . '%';
            }
            ?><div class="percent_and_progress_bar"><?php echo $percentQuestion;?>
            <div class="progress">
            <div class="progress-bar active"  aria-valuenow="<?php echo $percentQuestion;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $percentQuestion;?>">
            </div>
            </div></div><?php
            foreach($questionsArray as $number=>$currentQuestion)
            {
                $question = array('number'=>$number,'currentQuestion'=>$currentQuestion);
                $this->renderSingleQuestion($question);
            }
            if($_SESSION['currentPage'] == 1 )
            {
                echo '<div class="previous_next_submit_block"><input name="nextPage" class="btn btn-danger" type="submit" value="Следующая страница"></div><br><br>';
            }
            elseif($_SESSION['currentPage'] == $_SESSION['pagesCount'] + 1)
            {
                echo '<div class="previous_next_submit_block"><input name="previousPage" class="btn btn-warning" type="submit" value="Предыдущая страница">'.' ';
                echo '<input name="submitAnswers" class="btn btn-danger" type="submit" value="Отправить"></div><br><br>';
            }
            else
            {
                echo '<div class="previous_next_submit_block"><input name="previousPage" class="btn btn-warning" type="submit" value="Предыдущая страница">'.' ';
                echo '<input name="nextPage" class="btn btn-danger" type="submit" value="Следующая страница"></div><br><br>';
            }
            ?>
            <?php
            echo '</form>';
        }
        else
        {
            return false;
        }

        return true;
    }

    private  function renderSingleQuestion($question)
    {
        $correctQuestionNumber = $question['number'] + 1 ;
        $answer = $_SESSION['answer_'.$correctQuestionNumber];
        echo '<div class="question-block">';
        echo '<div class="question">';
        echo $question['currentQuestion'];
        echo ' </div></div>';
        echo '<textarea class="form-control" name="answer_';?><?php echo $correctQuestionNumber;?>"><?php echo $answer; ?></textarea>
    <?php
    }

}