<?php
define("SMTP_HOST", "mail.eb01.com.hk"); //Hostname of the mail server
define("SMTP_PORT", "465"); //Port of the SMTP like to be 25, 80, 465 or 587
//define("SMTP_UNAME", "mit@playtripapp.com"); //Username for SMTP authentication any valid email created in your domain
//define("SMTP_PWORD", "mit@123456"); //Password for SMTP authentication
define("SMTP_UNAME", "mit@eb01.com.hk"); //Username for SMTP authentication any valid email created in your domain
define("SMTP_PWORD", "mit@12345"); //Password for SMTP authentication
include "classes/class.phpmailer.php"; // include the class name

$email = "mohit.infoseek@gmail.com";
$mail	= new PHPMailer; // call the class 
$mail->IsSMTP(); 
$mail->Host = SMTP_HOST; //Hostname of the mail server
$mail->Port = SMTP_PORT; //Port of the SMTP like to be 25, 80, 465 or 587
$mail->SMTPAuth = false; //Whether to use SMTP authentication
$mail->Username = SMTP_UNAME; //Username for SMTP authentication any valid email created in your domain
$mail->Password = SMTP_PWORD; //Password for SMTP authentication
$mail->AddReplyTo("kumar.11rock@gmail.com", "Reply name"); //reply-to address
$mail->SetFrom("kumar.11rock@gmail.com", "Kumar SMTP Mailer"); //From address of the mail
// put your while loop here like below,
$mail->Subject = "Your SMTP Mail"; //Subject od your mail
$mail->AddAddress($email, "Prashant yadav"); //To address who will receive this email
$mail->MsgHTML("<b>Hi, your first SMTP mail has been received. Great Job!.. <br/><br/>by</b>"); //Put your body of the message you can place html code here
//$mail->AddAttachment("images/asif18-logo.png"); //Attach a file here if any or comment this line, 
$send = $mail->Send(); //Send the mails
if($send){
	echo '<center><h3 style="color:#009933;">Mail sent successfully</h3></center>';
}
else{
	echo '<center><h3 style="color:#FF3300;">Mail error: </h3></center>'.$mail->ErrorInfo;
}
?>
<!-- <!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Send mails using SMTP and PHP in PHP Mailer using our own server or gmail server by Asif18</title>
<meta name="keywords" content="send mails using smpt in php, php mailer for send emails in smtp, use gmail for smtp in php, gmail smtp server name"/>
<meta name="description" content="Send mails using SMTP and PHP in PHP Mailer using our own server or gmail server"/>
<style>
.as_wrapper{
	font-family:Arial;
	color:#333;
	font-size:14px;
}
.mytable{
	padding:20px;
	border:2px dashed #17A3F7;
	width:100%;
}
</style>
<body>
<div class="as_wrapper">
	<h1>Send mails using SMTP and PHP in PHP Mailer using our own server or gmail server</h1>
    <form action="" method="post">
    <table class="mytable">
    <tr>
    	<td><input type="email" placeholder="Email" name="email" /></td>
	</tr>
    <tr>
    	<td><input type="submit" name="send" value="Send via SMTP" /></td>
	</tr>
    </table>
    </form>
</div>
</body>
</html> -->