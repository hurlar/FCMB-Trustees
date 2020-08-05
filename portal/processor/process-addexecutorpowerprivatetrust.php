<?php

session_start();

ob_start();

require_once('../Connections/conn.php');

$uid = $_POST['uid'];
$willtype = $_POST['willtype'];
$question1 = $_POST['question1'];
$question2 = $_POST['question2'];
$question3 = $_POST['question3'];
$question4 = $_POST['question4'];
$question5 = $_POST['question5'];
$question6 = $_POST['question6'];
$question7 = $_POST['question7'];
$question8 = $_POST['question8'];
$question9 = $_POST['question9'];
$question10 = $_POST['question10'];
$question11 = $_POST['question11'];
$question12 = $_POST['question12'];
$question13 = $_POST['question13'];
$question14 = $_POST['question14'];
$question15 = $_POST['question15'];


$question1 = trim($question1);
$question2 = trim($question2);
$question3 = trim($question3);
$question4 = trim($question4);
$question5 = trim($question5);
$question6 = trim($question6);
$question7 =    trim($question7);
$question8 =    trim($question8);
$question9 =    trim($question9);
$question10 =    trim($question10);
$question11 =    trim($question11);
$question12 =    trim($question12);
$question13 =    trim($question13);
$question14 =    trim($question14);
$question15 =    trim($question15);



$question1 = stripslashes($question1);
$question2 = stripslashes($question2);
$question3 = stripslashes($question3);
$question4 = stripslashes($question4);
$question5 = stripslashes($question5);
$question6 = stripslashes($question6);
$question7 = stripslashes($question7);
$question8 =    stripslashes($question8);
$question9 =    stripslashes($question9);
$question10 =    stripslashes($question10);
$question11 =    stripslashes($question11);
$question12 =    stripslashes($question12);
$question13 =    stripslashes($question13);
$question14 =    stripslashes($question14);
$question15 =    stripslashes($question15);



$question1 = mysqli_real_escape_string($conn, $question1);
$question2 = mysqli_real_escape_string($conn, $question2);
$question3 = mysqli_real_escape_string($conn, $question3);
$question4 = mysqli_real_escape_string($conn, $question4);
$question5 = mysqli_real_escape_string($conn, $question5);
$question6 = mysqli_real_escape_string($conn, $question6);
$question7 = mysqli_real_escape_string($conn, $question7);
$question8 =    mysqli_real_escape_string($conn, $question8);
$question9 =    mysqli_real_escape_string($conn, $question9);
$question10 =    mysqli_real_escape_string($conn, $question10);
$question11 =    mysqli_real_escape_string($conn, $question11);
$question12 =    mysqli_real_escape_string($conn, $question12);
$question13 =    mysqli_real_escape_string($conn, $question13);
$question14 =    mysqli_real_escape_string($conn, $question14);
$question15 =    mysqli_real_escape_string($conn, $question15);

/*$fname = ucfirst($fname);

$mname = ucfirst($mname);

$lname = ucfirst($lname);*/

$url1 = '../privatetrust-preview.php';

$url2 = '../privatetrust-executors-power.php?a=error';

mysqli_select_db($conn, $database_conn);

$sql1 = "SELECT `id`,`uid`,`willtype` FROM executor_power WHERE `uid` = '$uid' AND `willtype` = '$willtype' ";
$result1 = mysqli_query($conn, $sql1) or die(mysqli_error($conn));
$total = mysqli_fetch_assoc($result1); 
$executorpowerid = $total['id']; 
if($total == TRUE){
    $sql3 = "UPDATE executor_power SET question1 = '$question1', question2 = '$question2', question3 = '$question3', question4 = '$question4', question5 = '$question5', question6 = '$question6', question7 = '$question7', question8 = '$question8', question9 = '$question9', question10 = '$question10', question11 = '$question11', question12 = '$question12', question13 = '$question13', question14 = '$question14', question15 = '$question15' WHERE id = $executorpowerid";
         $result_sql3 = mysqli_query($conn, $sql3) or die(mysqli_error($conn));
        if($result_sql3 == TRUE){
                header("Location: $url1"); 
    exit();
        }

}else{
  $sql="INSERT INTO executor_power (`uid` ,`willtype` ,`question1` ,`question2` ,`question3` ,`question4` ,`question5` ,`question6` ,`question7` ,`question8` ,`question9` ,`question10` ,`question11` ,`question12` ,`question13` ,`question14` ,`question15` ,`dateposted`) VALUES ('$uid' ,'$willtype' ,'$question1' ,'$question2' ,'$question3' ,'$question4', '$question5' ,'$question6' ,'$question7' ,'$question8' ,'$question9' ,'$question10' ,'$question11' ,'$question12' ,'$question13' ,'$question14' ,'$question15', NOW()) ";

      $result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

      if($result){
      header("Location: $url1"); 

      }

}



?>



