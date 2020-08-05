<?php
session_start();
require ('../Connections/conn.php');

mysqli_select_db($conn, $database_conn);
$query_lyt = "SELECT * FROM layout";
$lyt = mysqli_query($conn, $query_lyt) or die(mysqli_error($conn));
$row_lyt = mysqli_fetch_assoc($lyt);
$totalRows_lyt = mysqli_num_rows($lyt);

$url = "management-team";
mysqli_select_db($conn, $database_conn);
$query_url = "SELECT * FROM content WHERE pg_alias = '$url' ";
$pageurl = mysqli_query($conn, $query_url) or die(mysqli_error($conn));
$row_pageurl = mysqli_fetch_assoc($pageurl);
$totalRows_pageurl = mysqli_num_rows($pageurl);
$pagecaturl = $row_pageurl['pg_cat'];
$incpageurl = $row_pageurl['pg_url'];

mysqli_select_db($conn, $database_conn);
$query_rtdurl = "SELECT * FROM content WHERE pg_cat = '$pagecaturl' AND rate_ord > '0' ORDER BY rate_ord ASC";
$rtdurl = mysqli_query($conn, $query_rtdurl) or die(mysqli_error($conn));
$row_rtdurl = mysqli_fetch_assoc($rtdurl);
$totalRows_rtdurl = mysqli_num_rows($rtdurl);

mysqli_select_db($conn, $database_conn);
$query_mgt = "SELECT * FROM management WHERE category = 'Management Team' AND rate_ord > '0' ORDER BY rate_ord ASC ";
$mgt = mysqli_query($conn, $query_mgt) or die(mysqli_error($conn));
$row_mgt = mysqli_fetch_assoc($mgt);
$totalRows_mgt = mysqli_num_rows($mgt);

mysqli_select_db($conn, $database_conn);
$slug = mysqli_real_escape_string($conn, $_GET['slug']);
$query_tm = "SELECT * FROM management WHERE slug = '$slug'";
$tm = mysqli_query($conn, $query_tm) or die(mysqli_error($conn));
$row_tm = mysqli_fetch_assoc($tm);
$totalRows_tm = mysqli_num_rows($tm);
$mgtcat = $row_tm['category'];

mysqli_select_db($conn, $database_conn);
$query_cattype = "SELECT * FROM management WHERE category = '$mgtcat' AND slug != '$slug' AND rate_ord > '0' ";
$cattype = mysqli_query($conn, $query_cattype) or die(mysqli_error($conn));
$row_cattype = mysqli_fetch_assoc($cattype);
$totalRows_cattype = mysqli_num_rows($cattype);
//$mgtcat = $row_tm['category'];

