<?php
if (isset($_GET['action']) && $_GET['action'] == 'send') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $from = $email;
    // $to = "catchin.light@gmail.com";
    $to = "snake.eatermgs@live.fr";
    $message = "From: $name \nEmail: $email \nMessage: $message";
    $headers = "From:" . $from;
    die(true);
    die(mail($to,$subject,$message, $headers));
}
