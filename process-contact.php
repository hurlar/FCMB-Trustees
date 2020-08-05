<?php

session_start();
ob_start();

include('Connections/conn.php');


$name  =    $_POST['name'];
$email =    $_POST['email'];
$phone =  $_POST['phone'];
$subject =  $_POST['subject'];
$message =  $_POST['message'];


$name = stripslashes($name);
$email = stripslashes($email);
$phone = stripslashes($phone);
$subject = stripslashes($subject);
$message = stripslashes($message);


$name = mysqli_real_escape_string($conn, $name);
$email = mysqli_real_escape_string($conn, $email);
$phone = mysqli_real_escape_string($conn, $phone);
$subject = mysqli_real_escape_string($conn, $subject);
$message = mysqli_real_escape_string($conn, $message);



$admin = 'fcmbtrustees@fcmb.com';


if(!isset($name) || !isset($email) || !isset($phone) || !isset($subject) || !isset($message)) {
        
        header("Location: contact.php?a=error-all");
    }

    // PHP validation for the fields required
    if(strlen($name)<8) {
        header("Location: contact.php?a=error-name");
    }
    
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: contact.php?a=error-email");
    }

    elseif (strlen($phone)<1) {
        header("Location: contact.php?a=error-phone");
    }
    elseif (strlen($subject)<4) {
        header("Location: contact.php?a=error-subject");
    }

    elseif(strlen($message)<20) {
        header("Location: contact.php?a=error-message");
    }

    else {

$to =  $admin;
$subject1 = "New Message from FCMB Trustees Contact Form " ;
$message1 = "Name: {name} <br> Email: {email} <br> Mobile Number: {phone} <br>Subject: {subject} <br> Message: {message} ";

// Always set content-type when sending HTML email

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: " . $name . " <" . $email . ">" . "\r\n";


$replacements = array(

        '({name})' =>   $name,

        '({email})' =>  $email,

        '({phone})' =>  $phone,

	'({subject})' =>  $subject,

        '({message})' =>  $message,

    );

    $message = preg_replace( array_keys( $replacements ), array_values( $replacements ), $message1 ); 

$sentmail = mail($to,$subject1,$message,$headers); 

header("Location: contact.php?a=successful "); 


}

?>
