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
                        <h2><?php echo $row_tm['name'] ;?></h2>
                        <p><?php echo $row_tm['position'];?></p>
                    </div> <!-- /.container -->
                </div> <!-- /.overlay -->
            </div> 

            <div class="shop-details">
                <div class="container">
                    <div class="product-details">
                        <div class="row">
                            <div class="col-lg-5 col-12">
                            	<div class="product-tab clearfix">
                                	<img src="images/team/<?php echo $row_tm['image'];?>" alt="<?php echo $row_tm['name'] ;?>" />
                                </div>
                            </div>
                            <div class="col-lg-7 col-12">
                                <div class="product-info">
                                    <p><?php echo $row_tm['descrp'];?></p>
                                </div> <!-- /.product-info -->
                            </div>
                        </div>
                    </div> 
                </div> <!-- /.container -->
            </div> <!-- /.shop-details -->
            
            <div class="branch-address">
                <div class="container">
                    <div class="row">
                        <div class="address-slider">
                            <?php do { ?>
                            <div class="item">
                                <div class="wrapper">
                                    <h6><a href="team-details.php?slug=<?php echo $row_cattype['slug'] ;?>"><?php echo $row_cattype['name'] ;?></a></h6>
                                    <p><?php echo $row_cattype['position'] ;?></p>
                                </div> <!-- /.wrapper -->
                            </div>
                            <?php } while ($row_cattype = mysqli_fetch_assoc($cattype));?>
                        </div> <!-- /.address-slider -->
                    </div>
                </div> <!-- /.container -->
            </div>

<!--<div style="margin-bottom:50px;"></div>-->
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