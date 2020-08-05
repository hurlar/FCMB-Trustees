<?php

session_start();

ob_start();

require_once('../Connections/conn.php');

require_once('../phpmailer521/class.phpmailer.php');

$uid =    $_POST['uid'];
$willtype = $_POST['willtype'];
$fullname = $_POST['fullname'];  
$addr =     $_POST['addr'];
$email =    $_POST['email'];
$phone =    $_POST['phone'];
$aphone =    $_POST['aphone'];
$gender =    $_POST['gender'];
$dob =    $_POST['dob'];
$state =    $_POST['state'];
$nationality =    $_POST['nationality'];
$lga =    $_POST['lga'];
$employmentstatus =    $_POST['employmentstatus'];
$employer =    $_POST['employer'];
$employerphone =    $_POST['employerphone'];
$employeraddr =    $_POST['employeraddr'];
$maritalstatus =    $_POST['maritalstatus']; 
$spname =    $_POST['spname']; 
$spemail =    $_POST['spemail'];
$spphone =    $_POST['spphone'];
$sdob =    $_POST['sdob'];
$spaddr =    $_POST['spaddr'];
$spcity =    $_POST['spcity'];
$spstate =    $_POST['spstate'];
$marriagetype =    $_POST['marriagetype'];
$marriageyear =    $_POST['marriageyear'];
$marriagecert =    $_POST['marriagecert'];
$spcitym =    $_POST['spcitym'];
$spcountrym =    $_POST['spcountrym'];
$divorce      =    $_POST['divorce'];
$divorceyear =    $_POST['divorceyear'];
$addinfo =    $_POST['addinfo'];

$_SESSION['willtype'] = $willtype;
$_SESSION['fullname'] = $fullname;  
$_SESSION['email'] = $email;

$url1 = '../comprehensivewill-preview.php?a=successfull';

$url2 = '../comprehensivewill-preview.php?a=error';

$templateid ='2'; // define the session id from the settings for default template 

mysqli_select_db($conn, $database_conn);
$sql = "SELECT * FROM mail_templates WHERE id = '$templateid' "; 
$query_run = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$row = mysqli_fetch_assoc($query_run);
$thead = $row['thead'];
$tfooter = $row['tfooter'];

$title = 'FCMB Trustees Confirmation';
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

mysqli_select_db($conn, $database_conn);

$sql="INSERT INTO comprehensivewill_tb (uid, willtype, fullname, address, email, phoneno, aphoneno, gender, dob, state, nationality, lga, employmentstatus, employer, employerphone, employeraddr, maritalstatus, spname, spemail, spphone, sdob, spaddr, spcity, spstate, marriagetype, marriageyear, marriagecert, marriagecity, marriagecountry, divorce, divorceyear, addinfo, datecreated) VALUES ('$uid', '$willtype', '$fullname', '$addr', '$email', '$phone', '$aphone', '$gender', '$dob', '$state', '$nationality', '$lga', '$employmentstatus', '$employer', '$employerphone', '$employeraddr', '$maritalstatus', '$spname', '$spemail', '$spphone', '$sdob', '$spaddr', '$spcity', '$spstate', '$marriagetype', '$marriageyear', '$marriagecert', '$spcitym', '$spcountrym', '$divorce', '$divorceyear', '$addinfo', NOW()) ";

$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($result){
$message1  = $thead;
$message1 .= 'Dear {Name}, <br>
                    You have successfully submitted your {willtype}.<br> A representative will contact you soon.';
$message1 .= $tfooter;

$search = array('{Name}','{name}','{Email}','{email}','{Willtype}','{willtype}','[Name]','[name]','[Email]','[email]','[Willtype]','[willtype]');
$replace = array($fullname, $fullname, $email, $email, $willtype, $willtype);
$message = str_replace( $search, $replace,  $message1 );


  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
  $mail->MsgHTML($message);
  $mail->AddAddress($email, $fullname);
  

    $mail->AddAttachment($path.$attach1);
    $mail->AddAttachment($path.$attach2);

  if(!$mail->Send()) {
      header("Location: $url1");
  } else {
      header("Location: processor-admin-comprehensivewill-confirmation.php");
  }
  // Clear all addresses and attachments for next loop
  $mail->ClearAddresses();
  $mail->ClearAttachments();

} else {

header("Location: $url2");

}

?>



