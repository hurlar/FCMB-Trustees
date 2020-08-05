<?php require ('Connections/conn.php');
include ('session.php');
if(!isset($userid)){
header('location:index.php');
exit();
}

mysqli_select_db($conn, $database_conn);
$selectinvestment = "SELECT * FROM `investment_request_savings` WHERE `uid` = '$userid' ";
$resultselectinvestment = mysqli_query($conn, $selectinvestment) or die (mysqli_error($conn));
$rowinvestment = mysqli_fetch_assoc($resultselectinvestment);
$totalselectinvestment = mysqli_num_rows($resultselectinvestment);
//echo $f1 = $rowinvestment['investment_sum']; exit();

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


    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />   -->

    <style type="text/css">
    .box{
        color: #fff;
        /**padding: 20px;**/
        display: none;
        margin-top: 20px;
    }
    .married{ background: #228B22; }

        .boxx{
        color: #fff;
        display: none;
        margin-top: 20px;
    }
    .Yes{ background: #228B22; }

</style>

<script type="text/javascript">
$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        var inputValue = $(this).attr("value");
        var targetBox = $("." + inputValue);
        $(".box").not(targetBox).hide();
        $(targetBox).show();
    });
});
</script>

<script type="text/javascript">
$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        var inputValue = $(this).attr("value");
        var targetBoxx = $("." + inputValue);
        $(".boxx").not(targetBoxx).hide();
        $(targetBoxx).show();
    });
});
</script>

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
                    
                    <section class="box-typical sidemenu" >
                        <div class="profile-card">
                            <div class="profile-card-name"> Request for Investment Savings in the Investment Management Trust </div>

                    </section><!--.box-typical-->

                </div><!--.col- -->

                <div class="col-lg-9 col-lg-push-3 col-md-12">
                    <form action="processor/process-investment-request-saving.php" method="post">
                    <section class="card">
                           
                <div class="card-block">
                    
                                        
                                                              <?php 

if (isset($_GET['a'])) {  
$url = mysqli_real_escape_string($conn, $_GET['a']);

?>

<?php if($url == 'asset-denied'){  ?>
<div class="alert alert-warning alert-fill alert-close alert-dismissible fade show" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <?php echo  ' Please add bank account. ' ; ?>
</div>
<?php } ?>

<?php if($url == 'pension-denied'){  ?>
<div class="alert alert-warning alert-fill alert-close alert-dismissible fade show" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <?php echo  ' Please add a pension benefit. ' ; ?>
</div>
<?php } ?>

<?php if($url == 'beneficiary-denied'){  ?>
<div class="alert alert-warning alert-fill alert-close alert-dismissible fade show" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <?php echo  ' Please add a beneficiary. ' ; ?>
</div>
<?php } ?>

<?php if($url == 'lettersonly'){  ?>
<div class="alert alert-warning alert-fill alert-close alert-dismissible fade show" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <?php echo  ' Name must consist of letters only. ' ; ?>
</div>
<?php } ?>

<?php if($url == 'numbersonly'){  ?>
<div class="alert alert-warning alert-fill alert-close alert-dismissible fade show" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <?php echo  ' Phone Number must consist of numbers only. ' ; ?>
</div>
<?php } ?>

<?php if($url == 'error'){  ?>
<div class="alert alert-warning alert-fill alert-close alert-dismissible fade show" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <?php echo  ' Sorry, we can\'t process you request at the moment. Please try again later.' ; ?>
</div>
<?php } ?>

<?php if($url == 'successful'){  ?>
<div class="alert alert-success alert-fill alert-close alert-dismissible fade show" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <?php echo  ' Add successful' ; ?>
</div>
<?php } ?>

<?php if($url == 'update'){  ?>
<div class="alert alert-success alert-fill alert-close alert-dismissible fade show" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <?php echo  ' Update successful' ; ?>
</div>
<?php } ?>


<?php } ?>


                    <h5 class="with-bo/rder">Request for Investment Savings in the INVESTMENT MANAGEMENT TRUST</h5>

                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <p>Dear Sir/ Madam,</p>
                        </div>
                    
                        <div class="col-md-12 col-sm-12">
                            <p>Kindly invest on my behalf the sum of <input type="text" name="request_amount" value="<?php echo $rowinvestment['investment_sum']; ?>" required/> (₦ Naira)
