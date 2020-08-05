<?php
require_once('../Connections/conn.php');
require_once('../phpmailer521/class.phpmailer.php');
//ob_start();

$param = $_SESSION['param'];
$slug = $_SESSION['slug'];

$password = $_POST['password'];
$repassword = $_POST['repassword'];

$password = trim($password);
$repassword = trim($repassword);

$password = stripslashes($password);
$repassword = stripslashes($repassword);

$password = mysqli_real_escape_string($conn, $password);
$repassword = mysqli_real_escape_string($conn, $repassword);

$url3 = '../change-password.php?a=password-too-short' ; 

if(strlen($password) < 8 ){
  header("Location: $url3");
  exit();
}

$password1 = md5($password);
$repassword1 = md5($repassword);

$url2 = '../change-password.php?a=password-mismatch' ;  

if($password1 != $repassword1){
  header("Location: $url2");
  exit();
}

$url1 = '../change-password.php?a=error' ; 

//mysql_select_db($database_conn, $conn);
$sql1 = "SELECT * FROM users WHERE id = '$slug' ";
$result1 = mysqli_query($conn, $sql1) or die(mysqli_error($conn)) ;
$row_usr = mysqli_fetch_assoc($result1);
$count = mysqli_num_rows($result1);
$email = $row_usr['email'];
$name = $row_usr['fname'];
$lname = $row_usr['lname'];

        $templateid ='2'; // define the session id from the settings for default template  

mysqli_select_db($conn, $database_conn);
$sql = "SELECT * FROM mail_templates WHERE id = '$templateid' "; 
$query_run = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$row = mysqli_fetch_assoc($query_run);
$thead = $row['thead'];
$tfooter = $row['tfooter'];

$title = 'Password Change Notification';
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


$sql="UPDATE users SET password = '$password1' WHERE id = '$slug'" ;
$result = mysqli_query($conn, $sql);

if(!$result){
  header("Location: $url1");
} else {
$message1  = $thead;
$message1 .= 'Dear {name}, <br><br> You recently changed your FCMB Trustees password. <br><br> As a security precaution, this mail has been sent to your email address.<br><br> Click <a href="https://on.fcmb.com/Write-Your-Will-Now2" target="_blank">here</a> to log-in to your account.';
$message1 .= $tfooter;

$search = array('{Name}','{name}','{Email}','{email}');
$replace = array($name,$name, $email,$email );
$message = str_replace( $search, $replace,  $message1 );


  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
  $mail->MsgHTML($message);
  $mail->AddAddress($email, $name);
  

    $mail->AddAttachment($path.$attach1);
    $mail->AddAttachment($path.$attach2);

  if(!$mail->Send()) {
    header("Location: ../index.php?a=password-changed");
  } else {
    header("Location: ../index.php?a=password-changed");
  }
  // Clear all addresses and attachments for next loop
  $mail->ClearAddresses();
  $mail->ClearAttachments();
}
?>

