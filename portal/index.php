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
                        <h3>Login to your account</h3>
                        <!-- <p>Access to the most powerfull tool in the entire design and web industry.</p> -->
                        <form action="authenticate.php" method="post">
<?php 
if (isset($_GET['a'])) {  
$url = $_GET['a'] ;
?>

<?php if($url == 'denied'){  ?>
<div class="alert alert-warning">
  <strong>Warning! </strong><?php echo  ' Invalid E-mail Address or Password' ; ?>
</div>
<?php } ?>




<?php if($url == 'invalid'){  ?>
<div class="alert alert-warning">
  <strong>Warning! </strong><?php echo  ' You need to login to access' ; ?>
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

<?php if($url == 'password-changed'){  ?>
<div class="alert alert-success">
  <?php echo  'Password change successful.<br> Please Login' ; ?>
</div>
<?php } ?>


<?php 
}
?>
                            <input class="form-control" type="text" name="email" placeholder="E-mail Address" required>
                            <input class="form-control" type="password" name="password" placeholder="Password" required>
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn">Login</button> <a href="forgot-password.php">Forgotten password?</a>
                            </div>
                        </form>
                        <div class="page-links">
                            <a href="register.php">Register new account</a>
                        </div>
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