in your Investment Management Trust.</p>
                        </div>
                        
                        <div class="col-md-12 col-sm-12">
                            <p>The agreed investment return of <input type="text" name="investment_returns" value="<?php echo $rowinvestment['investment_returns']; ?>" required/> will apply.</p>
                        </div>
                        
                        <div class="row col-md-12 col-sm-12">
                            <div class="col-md-4 col-sm-12">
                                Principal will be provided by way of: 
                            </div>
                            <div class="col-md-8 col-sm-12">
                            <div class="radio">
                                <input type="radio" name="principal" id="radio-1" value="Cheque Deposit" <?php if($rowinvestment['principal_fund'] == 'Cheque Deposit'){ echo ' checked="checked"'; } ?>  required>
                                <label for="radio-1">Cheque Deposit </label>
                                <input type="radio" name="principal" id="radio-2" value="Cash Deposit" <?php if($rowinvestment['principal_fund'] == 'Cash Deposit'){ echo ' checked="checked"'; } ?> required>
                                <label for="radio-2">Cash Deposit </label>
                                <input type="radio" name="principal" id="radio-3" value="Transfer" <?php if($rowinvestment['principal_fund'] == 'Transfer'){ echo ' checked="checked"'; } ?> required>
                                <label for="radio-3">Transfer</label>
                            </div>
                        </div>

                </div>
                
                <div class="row col-md-12 col-sm-12">
                            <div class="col-md-4 col-sm-12">
                                Trust Period on investment: 
                            </div>
                            <div class="col-md-8 col-sm-12">
                            <div class="radio">
                                <input type="radio" name="trustperiod" id="radio-4" value="1 Month" <?php if($rowinvestment['investment_period'] == '1 Month'){ echo ' checked="checked"'; } ?>  required>
                                <label for="radio-4">1 Month </label>
                                
                                
                                <input type="radio" name="trustperiod" id="radio-5" value="2 Months" <?php if($rowinvestment['investment_period'] == '2 Months'){ echo ' checked="checked"'; } ?> required>
                                <label for="radio-5">2 Months</label>
                                
                                
                                <input type="radio" name="trustperiod" id="radio-6" value="3 Months" <?php if($rowinvestment['investment_period'] == '3 Months'){ echo ' checked="checked"'; } ?> required>
                                <label for="radio-6">3 Months</label>
                                
                                
                                <input type="radio" name="trustperiod" id="radio-7" value="6 Months" <?php if($rowinvestment['investment_period'] == '6 Months'){ echo ' checked="checked"'; } ?> required>
                                <label for="radio-7">6 Months</label>
                                
                                
                                <input type="radio" name="trustperiod" id="radio-8" value="12 Months" <?php if($rowinvestment['investment_period'] == '12 Months'){ echo ' checked="checked"'; } ?> required>
                                <label for="radio-8">12 Months</label>
                                
                                
                            </div>
                        </div>

                </div>
                
                <div class="col-md-12 col-sm-12">
                            <p><u>*Optional</u></p>
                        </div>
                
                <div class="row col-md-12 col-sm-12">
                   
                            <div class="col-md-4 col-sm-12">
                                Additional Investment will be made: 
                            </div>
                            <div class="col-md-8 col-sm-12">
                            <div class="radio">
                                <input type="radio" name="additionalinvestment" id="radio-9" value="Monthly" <?php if($rowinvestment['additional_investment'] == 'Monthly'){ echo ' checked="checked"'; } ?> >
                                <label for="radio-9">Monthly </label>
                                
                                
                                <input type="radio" name="additionalinvestment" id="radio-10" value="Quarterly" <?php if($rowinvestment['additional_investment'] == 'Quarterly'){ echo ' checked="checked"'; } ?> >
                                <label for="radio-10">Quarterly</label>
                                
                                
                                <input type="radio" name="additionalinvestment" id="radio-11" value="Bi-annually" <?php if($rowinvestment['additional_investment'] == 'Bi-annually'){ echo ' checked="checked"'; } ?> >
                                <label for="radio-11">Bi-annually</label>

                                
                            </div>
                        </div>

                </div>
                
                
                                <div class="col-md-12 col-sm-12">
                            <p><u>*Please execute this action at prevailing terms
