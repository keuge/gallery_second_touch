<?php
session_start();
//Записать в файл все полученные ответы и отправить по почте

class Answers
{
    function getAnswers($questionsArray)
    {
        $sessionId = session_id();
        $date = date('d.m.Y');
        $fileName = 'grey-brif' . '-' . $date;

        foreach($questionsArray as $key=>$question)
        {
            $correctQuestionNumber = $key + 1;

            $_SESSION["answer_$correctQuestionNumber"];

            if(!empty($_SESSION["answer_$correctQuestionNumber"]))
            {
                $allAnswers[] = $correctQuestionNumber . '. ' .$question. ' ' . $_SESSION["answer_$correctQuestionNumber"] . "\n";

            }
            if(empty($_SESSION["answer_$correctQuestionNumber"]))
            {
                $allAnswers[] = $correctQuestionNumber . '. ' .$question . "\n";

            }
        }

        if(!empty($_POST['submitAnswers']))
        {
            $_SESSION['sendAnswers'] = $sessionId;
            file_put_contents("$fileName.doc", $allAnswers);
            $this->mail_attachment("$fileName.doc", "", "sergsh10@list.ru", "sergsh10@list.ru", "$fileName", "sergsh10@list.ru", "Сообщение от $fileName", "Привет, Сергей, тебе сообщение от $fileName ");
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