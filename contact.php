<?php include ('inc_query.php');?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<!-- For IE -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!-- For Resposive Device -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- For Window Tab Color -->
		<!-- Chrome, Firefox OS and Opera -->
		<meta name="theme-color" content="#5c0f8b">
		<!-- Windows Phone -->
		<meta name="msapplication-navbutton-color" content="#5c0f8b">
		<!-- iOS Safari -->
		<meta name="apple-mobile-web-app-status-bar-style" content="#5c0f8b">
		<title>FCMB Trustees</title>
		<!-- Favicon -->
		<link rel="icon" type="image/ico" sizes="56x56" href="images/favicon.ico">
		<!-- Main style sheet -->
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<!-- responsive style sheet -->
		<link rel="stylesheet" type="text/css" href="css/responsive.css">
		
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
		<div class="main-page-wrapper">
		    <header class="header-two">
				<?php include ('inc/inc_topheader.php');?>

				<?php include ('inc/inc_nav.php');?>

			</header>

			
			<div class="theme-inner-banner section-spacing">
				<div class="overlay">
					<div class="container">
						<h2>Contact Us</h2>
					</div> <!-- /.container -->
				</div> <!-- /.overlay -->
			</div>

			<div class="contact-us-section section-spacing">
				<div class="container">
					<div class="theme-title-one">
						<h2>GET IN TOUCH WITH US</h2>
						<!-- <p>A tale of a fateful trip that started from this tropic port aboard this tiny ship today stillers</p> -->
					</div> <!-- /.theme-title-one -->
					<div class="clearfix main-content no-gutters row">
						<div class="col-lg-5 col-12">
						<div class="img-box">
					<!--<img sr="images/contact-us.png" class="img-responsive"/>-->
						</div>
						</div>
						<div class="col-lg-7 col-12">
							<div class="form-wrapper">
							<?php 
	                            if (isset($_GET['a'])) {  
	                            $a = $_GET['a'] ;
	                            ?>

	                            <?php if($a == 'error-name'){  ?>
	                            <div class="alert alert-warning">
	                              <strong>Warning! </strong><?php echo  ' Name too short or not specified, Please enter Full name' ; ?>
	                            </div>
	                            <?php } ?>
	                            <?php if($a == 'error-email'){  ?>
	                            <div class="alert alert-warning">
	                              <strong>Warning! </strong><?php echo  ' Please enter a valid email address' ; ?>
	                            </div>
	                            <?php } ?>
	                            <?php if($a == 'error-phone'){  ?>
	                            <div class="alert alert-warning">
	                              <strong>Warning! </strong><?php echo  ' Please enter a valid Mobile Number' ; ?>
	                            </div>
	                            <?php } ?>
				    <?php if($a == 'error-subject'){  ?>
	                            <div class="alert alert-warning">
	                              <strong>Warning! </strong><?php echo  ' Please enter a subject' ; ?>
	                            </div>
	                            <?php } ?>
	                            <?php if($a == 'error-message'){  ?>
	                            <div class="alert alert-warning">
	                              <strong>Warning! </strong><?php echo  ' Your message is too short please tell us more so we can help!' ; ?>
	                            </div>
	                            <?php } ?>

	                            <?php if($a == 'successful'){  ?>
	                            <div class="alert alert-success">
	                              <?php echo  ' Message sent successfully' ; ?>
	                            </div>
	                            <?php } ?>


                        	<?php } ?>
								<form action="process-contact.php" method="POST" class="theme-form-one fo/rm-validat/ion" autocomplete="off">
									<div class="row">
										<div class="col-sm-6 col-12"><input type="text" placeholder="Name *" name="name" required></div>
										<div class="col-sm-6 col-12"><input type="number" pattern="[0-9]" placeholder="Phone *" name="phone" required></div>
										<div class="col-sm-6 col-12"><input type="text" placeholder="Email *" name="email" required></div>
										<div class="col-sm-6 col-12"><input type="text" placeholder="Subject *" name="subject" required></div>
										<div class="col-12"><textarea placeholder="Message" name="message" required></textarea></div>
									</div> <!-- /.row -->
									<button class="theme-button-one">SEND MESSAGE</button>
								</form>
							</div> <!-- /.form-wrapper -->
						</div> <!-- /.col- -->
					</div> <!-- /.main-content -->
				</div> <!-- /.container -->

				<!--Contact Form Validation Markup -->
				<!-- Contact alert -->
				<div class="alert-wrapper" id="alert-success">
					<div id="success">
						<button class="closeAlert"><i class="fa fa-times" aria-hidden="true"></i></button>
						<div class="wrapper">
			               	<p>Your message was sent successfully.</p>
			             </div>
			        </div>
			    </div> <!-- End of .alert_wrapper -->
			    <div class="alert-wrapper" id="alert-error">
			        <div id="error">
			           	<button class="closeAlert"><i class="fa fa-times" aria-hidden="true"></i></button>
			           	<div class="wrapper">
			               	<p>Sorry!Something Went Wrong.</p>
			            </div>
			        </div>
			    </div> <!-- End of .alert_wrapper -->
			</div> <!-- /.contact-us-section -->

<div style="margin-bottom:50px;"></div>
<?php include ('inc/inc_footer.php');?>
		<!--	<footer class="theme-footer-two">
				<div class="bottom-footer">
					<div class="container">
						<div class="row">
							<div class="col-md-6 col-12">
								<p>&copy; Copyrights 2019. All Rights Reserved.</p>
							</div>
							<div class="col-md-6 col-12">
								<ul class="social-icon">
									<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
									<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
									<li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</footer> -->
	        

	        <!-- Scroll Top Button -->
			<button class="scroll-top tran3s">
				<i class="fa fa-angle-up" aria-hidden="true"></i>
			</button>


<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5d496c41e5ae967ef80eb2df/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->


    	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
    	<!-- jQuery -->
		<script src="vendor/jquery.2.2.3.min.js"></script>
		<!-- Popper js -->
		<script src="vendor/popper.js/popper.min.js"></script>
		<!-- Bootstrap JS -->
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<!-- Camera Slider -->
		<script src='vendor/Camera-master/scripts/jquery.mobile.customized.min.js'></script>
	    <script src='vendor/Camera-master/scripts/jquery.easing.1.3.js'></script> 
	    <script src='vendor/Camera-master/scripts/camera.min.js'></script>
	    <!-- menu  -->
		<script src="vendor/menu/src/js/jquery.slimmenu.js"></script>
		<!-- WOW js -->
		<script src="vendor/WOW-master/dist/wow.min.js"></script>
		<!-- owl.carousel -->
		<script src="vendor/owl-carousel/owl.carousel.min.js"></script>
		<!-- js count to -->
		<script src="vendor/jquery.appear.js"></script>
		<script src="vendor/jquery.countTo.js"></script>
		<!-- Fancybox -->
		<script src="vendor/fancybox/dist/jquery.fancybox.min.js"></script>
		<!-- Validation -->
		<script type="text/javascript" src="vendor/contact-form/validate.js"></script>
		<script type="text/javascript" src="vendor/contact-form/jquery.form.js"></script>
		<!-- Theme js -->
		<script src="js/theme.js"></script>
		</div> <!-- /.main-page-wrapper -->
	</body>
</html>