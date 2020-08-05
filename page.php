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

            <?php //include ('inc/inc_page.php');?>
            <?php include ("inc/".$pageinc) ;?>



<div style="margin-bottom:50px;"></div>
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