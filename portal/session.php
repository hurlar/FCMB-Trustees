<?php
$userid1 = $_SESSION['userid'];

$query = "SELECT * FROM users WHERE `id` = '$userid1' ";
$usr = mysqli_query($conn, $query) or die(mysqli_error($conn));
$rowusr = mysqli_fetch_assoc($usr);
$userid = $rowusr['id'];
$fname = $rowusr['fname'];
$lname = $rowusr['lname'];
$gender = $rowusr['gender']; 
$phone = $rowusr['phone']; 

    
    // set timeout period in seconds
$inactive = 1500;
// check to see if $_SESSION['timeout'] is set
if(isset($_SESSION['timeout']) ) {
	$session_life = time() - $_SESSION['timeout']; 
	if($session_life > $inactive)
        { session_destroy(); header("Location: logout.php"); }
}
$_SESSION['timeout'] = time();
?>