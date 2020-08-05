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
    //header("Location:../my-assets.php?a=denied");
    //exit();
    mysqli_select_db($conn, $database_conn);

            $sqlaccess = "SELECT `uid`,`access` FROM access_level  WHERE `uid` = '$uid' "; 
            
            $query_sqlaccess = mysqli_query($conn, $sqlaccess) or die(mysqli_error($conn));
            
            $row_access = mysqli_fetch_assoc($query_sqlaccess); 
            
            $totalaccess = mysqli_num_rows($query_sqlaccess); 
            
            if ($row_access['access'] > '2') {
            	header("Location:../dashboard.php");
            	exit();
            }
            
            if ($totalaccess == TRUE) {
            
            	$update1 = "UPDATE access_level SET access = '2' WHERE uid = '$uid' "; 
            
            	$update_run1 = mysqli_query($conn, $update1) or die(mysqli_error($conn));
            
            	header("Location: ../dashboard.php");
            
            	//exit();
            
            }else{
            
            	$insert1 = "INSERT INTO access_level (uid, access) VALUES ('$uid', '2')";
            
            	$insert_run1 = mysqli_query($conn, $insert1) or die(mysqli_error($conn));
            
            	header("Location: ../dashboard.php");
            
            }
}else{
    header("Location:../percentage-sharing.php");
	//exit();
}

?>