?>
<!DOCTYPE html>
<html lang="en">
<?php //include ('inc/inc_head.php');?>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <!-- For IE -->

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- For Resposive Device -->

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- For Window Tab Color -->

        <!-- Chrome, Firefox OS and Opera -->

        <meta name="theme-color" content="#061948">

        <!-- Windows Phone -->

        <meta name="msapplication-navbutton-color" content="#061948">

        <!-- iOS Safari -->

        <meta name="apple-mobile-web-app-status-bar-style" content="#061948">

        <title>FCMB Trustees</title>

        <!-- Favicon -->

        <link rel="icon" type="image/ico" sizes="56x56" href="../images/favicon.ico">

        <!-- Main style sheet -->

        <link rel="stylesheet" type="text/css" href="../css/style.css">

        <!-- responsive style sheet -->

        <link rel="stylesheet" type="text/css" href="../css/responsive.css">

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
                <?php //include ('inc/inc_topheader.php');?>
                                <div class="top-header">

                    <div class="container">

                        <div class="row">

                            <div class="col-md-6 col-sm-8 col-12">

                                <ul class="left-widget">

                                    <li><i class="fa fa-envelope"></i> <a href="mailto:fcmbtrustees@fcmb.com"><?php echo $row_lyt['top-l'];?></a></li>

                                    <li><i class="fa fa-phone"></i> <?php echo $row_lyt['top-r'];?></li>

                                </ul>

                            </div>

                            <div class="col-md-6 col-sm-4 col-12">

                                <ul class="right-widget">

                                    <li><a href="./portal" target="_blank" class="theme-button-two"><?php echo $row_lyt['head-l'];?></a></li>

                                    <li><a href="./portal" target="_blank" class="theme-button-three"><?php echo $row_lyt['head-r'];?></a></li>                         

                                </ul>

                            </div>

                        </div> <!-- /.row -->

                    </div> <!-- /.container -->

                </div> <!-- /.top-header -->

                <?php //include ('inc/inc_nav.php');?>
                                <div class="theme-menu-wrapper">                    <div class="container">                        <div class="bg-wrapper clearfix" style="height:150px;">                            <div class="logo float-left"><a href="../"><img src="../images/logo.svg" alt="FCMB Trustees Logo" style="height:200px; padding-bottom:10px;" ></a></div>                            <!-- ============== Menu Warpper ================ -->                            <div class="menu-wrapper float-left">                                <nav id="mega-menu-holder" class="clearfix">                                   <ul class="clearfix">                                        <li class="act.ive"><a href="../">Home</a>                                        </li>                                        <li><a href="#">About Us</a>                                            <ul class="dropdown">                                                <li><a href="../company-profile">Company Profile</a></li>                                                <li><a href="../what-we-do">What We Do </a></li>                                                <li><a href="../management-team">Management Team </a></li>                                                <li><a href="../board-of-directors">Board of Directors </a></li>                                           </ul>                                        </li>                                        <li><a href="#">Our Services</a>                                            <ul class="dropdown">                                                <li><a href="../corporate-trust-services">Corporate Trust Services </a>                                                    <ul>                                                        <li><a href="../debenture-security-trustees">Debenture/ Security Trustees </a></li>                                                        <li><a href="../bonds-debt-issuance">Bonds/ Debt Issuance </a></li>                                                        <li><a href="../mutual-funds">Mutual Funds </a></li>                         </ul>                                   </li>                                                <li><a href="../private-wealth-services">Private Trust & Wealth Management Services </a>                                                    <ul>                                                        <li><a href="../wills">Wills and Probate Services</a></li>                                                        <li><a href="../private-living-trust">Private/ Living Trust </a></li>                                                        <li><a href="../education-trust">Education Trust </a></li>                                                        <li><a href="../reserve-trust">Reserve Trust </a></li>                                                        <li><a href="../investment-management-trust">Investment Management Trust </a></li>                                                        <li><a href="../codicil">Codicil </a></li>                                                    </ul>                                                </li>                       <li><a href="../other-services">Other Services </a>                                                    <ul>                                                        <li><a href="../endowment-foundation-management">Endowment/ Foundation Management</a></li>                                                        <li><a href="../escrow-agent">Escrow Agent</a></li>                                                        <li><a href="../cooperative-schemes">Cooperative Schemes </a></li>                                                    </ul>                                                </li>                                           </ul>                                        </li><li><a href="#">FAQs</a>                                            <ul class="dropdown">                                                <li><a href="../trusts-faqs">TRUSTS FAQs </a></li>                                                <li><a href="../wills-faqs">WILLS FAQs</a></li>                                           </ul>                                        </li>                                        <li><a href="../contact">contact us</a></li>                                   </ul>                                </nav> <!-- /#mega-menu-holder -->                            </div> <!-- /.menu-wrapper -->                            <div class="right-widget float-right">                                <ul>                                    <li class="search-option">                                        <div class="dropdown">                                            <button type="button" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-search" aria-hidden="true"></i></button>                                            <form action="process-search.php" class="dropdown-menu" method="POST">                                                <input type="text" name="search" Placeholder="Enter Your Search" required>                                                <button><i class="fa fa-search"></i></button>                                            </form>                                        </div>                                    </li>                                </ul>                            </div> <!-- /.right-widget -->                        </div> <!-- /.bg-wrapper -->                    </div> <!-- /.container -->                </div> <!-- /.theme-menu-wrapper -->

            </header>

            

            <div class="theme-inner-banner section-spacing">

                <div class="overlay">

                    <div class="container">

                        <h2><?php echo $row_pageurl['pg_name'];?></h2>

                    </div> <!-- /.container -->

                </div> <!-- /.overlay -->

            </div> <!-- /.theme-inner-banner -->





            <!--

            =====================================================

                Our Team

            =====================================================

            -->

            <div class="our-team section-spacing">

                <div class="container">

                    <div class="wrapper">

                        <div class="row">


                        <?php do { ?>

                            <div class="col-lg-3 col-sm-6 col-12">

                                <div class="team-member">
				
				<?php if ($row_mgt['image'] != NULL){ ?>
                                    <div class="image-box">

                                        <img src="../images/team/<?php echo $row_mgt['image'];?>" alt="">

                                    </div> <!-- /.image-box -->
				<?php } ?>
                                    <div class="text">

                                        <h6><a href="team-details.php?slug=<?php echo $row_mgt['slug'];?>">
                                        <?php echo $row_mgt['name'];?>
                                        </a></h6>
                                        <a href="team-details.php?slug=<?php echo $row_mgt['slug'];?>"><span><?php echo $row_mgt['position'];?></span></a>

                                    </div> <!-- /.text -->

                                </div> <!-- /.team-member -->

                            </div> <!-- /.col- -->

<?php } while ($row_mgt = mysqli_fetch_assoc($mgt));?>


                        </div> <!-- /.row -->

                    </div> <!-- /.wrapper -->

                </div> <!-- /.container -->

            </div> <!-- /.our-team -->
            </br></br>




