<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$edtearningtype = $_POST['edtearningtype']; 
$edtsourceoffundnote =     $_POST['edtsourceoffundnote'];
$edtsourceoffundannualincome =    $_POST['edtsourceoffundannualincome'];
$edtsourceoffundid =    $_POST['edtsourceoffundid'];

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
        
$edtearningtype = trim($edtearningtype);
$edtsourceoffundnote =     trim($edtsourceoffundnote);
$edtsourceoffundannualincome =    trim($edtsourceoffundannualincome);

$edtearningtype = stripslashes($edtearningtype);
$edtsourceoffundnote =     stripslashes($edtsourceoffundnote);
$edtsourceoffundannualincome =    stripslashes($edtsourceoffundannualincome);

$edtearningtype = mysqli_real_escape_string($conn, $edtearningtype);
$edtsourceoffundnote =     mysqli_real_escape_string($conn, $edtsourceoffundnote);
$edtsourceoffundannualincome =    mysqli_real_escape_string($conn, $edtsourceoffundannualincome);

$url1 = '../education-marital-info.php?a=update';
$url2 = '../education-marital-info.php?a=error';

mysqli_select_db($conn, $database_conn);

$sql="UPDATE  sourceoffund SET `earning_type` = '$edtearningtype', `note` = '$edtsourceoffundnote', `annual_income` = '$edtsourceoffundannualincome' WHERE `id` = '$edtsourceoffundid' ";  

$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$lastid = mysql_insert_id();

if(!$result){
header("Location: $url2"); 
} else {
header("Location: $url1");
}
//}
?>

