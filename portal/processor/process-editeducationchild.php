<?php 
session_start();
ob_start();

require_once('../Connections/conn.php');
$tbl_name = "education_beneficiary"; 

//$userid = $_SESSION['userid'];

  if($_SERVER['REQUEST_METHOD']=='POST'){

    //Getting actual file name
    $name = $_FILES['edtpassport']['name'];
    $size = $_FILES['edtpassport']['size'];
    $edtnameofchild = $_POST['edtnameofchild']; 
    $edtdob =     $_POST['edtdob'];
    $edtsex =    $_POST['edtsex'];
    $edtrelationship =    $_POST['edtrelationship'];
    $edtnameofchildid =    $_POST['edtnameofchildid'];

    //Sanitizing datas
    $search  = array('&', '-', ' ', '.', '+', '()');
    $replace = array('');

    if(!ctype_alpha(str_replace($search,$replace,$edtnameofchild))){
        header("Location: ../education-beneficiary.php?a=lettersonly");
        exit();
    }else{

    $edtnameofchild = trim($edtnameofchild);

    $edtnameofchild = stripslashes($edtnameofchild);

    $edtnameofchild = mysqli_real_escape_string($conn, $edtnameofchild);

    $edtnameofchild = ucfirst($edtnameofchild);

  }

        // valid image extensions
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
    
    //Getting temporary file name stored in php tmp folder 
    $tmp_name = $_FILES['edtpassport']['tmp_name'];
    $imgExt = strtolower(pathinfo($name,PATHINFO_EXTENSION)); // get image extension

        // allow valid image file formats
    if(in_array($imgExt, $valid_extensions)){   
    $Date2 = date('YmdHis');
    $edtpassport = $Date2.".".$imgExt;

    //Path to store files on server
    $path = '../../cms/uploads/passport/';

    if(($size < 1250000)){
      
        if(!empty($name)){
      move_uploaded_file($tmp_name,$path.$edtpassport);

            $insert_personalinfo = "UPDATE education_beneficiary SET `nameofchild` = '$edtnameofchild', `dob` = '$edtdob', `relationship` = '$edtrelationship', `sex` = '$edtsex',  `passport` = '$edtpassport' WHERE id = '$edtnameofchildid' ";

            $result_insert = mysqli_query($conn, $insert_personalinfo) or die(mysqli_error($conn));
            header("Location:../education-beneficiary.php?a=successful");


    }else{
      header("Location:../education-beneficiary.php?a=error");
    }
    }else{
      header("Location:../education-beneficiary.php?a=denied");
    }

  }else{
       $insert_personalinfo = "UPDATE education_beneficiary SET `nameofchild` = '$edtnameofchild', `dob` = '$edtdob', `relationship` = '$edtrelationship', `sex` = '$edtsex' WHERE id = '$edtnameofchildid' ";

            $result_insert = mysqli_query($conn, $insert_personalinfo) or die(mysqli_error($conn));
            header("Location:../education-beneficiary.php?a=successful");
  }

  }else{
    header("Location:../education-beneficiary.php?a=error");
  }