<div style="margin-bottom:50px;"></div>
            <?php //include ('inc/inc_footer.php');?>
                        <footer class="theme-footer-two">

                <div class="bottom-footer">

                    <div class="container">

                        <div class="row">

                            <div class="col-md-6 col-12">

                                <p>&copy; <?php echo date('Y')?> <?php echo $row_lyt['footer-1'];?></p>

                            </div>

                            <div class="col-md-4 col-12">
                                <ul class="social-icon">

                                    <li><a href="https://www.facebook.com/csltrustees/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>

                                    <li><a href="https://twitter.com/fcmbtrustees" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>

                                    <li><a href="https://www.linkedin.com/company/csltrustees/" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                    
                                    <li><a href="https://instagram.com/fcmbtrusteeslimited" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>

                                </ul>

                            </div>
                            <div class="col-md-2 col-12">
                                
                <!--<p> Chat With Us</p>-->
                            </div>

                        </div>

                    </div>

                </div>

            </footer> 
            

            

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
        <script src="../vendor/jquery.2.2.3.min.js"></script>
        <!-- Popper js -->
        <script src="../vendor/popper.js/popper.min.js"></script>
        <!-- Bootstrap JS -->
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <!-- Camera Slider -->
        <script src='../vendor/Camera-master/scripts/jquery.mobile.customized.min.js'></script>
        <script src='../vendor/Camera-master/scripts/jquery.easing.1.3.js'></script> 
        <script src='../vendor/Camera-master/scripts/camera.min.js'></script>
        <!-- menu  -->
        <script src="../vendor/menu/src/js/jquery.slimmenu.js"></script>
        <!-- WOW js -->
        <script src="../vendor/WOW-master/dist/wow.min.js"></script>
        <!-- owl.carousel -->
        <script src="../vendor/owl-carousel/owl.carousel.min.js"></script>
        <!-- js count to -->
        <script src="../vendor/jquery.appear.js"></script>
        <script src="../vendor/jquery.countTo.js"></script>
        <!-- Fancybox -->
        <script src="vendor/fancybox/dist/jquery.fancybox.min.js"></script>

        <!-- Theme js -->
        <script src="../js/theme.js"></script>
        </div> <!-- /.main-page-wrapper -->
    </body>
</html>