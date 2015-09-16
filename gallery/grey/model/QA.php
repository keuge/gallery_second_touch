<?php
//обработка текущей страницы опросника, сохранение в сессиию ответов
class QA
{
    public $sessionAnswer = array();
    public $answer;
    public $toQuestion;

    public function getQA($currentPageSession, $currentPageGet, $previousPageGet, $nextPageGet, $keys)
    {
        $currentPageSession['currentPage'] = $currentPageSession;
        $currentPageGet['currentPage'] =  $currentPageGet;
        $previousPageGet['previousPage'] = $previousPageGet;
        $nextPageGet['nextPage'] = $nextPageGet;

        if(empty($currentPageSession['currentPage']) || !isset($currentPageSession['currentPage']) || $currentPageSession['currentPage'] <= 0)
        {
            $currentPageSession['currentPage'] = 1;
        }
        elseif(!empty($currentPageSession['currentPage']))
        {
            if(!empty($currentPageGet['currentPage']))
            {
                $currentPageSession['currentPage'] =  $currentPageGet['currentPage'];
            }

            if(!empty($previousPageGet['previousPage']))
            {
                $currentPageSession['currentPage'] =  $currentPageSession['currentPage'] - 1;
            }
            elseif(!empty($nextPageGet['nextPage']))
            {
                $currentPageSession['currentPage'] = $currentPageSession['currentPage'] + 1;
            }

            echo $currentPageSession['currentPage'];
            $this->toQuestion = $currentPageSession['currentPage'] * 4 - 1;
            $fromQuestion = $this->toQuestion - 3;

            for($i=$fromQuestion; $i<=$this->toQuestion;$i++)
            {
                $this->answer = 'answer' . $keys[$i];

                if(!empty($_GET["$this->answer"]))
                {
                    $this->sessionAnswer[$this->answer] = $_SESSION["$this->answer"] = $_GET["$this->answer"];
                }
                elseif(!empty($_SESSION["$this->answer"]))
                {
                    $this->sessionAnswer[$this->answer] = $_SESSION["$this->answer"];
                }
            }
        }
    }
}
