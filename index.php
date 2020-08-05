<?php include ('inc_query.php');?>
<!DOCTYPE html>
<html lang="en">
        <?php include ('inc/inc_head.php');?>

    <body>
        <div class="main-page-wrapper">
            <header class="header-two"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <?php include ('inc/inc_topheader.php');?>

                                <div class="theme-menu-wrapper">                    <div class="container">                        <div class="bg-wrapper clearfix" style="height:150px;">                            <div class="logo float-left"><a href="index"><img src="images/logo.svg" alt="FCMB Trustees Logo" style="height:200px; padding-bottom:10px;" ></a></div>                            <!-- ============== Menu Warpper ================ -->                            <div class="menu-wrapper float-left">                                <nav id="mega-menu-holder" class="clearfix">                                   <ul class="clearfix">                                        <li class="act.ive"><a href="index">Home</a>                                        </li>                                        <li><a href="#">About Us</a>                                            <ul class="dropdown">                                                <li><a href="company-profile">Company Profile</a></li>                                                <li><a href="what-we-do">What We Do </a></li>                                                <li><a href="management-team">Management Team </a></li>                                                <li><a href="board-of-directors">Board of Directors </a></li>                                           </ul>                                        </li>                                        <li><a href="#">Our Services</a>                                            <ul class="dropdown">                                                <li><a href="corporate-trust-services">Corporate Trust Services </a>                                                    <ul>                                                        <li><a href="debenture-security-trustees">Debenture/ Security Trustees </a></li>                                                        <li><a href="bonds-debt-issuance">Bonds/ Debt Issuance </a></li>                                                        <li><a href="mutual-funds">Mutual Funds </a></li>                                                    </ul>                                                </li>                                                <li><a href="private-wealth-services">Private Trust & Wealth Management Services </a>                                                    <ul>                                                        <li><a href="wills-probate-services">Wills and Probate Services</a></li>                                                        <li><a href="private-living-trust">Private/ Living Trust </a></li>                                                        <li><a href="education-trust">Education Trust </a></li>                                                        <li><a href="reserve-trust">Reserve Trust </a></li>                                                        <li><a href="investment-management-trust">Investment Management Trust </a></li>                                                        <li><a href="codicil">Codicil </a></li>                                                    </ul>                                                </li>                                                <li><a href="other-services">Other Services </a>                                                    <ul>                                                        <li><a href="endowment-foundation-management">Endowment/ Foundation Management</a></li>                                                        <li><a href="escrow-agent">Escrow Agent</a></li>                                                        <li><a href="cooperative-schemes">Cooperative Schemes </a></li>                                                    </ul>                                                </li>                                           </ul>                                        </li><li><a href="#">FAQs</a>                                            <ul class="dropdown">                                                <li><a href="trusts-faqs">TRUSTS FAQs </a></li>                                                <li><a href="wills-faqs">WILLS FAQs</a></li>                                           </ul>                                        </li>                                        <li><a href="contact">contact us</a></li>                                   </ul>                                </nav> <!-- /#mega-menu-holder -->                            </div> <!-- /.menu-wrapper -->                            <div class="right-widget float-right">                                <ul>                                    <li class="search-option">                                        <div class="dropdown">                                            <button type="button" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-search" aria-hidden="true"></i></button>                                            <form action="process-search.php" class="dropdown-menu" method="POST">                                                <input type="text" name="search" Placeholder="Enter Your Search" required>                                                <button><i class="fa fa-search"></i></button>                                            </form>                                        </div>                                    </li>                                </ul>                            </div> <!-- /.right-widget -->                        </div> <!-- /.bg-wrapper -->                    </div> <!-- /.container -->                </div> <!-- /.theme-menu-wrapper -->

            </header>

            
            <?php include ('inc/inc_slides.php');?>
            
            
            <div class="our-solution section-spacing">
                <div class="container">
                    <div class="wrapper">
                        <div class="row">
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="single-solution-block">
                    <a href="corporate-trust-services"> <img src="images/icon/corporate-trust.png" /> </a>
                                    <h5><a href="corporate-trust-services"><?php echo $row_lyt['home-caption1'];?></a></h5>
                                    <p><?php echo $row_lyt['home-text1'];?> </p>
                                </div> <!-- /.single-solution-block -->
                            </div> <!-- /.col- -->
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="single-solution-block">
                                    <a href="private-wealth-services"> <img src="images/icon/Private.png" /> </a>
                                    <h5><a href="private-wealth-services"><?php echo $row_lyt['home-caption2'];?></a></h5>
                                    <p><?php echo $row_lyt['home-text2'];?></p>
                                </div> <!-- /.single-solution-block -->
                            </div> <!-- /.col- -->
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="single-solution-block"> 
                                    <a href="other-services"> <img src="images/icon/other.png" /> </a>
                                    <h5><a href="other-services"><?php echo $row_lyt['home-caption3'];?></a></h5>
                                    <p><?php echo $row_lyt['home-text3'];?>For further information click <a href="other-services">here</a> </p>
                                </div> <!-- /.single-solution-block -->
                            </div>
                        </div> <!-- /.row -->
                    </div> <!-- /.wrapper -->
                </div> <!-- /.container -->
            </div> <!-- /.our-solution -->

            <div class="dual-banner bg-grey">
                <div class="container">
                    <div class="clearfix row">
                        <div class="col-md-6">
                            <div class="theme-title-one">
                                
                                <h2><?php echo $row_lyt['home-caption4'];?></h2>
                             <p><?php echo $row_lyt['home-text4'];?> </p>
                                    
                            
                        </div>
                        </div>

                        <div class="col-md-2">
                            <img src="images/will-icon.svg" height="200px" alt=""/>
                        </div>
                        <div class="col-md-4"> 
                                <h2><?php echo $row_lyt['home-caption5'];?></h2>
                                <p><?php echo $row_lyt['home-text5'];?>
                                    <br><br> <a href="step-by-step-guide"><button class="theme-button-one">Learn More</button></a>
                                </p>
                            <!-- </div> -->
                        </div>
                    </div>
                </div> <!-- /.container -->
            </div>

            <div class="our-solution sect/ion-spacing" style="padding-top:20px;">
                <div class="container">
                    <div class="theme-title-one">
                        <h2><?php echo $row_lyt['home-caption6'];?></h2>
            <p></p>


            <div class="col-lg-12 col-sm-12 col-12">
                <form action="process-newsletter.php" method="post" class="theme-form-one">
                            <div class="row">
                                <div class="col-sm-9 col-12">
                                    <input type="email" name="newsletter" placeholder="Enter E-mail Address" required>
                                </div>
                                <div class="col-sm-3 col-12">
                                    <button type="submit" class="theme-button-one">Subscribe</button>

                                </div>
                            </div>
                </form>
            </div>



                    </div> <!-- /.theme-title-one -->

                </div> <!-- /.container -->
            </div> <!-- /.our-solution -->


            
