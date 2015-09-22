<?php
session_start();
//Записать в файл все полученные ответы и отправить по почте

class Answers
{
    function getAnswers($questionsArray)
    {
        $sessionId = session_id();

        foreach($questionsArray as $key=>$question)
        {
            $correctQuestionNumber = $key + 1;

            $_SESSION["answer_$correctQuestionNumber"];

            if(!empty($_SESSION["answer_$correctQuestionNumber"]) && !empty($_POST['submitAnswers']))
            {
                $allAnswers[] = $correctQuestionNumber . '. ' .$question. ' ' . $_SESSION["answer_$correctQuestionNumber"] . "\n";
                $_SESSION['sendAnswers'] = $sessionId;

            }
            elseif($_SESSION["answer_$correctQuestionNumber"] == NULL)
            {
                unset($_SESSION['sendAnswers']);
                return false;
            }
        }
        if(!empty($_POST['submitAnswers']))
        {
            file_put_contents("$sessionId.doc", $allAnswers);
            $this->mail_attachment("$sessionId.doc", "", "keugere@gmail.com", "keugere@gmail.com", "$sessionId", "keugere@gmail.com", "Сообщение от $sessionId", "Привет, Максим, тебе сообщение от $sessionId ");
        }
    }


    function mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message)
    {
        $file = $path.$filename;
        $file_size = filesize($file);
        $handle = fopen($file, "rb");
        $content = fread($handle, $file_size);
        fclose($handle);
        $content = chunk_split(base64_encode($content));
        $uid = md5(uniqid(time()));
        $name = basename($file);
        $header = "From: ".$from_name." <".$from_mail.">\r\n";
        $header .= "Reply-To: ".$replyto."\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
        $header .= "This is a multi-part message in MIME format.\r\n";
        $header .= "--".$uid."\r\n";
        $header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
        $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $header .= $message."\r\n\r\n";
        $header .= "--".$uid."\r\n";
        $header .= "Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document; name=\"".$name."\"\r\n";
        $header .= "Content-Transfer-Encoding: base64\r\n";
        $header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
        $header .= $content."\r\n\r\n";
        $header .= "--".$uid."--";
        mail($mailto, $subject, "", $header);
    }
}