<?php require ('Connections/conn.php');
include ('session.php');
if(!isset($userid)){
header('location:index.php');
exit();
}

$query = "SELECT * FROM trustdeed_tb WHERE `uid` = '$userid' ";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
$row = mysqli_fetch_assoc($result);
$totalrow = mysqli_num_rows($result);

$queryedt = "SELECT * FROM trustdeed_tb WHERE `uid` = '$userid' ";
$resultedt = mysqli_query($conn, $queryedt) or die(mysqli_error($conn));
$rowedt = mysqli_fetch_assoc($resultedt);
$totalrowedt = mysqli_num_rows($resultedt);


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
        padding: 20px;
        display: none;
        margin-top: 20px;
    }
    .yes{ background: #228B22; }

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

                    <!--<section class="box-typical sidemenu">
                        <div class="profile-card">
                            <div class="profile-card-name">A witness is a person of sound mind who is required by law to sign your Will in your presence. You must have at least two witnesses for your Will to be Valid. A witness cannot be a beneficiary and must be over 18 years old.</div>
                        </div>
                    </section>--><!--.box-typical-->

                </div><!--.col- -->

                <div class="col-lg-9 col-lg-push-3 col-md-12">
<form action="processor/process-trustdeed.php" method="post"> 
                <section class="card">
                <div class="card-block">
                    
                                                                                                                                              <?php 

if (isset($_GET['a'])) {  
$url = mysqli_real_escape_string($conn, $_GET['a']);

?>

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

<?php if($url == 'delete'){  ?>
<div class="alert alert-success alert-fill alert-close alert-dismissible fade show" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<?php echo  ' Delete successful' ; ?>
</div>
<?php } ?>

<?php if($url == 'denied'){  ?>
<div class="alert alert-warning alert-fill alert-close alert-dismissible fade show" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<?php echo  ' Please add a Trust Deed ' ; ?>
</div>
<?php } ?>

<?php if($url == 'Error'){  ?>
<div class="alert alert-warning alert-fill alert-close alert-dismissible fade show" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<?php echo  ' Sorry, we can\'t process you request at the moment. Please try again later.  ' ; ?>
</div>
<?php } ?>

<?php if($url == 'Invalid'){  ?>
<div class="alert alert-warning alert-fill alert-close alert-dismissible fade show" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<?php echo  '  Sorry, we can\'t process you request at the moment. Please try again later. ' ; ?>
</div>
<?php } ?>

<?php if($url == 'invalid'){  ?>
<div class="alert alert-warning alert-fill alert-close alert-dismissible fade show" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<?php echo  '  Invalid file format ' ; ?>
</div>
<?php } ?>

<?php if($url == 'Denied'){  ?>
<div class="alert alert-warning alert-fill alert-close alert-dismissible fade show" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<?php echo  '  Maximum size exceeded. ' ; ?>
</div>
<?php } ?>

<?php if($url == 'passportrequired'){  ?>
<div class="alert alert-warning alert-fill alert-close alert-dismissible fade show" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<?php echo  '  You must upload a passport photograph. ' ; ?>
</div>
<?php } ?>


<?php } ?> 


                    <h5 class="with-bo/rder">Add Trust Deed</h5>

                    <div class="row">
                    
                <div class="col-md-12 col-sm-12">
                    
                    <?php if ($totalrow != NULL) { ?>
                        <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Purpose/ Objective of Trust</th>
                                            <th></th>
                                            <th></th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                        <?php do { ?>
                                            <tr>
                                <td> <?php echo $row["purposeoftrust"];?></td>
                                                <td><button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#edittrustdeed<?php echo $row["id"]; ?>">
                                                Edit
                                                </button></td>
                                                <td><a href="processor/process-trustdeeddelete.php?a=<?php echo $row["id"]; ?>"><button type="button" class="btn btn-inline btn-fcmb" >
                                                Delete
                                                </button></a></td>
                                            </tr>
                                        <?php } while ($row = mysqli_fetch_assoc($result));?>
                                                                                </tbody>
                                    </table>
                            <?php } ?>
                                    <br/>
                        <?php if($totalrow < '1') { ?>
                            <button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#addtrustdeed">
                                Add Trust Deed
                            </button>
                        <?php } ?>    
                        <!--</div>-->
                
                </div>
                </div>
                </div>
                
                        
            </section>
            
            
            <input type="hidden" name="uid" value="<?php echo $userid?>">
                <input type="submit" name="insert" id="spouseinsert" value="Save and Proceed" class="btn btn-inline btn-fcmb" style="float:right;">
                        </form>
                </div><!--.col- -->



            </div><!--.row-->
        </div><!--.container-fluid-->
    </div><!--.page-content-->


    <!--ADD TRUST DEED MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="addtrustdeed" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Trust Deed Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-add-trustdeed.php" method="POST">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInputEmail1">Please state the purpose/ objective of Trust</label>
                                            <textarea rows="2" name="purposeoftrust" class="form-control maxlength-simple" required><?php echo $_SESSION['purposeoftrust'];?></textarea>
                                            </fieldset>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInputEmail1">Proposed Name of Trust</label>
                                            <textarea rows="2" name="nameoftrust" class="form-control maxlength-simple" required><?php echo $_SESSION['nameoftrust'];?></textarea>
                                            </fieldset>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInputEmail1">Please state initial contribution to be provided</label>
                                            <textarea rows="2" name="initialcontribution" class="form-control maxlength-simple" required><?php echo $_SESSION['initialcontribution'];?></textarea>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <input type="hidden" name="trustdeeduid" value="<?php echo $userid; ?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
    <!--ADD TRUST DEED MODAL ENDS HERE-->
    
<?php do { ?>
    <!--EDIT TRUST DEED MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="edittrustdeed<?php echo $rowedt['id']?>" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Trust Deed details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-edittrustdeed.php" method="POST">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInputEmail1">Please state the purpose/ objective of Trust</label>
                                            <textarea rows="2" name="edtpurposeoftrust" class="form-control maxlength-simple" required><?php echo $rowedt['purposeoftrust']?></textarea>
                                            </fieldset>
                                        </div>
                                    </div>
                                    
                                                                        <div class="row">
                                        <div class="col-sm-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInputEmail1">Proposed Name of Trust</label>
                                            <textarea rows="2" name="edtnameoftrust" class="form-control maxlength-simple" required><?php echo $rowedt['nameoftrust']?></textarea>
                                            </fieldset>
                                        </div>
                                    </div>
                                    
                                                                        <div class="row">
                                        <div class="col-sm-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInputEmail1">Please state initial contribution to be provide</label>
                                            <textarea rows="2" name="edtinitialcontribution" class="form-control maxlength-simple" required><?php echo $rowedt['initialcontribution']?></textarea>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <input type="hidden" name="edttrustdeedid" value="<?php echo $rowedt['id']?>"  />
                                    <input type="submit" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
<?php } while ($rowedt = mysqli_fetch_assoc($resultedt));?>
<!--EDIT TRUST DEED MODAL ENDS HERE-->


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
<script src="js/app.js"></script>
</body>
</html>