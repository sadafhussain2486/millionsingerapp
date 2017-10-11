<?php
include "classes/class.phpmailer.php"; // include the class name
$email = "mohit.infoseek@gmail.com";
$mail = new PHPMailer(); // create a new object
$mail->IsSMTP(); // enable SMTP
$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = false; // authentication enabled
$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
$mail->Host = "smtp.gmail.com";
$mail->Port = 465; // or 587
$mail->IsHTML(true);
$mail->Username = "prashantiyadav567@gmail.com";
$mail->Password = "Welcome123$";
$mail->SetFrom("prashantiyadav567@gmail.com");
$mail->Subject = "Your Gmail SMTP Mail";
$mail->Body = "<b>Hi, your first SMTP mail via gmail server has been received. Great Job!.. <br/><br/>by <a href='http://www.asif18.com/7/php/send-mails-using-smtp-in-php-by-gmail-server-or-own-domain-server/'>Prashant</a></b>";
$mail->AddAddress($email);
if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}
else{
	echo "Message has been sent";
}
?>