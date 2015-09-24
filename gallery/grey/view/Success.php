<?
class Success
{
    public function checkIfAllQuestionsWhereAnswered()
    {
        $sessionId = session_id();

        if($_SESSION['sendAnswers'] == $sessionId)
        {
            session_destroy();
            echo '<div id="successobject">Вы успешно прошли опрос.<br> Вы молодец! <br> Спасибо!</div>';
//            echo '<a class="btn btn-danger" href="http://f7u12.ru/grey/" role="button">Еще раз пройти опрос?</a>';
        }
    }
}