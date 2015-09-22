<?
class Success
{
    public function checkIfAllQuestionsWhereAnswered()
    {
        $sessionId = session_id();

        if($_SESSION['sendAnswers'] == $sessionId)
        {
            session_destroy();
            echo '<div id="successobject"><div >Вы успешно прошли опрос.<br> Вы молодец! <br> Спасибо!</div></div>';
            echo '<a class="btn btn-warning" href="http://f7u12.ru/grey/" role="button">Еще раз пройти опрос?</a>';
        }
    }
}