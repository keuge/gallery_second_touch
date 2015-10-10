<?php
session_start();
//Записать в файл все полученные ответы и отправить по почте

class Answers
{
    public $fileName;
    public $sessionId;
    public $allAnswers;

    function getAnswers($questionsArray)
    {
        $this->sessionId = session_id();
        $date = date("H-i-s");
        $this->fileName = $date;

        foreach($questionsArray as $key=>$question)
        {
            $correctQuestionNumber = $key + 1;

            $_SESSION["answer_$correctQuestionNumber"];

            if(!empty($_SESSION["answer_$correctQuestionNumber"]))
            {
                $this->allAnswers.= $correctQuestionNumber . '. ' .$question. ' ' . $_SESSION["answer_$correctQuestionNumber"] . "\n";

            }
            if(empty($_SESSION["answer_$correctQuestionNumber"]))
            {
                $this->allAnswers.= $correctQuestionNumber . '. ' .$question . "\n";
            }
        }

        return $this->allAnswers;

    }
}