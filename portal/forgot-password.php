<?php require ('Connections/conn.php');?>
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
                        <!--<h3>Login to your account</h3>-->
                         <p>Enter your email address and we will send you a link to reset your password.</p> 
                        <form action="processor/process-forgottenpwd.php" method="post">
<?php 
if (isset($_GET['a'])) {  
$url = mysqli_real_escape_string($conn, $_GET['a']) ;
?>

<?php if($url == 'error'){  ?>
<div class="alert alert-warning">
  <strong>Warning! </strong><?php echo  ' Sorry we couldn\'t process your request. Please try again later '; ?>
</div>
<?php } ?>




<?php if($url == 'Invalid'){  ?>
<div class="alert alert-warning">
  <strong>Warning! </strong><?php echo  ' No Account Found' ; ?>
</div>
<?php } ?>


<?php if($url == 'logout'){  ?>
<div class="alert alert-warning">
  <?php echo  ' You have successfully logged out' ; ?>
</div>
<?php } ?>

<?php if($url == 'signup-ok'){  ?>
<div class="alert alert-success">
  <?php echo  'Account created successfully. Please Login' ; ?>
</div>
<?php } ?>

<?php if($url == 'successful'){  ?>
<div class="alert alert-success">
  <?php echo  'A password reset link has been sent to your Email Address ' ; ?>
</div>
<?php } ?>


<?php 
}
?>
                            
                            <input class="form-control" type="email" name="forgottenemail" placeholder="Enter E-mail Address" required>
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn">Reset Password</button> 
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