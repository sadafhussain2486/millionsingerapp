<?php
$to="mohit.infoseek@gmail.com";
$subject="Test Subject";
$message="Test Message";
$fromname="Prashant Yadav";
$from="kumar.11rock@gmail.com";
$headers = "From: $fromname <{$from}>\r\n" .
                "Reply-To: {$from}\r\n" .
                "MIME-Version: 1.0\r\n" .
                "Content-type: text/html; charset=UTF-8";
       echo $return = mail($to, $subject, $message,$headers);
       /*if(mail($to, $subject, $message))
       {
       	echo "yes";
       }
       else
       {
       	echo "no";
       }*/

//echo phpinfo();
?>