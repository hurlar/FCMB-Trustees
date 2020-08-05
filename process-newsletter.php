<?php

session_start();
ob_start();

include('Connections/conn.php');


$newsletter  =    $_POST['newsletter'];


$newsletter = stripslashes($newsletter);


$newsletter = mysqli_real_escape_string($conn, $newsletter); 

$admin = 'fcmbtrustees@fcmb.com';


if(!isset($newsletter)) {
        
        header("Location: index.php?a=error-all");
    }

    // PHP validation for the fields required
	if(!filter_var($newsletter, FILTER_VALIDATE_EMAIL)) {
        header("Location: index.php?a=error-email");
    }

    else {

$to =  $admin;
$subject1 = "New Message from FCMB Trustees Newsletter Form " ;
$message1 = "Email: {newsletter} ";

// Always set content-type when sending HTML email

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: FCMB TRUSTEES <fcmbtrustees@fcmb.com>" . "\r\n";


$replacements = array(

        '({newsletter})' =>   $newsletter,

    );

    $message = preg_replace( array_keys( $replacements ), array_values( $replacements ), $message1 ); 

$sentmail = mail($to,$subject1,$message,$headers); 
}
?>

<?php if ($sentmail) { ?>
	<script language="javascript" type="text/javascript">
		alert('Thank you for subscribing to our newsletter. We will contact you shortly.');
		window.location = 'index.php';
	</script>
<?php } else { ?>
	<script language="javascript" type="text/javascript">
		alert('Message failed. Please, send an email to fcmbtrustees@fcmb.com');
		window.location = 'index.php';
	</script>
<?php } ?>

