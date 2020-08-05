<?php require ('Connections/conn.php');
include ('session.php');
if(!isset($userid)){
header('location:index.php');
exit();
}
$query_pwill = "SELECT `uid` FROM premiumwill_tb WHERE `uid` = '$userid' ";
$pwill = mysqli_query($conn, $query_pwill) or die(mysqli_error($conn));
$row_pwill = mysqli_fetch_assoc($pwill);
$totalpwill = mysqli_num_rows($pwill);

$query_cwill = "SELECT `uid` FROM comprehensivewill_tb WHERE `uid` = '$userid' ";
$cwill = mysqli_query($conn, $query_cwill) or die(mysqli_error($conn));
$row_cwill = mysqli_fetch_assoc($cwill);
$totalcwill = mysqli_num_rows($cwill);


?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>FCMB Trustees</title>

    <link href="img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
    <link href="img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
    <link href="img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
    <link href="img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
    <link href="img/favicon.png" rel="icon" type="image/png">
    <link href="img/favicon.ico" rel="shortcut icon">
    <link href="images/favicon.ico" rel="shortcut icon">
    <!-- popover stylesheet starts-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <!-- popover stylesheet ends -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<link rel="stylesheet" href="css/separate/vendor/slick.min.css">
<link rel="stylesheet" href="css/separate/pages/profile.min.css">
    <link rel="stylesheet" href="css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/separate/pages/widgets.min.css">
    
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

