<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$nameofcompany = $_POST['nameofcompany']; 
$telephone =     $_POST['telephone'];
$emailaddress =    $_POST['emailaddress'];
$humanresourceid =    $_POST['humanresourceid'];

$_SESSION['nameofcompany'] = $nameofcompany;
$_SESSION['telephone'] =     $telephone;
$_SESSION['emailaddress'] =    $emailaddress;
$_SESSION['humanresourceid'] =    $humanresourceid;

   // $search  = array('&', '-', ' ', '.');
    //$replace = array('');

    //if(!ctype_alpha(str_replace($search,$replace,$nextofkinfullname))){
      //  header("Location: ../simplewill-marital-info.php?a=lettersonly");
        //exit();
    //}elseif(!ctype_alpha(str_replace($search,$replace,$nextofkinmothername))){
      //  header("Location: ../simplewill-marital-info.php?a=lettersonly");
        //exit();
    //}elseif(!ctype_digit($nextofkinphone)){
      //  header("Location: ../simplewill-marital-info.php?a=numbersonly");
        //exit();
    //}else{

$nameofcompany = trim($nameofcompany);
$telephone =     trim($telephone);
$emailaddress =    trim($emailaddress);

$nameofcompany = stripslashes($nameofcompany);
$telephone =     stripslashes($telephone);
$emailaddress =    stripslashes($emailaddress);

$nameofcompany = mysqli_real_escape_string($conn, $nameofcompany);
$telephone =     mysqli_real_escape_string($conn, $telephone);
$emailaddress =    mysqli_real_escape_string($conn, $emailaddress);

$url1 = '../simplewill-marital-info.php?a=successful';
$url2 = '../simplewill-marital-info.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql="INSERT INTO  humanresourcescontact (`uid`, `nameofcompany`, `telephone`, `emailaddress`) VALUES ('$humanresourceid', '$nameofcompany', '$telephone', '$emailaddress' )";

$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$lastid = mysql_insert_id();

if(!$result){
header("Location: $url2"); 
} else {
unset($_SESSION["nameofcompany"]);
unset($_SESSION["telephone"]);
unset($_SESSION["emailaddress"]);

header("Location: $url1");
}
//}
?>

