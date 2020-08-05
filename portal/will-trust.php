<?php require ('Connections/conn.php');
include ('session.php');

//$query = "SELECT `uid` FROM personal_info WHERE `uid` = '$userid' ";
//$pi = mysqli_query($conn, $query) or die(mysqli_error($conn));
//$row_pi = mysqli_fetch_assoc($pi);
//$rowpi = $row_pi['uid']; 

//$query = "SELECT * FROM access_level WHERE `uid` = '$userid' "; 
//$ada = mysqli_query($conn, $query) or die(mysqli_error($conn));
//$row_ada = mysqli_fetch_assoc($ada);
//$rowaccess = $row_ada['access'];

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

                </div><!--.col- -->

                <div class="col-lg-9 col-lg-push-3 col-md-12">
                <!--<div class="container-fluid">-->
                <div class="row">
                    <div class="col-lg-4 col-sm-6">

                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="prof/ile-card-photo">
                                <img src="img/icon-will.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Comprehensive <br> Will</div>

                            <a href="comprehensive-will.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>

                        </div>

                        </section>

                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="profil/e-card-photo">
                                <img src="img/icon-trust.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Simple Classic<br/> Will</div>
                            <a href="#"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>
                        </div>

                        </section>
                    
                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="prof/ile-card-photo">
                                <img src="img/icon-will.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Simple Premium <br/>Will</div>
                                <a href="#"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>
                        </div><!--.profile-card-->

                        </section>

                    </div>
                </div>

                <div class="row">
                    

                    <div class="col-lg-4 col-sm-6">
                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="profil/e-card-photo">
                                <img src="img/icon-trust.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Education Trust<br/> Form</div>
                                <a href="#"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>
                        </div>

                        </section>
                    
                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="prof/ile-card-photo">
                                <img src="img/icon-will.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Estate Planning <br/>Form</div>
                                    <a href="#"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>
                        </div><!--.profile-card-->

                        </section>

                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="profil/e-card-photo">
                                <img src="img/icon-trust.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Investment Management <br/>Trust Form</div>

                                <a href="#"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>
                        </div>

                        </section>
                    
                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="profil/e-card-photo">
                                <img src="img/icon-trust.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Reserve Trust<br/>Form</div>

                                <a href="#"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>
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