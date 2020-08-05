<?php 
session_start();
ob_start();

require_once('../Connections/conn.php');
$tbl_name = "personal_info"; 

//$userid = $_SESSION['userid'];

  if($_SERVER['REQUEST_METHOD']=='POST'){

    //Getting actual file name
    $name = $_FILES['passport']['name'];
    $size = $_FILES['passport']['size'];
    $uid = $_POST['uid']; 
    $salutation = $_POST['salutation']; 
    $fname =     $_POST['fname'];
    $mname =    $_POST['mname'];
    $lname =    $_POST['lname'];
    $dob =    $_POST['dob'];
    //$dob = date("Y-m-d", strtotime($dob1)); 
    $gender =    $_POST['gender'];
    $mothermaidenname =    $_POST['mothermaidenname']; 
    $nationality =    $_POST['nationality'];
    $state =    $_POST['state'];
    $phoneno =    $_POST['phoneno'];
    $aphoneno =    $_POST['altphoneno'];
    $msg =    $_POST['message'];
    $city =    $_POST['city'];
    $rstate =    $_POST['rstate'];
    $lga =    $_POST['lga'];
    $identification =    $_POST['identification'];
    $idnumber =    $_POST['idnumber'];
    $issuedate =    $_POST['issuedate'];
    //$issuedate =date("Y-m-d", strtotime($issuedate1)); 
    $expirydate =    $_POST['expirydate']; 
    //$expirydate =date("Y-m-d", strtotime($expirydate1)); 
    $issuedplace =    $_POST['issuedplace'];
    $estatus =    $_POST['estatus'];
    $employer =    $_POST['employer'];
    $employeraddr =    $_POST['employeraddr'];
    $employerphone =    $_POST['employerphone'];
    $sourceoffund =    $_POST['sourceoffund'];
    $earningothers =    $_POST['earningothers'];
    $annualturnover =    $_POST['annualturnover'];

    //Sanitizing datas
    $search  = array('&', '-', ' ', '.', '+', '()');
    $replace = array('');

    if(!ctype_alpha(str_replace($search,$replace,$fname))){
        header("Location: ../education-personal-info.php?a=lettersonly");
        exit();
    }elseif(!ctype_alpha(str_replace($search,$replace,$lname))){
        header("Location: ../education-personal-info.php?a=lettersonly");
        exit();
    }elseif(!ctype_digit($phoneno)){
        header("Location: ../education-personal-info.php?a=numbersonly");
        exit();
    }elseif(!ctype_alpha(str_replace($search,$replace,$mothermaidenname))){
        header("Location: ../education-personal-info.php?a=lettersonly");
        exit();
    }else{

    $fname = trim($fname);
    $mname = trim($mname);
    $lname = trim($lname);
    $phoneno = trim($phoneno);
    $aphoneno = trim($aphoneno);
    $msg = trim($msg);
    $city = trim($city);
    $lga =    trim($lga);
    $employer =    trim($employer);
    $employeraddr =    trim($employeraddr);
    $employerphone =    trim($employerphone);
    $sourceoffund =     trim($sourceoffund);
    $earningothers =     trim($earningothers);
    $annualturnover =     trim($annualturnover);


    $fname = stripslashes($fname);
    $mname = stripslashes($mname);
    $lname = stripslashes($lname);
    $phoneno = stripslashes($phoneno);
    $aphoneno = stripslashes($aphoneno);
    $msg = stripslashes($msg);
    $city = stripslashes($city);
    $lga =    stripslashes($lga);
    $employer =    stripslashes($employer);
    $employeraddr =    stripslashes($employeraddr);
    $employerphone =    stripslashes($employerphone);
    $sourceoffund =    stripslashes($sourceoffund);
    $earningothers =    stripslashes($earningothers);
    $annualturnover =    stripslashes($annualturnover);

    
    $fname = mysqli_real_escape_string($conn, $fname);
    $mname = mysqli_real_escape_string($conn, $mname);
    $lname = mysqli_real_escape_string($conn, $lname);
    $phoneno = mysqli_real_escape_string($conn, $phoneno);
    $aphoneno = mysqli_real_escape_string($conn, $aphoneno);
    $msg = mysqli_real_escape_string($conn, $msg);
    $city = mysqli_real_escape_string($conn, $city);
    $lga =    mysqli_real_escape_string($conn, $lga);
    $employer =    mysqli_real_escape_string($conn, $employer);
    $employeraddr =    mysqli_real_escape_string($conn, $employeraddr);
    $employerphone =    mysqli_real_escape_string($conn, $employerphone);
    $sourceoffund =    mysqli_real_escape_string($conn, $sourceoffund);
    $earningothers =    mysqli_real_escape_string($conn, $earningothers);
    $annualturnover =    mysqli_real_escape_string($conn, $annualturnover);

    $fname = ucfirst($fname);
    $mname = ucfirst($mname);
    $lname = ucfirst($lname);
    $mothermaidenname = ucfirst($mothermaidenname);

  }

        // valid image extensions
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
    
    //Getting temporary file name stored in php tmp folder 
    $tmp_name = $_FILES['passport']['tmp_name'];
    $imgExt = strtolower(pathinfo($name,PATHINFO_EXTENSION)); // get image extension

        // allow valid image file formats
    if(in_array($imgExt, $valid_extensions)){   
    $Date2 = date('YmdHis');
    $passport = $Date2.".".$imgExt;

    //Path to store files on server
    $path = '../../cms/uploads/passport/';

    if(($size < 1250000)){
      
        if(!empty($name)){
      move_uploaded_file($tmp_name,$path.$passport);

            //Checking if the uid exists inside the personal info table
      $query_select = "SELECT `uid` FROM personal_info WHERE uid = '$uid' ";
      $select_run = mysqli_query($conn, $query_select) or die(mysqli_error($conn));
      $total_select = mysqli_num_rows($select_run);
      //echo $passport; 
      if ($total_select = '1') {
            $update_personalinfo = "UPDATE personal_info SET salutation = '$salutation', fname = '$fname', mname = '$mname', lname = '$lname', dob = '$dob', gender = '$gender', maidenname = '$mothermaidenname', nationality = '$nationality', state = '$state', phone = '$phoneno', aphone = '$aphoneno', msg = '$msg', city = '$city', rstate = '$rstate', lga = '$lga', employment_status = '$estatus', employer = '$employer', employerphone = '$employerphone', employeraddr = '$employeraddr', passport = '$passport', identification_type = '$identification', identification_number = '$idnumber', issuedate = '$issuedate', expirydate = '$expirydate', issuedplace = '$issuedplace', earning_type = '$sourceoffund', earning_note = '$earningothers', annual_income = '$annualturnover' WHERE uid = $uid";
    
            $update_user = "UPDATE users SET fname = '$fname', lname = '$lname', phone = '$phoneno', gender = '$gender' WHERE id = '$uid' ";
            $result_update = mysqli_query($conn, $update_personalinfo) or die(mysqli_error($conn));
            //echo 'Successfully Updated';
            header("Location:../education-marital-info.php");
      }else{
            $insert_personalinfo = "INSERT INTO personal_info (salutation, fname, mname, lname, dob, gender, maidenname, nationality, state, phone,aphone,msg,city,rstate,lga,uid,datecreated,employment_status, employer, employeraddr, employerphone, passport,  identification_type, identification_number, issuedate , expirydate, issuedplace, earning_type, earning_note, annual_income) VALUES ('$salutation', '$fname', '$mname', '$lname', '$dob', '$gender', '$mothermaidenname', '$nationality', '$state', '$phoneno', '$aphoneno', '$msg', '$city', '$rstate','$lga', '$uid', NOW(), '$estatus', '$employer', '$employeraddr', '$employerphone', '$passport', '$identification', '$idnumber', '$issuedate', '$expirydate', '$issuedplace', '$sourceoffund', '$earningothers', '$annualturnover') ";

            $insert_user = "UPDATE users SET fname = '$fname', lname = '$lname', phone = '$phoneno', gender = '$gender' WHERE id = '$uid' ";
            $result_insert = mysqli_query($conn, $insert_personalinfo) or die(mysqli_error($conn));
            header("Location:../education-marital-info.php");
            //echo 'Successfully Inserted';
      }

    }else{
      header("Location:../education-personal-info.php?a=error");
    }
    }else{
      header("Location:../education-personal-info.php?a=denied");
    }

  }else{
    header("Location:../education-personal-info.php?a=invalid");
  }

  }else{
    header("Location:../education-personal-info.php?a=error");
  }