<?php require ('Connections/conn.php');
include ('session.php');
if(!isset($userid)){
header('location:index.php');
exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FCMB Trustees</title>
    <link rel="stylesheet" type="text/css" href="css2/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css2/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="css2/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="css2/iofrm-theme4.css">
    <link href="images/favicon.ico" rel="shortcut icon">
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-50894378-7"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-50894378-7');
</script>

    <style> 
 .tooltip.show p {
   text-align:left;
 }
</style>
</head>
<body>
    <div class="form-body">
        <div class="website-logo">
            <a href="index.php">
                <div class="logo">
                    <img class="logo-size" src="images/logo.svg" alt="">
                </div>
            </a>
        </div>
        <div class="row">
            <div class="img-holder">
                <!--<div class="bg"></div>-->
                <div class="info-holder">



<?php if ($gender == 'Male') { 
                                echo '<img src="img/fcmb-avatar.png" alt=""/><br/> <br/>';
                             } elseif ($gender == 'Female') {
                                echo '<img src="img/fcmb-avatar-temi.png" alt=""/><br/> <br/>';
                             } else{
                                echo '<img src="img/fcmb-avatar.png" alt=""/><br/> <br/>';
                                }?>








                    <!--<img src="img/fcmb-avatar.png" alt=""> <br/> <br/>-->
<h3>Welcome,<br/> <?php echo ucfirst($fname).' '.ucfirst($lname); ?><h3>
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Thank you for signing up to FCMB Trustees Estate Planning Services.</h3>
                        <p class="get-started">This process can be completed in a short period of time. As you safeguard your finances for the future, we encourage you to complete this process and keep your estate up-to-date.</p>
                        <h3>Confidentiality</h3>
                        <p class="get-started">The Disclosing Party has confidence that by sharing this Confidential Information it will enable him/ her to plan his/ her estate properly and efficiently. This is in their best interest to ensure that all such Confidential Information will be safeguarded and carefully protected by the FCMB Trustees Limited.</p>

<p class="get-started">"Confidential Information" means proprietary and confidential information about the Disclosing Party's assets and investments. Such information including, but not limited to, certain or all of the assets, investments, documents or disposition of property, financial status and plans, personnel information, all business, financial, technical, and other information marked or designated by The Disclosing Party as "confidential" or "proprietary", all of which are of vital importance to estate planning. Confidential Information also includes information which, by the nature of the circumstances surrounding the disclosure, ought in good faith to be treated as confidential.</p>

<p class="get-started">FCMB Trustees Limited agrees that it will not disclose the Information to any third party for any reason or purpose whatsoever without the prior written consent of the Disclosing Party.</p>


                        <p>For further enquires contact us at <a href="mailto:fcmbtrustees@fcmb.com">fcmbtrustees@fcmb.com</a></p>
                        <!--<form>-->
                        <p>By clicking on <button type="button" class="btn btn-fcmb" data-toggle="modal" data-target="#exampleModalCenter"> Get Started
                                        </button> you are confirming that you agree to our terms and conditions. </p>
                            </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

<form action="process-flow.php" method="post"> 
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle" style="color:#5C0F8B;">Just before you proceed...</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p style='text-align:left'>Below is a quick checklist of specific information you should have, at hand, so you can successfully generate your document.</p>
<p style='text-align:left'>
- Active email account<br/>
- List of Assets<br/>
- List of Beneficiaries<br/>
- Names of Guardian(s) where needed<br>
- Names of Executors</br>
- Names of Trustees</p>
<p style='text-align:left'>It's okay if you don't have everything right now, you can always start now and complete your document later.<br/>
Click the button below to start creating your legal document.</p>

<input type="submit" value="Proceed" class="btn btn-fcmb" style="background-color:#5C0F8B; float:right; color:#ffffff;">

      </div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-fcmb" style="background-color:#5C0F8B;">proceed</button>
      </div>-->
    </div>
  </div>
</div>
</form>

<script src="js2/jquery.min.js"></script>
<script src="js2/popper.min.js"></script>
<script src="js2/bootstrap.min.js"></script>
<script src="js2/main.js"></script>
<script>
 $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})   
$('[data-toggle="popover"]').popover({
    container: 'body'
});
</script>

</body>
</html>