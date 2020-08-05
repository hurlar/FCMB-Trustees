<?php require('Connections/conn.php');
// If form submitted, insert values into the database.
if (isset($_POST['email'])){
        // removes backslashes
    $email = stripslashes($_REQUEST['email']);
        //escapes special characters in a string
    $email = mysqli_real_escape_string($conn,$email);
    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($conn,$password);
    $email = strtolower($email);
    $password = strtolower($password);
    $password1 = md5($password);
    //Checking is user existing in the database or not
        $query = "SELECT * FROM `users` WHERE email='$email'
and password='$password1' ";
    $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    $r = mysqli_fetch_assoc($result);
    $rows = mysqli_num_rows($result);
        if($rows==1){
  $_SESSION['userid'] = $r['id'];
  $_SESSION['email'] = $r['email'];
  $_SESSION['fname'] = $r['fname'];
    $_SESSION['lname'] = $r['lname'];
    $_SESSION['gender'] = $r['gender'];
    $_SESSION['phone'] = $r['phone'];
            // Redirect user to index.php
        header("Location: getstarted.php");
         }else{
            header("Location: index.php?a=denied");
    }
    } ?>