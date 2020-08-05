<?php 
session_start();
ob_start();

require_once('../Connections/conn.php');
$tbl_name = "passport_tb"; 

//$userid = $_SESSION['userid'];

	if($_SERVER['REQUEST_METHOD']=='POST'){
		
		//Getting actual file name
		$name = $_FILES['addphoto']['name'];
		$size = $_FILES['addphoto']['size'];
		$uid = $_POST['uid']; 


		// valid image extensions
		$valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions
		
		
		//Getting temporary file name stored in php tmp folder 
		$tmp_name = $_FILES['addphoto']['tmp_name'];
		$imgExt = strtolower(pathinfo($name,PATHINFO_EXTENSION)); // get image extension

		// allow valid image file formats
		if(in_array($imgExt, $valid_extensions)){		
		$Date2 = date('YmdHis');
		$newfile = $Date2.".".$imgExt;

		//Path to store files on server
		$path = 'uploads/pix/';
		
		//checking File size
		if(($size > 10000)){
			
			header("Location:../simplewill-add-witness.php?a=Denied"); //Size is too Large
			
		}
			
		//checking file available or not 
		if(!empty($name)){
			move_uploaded_file($tmp_name,$path.$newfile);


    //Writes the information to the database
    $query = "INSERT INTO '$tbl_name' (uid, image) VALUES ('$uid', '$newfile') ";
    $query_run = mysqli_query($conn, $query) or die(mysqli_error($conn));
}else{
  header("Location:../simplewill-add-witness.php?a=Invalid"); //Invalid file format
}
		   header("Location:../simplewill-add-witness.php?a=Successful"); // Success
		}else{
			header("Location:../simplewill-add-witness.php?a=Error"); //Error Message
		}
	}
?>