<?php include ('inc/inc_header.php');?>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-lg-pull-6 col-md-6 col-sm-6">
                    <?php include ('inc/inc_avatar.php');?>
                    
                    <section class="box-typical sidemenu">
                        <div class="profile-card">
                            <div class="profile-card-name"> Select Service</div> <br/>

                                <a href="select-service.php"><button type="button" class="btn btn-inline btn-fcmb" > Go Back </button></a>
                        </div>
                    </section><!--.box-typical-->
                    
                    <p style="color: #000000;"><strong>For E-Wills FAQs. Click <a href="http://fcmbtrustees.com/page.php?a=wills-faqs" target="_blank">here</a></strong></p>

                </div>

                <div class="col-lg-9 col-lg-push-3 col-md-12">
                <!--<div class="container-fluid">-->
                    <div class="row">
                    

                        <div class="col-lg-4 col-sm-6" >
                            <section class="box-typical" style="height:480px;">
                                <div class="profile-card">
                                    <div class="prof/ile-card-photo">
                                        <img src="img/icon-will.png" alt=""/>
                                    </div>
                                    <div class="profile-card-name"> Simple Will </div> 
                                    <p data-toggle="popover" data-trigger="focus" data-placement="top"  data-content="A Simple Will consists of the Bank Accounts and Employment Benefits (RSA Pension) only."><a href="#" style="color:#bb16a3;" >What does a Simple Will consist of?</a></p>
                                    
                                    <p style="color:#000000;">&#x20A6;10,750.00 (VAT inclusive) <br/> <br/>
                                    <span style="color:#000000; font-size:15px; line-height:1px;">This Will is a non-probated Will, though you have the option to probate it, for an additional fee. You can find information, on the next page, on the difference between a probated and a non-probated will. </span> <br/>
                                    <a href="simple-will.php"><button type="button" class="btn btn1 btn-inline btn-fcmb">Get Started</button></a>
                                </div><!--.profile-card-->
    
                            </section>
    
                        </div>
    
                        <div class="col-lg-4 col-sm-6">
                            <section class="box-typical" style="height:480px;">
                                <div class="profile-card">
                                    <div class="prof/ile-card-photo">
                                        <img src="img/icon-will.png" alt=""/>
                                    </div>
                                    <div class="profile-card-name">Premium Will</div>
                                        <p data-toggle="popover" data-trigger="focus" data-placement="top"  data-content="A Premium Will consists of the Bank Accounts, RSA Pension, Real Estate, Shares, Life Insurance, other Personal chattels."><a href="#" style="color:#bb16a3;" >What does a Premium Will consist of?</a>
                                        </p>
                                        <p style="color:#000000;">&#x20A6;26,875.00 (Cost of Will & VAT)<br>+<br>&#x20A6;15,000.00 <br>(Probate & Processing Fee)</p>
                                        <p style="color:#000000;">Ideal for Asset Value of &#x20A6;25m and below. </p> 
                                        <?php if ($totalpwill == NULL) { ?>
                                            <a href="choose-premium-will.php"><button type="button" class="btn btn2 btn-inline btn-fcmb">Get Started</button></a>
                                        <?php } ?>
        
                                        <?php if ($totalpwill != NULL) { ?>
                                            <a href="premiumwill-preview.php"><button type="button" class="btn btn2 btn-inline btn-fcmb">View my Will</button></a>
                                        <?php } ?>
                                </div><!--.profile-card-->
        
                                </section>
                            </div>
    
                        <div class="col-lg-4 col-sm-6">
    
                            <section class="box-typical" style="height:480px;">
                                <div class="profile-card">
                                    <div class="prof/ile-card-photo">
                                        <img src="img/icon-will.png" alt=""/>
                                    </div>
                                    <div class="profile-card-name">
                                        Comprehensive Will
                                    </div>
                                    <p data-toggle="popover" data-trigger="focus" data-placement="top"  data-content="A Comprehensive Will consists of the Bank Accounts, RSA Pension, Real Estate, Shares, Life Insurance, other Personal chattels. (for Ultra High Networth Individuals)."><a href="#" style="color:#bb16a3;" >What does a Comprehensive Will consist of?</a></p>
                                    <p style="color:#000000;">Price is subject to review of individual circumstances</p> 
                                    <p style="color:#000000;">(Exclusive of Probate and Processing fee of &#x20A6;15,000.00)</p>
                                    <p style="color:#000000;">Ideal for Asset Value of over &#x20A6;25m. </p>
                                    <?php if ($totalcwill == NULL) { ?>
                                        <a href="choose-comprehensive-will.php"><button type="button" class="btn btn3 btn-inline btn-fcmb">Get Started</button></a>
                                    <?php } ?>
            
                                    <?php if ($totalcwill != NULL) { ?>
                                        <a href="comprehensivewill-preview.php"><button type="button" class="btn btn3 btn-inline btn-fcmb">View my Will</button></a>
                                    <?php } ?>
    
                                </div>
    
                            </section>
                            
                        </div>
                        <div class="col-lg-12">
                            <span style="color:#000000;">
                                <strong> Should your circumstances change or should you wish to change/ update the type of Will that you have, you can create a
                                </strong> 
                                <a href="https://fcmbtrustees.com/page.php?a=codicil" target="_blank">
                                    <button type="button" class="btn btn-inline btn-fcmb" title="is a document that amends an existing Will">
                                        Codicil 
                                    </button>
                                </a> 
                            </span>
                        </div>
                    </div>
                                
                
                </div><!--.col- -->


                
            </div><!--.row-->
        </div><!--.container-fluid-->
    </div><!--.page-content-->

    <script src="js/lib/jquery/jquery-3.2.1.min.js"></script>
    <script src="js/lib/popper/popper.min.js"></script>
    <script src="js/lib/tether/tether.min.js"></script>
    <script src="js/lib/bootstrap/bootstrap.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/lib/slick-carousel/slick.min.js"></script>
    <script>
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover();   
    });
    </script>

    <script>
        $(function () {
            $(".profile-card-slider").slick({
                slidesToShow: 1,
                adaptiveHeight: true,
                prevArrow: '<i class="slick-arrow font-icon-arrow-left"></i>',
                nextArrow: '<i class="slick-arrow font-icon-arrow-right"></i>'
            });

            var postsSlider = $(".posts-slider");

            postsSlider.slick({
                slidesToShow: 4,
                adaptiveHeight: true,
                arrows: false,
                responsive: [
                    {
                        breakpoint: 1700,
                        settings: {
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 1350,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 500,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            });

            $('.posts-slider-prev').click(function(){
                postsSlider.slick('slickPrev');
            });

            $('.posts-slider-next').click(function(){
                postsSlider.slick('slickNext');
            });

            /* ==========================================================================
             Recomendations slider
             ========================================================================== */

            var recomendationsSlider = $(".recomendations-slider");

            recomendationsSlider.slick({
                slidesToShow: 4,
                adaptiveHeight: true,
                arrows: false,
                responsive: [
                    {
                        breakpoint: 1700,
                        settings: {
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 1350,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 500,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            });

            $('.recomendations-slider-prev').click(function() {
                recomendationsSlider.slick('slickPrev');
            });

            $('.recomendations-slider-next').click(function(){
                recomendationsSlider.slick('slickNext');
            });
        });
    </script>
<script src="js/app.js"></script>
</body>
</html>