<?php include ('inc/inc_footer.php');?>

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


            <!-- Scroll Top Button -->
            <button class="scroll-top tran3s">
                <i class="fa fa-angle-up" aria-hidden="true"></i>
            </button>

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
        <!-- Language Stitcher -->
        <script src="vendor/language-switcher/jquery.polyglot.language.switcher.js"></script>

        <!-- Theme js -->
        <script src="js/theme.js"></script>
        <script type="text/javascript" src="js/jssor.js"></script>
        <script>
            jQuery(document).ready(function ($) {

                var options = {
                    $FillMode: 2,                                       //[Optional] The way to fill image in slide, 0 stretch, 1 contain (keep aspect ratio and put all inside slide), 2 cover (keep aspect ratio and cover whole slide), 4 actual size, 5 contain for large image, actual size for small image, default value is 0
                    $AutoPlay: 1,                                       //[Optional] Auto play or not, to enable slideshow, this option must be set to greater than 0. Default value is 0. 0: no auto play, 1: continuously, 2: stop at last slide, 4: stop on click, 8: stop on user navigation (by arrow/bullet/thumbnail/drag/arrow key navigation)
                    $Idle: 4000,                                        //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                    $PauseOnHover: 1,                                   //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

                    $ArrowKeyNavigation: 1,                             //[Optional] Steps to go for each navigation request by pressing arrow key, default value is 1.
                    $SlideEasing: $Jease$.$OutQuint,                    //[Optional] Specifies easing for right to left animation, default value is $Jease$.$OutQuad
                    $SlideDuration: 800,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                    $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide, default value is 20
                    //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                    //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                    $SlideSpacing: 0,                                   //[Optional] Space between each slide in pixels, default value is 0
                    $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                    $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                    $DragOrientation: 1,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $Cols is greater than 1, or parking position is not 0)

                    $BulletNavigatorOptions: {                          //[Optional] Options to specify and enable navigator or not
                        $Class: $JssorBulletNavigator$,                 //[Required] Class to create navigator instance
                        $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                        $SpacingX: 8,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                        $Orientation: 1                                //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                    },

                    $ArrowNavigatorOptions: {                           //[Optional] Options to specify and enable arrow navigator or not
                        $Class: $JssorArrowNavigator$,                  //[Requried] Class to create arrow navigator instance
                        $ChanceToShow: 2                                 //[Optional] Steps to go for each navigation request, default value is 1
                    }
                };

                var jssor_slider1 = new $JssorSlider$("slider1_container", options);

                //responsive code begin
                //you can remove responsive code if you don't want the slider scales while window resizing
                function ScaleSlider() {
                    var bodyWidth = document.body.clientWidth;
                    if (bodyWidth)
                        jssor_slider1.$ScaleWidth(Math.min(bodyWidth, 1920));
                    else
                        window.setTimeout(ScaleSlider, 30);
                }
                ScaleSlider();

                $(window).bind("load", ScaleSlider);
                $(window).bind("resize", ScaleSlider);
                $(window).bind("orientationchange", ScaleSlider);
                //responsive code end
            });
        </script>
        </div> <!-- /.main-page-wrapper -->
    </body>
</html>