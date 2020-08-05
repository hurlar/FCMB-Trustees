<?php
require_once('../Connections/conn.php');
require_once('../phpmailer521/class.phpmailer.php');
ob_start();

if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['gender']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['password']) && isset($_POST['repassword']) ) {
    $fname =      $_POST['fname'];
    $lname =      $_POST['lname'];
    $gender =     $_POST['gender'];
    $email =      $_POST['email'];
    $phone =      $_POST['phone'];
    $password =     $_POST['password'];
    $repassword =     $_POST['repassword'];

    $fname = trim($fname);
    $lname = trim($lname);
    $email = trim($email);
    $phone = trim($phone);
    $password = trim($password);
    $repassword = trim($repassword);

    $_SESSION['fname'] = $fname;
    $_SESSION['lname'] = $lname;
    $gender =     $_POST['gender'];
    $_SESSION['email'] = $email;
    $_SESSION['phone'] = $phone;
    $password =     $_POST['password'];
    $repassword =     $_POST['repassword'];
    
    $search  = array('&', '-', ' ', '.');
    $replace = array('');

    if (empty($fname) || empty($lname) || empty($gender) || empty($email) || empty($phone) && empty($password) && empty($repassword) ) {
        header("Location: ../register.php?a=Error");
        exit();
    }elseif(!ctype_alpha(str_replace($search,$replace,$fname))){
        header("Location: ../register.php?a=lettersonly");
        exit();
    }elseif(!ctype_alpha(str_replace($search,$replace,$lname))){
        header("Location: ../register.php?a=lettersonly");
        exit();
    }elseif(!ctype_digit($phone)){
        header("Location: ../register.php?a=numbersonly");
        exit();
    }else{
        $fname = stripslashes($fname);
        $lname = stripslashes($lname);
        $email = stripslashes($email);
        $phone = stripslashes($phone);
        $password = stripslashes($password);
        $repassword = stripslashes($repassword);

        $fname = mysqli_real_escape_string($conn, $fname);
        $lname = mysqli_real_escape_string($conn, $lname);
        $email = mysqli_real_escape_string($conn, $email);
        $phone = mysqli_real_escape_string($conn, $phone);
        $password = mysqli_real_escape_string($conn, $password);
        $repassword = mysqli_real_escape_string($conn, $repassword);

        $fname = ucfirst($fname);
        $lname = ucfirst($lname);
        $email = strtolower($email);
        $password = strtolower($password);
        $repassword = strtolower($repassword);
        
        $fullname = $fname.' '.$lname;

        $sql1="SELECT * FROM users WHERE email = '$email'";
        $result1=mysqli_query($conn, $sql1);
        $count=mysqli_num_rows($result1);
        if($count != '0'){
        header("Location: ../register.php?a=email-exists");
        exit();
        }elseif(strlen($password) < 8 ){
                  header("Location: ../register.php?a=password-too-short");
                  exit();
                }elseif($password != $repassword) {
                    header("Location: ../register.php?a=Denied");
                    exit();
        }

        $password1 = md5($password);
        $repassword1 = md5($repassword);

        $templateid ='2'; // define the session id from the settings for default template  

mysqli_select_db($conn, $database_conn);
$sql = "SELECT * FROM mail_templates WHERE id = '$templateid' "; 
$query_run = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$row = mysqli_fetch_assoc($query_run);
$thead = $row['thead'];
$tfooter = $row['tfooter'];

$title = 'Registration Successful';
$sender_name = 'FCMB Trustees';
$sender = 'notification@fcmbtrustees.com';

$mail   = new PHPMailer();

$mail->SMTPAuth      = true;                  // enable SMTP authentication
$mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
$mail->Host          = "172.27.15.18"; // sets the SMTP server
$mail->Port          = 25;                    // set the SMTP port for the server
$mail->SMTPSecure = "ssl"; 
$mail->Username      = ""; // SMTP account username
$mail->Password      = "";        // SMTP account password


$mail->setFrom($sender, $sender_name);
$mail->AddReplyTo($sender, $sender_name);
$mail->addAddress($email, $fname.' '.$lname);
$mail->Subject = $title ;


$sql="INSERT INTO users (`fname`,`lname`,`email`,`gender`,`phone`,`password`,`created`)VALUES('$fname','$lname','$email','$gender','$phone','$password1', NOW())";
$result = mysqli_query($conn, $sql);
$_SESSION['userid'] = mysqli_insert_id($conn);
$emailid = $_SESSION['userid'];

if(!$result){
  header("Location: ../register.php?a=Invalid");
  exit();
} else {
    $sqlprocessflow = "INSERT INTO processflow_tb (`uid`,`name`,`email`,`stage`,`progress`)VALUES('$emailid','$fullname','$email','1','Yes')";
$resultprocessflow = mysqli_query($conn, $sqlprocessflow);

$message1  = $thead;
$message1 .= 'Dear {name}, <br><br> Thank you for signing up to FCMB Trustees Estate Planning Services. <br> Click <a href="https://on.fcmb.com/Write-Your-Will-Now2" target="_blank">here</a> to log-in to your account and get started.';
$message1 .= $tfooter;

$search = array('{Name}','{name}','{Email}','{email}', '{due}','{Due}','[Name]','[name]','[Email]','[email]');
$replace = array($fname,$fname, $email,$email, $due, $due,$name,$name,$email,$email );
$message = str_replace( $search, $replace,  $message1 );


  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
  $mail->MsgHTML($message);
  $mail->AddAddress($email, $fname);
  

    $mail->AddAttachment($path.$attach1);
    $mail->AddAttachment($path.$attach2);

  if(!$mail->Send()) {
    header("Location: process-admin-usersignup.php");
  } else {
    header("Location: process-admin-usersignup.php");
  }
  // Clear all addresses and attachments for next loop
  $mail->ClearAddresses();
  $mail->ClearAttachments();

}
    }

}else{
    header("Location: ../register.php?a=Error");
}

?>

