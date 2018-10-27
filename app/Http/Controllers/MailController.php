<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

require 'App/Lib/PHP-email/PHPMailerAutoload.php';


class MailController extends Controller
{
    public function test() {

    	$mail = new \PHPMailer(true);
    	 try{
    	 	$mail->isSMTP();
    	 	$mail->CharSet = 'utf-8'; #set it utf-8
    	 	$mail->SMTPAuth = true; #set it true
    	 	$mail->SMTPSecure = 'tls';
    	 	$mail->Host = 'tls://smtp.gmail.com:587'; #gmail has host  smtp.gmail.com
    	 	$mail->Port = 587; #gmail has port  587 . without double quotes
    	 	$mail->Username = 'viparvez@gmail.com'; #your username. actually your email
    	 	$mail->Password = 'suJANa53535326@4916120503030409'; # your password. your mail password
    	 	$mail->setFrom('viparvez@gmail.com', 'Sirajum Monir'); 
    	 	$mail->Subject = 'Test';
    	 	$mail->MsgHTML("Test Email");
    	 	$mail->addAddress('cafe360bd@gmail.com'); 
    	 	$mail->send();
    	 }catch(phpmailerException $e){
    	 	dd($e);
    	 }catch(Exception $e){
    	 	dd($e);
    	 } 

    }
}
