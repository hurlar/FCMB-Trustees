<?php require ('Connections/conn.php');
include ('session.php');
if(!isset($userid)){
header('location:index.php');
exit();
}
$query_lwill = "SELECT `uid`, `willtype` FROM privatetrust_tb WHERE `uid` = '$userid' AND `willtype` = 'Estate Planning Questionnaire Form' ";
$lwill = mysqli_query($conn, $query_lwill) or die(mysqli_error($conn));
$row_lwill = mysqli_fetch_assoc($lwill);
$totallwill = mysqli_num_rows($lwill);

$query_edu = "SELECT `uid`, `willtype` FROM education_tb WHERE `uid` = '$userid' AND `willtype` = 'Education Trust Form' ";
$edu = mysqli_query($conn, $query_edu) or die(mysqli_error($conn));
$row_edu = mysqli_fetch_assoc($edu);
$totaledu = mysqli_num_rows($edu);

$query_inv = "SELECT `uid`, `willtype` FROM investmenttrust_tb WHERE `uid` = '$userid' AND `willtype` = 'Investment Management Trust Form' ";
$inv = mysqli_query($conn, $query_inv) or die(mysqli_error($conn));
$row_inv = mysqli_fetch_assoc($inv);
$totalinv = mysqli_num_rows($inv);

$query_res = "SELECT `uid`, `willtype` FROM reservetrust_tb WHERE `uid` = '$userid' AND `willtype` = 'Reserve Trust Form' ";
$res = mysqli_query($conn, $query_res) or die(mysqli_error($conn));
$row_res = mysqli_fetch_assoc($res);
$totalres = mysqli_num_rows($res);

