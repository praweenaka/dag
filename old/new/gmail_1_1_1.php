<?php
date_default_timezone_set('Asia/Colombo');

require 'email/PHPMailerAutoload.php';
$mail = new PHPMailer;
$mail->isSMTP();

$mail->Host = 'gator4088.hostgator.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = "it@tyrehouse.com";
$mail->Password = "123456";
$mail->setFrom('it@tyrehouse.com', 'IT Admin');

$mail->addAddress('ezsudesh@gmail.com');
$mail->addAddress('sachithkumara@gmail.com');  
$mail->addAddress('shano1106@gmail.com');  

$mail->Body = '<i>This is the HTML message 4 body italic letters<i>';
$mail->Subject = 'PHPMailer GMail SMTP test';

$mail->isHTML(true); 

if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}



?>