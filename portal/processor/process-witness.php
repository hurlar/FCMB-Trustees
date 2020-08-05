<?php

session_start();

ob_start();

require_once('../Connections/conn.php');

$uid =    $_POST['uid'];

//mysqli_select_db($conn, $database_conn);

//$ex = "SELECT uid FROM witness_tb WHERE uid = '$uid' "; 

//$query_ex = mysqli_query($conn, $ex) or die(mysqli_error($conn));

//$totalex = mysqli_num_rows($query_ex); 

//if ($totalex < '2') {
    //header("Location:../add-witness.php?a=denied");
    //exit();
//}


mysqli_select_db($conn, $database_conn);

$sql = "SELECT uid,access FROM access_level  WHERE uid = '$uid' "; 

$query_sql = mysqli_query($conn, $sql) or die(mysqli_error($conn));

$row_access = mysqli_fetch_assoc($query_sql);

$totalacl = mysqli_num_rows($query_sql); 

if ($row_access['access'] > '5') {
	header("Location:../dashboard.php");
	exit();
}

if ($totalacl == TRUE) {

	$update1 = "UPDATE access_level SET access = '5' WHERE uid = '$uid' "; 

	$update_run1 = mysqli_query($conn, $update1) or die(mysqli_error($conn));

	header("Location: ../dashboard.php?a=update");

	//exit();

}else{

	$insert1 = "INSERT INTO access_level (uid, access) VALUES ('$uid', '5')";

	$insert_run1 = mysqli_query($conn, $insert1) or die(mysqli_error($conn));

	header("Location: ../dashboard.php?a=insert");

}

?>



