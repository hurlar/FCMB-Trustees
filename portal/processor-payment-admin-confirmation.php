<?php require ('Connections/conn.php');
include ('session.php');
require_once('phpmailer521/class.phpmailer.php');

//$uid = $userid;
$transactid = $_SESSION['transactionid'] ;
$amount1 = $_SESSION['value']; 
$amount = number_format($amount1, 2);
$willtype = $_SESSION['willtype'];
$name = $_SESSION['name'];
$lname = $_SESSION['lname'];

$templateid ='2'; // define the session id from the settings for default template  

mysqli_select_db($conn, $database_conn);
$sql = "SELECT * FROM mail_templates WHERE id = '$templateid' "; 
$query_run = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$row = mysqli_fetch_assoc($query_run);
$thead = $row['thead'];
$tfooter = $row['tfooter'];

$title = 'Payment Successful';
$sender_name = 'FCMB Trustees';
//$sender = 'fcmbtrustees@fcmb.com';
//$adminemail = 'fcmbtrustees@fcmb.com';

//$mail  = new PHPMailer();
//$mail->isSMTP();
//$mail->Host          = "172.27.15.18"; // sets the SMTP server
//$mail->Port          = 25;          // set the SMTP port for the GMAIL server

$sender = 'notifications@fcmbtrustees.com';
//$adminemail = 'fcmbtrustees@fcmb.com';
$adminemail = 'akintolu.olaoluwa@gmail.com';
$mail   = new PHPMailer();

$mail->SMTPAuth      = true;                  // enable SMTP authentication
$mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
$mail->Host          = "172.27.15.18"; // sets the SMTP server
$mail->Port          = 25;                    // set the SMTP port for the GMAIL server
$mail->Username      = ""; // SMTP account username
$mail->Password      = "";        // SMTP account password


$mail->setFrom($sender, $sender_name);
$mail->AddReplyTo($sender, $sender_name);
$mail->Subject = $title ;

$message1  = $thead;
$message1 .= 'Dear Admin, <br>
            A payment of ₦ {amount} with transaction number {transactionid} for {willtype} was made by {name} {lname}. ';
$message1 .= $tfooter;

$search = array('{Name}','{name}','{Lname}','{lname}', '{amount}','{Amount}','{transactionid}','{Transactionid}','{Willtype}','{willtype}','[Name]','[name]','[Lname]','[lname]','[Amount]','[amount]','[Transactionid]','[transactionid]','[Willtype]','[willtype]');
$replace = array($name,$name, $lname,$lname, $amount, $amount, $transactid, $transactid,$willtype, $willtype,$name,$name,$email,$email,$amount,$amount,$transactid,$transactid,$willtype,$willtype);
$message = str_replace( $search, $replace,  $message1 );


  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
  $mail->MsgHTML($message);
  $mail->AddAddress($adminemail, $name);
  

    $mail->AddAttachment($path.$attach1);
    $mail->AddAttachment($path.$attach2);

  if(!$mail->Send()) {
    header("Location: payment-completed.php");
  } else {
      header("Location: payment-completed.php");
  }
  // Clear all addresses and attachments for next loop
  $mail->ClearAddresses();
  $mail->ClearAttachments();
//	}	
				
?>