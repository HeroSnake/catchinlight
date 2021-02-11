<?php
    ini_set( 'display_errors', 1 );
 
    error_reporting( E_ALL );
    $name; $email; $message; $subject; $headers; $captcha;
    $done = 0;
    if(isset( $_POST['name']) && isset( $_POST['email']) && isset( $_POST['message']) && isset( $_POST['subject'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $captcha = $_POST['g-recaptcha-response'];
        $from = $email;
        $to = "catchin.light@gmail.com";
        $message = "From: $name \nEmail: $email \nMessage: ".$_POST['message'];
        $headers = "From:" . $from;
        $done = 1;
        mail($to,$subject,$message, $headers);
    }

    header('location: contact?mailsent='.$done);
?>
