<?php
//вывод формы с вопросами, полями для ввода ответов
class QAForm
{

    public $sessionAnswer;

    public function renderQuestionForm(array $questionsArray) {
        if(!empty($questionsArray)) {
            echo '<form action="" method="post">';

            foreach($questionsArray as $question) {
                $this->renderSingleQuestion($question);
            }

            echo '</form>';
        }
        else {
            return false;
        }

        return true;
    }

    protected function renderSingleQuestion($question) {
        echo $question['question'];
        echo '<input type="text" name="answer_'.$question['number'].'" value="'.$question['answer'].'">';
    }

    public function getQAForm($arrayQuestions, $keys, $answer, $toQuestion, $i, $questionAnswer = NULL)
    {
        ?>
        <form name="questionForm" action="index.php" method="get">
        <div class="question-block">
            <div class="question">
                <?php
                $arrayQuestions["$i"];
                ?>
            </div>
        </div>
        <br>
        <textarea name="answer<?php echo $keys[$i];?>"  class="form-control" ><?php echo $this->sessionAnswer["$answer"];?></textarea>
        <br>
        <?php
        if(!empty($sessionAnswer[$answer]))
        {
            $questionAnswer .= $arrayQuestions["$i"] .' '. $sessionAnswer[$answer] . '
    ';
        }
        ?>
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
}