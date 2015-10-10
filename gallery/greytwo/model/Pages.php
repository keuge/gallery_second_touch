<?php
session_start();
//Запись вопросов в массив из текущей страницы. Запись в сессию ответов из формы.
class Pages
{
    public function getCurrentPageQuestions($questionsArray)
    {
        $questionsArrayOnPage = NULL;
        //считаем, сколько всего есть вопросов и страниц
        $allQuestions = count($questionsArray);
        $pagesCount = $_SESSION['pagesCount'] = (integer)($allQuestions/4);

        $_SESSION['currentPage'];
        //если номер текущей страницы не определен, то ставим текущую страницу 1
        if($_SESSION['currentPage'] == NULL || empty($_SESSION['currentPage']) || $_SESSION['currentPage'] <= 0)
        {
            $_SESSION['currentPage'] = 1;
        }
        //если из формы пришел номер текущей страницы, то сохраняем этот номер в сессии
        elseif(!empty($_POST['currentPage']))
        {
            $_SESSION['currentPage'] = $_POST['currentPage'];
        }
        //если была нажата кнопка "текущая страница и номер страницы не больше номера последней страницы, то передвигаемся на одну страницу вперед
        if(!empty($_POST['nextPage']) && $_SESSION['currentPage'] <= $pagesCount || !empty($_POST['submitAnswers']))
        {
            //записываем ответы в сессию
            for($i=1; $i<=$allQuestions; $i++)
            {
                if(!empty($_POST["answer_$i"]))
                {
                    $_SESSION["answer_$i"] = $_POST["answer_$i"];
                }
                elseif($_SESSION["answer_$i"] == '')
                {
                    $_SESSION["answer_$i"] = NULL;
                }
            }
            $_SESSION['currentPage'] = $_SESSION['currentPage'] + 1;
            $_SESSION['percentQuestion'] = (integer)(($_SESSION['currentPage']/($pagesCount+1)) * 100);
        }
        //если нажата кнопка "предыдущая страница" и номер страница больше 1, то передвигаемся на одну страницу назад
        elseif(!empty($_POST['previousPage']) && $_SESSION['currentPage'] >= 2)
        {
            //записываем ответы в сессию
            for($i=1; $i<=$allQuestions; $i++)
            {
                if(!empty($_POST["answer_$i"]))
                {
                    $_SESSION["answer_$i"] = $_POST["answer_$i"];
                }
                elseif($_SESSION["answer_$i"] == '')
                {
                    $_SESSION["answer_$i"] = NULL;
                }
            }
            $_SESSION['currentPage'] = $_SESSION['currentPage'] - 1;
            $_SESSION['percentQuestion'] = (integer)(($_SESSION['currentPage']/($pagesCount+1)) * 100);
        }
        //до какого вопроса делаем выборку
        $toQuestion = $_SESSION['currentPage'] * 4 - 1;
        //и от какого вопроса
        $fromQuestion = $toQuestion - 3;
        //записать в массив все вопросы из текущей страницы
        for($i=$fromQuestion; $i<=$toQuestion; $i++)
        {
            //если есть вопрос, то записываем вопрос в массив
            if(!empty($questionsArray[$i]))
            {
                $questionsArrayOnPage[$i] = $questionsArray[$i];
            }
        }
        return $questionsArrayOnPage;
    }
}


