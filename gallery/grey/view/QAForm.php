<?php
session_start();
//вывод формы с вопросами
class QAForm
{
    public function renderQuestionForm($questionsArray)
    {
        if(!empty($questionsArray))
        {
            echo '<form action="" method="post">';

            foreach($questionsArray as $number=>$currentQuestion)
            {
                $question = array('number'=>$number,'currentQuestion'=>$currentQuestion);
                $this->renderSingleQuestion($question);
            }
            echo '<div class="BF_Buttons"><input name="previousPage" class="btn btn-warning" type="submit" value="Предыдущая страница">'.' ';
            echo '<input name="nextPage" class="btn btn-warning" type="submit" value="Следующая страница" ></div><br><br>';
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
        $correctQuestionNumber = $question['number'] +1 ;
        $answer = $_SESSION['answer_'.$correctQuestionNumber];
        echo '<div class="question-block">';
        echo '<div class="question">';
        echo $question['number'] + 1 .'.  '.$question['currentQuestion'];
        echo ' </div></div>';
        echo '<textarea class="form-control" name="answer_';?><?php echo $question['number']+1?>"><?php echo $answer; ?></textarea>
    <?php;

    }

}