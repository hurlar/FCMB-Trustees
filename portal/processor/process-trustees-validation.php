<?php

session_start();

ob_start();

require_once('../Connections/conn.php');

$uid =    $_POST['uid'];
$ctrustee =    $_POST['ctrustee'];

mysqli_select_db($conn, $database_conn);

$ex = "SELECT uid FROM trustee_tb WHERE uid = '$uid' "; 

$query_ex = mysqli_query($conn, $ex) or die(mysqli_error($conn));

$totalex = mysqli_num_rows($query_ex); 

//if ($totalex < '1') {
    //header("Location:../add-trustees.php?a=denied");
   // exit();
//}

//mysqli_select_db($conn, $database_conn);

//$in = "INSERT INTO trustee_tb (`uid`, `title`, `fullname`, `email`, `phone`, `addr`) VALUES ('$uid', 'corporate', 'FCMB Trustees', 'fcmbtrustees@fcmb.com', '+234 1 290 2721', 'Primrose Tower, 2nd Floor, 17A Tinubu Street,
//Lagos')"; 

//$query_in = mysqli_query($conn, $in) or die(mysqli_error($conn));

mysqli_select_db($conn, $database_conn);

$sql = "SELECT uid,access FROM access_level  WHERE uid = '$uid' "; 

$query_sql = mysqli_query($conn, $sql) or die(mysqli_error($conn));

$row_access = mysqli_fetch_assoc($query_sql);

$totalacl = mysqli_num_rows($query_sql); 

if ($row_access['access'] > '4') {
	header("Location:../dashboard.php");
	exit();
}

if ($totalacl == TRUE) {

	$update1 = "UPDATE access_level SET access = '4' WHERE uid = '$uid' "; 

	$update_run1 = mysqli_query($conn, $update1) or die(mysqli_error($conn));

	header("Location: ../dashboard.php?a=update");

	//exit();

}else{

	$insert1 = "INSERT INTO access_level (uid, access) VALUES ('$uid', '4')";

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



