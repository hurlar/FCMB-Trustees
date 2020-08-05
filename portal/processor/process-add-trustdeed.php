<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$purposeoftrust = $_POST['purposeoftrust'];
$nameoftrust = $_POST['nameoftrust'];
$initialcontribution = $_POST['initialcontribution'];
$trustdeeduid = $_POST['trustdeeduid'];

$_SESSION['purposeoftrust'] = $purposeoftrust;
$_SESSION['nameoftrust'] = $nameoftrust;
$_SESSION['initialcontribution'] = $initialcontribution;

//echo $uid.' '.$workorderid;
//exit();

$url1 = '../trust-deed.php?a=successful';
$url2 = '../trust-deed.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql="INSERT INTO trustdeed_tb (`uid`, `purposeoftrust`, `nameoftrust`,`initialcontribution`,`dateposted`) VALUES ('$trustdeeduid','$purposeoftrust', '$nameoftrust', '$initialcontribution', NOW())";

$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$lastid = mysql_insert_id();

if(!$result){
header("Location: $url2"); 
} else {
unset($_SESSION["purposeoftrust"]);
unset($_SESSION["nameoftrust"]);
unset($_SESSION["initialcontribution"]);
header("Location: $url1");
}
//}
?>