?>
<!DOCTYPE html>
<html>
<head lang="en"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
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
                    
                    <p style="color: #000000;"><strong>For E-Trusts FAQs. Click <a href="http://fcmbtrustees.com/page.php?a=trusts-faqs" target="_blank">here</a></strong></p>

                </div><!--.col- -->

                <div class="col-lg-9 col-lg-push-3 col-md-12">
                
                <div class="row">
                    

                    <div class="col-lg-4 col-sm-6">
                        <section class="box-typical">
                        <div class="profile-card">
                            <div class="profil/e-card-photo">
                                <img src="img/icon-trust.png" alt=""/>
                            </div>
                            <div class="profile-card-name">Private/ Living <br/> Trust</div>
                            <p data-toggle="popover" data-trigger="focus" data-placement="right"  data-html="true" data-content='A Private/ Living Trust is an arrangement whereby legal ownership of certain assets are transferred by you (the "Settlor") to us (the Trustee) to be held for the benefit of your selected beneficiaries. For more information, click <a href="https://fcmbtrustees.com/page.php?a=private-living-trust" target="_blank">here</a>'> 

                            <a href="#" style="color:#bb16a3;">What is a Private/ Living Trust?</a>

                            </p>
                            <p>Price is subject to review of individual circumstances </p>
                             <?php if ($totallwill == NULL) { ?>
                                <div><a href="choose-private-trust.php"><button type="button" class="btn btn4 btn-inline btn-fcmb">Get Started</button></a> </div>
                            <?php } ?>
                                <?php if ($totallwill != NULL) { ?>
                                    <!--<div><a href="private-living-trust.php"><button type="button" class="btn btn4 btn-inline btn-fcmb">View my Trust</button></a></div>-->
                                    <div><a href="privatetrust-preview.php"><button type="button" class="btn btn4 btn-inline btn-fcmb">View my Trust</button></a></div>
                                <?php } ?>
                        </div>

                        </section>
                    
                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <section class="box-typical">
                        <div class="profile-card">
                            <div class="prof/ile-card-photo">
                                <img src="img/icon-trust.png" alt=""/>
                            </div>
                            <div class="profile-card-name">Education  <br/>Trust</div>
                            <p data-toggle="popover" data-trigger="focus" data-placement="left"  data-html="true" data-content='An Education Trust Plan is a Savings Trust managed and administered by FCMB Trustees for the benefit of a named beneficiary, for the purpose of enabling you to build up funds towards the financial security for the future education of your children/ wards. For more information, click <a href="https://fcmbtrustees.com/page.php?a=education-trust" target="_blank">here</a>'> 

                            <a href="#" style="color:#bb16a3;" >What is an Education Trust?</a>

                            </p>
                            <p>Engagement Fee <br>
                            &#x20A6; 25,000</p>
                            
                            <!--<div><a href="https://fcmbtrustees.com/images/downloads/Education-Trust-Form.pdf" target="_blank" download><button type="button" class="btn btn5 btn-inline btn-fcmb">Download</button></a> </div>-->
                            
                             <?php if ($totaledu == NULL) { ?>
                                <div><a href="choose-education-form.php"><button type="button" class="btn btn5 btn-inline btn-fcmb">Get Started</button></a> </div>
                            <?php } ?>
                                <?php if ($totaledu != NULL) { ?>
                                            <a href="educationtrustform-preview.php"><button type="button" class="btn btn5 btn-inline btn-fcmb">View my Trust</button></a>
                                        <?php } ?> 
                        </div>
                        <!--.profile-card-->

                        </section>

                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <section class="box-typical">
                            <div class="profile-card">
                                <div class="profil/e-card-photo">
                                    <img src="img/icon-trust.png" alt=""/>
                                </div>
                                <div class="profile-card-name">Investment Management <br/>Trust </div>
                                <p data-toggle="popover" data-trigger="focus" data-placement="left"  data-html="true" data-content='An Investment Management Trust is a co-ordinated approach to manage your assets and execute your plans through a carefully crafted Trust structure. For more information, click <a href="https://fcmbtrustees.com/page.php?a=investment-management-trust" target="_blank">here</a>'> 
    
                                <a href="#" style="color:#bb16a3;" >What is an Investment Management Trust?</a>
    
                                </p>
                                
                                <!--<div><a href="https://fcmbtrustees.com/images/downloads/Investment-Trust.pdf" target="_blank" download><button type="button" class="btn btn6 btn-inline btn-fcmb">Download</button></a> </div>-->
                                
                                <?php if ($totalinv == NULL) { ?>
                                <div><a href="choose-investment-form.php"><button type="button" class="btn btn6 btn-inline btn-fcmb">Get Started</button></a> </div>
                            <?php } ?>
                                <?php if ($totalinv != NULL) { ?>
                                            <a href="investmentmanagementtrustform-preview.php"><button type="button" class="btn btn6 btn-inline btn-fcmb">View my Trust</button></a>
                                        <?php } ?>
                                        
                            </div>

                        </section>
                    
                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <section class="box-typical" style="height:370px;">
                        <div class="profile-card">
                            <div class="profil/e-card-photo">
                                <img src="img/icon-trust.png" alt=""/>
                            </div>
                            <div class="profile-card-name">Reserve <br/>Trust</div>
                            <p data-toggle="popover" data-trigger="focus" data-placement="right"  data-html="true" data-content='Reserve Trusts are Savings Trusts for upwardly mobile people who want to set aside funds in a short-term Trust attached to a specific purpose or intended for specific beneficiaries. The minimum investment tenure is 6 months and it is interest bearing. For more information, click <a href="https://fcmbtrustees.com/page.php?a=reserve-trust" target="_blank">here</a>'> 

                            <a href="#" style="color:#bb16a3;" >What is a Reserve Trust?</a>

                            </p>
                            
                            <!-- <div><a href="https://fcmbtrustees.com/images/downloads/Reserve-Trust.pdf" target="_blank" download><button type="button" class="btn btn7 btn-inline btn-fcmb">Download</button></a> </div>-->
                            
                             <?php if ($totalres == NULL) { ?>
                                <div><a href="choose-reserve-trust.php"><button type="button" class="btn btn7 btn-inline btn-fcmb">Get Started</button></a> </div>
                            <?php } ?>
                                <?php if ($totalres != NULL) { ?>
                                            <a href="reservetrustform-preview.php"><button type="button" class="btn btn7 btn-inline btn-fcmb">View my Trust</button></a>
                                        <?php } ?>
                                        
                        </div>

                        </section>
                    
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