<?php require ('Connections/conn.php');
$_SESSON['param'] = mysqli_real_escape_string($conn, $_GET['param']) ;
$_SESSION['slug'] = mysqli_real_escape_string($conn, $_GET['slug']) ;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FCMB Trustees</title>
    <link href="images/favicon.ico" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="css/iofrm-theme19.css">
    <link href="images/favicon.ico" rel="shortcut icon">
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-50894378-7"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-50894378-7');
</script>

</head>
<body>
    <div class="form-body without-side">
        <div class="website-logo">
            <a href="index.php">
                <div class="logo">
                    <img class="logo-size" src="images/logo.svg" alt="">
                </div>
            </a>
            <!--<h3>Welcome to FCMB Trustees</h3>-->
        </div>
        <div class="row">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <img src="images/graphic3.svg" alt="">

                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Change Password</h3>
                         <p style="color:red;">Password must be at least 8 characters</p> 
                       <form action="processor/process-changepwd.php" method="post">
                            <!--<form action="test.php" method="post">-->
<?php 
if (isset($_GET['a'])) {  
$url = mysqli_real_escape_string($conn, $_GET['a']) ;
?>

<?php if($url == 'password-mismatch'){  ?>
<div class="alert alert-warning">
  <strong>Warning! </strong><?php echo  ' The entered passwords do not match' ; ?>
</div>
<?php } ?>




<?php if($url == 'error'){  ?>
<div class="alert alert-warning">
  <strong>Warning! </strong><?php echo  ' Sorry, we couldn\'t process your request at the moment' ; ?>
</div>
<?php } ?>


<?php if($url == 'password-too-short'){  ?>
<div class="alert alert-warning">
  <?php echo  ' Password must be a minimum of 8 characters' ; ?>
</div>
<?php } ?>

<?php if($url == 'signup-ok'){  ?>
<div class="alert alert-success">
  <?php echo  'Account created successfully. Please Login' ; ?>
</div>
<?php } ?>

<?php if($url == 'successful'){  ?>
<div class="alert alert-success">
  <?php echo  'Password change successful.<br> Please Login' ; ?>
</div>
<?php } ?>


<?php 
}
?>
                            <!--<input class="form-control" type="text" name="email" placeholder="E-mail Address" required>-->
                            <label>Enter Your New Password</label>
                            <input class="form-control" type="password" name="password" required>
                            <label>Confirm Your New Password</label>
                            <input class="form-control" type="password" name="repassword" required>
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>