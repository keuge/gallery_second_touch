<?php
session_start();
//из текстового файла каждую строку записать в массив
class ArrayQuestionsComponent
{
    public $keys ;
    public $arrayQuestions;
    public $filePath;

    public function getQuestionsFromFileToArray($filePath)
    {
        $questions = file($filePath);
        foreach($questions as $key => $arrayQuestion)
        {
            $this->keys[] .= $key;
            $this->arrayQuestions[] .= $arrayQuestion;
        }
        return $keyAndQuestion = array_combine($this->keys, $this->arrayQuestions);
    }
}

