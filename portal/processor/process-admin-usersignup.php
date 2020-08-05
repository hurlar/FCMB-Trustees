<?php require ('../Connections/conn.php');
//include ('session.php');
require_once('../phpmailer521/class.phpmailer.php');

$fname = $_SESSION['fname'];
$lname = $_SESSION['lname'];

$fname = ucfirst($fname);
$lname = ucfirst($lname);

$templateid ='2'; // define the session id from the settings for default template  

mysqli_select_db($conn, $database_conn);
$sql = "SELECT * FROM mail_templates WHERE id = '$templateid' "; 
$query_run = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$row = mysqli_fetch_assoc($query_run);
$thead = $row['thead'];
$tfooter = $row['tfooter'];

$title = 'Notification of a New User Signup On FCMB Trustees';
$sender_name = 'FCMB Trustees';
$sender = 'notifications@fcmbtrustees.com';
$adminemail = 'fcmbtrustees@fcmb.com';

$mail  = new PHPMailer();

$mail->SMTPAuth      = true;                  // enable SMTP authentication
$mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
$mail->Host          = "172.27.15.18"; // sets the SMTP server
$mail->Port          = 25;                    // set the SMTP port for the GMAIL server
$mail->Username      = " "; // SMTP account username
$mail->Password      = " ";        // SMTP account password


$mail->setFrom($sender, $sender_name);
$mail->AddReplyTo($sender, $sender_name);
$mail->Subject = $title ;

$message1  = $thead;
$message1 .= 'Dear Admin, <br>
            This is to notify you that a new user ({fname} {lname}) just registered on the FCMB Trustees portal.';
$message1 .= $tfooter;

$search = array('{Fname}','{fname}','{Lname}','{lname}','[Fname]','[fname]','[Lname]','[lname]');
$replace = array($Fname,$fname, $Lname,$lname);
$message = str_replace( $search, $replace,  $message1 );


  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
  $mail->MsgHTML($message);
  $mail->AddAddress($adminemail, $fname.' '.$lname);
  

    $mail->AddAttachment($path.$attach1);
    $mail->AddAttachment($path.$attach2);

  if(!$mail->Send()) {
    header("Location: ../getstarted.php");
  } else {
      header("Location: ../getstarted.php");
  }
  // Clear all addresses and attachments for next loop
  $mail->ClearAddresses();
  $mail->ClearAttachments();
//	}	
				
?>