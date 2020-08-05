<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$edtnameofcompany = $_POST['edtnameofcompany']; 
$edttelephone =     $_POST['edttelephone'];
$edtemailaddress =    $_POST['edtemailaddress'];
$edthumanresourceid =    $_POST['edthumanresourceid'];

   // $search  = array('&', '-', ' ', '.');
    //$replace = array('');

    //if(!ctype_alpha(str_replace($search,$replace,$edtnextofkinfullname))){
      //  header("Location: ../simplewill-marital-info.php?a=lettersonly");
        //exit();
    //}elseif(!ctype_alpha(str_replace($search,$replace,$edtnextofkinmaidenname//))){
        //header("Location: ../simplewill-marital-info.php?a=lettersonly");
        //exit();
    //}elseif(!ctype_digit($edtnextofkinphone)){
      //  header("Location: ../simplewill-marital-info.php?a=numbersonly");
        //exit();
    //}else{
        
$edtnameofcompany = trim($edtnameofcompany);
$edttelephone =     trim($edttelephone);
$edtemailaddress =    trim($edtemailaddress);

$edtnameofcompany = stripslashes($edtnameofcompany);
$edttelephone =     stripslashes($edttelephone);
$edtemailaddress =    stripslashes($edtemailaddress);

$edtnameofcompany = mysqli_real_escape_string($conn, $edtnameofcompany);
$edttelephone =     mysqli_real_escape_string($conn, $edttelephone);
$edtemailaddress =    mysqli_real_escape_string($conn, $edtemailaddress);

$url1 = '../simplewill-marital-info.php?a=update';
$url2 = '../simplewill-marital-info.php?a=error';

mysqli_select_db($conn, $database_conn);

$sql="UPDATE humanresourcescontact SET `nameofcompany` = '$edtnameofcompany', `telephone` = '$edttelephone', `emailaddress` = '$edtemailaddress' WHERE `id` = '$edthumanresourceid' ";  

$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$lastid = mysql_insert_id();

if(!$result){
header("Location: $url2"); 
} else {
header("Location: $url1");
}
//}
?>

