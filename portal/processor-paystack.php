<?php require ('Connections/conn.php');
include ('session.php');
require_once('phpmailer521/class.phpmailer.php');

 $uid = $userid;
$transactid = $_SESSION['transactionid'] ;
$amount1 = $_SESSION['value']; 
$amount = number_format($amount1, 2);
$willtype = $_SESSION['willtype'];

$templateid ='2'; // define the session id from the settings for default template  

$query1 = "SELECT `email`,`fname`,`lname` FROM users WHERE `id` = '$uid' ";
$usr1 = mysqli_query($conn, $query1) or die(mysqli_error($conn));
$rowusr1 = mysqli_fetch_assoc($usr1);
$email = $rowusr1['email'];
$name = $rowusr1['fname'];
$lname = $rowusr1['lname'];

$_SESSION['name'] = $name;
$_SESSION['lname'] = $lname;

$fullname = $name.' '.$lname;

mysqli_select_db($conn, $database_conn);
$sql = "SELECT * FROM mail_templates WHERE id = '$templateid' "; 
$query_run = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$row = mysqli_fetch_assoc($query_run);
$thead = $row['thead'];
$tfooter = $row['tfooter'];

$title = 'Payment Successful';
$sender_name = 'FCMB Trustees';
//$sender = 'fcmbtrustees@fcmb.com';
//$mail  = new PHPMailer();
//$mail->isSMTP();
//$mail->Host          = "172.27.15.18"; // sets the SMTP server
//$mail->Port          = 25;          // set the SMTP port for the GMAIL server

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

$sql = "INSERT INTO payment_tb (uid, name, transactionid, willtype, amount, datepaid) VALUES ('$uid', '$fullname', '$transactid' ,'$willtype' ,'$amount',NOW()) ";
	$resultx = mysqli_query($conn, $sql) or die(mysqli_error($conn));

	if(!$resultx){
			header("Location: dashboard.php");
	}else { 
            //header("Location: payment-completed.php");
$message1  = $thead;
$message1 .= 'Dear {Name}, <br>
            Your payment of ₦ {amount} with transaction number {transactionid} for FCMB Trustees {willtype} was successful. <br>
            A representative will contact you soon.';
$message1 .= $tfooter;

$search = array('{Name}','{name}','{Email}','{email}', '{amount}','{Amount}', '{transactionid}','{Transactionid}','{Willtype}','{willtype}','[Name]','[name]','[Email]','[email]','[Amount]','[amount]','[Transactionid]','[transactionid]','[Willtype]','[willtype]');
$replace = array($name,$name, $email,$email, $amount, $amount, $transactid, $transactid,$willtype, $willtype,$name,$name,$email,$email,$amount,$amount,$transactid,$transactid,$willtype,$willtype);
$message = str_replace( $search, $replace,  $message1 );


  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
  $mail->MsgHTML($message);
  $mail->AddAddress($email, $name);
  

    $mail->AddAttachment($path.$attach1);
    $mail->AddAttachment($path.$attach2);

  if(!$mail->Send()) {
    header("Location: processor-payment-admin-confirmation.php");
  } else {
      header("Location: processor-payment-admin-confirmation.php");
  }
  // Clear all addresses and attachments for next loop
  $mail->ClearAddresses();
  $mail->ClearAttachments();
	}	
				
?>