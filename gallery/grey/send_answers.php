<?php
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
    $header .= "Content-Type: application/msword; name=\"".$filename."\"\r\n"; // use different content types here
    $header .= "Content-Transfer-Encoding: base64\r\n";
    $header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
    $header .= $content."\r\n\r\n";
    $header .= "--".$uid."--";
    if (mail($mailto, $subject, "", $header)) {
        echo "mail send ... OK"; // or use booleans here
    } else {
        echo "mail send ... ERROR!";
    }

}

//file_put_contents("$sessionId.doc",$questionAnswer);
//mail_attachment("$sessionId.doc", "/", "keugere@gmail.com", "keugere@gmail.com", "$sessionId", "keugere@gmail.com", "Сообщение от $sessionId", "$sessionAnswer");


//$file = ""; //File here (eg test.docx)
//$path = ""; //Path to file here (eg documents/)
//$mailto = ""; //Email address to send to
//$from_mail = ""; //Send mail address
//$from_name = ""; //From name
//$replyto = ""; //Email address to reply to
//$subjest = ""; //Mail subject
//$message = ""; //Mail body message


