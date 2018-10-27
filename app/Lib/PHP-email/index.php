<?php
require 'PHPMailerAutoload.php';

$date = date("Y-m-d");

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'tls://smtp.gmail.com:587';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'info@realvubd.com';                 // SMTP username
$mail->Password = 'B3xinf0987654';                       // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('info@realvubd.com', 'REALVU TICKETING SYSTEM');
//$mail->addAddress('viparvez@gmail.com', 'Sirajum Monir Parvez');     // Add a recipient
$mail->addAddress('sirajum.monir@realvubd.com');               // Name is optional
$mail->addReplyTo('sirajum.monir@realvubd.com', 'Sirajum Monir Parvez');
//$mail->addCC('abdul.awal@realvubd.com');
//$mail->addCC('sirajum.monir@realvubd.com');
//$mail->addBCC('rajib.das@digicontechnologies.com');

$mail->addAttachment("/opt/report/CSV/Balance$date.csv");         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'TEST EMAIL';
$mail->Body    = "<h1>Hi,</h1><h2>I am testing the system</h2><h4>SENT FROM ".$_SERVER['SERVER_ADDR']."</h4>";
$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}