<?php require ('Connections/conn.php');
include ('session.php');
if(!isset($userid)){
header('location:index.php');
exit();
}

$sql = "SELECT * FROM processflow_tb WHERE uid = '$userid' ";
$result = mysqli_query($conn, $sql);
$row_sql = mysqli_fetch_assoc($result);

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
    <link rel="stylesheet" href="css/modal/modal_css/bootstrap.min.css">
    <link rel="stylesheet" href="css/modal/modal_css/components.css">
    
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

                                <a href="select-service.php"><button type="button" class="btn btn-inline btn-fcmb" > Proceed </button></a>
                        </div>
                    </section><!--.box-typical-->

                </div>

                <div class="col-lg-9 col-lg-push-3 col-md-12">
                <!--<div class="container-fluid">
                <h3 style="text-align:center; color:#5C068C;">Your are currently on Stage 1 </h3>-->
                    <div class="row">
                    

                        <div class="col-lg-4 col-sm-6" >
                            <section class="box-typical" style="height:250px; background-color: transparent;">
                                <div class="profile-card">
                                    <div class="prof/ile-card-photo">
                                        <img src="images/icon/icon-registration.png" alt=""/>
                                    </div>
                                    <div class="profile-card-name"> STEP 1<span style="color:red;">*</span>: </div> 
                                    
                                    <p style="color:#000000;"> Registration </p>
                                    
                                    
<!--<p style="color:#000000;">   Completed: <?php //echo $row_sql['progress']; ?>  </p>-->
                                    
                                    

                                </div><!--.profile-card-->
    
                            </section>
    
                        </div>
    
                        <div class="col-lg-4 col-sm-6">
                            <section class="box-typical" style="height:250px; background-color: transparent;">
                                <div class="profile-card">
                                    <div class="prof/ile-card-photo">
                                        <img src="images/icon/icon-completion.png" alt=""/>
                                    </div>
                                    
                                    <div class="profile-card-name">STEP 2<span style="color:red;">*</span>:</div>
                                        <p style="color:#000000;"> Completion and Submission of Questionnaire (Draft Will) </p>
                                        
                                          
                                        <!--<p style="color:#000000;">   Completed: <?php //echo $row_sql['progress2']; ?> </p>-->
                                    
                                    
                                        
                                </div><!--.profile-card-->
        
                                </section>
                            </div>
    
                        <div class="col-lg-4 col-sm-6">
    
                            <section class="box-typical" style="height:250px; background-color: transparent;">
                                <div class="profile-card">
                                    <div class="prof/ile-card-photo">
                                        <img src="images/icon/icon-receipt.png" alt=""/>
                                    </div>
                                    <div class="profile-card-name">
                                        STEP 3:
                                    </div>
                                    <p style="color:#000000;">Receipt and review of draft Will by FCMB Trustees</p>
                                   <!-- <p style="color:#000000;">   Completed: <?php //echo $row_sql['progress3']; ?> </p>-->
    
                                </div>
    
                            </section>
                            
                        </div>
                    </div>

                    <div class="row">
                    
                        <!--<div class="col-lg-4 col-sm-6" >
                            <section class="box-typical" style="height:250px; background-color: transparent;">
                                <div class="profile-card">
                                    <div class="prof/ile-card-photo">
                                        <img src="images/icon/icon-review-of-testator.png" alt=""/>
                                    </div>
                                    <div class="profile-card-name"> STEP 4: </div>
                                    
                                    <p style="color:#000000;"> Review of draft Will by the Testator </p>
                                    <p style="color:#000000;">   Completed: <?php //echo $row_sql['progress4']; ?> </p>
                                </div><!--.profile-card-
    
                            </section>
    
                        </div>-->
    
                        <div class="col-lg-4 col-sm-6">
                            <section class="box-typical" style="height:250px; background-color: transparent;">
                                <div class="profile-card">
                                    <div class="prof/ile-card-photo">
                                        <img src="images/icon/icon-execution.png" alt=""/>
                                    </div>
                                    <div class="profile-card-name">STEP 4:</div>
                                        <p style="color:#000000;"> Execution of Will by Testator and Witnesses </p>
                                        <!--<p style="color:#000000;">   Completed: <?php //echo $row_sql['progress5']; ?> </p>-->
                                </div><!--.profile-card-->
        
                                </section>
                            </div>
    
                        <div class="col-lg-4 col-sm-6">
    
                            <section class="box-typical" style="height:250px; background-color: transparent;">
                                <div class="profile-card">
                                    <div class="prof/ile-card-photo">
                                        <img src="images/icon/icon-registry-and-lodgement.png" alt=""/>
                                    </div>
                                    <div class="profile-card-name">
                                        STEP 5:
                                    </div>
                                    <p style="color:#000000;"> Registry and Lodgment of Will at Probate Registry </p> 
                                    <!--<p style="color:#000000;">   Completed: <?php //echo $row_sql['progress6']; ?> </p>-->
    
                                </div>
    
                            </section>
                            
                        </div>
                        <p style="color: #000000;"><span style="color:red;">*</span> Please note that the two asterisked steps above are the only ones that will be done online. The three other steps will be completed with your relationship manager.</p>  
                    </div>
                              
                
                </div><!--.col- -->


                
            </div><!--.row-->
        </div><!--.container-fluid-->
    </div><!--.page-content-->
    
   <div class="modal fade" id="modal1" data-open-onload="true" data-open-delay="0" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document"> <button type="button" class="btn btn-primary pull-right" style="background-color:#FFD378;" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 style="text-align:center">CAVEAT <br/></h4>
                            Please note that you will be logged out after any 25 - minute period of inactivity. <br/> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/lib/jquery/jquery-3.2.1.min.js"></script>
    <script src="js/lib/popper/popper.min.js"></script>
    <script src="js/lib/tether/tether.min.js"></script>
    <script src="js/lib/bootstrap/bootstrap.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/lib/slick-carousel/slick.min.js"></script>
    <script src="js/modal/modal_js/bootstrap.min.js"></script>
    <script src="js/modal/modal_js/main.js"></script>
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