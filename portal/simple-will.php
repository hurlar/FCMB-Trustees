<?php require ('Connections/conn.php');
include ('session.php');
if(!isset($userid)){
header('location:index.php');
exit();
}

$willtype = 'Simple Will';
$amount = ' ';

mysqli_select_db($conn, $database_conn);

$sql = "SELECT * FROM `willtype` WHERE uid = '$userid' "; 

$query_sql = mysqli_query($conn, $sql) or die(mysqli_error($conn));

$totalacl = mysqli_num_rows($query_sql); 

if ($totalacl == TRUE) {

    $update1 = "UPDATE `willtype` SET `name` = '$willtype', `amount` = '$amount'  WHERE `uid` = '$userid' "; 

    $update_run1 = mysqli_query($conn, $update1) or die(mysqli_error($conn));

    //header("Location: dashboard.php");

    //exit();

}else{

    $insert1 = "INSERT INTO willtype (uid, name, amount) VALUES ('$userid', '$willtype', '$amount')";

    $insert_run1 = mysqli_query($conn, $insert1) or die(mysqli_error($conn));

    //header("Location: dashboard.php");

}

$query_swill = "SELECT `uid` FROM `simplewill_tb` WHERE `uid` = '$userid' ";
$swill = mysqli_query($conn, $query_swill) or die(mysqli_error($conn));
$row_swill = mysqli_fetch_assoc($swill);
$totalswill = mysqli_num_rows($swill);

$query_pay = "SELECT `id` FROM payment_tb WHERE `uid` = '$userid' AND `willtype` = '$willtype' ";
$pay = mysqli_query($conn, $query_pay) or die(mysqli_error($conn));
$row_pay = mysqli_fetch_assoc($pay);
$totalpay = mysqli_num_rows($pay);


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
<style>
    p {
        font-size:15px;
    }
</style>
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

                                <a href="select-will.php"><button type="button" class="btn btn-inline btn-fcmb" > Go Back </button></a>

                    </section><!--.box-typical-->

                </div><!--.col- -->

                <div class="col-lg-9 col-lg-push-3 col-md-12">
                <!--<div class="container-fluid">-->
                <div class="row">
                    

                    <div class="col-lg-12 col-sm-12">
                        <section class="card">
                <div class="card-block">
                    <h5 class="wi/th-border">What Is The Difference Between a Probated Will and a Non-Probated Will? </h5>
    <p>Probate is the judicial process whereby a Will is "registered" in a court of law and accepted as a valid public document that is the true last testament of the deceased.</p>


          <p>  The granting of probate is the first step in the legal process of administering the estate of a deceased person, resolving all claims and distributing the deceased person's property under a Will. A probate court decides the legal validity of a testator's (deceased person's) Will and grants its approval, also known as granting probate, to the executor. The probated Will then becomes a legal instrument that may be enforced by the executor in the law courts, if necessary. A probate also officially appoints the executor (or personal representative), generally named in the Will, as having legal power to dispose of the testator's assets in the manner specified in the testator's Will. </p>
<p>A non-probated Will may lead to the family/ wards been exempted from benefiting from the assets/properties. A violation of rights is likely to take place in a scenario where a Will is not probated. A non-probated Will also gives room to criminal liability, especially in the case of trying to conceal the existence of the Will for the financial gain when it is not filed at the Probate Registry.</p>

<p>If you choose to probate this Simple Will, you will need to pay &#x20A6;15,000.00 (Fifteen Thousand Naira) only, as Probate registry and Processing fees in addition to the one-off payment and custody fees. </p>
<p>Additionally, should you decide to pay for the Simple Will by an online transfer via Paystack, there will be a standard transfer charge of &#x20A6;296.88 for a non-probated Will or &#x20A6;446.88 for a probated Will. 
 </p>
 
 <p>For submission, kindly forward 3 (three) completed copies in triplicate to : 2nd Floor, Primrose Tower, 17A Tinubu Street, Lagos.
 </p>
 
  <!--<a href="https://fcmbtrustees.com/images/downloads/Simple-Will.pdf" target="_blank" download ><button type="button" class="btn btn-inline btn-fcmb" > Download </button></a>-->
  
 
  <?php if ($totalswill == NULL) { ?>
 <a href="choose-simple-will.php" ><button type="button" class="btn btn-inline btn-fcmb" > Write my Will </button></a>
 <?php } ?>
 
   <?php if ($totalswill != NULL AND $totalpay == NULL) { ?>
 <a href="simplewill-payment.php" ><button type="button" class="btn btn-inline btn-fcmb" > Make Payment </button></a>
  <a href="dashboard.php" ><button type="button" class="btn btn-inline btn-fcmb" > Go to my dashboard </button></a>
 <?php } ?>
 
    <?php if ($totalpay != NULL) { ?> 
 <a href="simplewill-preview.php" ><button type="button" class="btn btn-inline btn-fcmb" > View my Will </button></a>
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