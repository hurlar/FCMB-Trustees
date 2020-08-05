<?php

session_start();

ob_start();

require_once('../Connections/conn.php');

$uid =    $_POST['uid'];

mysqli_select_db($conn, $database_conn);

$ex = "SELECT uid FROM assets_tb WHERE uid = '$uid' "; 

$query_ex = mysqli_query($conn, $ex) or die(mysqli_error($conn));

$totalex = mysqli_num_rows($query_ex); 

if ($totalex < '1') {
    header("Location:../my-assets.php?a=denied");
    exit();
}else{
    header("Location:../percentage-sharing.php");
	//exit();
}

?>



