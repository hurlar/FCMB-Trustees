<?php

session_start();

ob_start();

require_once('../Connections/conn.php');

$uid =    $_POST['uid'];

mysqli_select_db($conn, $database_conn);

$sql = "SELECT uid,access FROM access_level  WHERE uid = '$uid' "; 

$query_sql = mysqli_query($conn, $sql) or die(mysqli_error($conn));

$totalacl = mysqli_num_rows($query_sql); 

if ($row_access['access'] > '6') {
	header("Location:../dashboard.php");
	exit();
}

if ($totalacl == TRUE) {

	$update1 = "UPDATE access_level SET access = '6' WHERE uid = '$uid' "; 

	$update_run1 = mysqli_query($conn, $update1) or die(mysqli_error($conn));

	header("Location: ../dashboard.php?a=update");

	//exit();

}else{

	$insert1 = "INSERT INTO access_level (uid, access) VALUES ('$uid', '6')";

	$insert_run1 = mysqli_query($conn, $insert1) or die(mysqli_error($conn));

	header("Location: ../dashboard.php?a=insert");

}





//mysqli_select_db($conn, $database_conn);

//$query = "SELECT uid FROM bvn_tb WHERE uid = '$uid' "; 

//$query_run = mysqli_query($conn, $query) or die(mysqli_error($conn));

//$totalms = mysqli_num_rows($query_run); 



//if ($totalms == TRUE) {

	//$update = "UPDATE bvn_tb SET bvn = '$bvn' WHERE uid = '$uid' "; 

	//$update_run = mysqli_query($conn, $update) or die(mysqli_error($conn));

	//header("Location: ../dashboard.php?a=update");

	//exit();

//}else{

	//$insert = "INSERT INTO bvn_tb (uid, bvn) VALUES ('$uid', '$bvn')";

	//$insert_run = mysqli_query($conn, $insert) or die(mysqli_error($conn));

	//header("Location: ../dashboard.php?a=insert");

//}



?>



