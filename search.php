<?php
session_start();
require('inc_query.php');


?>
<!DOCTYPE html>
<html lang="en">
<?php include ('inc/inc_head.php');?>

	<body>
		<div class="main-page-wrapper">

			<header class="header-two">
				<?php include ('inc/inc_topheader.php');?>

				<?php include ('inc/inc_nav.php');?>

			</header>

<div class="theme-inner-banner section-spacing">
				<div class="overlay">
					<div class="container">
						<h2>Search Results</h2>
					</div> <!-- /.container -->
				</div> <!-- /.overlay -->
			</div> <!-- /.theme-inner-banner -->

			<div class="service-details section-spacing">
				<div class="container">
					<div class="row">
						<div class="col-xl-12 col-lg-12 col-12">
							    <?php if ($totalRows_search == NULL) { ?>
                                    <h3>No results found!</h3>
                                <?php } ?>
                                
							    <?php if ($totalRows_search > '0') { ?>
                                    <?php do {?>
							<div class="service-content">
								<a href="page.php?a=<?php echo $row_search['pg_alias'];?>"><h3 class="main-title"> <?php echo $row_search['pg_name'];?> </h3></a>
								<p><?php $summ2 = $row_search['content']; 
                                                             echo word_striperblog2($summ2) ;?>...</p>

							</div> <!-- /.service-content -->
                            <?php } while ($row_search = mysqli_fetch_assoc($search));?>  
                                    <?php } ?>
						</div> <!-- /.col- -->

						
					</div> <!-- /.row -->
				</div> <!-- /.container -->
			</div> <!-- /.service-details -->




			<?php include ('inc/inc_footer.php');?>
			

	        

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

		<!-- Optional JavaScript _____________________________  -->

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

		<!-- Theme js -->
		<script src="js/theme.js"></script>
		</div> <!-- /.main-page-wrapper -->
	</body>
</html>