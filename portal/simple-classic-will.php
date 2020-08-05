<?php require ('Connections/conn.php');
include ('session.php');

//mysqli_select_database($conn, $da);
$query = "SELECT * FROM state_tb";
$st1 = mysqli_query($conn, $query) or die(mysqli_error($conn));
$row_st1 = mysqli_fetch_assoc($st1);

$query = "SELECT * FROM state_tb";
$st2 = mysqli_query($conn, $query) or die(mysqli_error($conn));
$row_st2 = mysqli_fetch_assoc($st2);

$query = "SELECT gender FROM users WHERE id = '$userid' ";
$gen = mysqli_query($conn, $query) or die(mysqli_error($conn));
$row_gen = mysqli_fetch_assoc($gen );

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
    <link rel="stylesheet" href="css/lib/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="css/separate/vendor/flatpickr.min.css">
    <link rel="stylesheet" href="css/separate/vendor/select2.min.css">
    <link rel="stylesheet" href="css/separate/vendor/bootstrap-daterangepicker.min.css">


    <!-- ===============DATE PICKER ====================== --> 
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        
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
                <h3 class="with-border">Simple Classic Will </h3>
                            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Personal Data </h5>
                <form action="#" method="post">

                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Full Name</label>
                                <input type="text" name="fname" value="<?php echo $fname;?>" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Address</label>
                                <textarea rows="1" name="message" class="form-control maxlength-simple"  ></textarea>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Email Address</label>
                                <input type="text" name="fname" value="<?php echo $fname;?>" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Phone Number(s)</label>
                                <input type="text" name="fname" value="<?php echo $fname;?>" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Marital Status</label>
                            </fieldset>
                        </div>
                        <div class="col-lg-9">
                        <div class="radio">
                                <input type="radio" name="mstatus" id="radio-1" value="single"  checked="checked"  required>
                                <label for="radio-1">Single </label>
                                <input type="radio" name="mstatus" id="radio-2" value="married"  required>
                                <label for="radio-2">Married </label>
                                <input type="radio" name="mstatus" id="radio-3" value="divorced"  required>
                                <label for="radio-3">Divorced</label>
                                <input type="radio" name="mstatus" id="radio-4" value="widowed"  required>
                                <label for="radio-4">Widowed</label> <br>
                            </div>
                            </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Gender</label>
                                <select class="form-control" name="salutation" required>
                                    <option value="Mr"> Male </option>
                                    <option value="Ms"> Female </option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Date Of Birth</label>
                                <input type="text" name="fname" value="<?php echo $fname;?>" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">State Of Origin</label>
                                <input type="text" name="fname" value="<?php echo $fname;?>" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Nationlity</label>
                                <input type="text" name="fname" value="<?php echo $fname;?>" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Spouse (If Applicable)</label>
                                 <input type="text" name="fname" value="<?php echo $fname;?>" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Mobile Phone</label>
                                <input type="text" name="fname" value="<?php echo $fname;?>" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Home Phone</label>
                                <input type="text" name="fname" value="<?php echo $fname;?>" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Means Of Identification</label>
                            </fieldset>
                        </div>
                        <div class="col-lg-9">
                        <div class="radio">
                                <input type="radio" name="mstatus" id="radio-1" value="single"  checked="checked"  required>
                                <label for="radio-1">International Passport </label>
                                <input type="radio" name="mstatus" id="radio-2" value="married"  required>
                                <label for="radio-2">Driver's License </label>
                                <input type="radio" name="mstatus" id="radio-3" value="divorced"  required>
                                <label for="radio-3">National ID Card</label>
                                <input type="radio" name="mstatus" id="radio-4" value="widowed"  required>
                                <label for="radio-4">INEC Voter's Card</label> <br>
                            </div>
                            </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">ID Number</label>
                                <input type="text" name="city" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                        <div class="col-lg-3">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Issue Date</label>
                                <input type="text" name="city" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Expiry Date</label>
                                <input type="text" name="city" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Place Of Issue</label>
                                <input type="text" name="city" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">RSA No : PEN</label>
                                <input type="text" name="fname" value="<?php echo $fname;?>" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Pension Fund Administrator</label>
                                <input type="text" name="fname" value="<?php echo $fname;?>" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                    </div>
                    <strong>NEXT OF KIN (For emergency and contact purpose only and need not be beneficiary)</strong>
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Name</label>
                                <input type="text" name="fname" value="<?php echo $fname;?>" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Mother's Maiden Name</label>
                                <input type="text" name="fname" value="<?php echo $fname;?>" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Address</label>
                                <textarea rows="1" name="message" class="form-control maxlength-simple"  ></textarea>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Telephone</label>
                                <input type="text" name="fname" value="<?php echo $fname;?>" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>

                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Email Address</label>
                                <input type="text" name="fname" value="<?php echo $fname;?>" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                    </div>

                    <strong>EMPLOYMENT DETAILS</strong>
                    <div class="row">
                        <div class="col-lg-3">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Employment Status</label>
                            </fieldset>
                        </div>
                        <div class="col-lg-9">
                        <div class="radio">
                                <input type="radio" name="mstatus" id="radio-1" value="single"  checked="checked"  required>
                                <label for="radio-1">International Passport </label>
                                <input type="radio" name="mstatus" id="radio-2" value="married"  required>
                                <label for="radio-2">Driver's License </label>
                                <input type="radio" name="mstatus" id="radio-3" value="divorced"  required>
                                <label for="radio-3">National ID Card</label>
                                <input type="radio" name="mstatus" id="radio-4" value="widowed"  required>
                                <label for="radio-4">INEC Voter's Card</label> <br>
                            </div>
                            </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Employer</label>
                                <input type="text" name="fname" value="<?php echo $fname;?>" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Employer's Address</label>
                                <textarea rows="1" name="message" class="form-control maxlength-simple"  ></textarea>
                            </fieldset>
                        </div>

                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Office Phone</label>
                                <input type="text" name="fname" value="<?php echo $fname;?>" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                    </div>

                    <strong>HUMAN CAPITAL CONTACT</strong><div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Name</label>
                                <input type="text" name="fname" value="<?php echo $fname;?>" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Telephone Number</label>
                                <textarea rows="1" name="message" class="form-control maxlength-simple"  ></textarea>
                            </fieldset>
                        </div>

                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Email Address</label>
                                <input type="text" name="fname" value="<?php echo $fname;?>" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                    </div>

                    <input type="hidden" name="uid" value="<?php echo $userid ;?>" />
                    <input type="submit" value="EDIT" class="btn btn-inline btn-fcmb" style="float:right;">
                </form>
                </div>
            </section>

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
    <script type="text/javascript" src="js/lib/flatpickr/flatpickr.min.js"></script>
    <script src="js/lib/select2/select2.full.min.js"></script>
    <script src="js/lib/bootstrap-select/bootstrap-select.min.js"></script>
    <script src="js/lib/daterangepicker/daterangepicker.js"></script>

<!--DATE PICKER STARTS-->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript">
            $(function() {
                $( "#datepicker" ).datepicker({
                    dateFormat : 'mm-dd-yy',
                    changeMonth : true,
                    changeYear : true,
                    yearRange: '-100y:c+nn',
                    maxDate: '-1d'
                });
            });
           
        </script>
<!--DATE PICKER ENDS-->

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