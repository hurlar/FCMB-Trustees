<?php 
session_start();
ob_start();
require_once('phpmailer521/class.phpmailer.php');
include('Connections/conn.php') ;

$templateid ='2'; // define the session id from the settings for default template  
$accesslevel ='6';

mysqli_select_db($conn, $database_conn);
$sql = "SELECT * FROM mail_templates WHERE id = '$templateid' "; 
$query_run = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$row = mysqli_fetch_assoc($query_run);
$thead = $row['thead'];
$tfooter = $row['tfooter'];

$title = 'FCMB Trustees Registration hasn\'t been completed';
$sender_name = 'FCMB Trustees';
$sender = 'notifications@fcmbtrustees.com';

$mail                = new PHPMailer();
//$body = $row_field['draft'];


$mail->SMTPAuth      = true;                  // enable SMTP authentication
$mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
$mail->Host          = "mail.tisvdigital.com"; // sets the SMTP server
$mail->Port          = 26;                    // set the SMTP port for the GMAIL server
$mail->Username      = "olaoluwa@tisvdigital.com"; // SMTP account username
$mail->Password      = "Akintolu@123";        // SMTP account password


$mail->setFrom($sender, $sender_name);
$mail->AddReplyTo($sender, $sender_name);
$mail->Subject = $title ;


mysqli_select_db($conn, $database_conn);
$acl = "SELECT * FROM access_level WHERE access != '$accesslevel' "; 
$query_acl = mysqli_query($conn, $acl) or die(mysqli_error($conn));
while ($row = mysqli_fetch_array($query_acl)) {
$uid =  $row["uid"]; 

mysqli_select_db($conn, $database_conn);
$sql1 = "SELECT * FROM users3 WHERE id = '$uid' "; 
$query_run1 = mysqli_query($conn, $sql1) or die(mysqli_error($conn));
$row1 = mysqli_fetch_assoc($query_run1);

$fname =  $row1["fname"]; 
$lname =  $row1["lname"]; 
$name =   $fname.' '.$lname;
$email =  $row1["email"]; 


$message1  = $thead;
$message1 .= 'Dear {name} <br> Your profile on FCMB Trustees hasnt been completed';
$message1 .= $tfooter;

$search = array('{Name}','{name}','{Email}','{email}', '{due}','{Due}','[Name]','[name]','[Email]','[email]');
$replace = array($name,$name, $email,$email, $due, $due,$name,$name,$email,$email );
$message = str_replace( $search, $replace,  $message1 );


  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
  $mail->MsgHTML($message);
  $mail->AddAddress($row1["email"], $row1["fname"]);
  

    $mail->AddAttachment($path.$attach1);
    $mail->AddAttachment($path.$attach2);

  if(!$mail->Send()) {
    echo "Mailer Error (" . str_replace("@", "&#64;", $row1["email"]) . ') ' . $mail->ErrorInfo . '<br>';
  } else {
    echo "Message sent to :" . $row1["fname"] . ' (' . str_replace("@", "&#64;", $row1["email"]) . ')<br>';
  }
  // Clear all addresses and attachments for next loop
  $mail->ClearAddresses();
  $mail->ClearAttachments();
}

?>