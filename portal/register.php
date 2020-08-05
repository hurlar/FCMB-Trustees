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
    <link rel="stylesheet" type="text/css" href="css/iofrm-style-register.css">
    <link rel="stylesheet" type="text/css" href="css/iofrm-theme19-register.css">
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-50894378-7"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-50894378-7');
</script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
</head>
<body>
    <div class="form-body without-side">
        <div class="website-logo">
            <a href="index.php">
                <div class="logo">
                    <img class="logo-size" src="images/logo.svg" alt="">
                </div>
            </a>
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
                        <h3 class="register">Register new account</h3>
                        <p>Password must be at least 8 characters</p>
                        <form action="processor/process-signup.php" method="POST">
<?php 

if (isset($_GET['a'])) {  
$url = $_GET['a'] ;

?>

<?php if($url == 'email-exists'){  ?>
<div class="alert alert-info">
    <?php echo  ' Email Address Already Exists' ; ?>
</div>
<?php } ?>

<?php if($url == 'Denied'){  ?>
<div class="alert alert-warning">
    <?php echo  ' Passwords Do Not Match' ; ?>
</div>
<?php } ?>

<?php if($url == 'Invalid'){  ?>
<div class="alert alert-danger no-margin">
        <?php echo  ' Sorry we can\'t process your request at the moment. Try later!' ; ?>
</div>
<?php } ?>

<?php if($url == 'Error'){  ?>
<div class="alert alert-danger no-margin">
      <?php echo  ' All fields are required' ; ?>
</div>
<?php } ?>

<?php if($url == 'password-too-short'){  ?>
<div class="alert alert-warning">
    <?php echo  ' Password must be at least 8 characters' ; ?>
</div>
<?php } ?>

<?php if($url == 'lettersonly'){  ?>
<div class="alert alert-warning">
    <?php echo  ' Name must consist of letters only' ; ?>
</div>
<?php } ?>

<?php if($url == 'numbersonly'){  ?>
<div class="alert alert-warning">
    <?php echo  ' Phone Number must consist of numbers only' ; ?>
</div>
<?php } ?>

<?php } ?>
                        <fieldset>
                            <input type="text" class="form-control" name="fname" placeholder="Enter First Name" value="<?php echo htmlspecialchars($_SESSION['fname']); ?>" required /> 
                        </fieldset>
                        
                        <fieldset>
                            <input type="text" class="form-control" name="lname" placeholder="Enter Last Name" value="<?php echo htmlspecialchars($_SESSION['lname']); ?>" required />
                            </fieldset>
                            
                            <input type="email" class="form-control" name="email" placeholder="Enter E-Mail" value="<?php echo $_SESSION['email']; ?>" required/>
                            
                            <input type="text" class="form-control" name="phone" placeholder="Enter Phone Number" value="<?php echo htmlspecialchars($_SESSION['phone']); ?>" required/>
                            <div class="form-group">
                                <select class="form-control" name="gender" required>
                                    <option name="" required>Please Select</option>
                                    <option name="Male" required>Male</option>
                                    <option name="Female" required>Female</option>
                                </select>
                            </div>
                            <input type="password" class="form-control" name="password" placeholder="Password" required/>
                            <input type="password" class="form-control" name="repassword" placeholder="Repeat password" required/>
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn">Register</button>
                            </div>
                        </form>
                        <div class="page-links">
                            <a href="index.php">Login to your account</a>
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