</u><br> Upon completion of the Trust Period, the Trust shall </p>
                        </div>
                
                <div class="row col-md-12 col-sm-12">
                   
                            <div class="col-md-8 col-sm-12">
                                (i) Make payment of <strong>both</strong> Principal and return to Beneficiary(ies) : 
                            </div>
                            <div class="col-md-4 col-sm-12">
                            <div class="radio">
                                <input type="radio" name="returntoBeneficiary" id="radio-13" value="Yes" <?php if($rowinvestment['pay_both_to_beneficiaries'] == 'Yes'){ echo ' checked="checked"'; } ?> >
                                <label for="radio-13">Yes </label>
                                
                                
                                <input type="radio" name="returntoBeneficiary" id="radio-14" value="No" <?php if($rowinvestment['pay_both_to_beneficiaries'] == 'No'){ echo ' checked="checked"'; } ?> >
                                <label for="radio-14">No </label>

                                
                            </div>
                        </div>

                </div>
                
                                <div class="row col-md-12 col-sm-12">
                   
                            <div class="col-md-8 col-sm-12">
                                (ii)Make payment of Investment return <strong>only</strong> to Beneficiary(ies): 
                            </div>
                            <div class="col-md-4 col-sm-12">
                            <div class="radio">
                <input type="radio" name="paymentofInvestmentreturns" id="radio-15" value="Yes" <?php if($rowinvestment['pay_returns_only_to_beneficiaries'] == 'Yes'){ echo ' checked="checked"'; } ?> >
                                <label for="radio-15">Yes </label>
                                
                                
                <input type="radio" name="paymentofInvestmentreturns" id="radio-16" value="No" <?php if($rowinvestment['pay_returns_only_to_beneficiaries'] == 'No'){ echo ' checked="checked"'; } ?> >
                                <label for="radio-16">No </label>

                                
                            </div>
                        </div>

                </div>
                
                <div class="row col-md-12 col-sm-12">
                   
                            <div class="col-md-8 col-sm-12">
                                (iii)Re-invest entire Principal after payment of returns:  
                            </div>
                            <div class="col-md-4 col-sm-12">
                            <div class="radio">
                                <input type="radio" name="paymentofreturns" id="radio-17" value="Yes" <?php if($rowinvestment['reinvest_entire_principal'] == 'Yes'){ echo ' checked="checked"'; } ?> >
                                <label for="radio-17">Yes </label>
                                
                                
                                <input type="radio" name="paymentofreturns" id="radio-18" value="No" <?php if($rowinvestment['reinvest_entire_principal'] == 'No'){ echo ' checked="checked"'; } ?> >
                                <label for="radio-18">No </label>

                                
                            </div>
                        </div>

                </div>
                
               <div class="col-md-12 col-sm-12">
                            <p><u>Declaration</u> </p>
                        </div>
                
                <div class="row col-md-12 col-sm-12">
                   
                            <div class="col-md-1 col-sm-12">
                                <input type="checkbox" name="declaration" required style="height:50px; width:50px;" /> 
                            </div>
                            <div class="col-md-11 col-sm-12">
                            I/ We understand that liquidation made before the expiration of the Trust Period is subject to a penalty charge
on returns accrued as at the date of liquidation.

                        </div>

                </div>
                
                
                
                
                </div>
                </div>
                        
            </section>

               
                <input type="hidden" name="investmentsavingsid" value="<?php echo $userid?>">
                <input type="submit" name="insert" id="spouseinsert" value="Save and Proceed" class="btn btn-inline btn-fcmb" style="float:right;">
                        </form> 



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

        $(function() {
            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
            cb(moment().subtract(29, 'days'), moment());

            $('#daterange').daterangepicker({
                "timePicker": true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                "linkedCalendars": false,
                "autoUpdateInput": false,
                "alwaysShowCalendars": true,
                "showWeekNumbers": true,
                "showDropdowns": true,
                "showISOWeekNumbers": true
            });

            $('#daterange2').daterangepicker();

            $('#daterange3').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true
            });

            $('#daterange').on('show.daterangepicker', function(ev, picker) {
                /*$('.daterangepicker select').selectpicker({
                    size: 10
                });*/
            });

            /* ==========================================================================
             Datepicker
             ========================================================================== */

            $('.flatpickr').flatpickr();
            $("#flatpickr-disable-range").flatpickr({
                disable: [
                    {
                        from: "2016-08-16",
                        to: "2016-08-19"
                    },
                    "2016-08-24",
                    new Date().fp_incr(30) // 30 days from now
                ]
            });
        });
    </script>

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

<script src="js/app.js"></script>
</body>
</html>