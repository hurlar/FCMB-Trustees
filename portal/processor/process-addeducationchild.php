<?php 
session_start();
ob_start();

require_once('../Connections/conn.php');
$tbl_name = "education_beneficiary"; 

//$userid = $_SESSION['userid'];

  if($_SERVER['REQUEST_METHOD']=='POST'){

    //Getting actual file name
    $name = $_FILES['passport']['name'];
    $size = $_FILES['passport']['size'];
    $nameofchild = $_POST['nameofchild']; 
    $dob =     $_POST['dob'];
    $sex =    $_POST['sex'];
    $relationship =    $_POST['relationship'];
    $educationuid =    $_POST['educationuid'];

    //Sanitizing datas
    $search  = array('&', '-', ' ', '.', '+', '()');
    $replace = array('');

    if(!ctype_alpha(str_replace($search,$replace,$nameofchild))){
        header("Location: ../education-beneficiary.php?a=lettersonly");
        exit();
    }else{

    $nameofchild = trim($nameofchild);

    $nameofchild = stripslashes($nameofchild);

    $nameofchild = mysqli_real_escape_string($conn, $nameofchild);

    $nameofchild = ucfirst($nameofchild);

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

            $insert_personalinfo = "INSERT INTO education_beneficiary (`uid`, `nameofchild`, `dob`,`relationship`,`sex`,`passport`,`dateposted`) VALUES ('$educationuid', '$nameofchild', '$dob','$relationship','$sex','$passport', NOW()) ";

            $result_insert = mysqli_query($conn, $insert_personalinfo) or die(mysqli_error($conn));
            header("Location:../education-beneficiary.php?a=successful");


    }else{
      header("Location:../education-beneficiary.php?a=error");
    }
    }else{
      header("Location:../education-beneficiary.php?a=denied");
    }

  }else{
    header("Location:../education-beneficiary.php?a=invalid");
  }

  }else{
    header("Location:../education-beneficiary.php?a=error");
  }