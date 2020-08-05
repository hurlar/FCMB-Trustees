<?php
require_once('../Connections/conn.php');
require_once('../phpmailer521/class.phpmailer.php');
ob_start();

$forgottenemail =      $_POST['forgottenemail'];
$forgottenemail = trim($forgottenemail);

$query = "SELECT * FROM `users` WHERE `email` = '$forgottenemail' "; 
$query_run = mysqli_query($conn, $query) or die(mysqli_error($conn));
$result1 = mysqli_num_rows($query_run); 
if ($result1 == 0) {
  header("location: ../forgot-password.php?a=Invalid");
exit();
}

$templateid ='2'; // define the session id from the settings for default template  

mysqli_select_db($conn, $database_conn);
$sql = "SELECT * FROM mail_templates WHERE id = '$templateid' "; 
$query_run = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$row = mysqli_fetch_assoc($query_run);
$thead = $row['thead'];
$tfooter = $row['tfooter'];

$title = 'Forgotten Password';
$sender_name = 'FCMB Trustees';
$sender = 'notifications@fcmbtrustees.com';

$mail   = new PHPMailer();

$mail->SMTPAuth      = true;                  // enable SMTP authentication
$mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
$mail->Host          = "172.27.15.18"; // sets the SMTP server
$mail->Port          = 25;                    // set the SMTP port for the GMAIL server
$mail->Username      = " "; // SMTP account username
$mail->Password      = " ";        // SMTP account password


$mail->setFrom($sender, $sender_name);
$mail->AddReplyTo($sender, $sender_name);
$mail->Subject = $title ;

$query2 = "SELECT * FROM `users` WHERE `email` = '$forgottenemail' "; 
$query_run2 = mysqli_query($conn, $query2) or die(mysqli_error($conn));
$row_pwd = mysqli_fetch_assoc($query_run2);
$result2 = mysqli_num_rows($query_run2); 
$param = $row_pwd['password'];
$fname = $row_pwd['fname'];
$lname = $row_pwd['lname'];
$id = $row_pwd['id'];

if($result2){

$message1  = $thead;
$message1 .= 'Dear {name}, <br><br> If you requested a password reset. Click the link to reset your password <a href="https://fcmbtrustees.com/portal/change-password.php?param={param}&slug={id}" target="_blank">Reset Password</a><br> <br> If you didn\'t make this request, Please ignore';
$message1 .= $tfooter;

$search = array('{Name}','{name}','{Email}','{email}', '{param}','{Param}', '{id}','{Id}','[Name]','[name]','[Email]','[email]','[param]','[Param]','[id]','[Id]');
$replace = array($fname,$fname, $email,$email, $param,$param, $id,$id, $fname,$fname, $email,$email, $param,$param, $id, $id );
$message = str_replace( $search, $replace,  $message1 );


  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
  $mail->MsgHTML($message);
  $mail->AddAddress($forgottenemail, $fname);
  

    $mail->AddAttachment($path.$attach1);
    $mail->AddAttachment($path.$attach2);

  if(!$mail->Send()) {
    header("Location: ../forgot-password.php?a=successful");
  } else {
    header("Location: ../forgot-password.php?a=successful"); 
  }
  // Clear all addresses and attachments for next loop
  $mail->ClearAddresses();
  $mail->ClearAttachments();    

} else {
//$message1 = "There was a problem with your signup. " ; 
header("Location: ../forgot-password.php?a=error");
}

?>