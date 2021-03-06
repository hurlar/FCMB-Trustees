<?php require ('Connections/conn.php');
include ('session.php');
if(!isset($userid)){
header('location:index.php');
exit();
}

$query = "SELECT * FROM spouse_tb WHERE `uid` = '$userid' ";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
$totalrow = mysqli_num_rows($result);

$queryedt = "SELECT * FROM spouse_tb WHERE `uid` = '$userid' ";
$resultedt = mysqli_query($conn, $queryedt) or die(mysqli_error($conn));
$rowedt = mysqli_fetch_assoc($resultedt);
//$totalrow = mysqli_num_rows($result);

$queryms = "SELECT `uid`, `status` FROM marital_status WHERE `uid` = '$userid' ";
$resultms = mysqli_query($conn, $queryms) or die(mysqli_error($conn));
$rowms = mysqli_fetch_assoc($resultms);

$querych = "SELECT `uid`, `status` FROM child_tb WHERE `uid` = '$userid' ";
$resultch = mysqli_query($conn, $querych) or die(mysqli_error($conn));
$rowch = mysqli_fetch_assoc($resultch);

$querychd = "SELECT * FROM children_details WHERE `uid` = '$userid' ";
$resultchd = mysqli_query($conn, $querychd) or die(mysqli_error($conn));
$totalrowchd = mysqli_num_rows($resultchd);

$queryedtch = "SELECT * FROM children_details WHERE `uid` = '$userid' ";
$resultedtch = mysqli_query($conn, $queryedtch) or die(mysqli_error($conn));
$rowedtch = mysqli_fetch_assoc($resultedtch);
//$totalrow = mysqli_num_rows($result);


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
    <link rel="stylesheet" href="css/bootstrap-datepicker3.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
    
    <link rel="stylesheet" href="css/separate/vendor/pnotify.min.css">
    
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />   -->

    <style type="text/css">
    .box{
        /**color: #fff;
        padding: 20px;**/
        display: none;
        margin-top: 20px;
    }
    /*.Married{ background: #228B22; }*/

        .boxx{
        color: #fff;
        display: none;
        margin-top: 20px;
    }
    .Yes{ background: #228B22; }

        .boxxx{
        /**color: #fff;**/
        display: none;
        margin-top: 20px;
    }
    .Divorced{ background: #228B22; }

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

<script type="text/javascript">
$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        var inputValue = $(this).attr("value");
        var targetBoxxx = $("." + inputValue);
        $(".boxxx").not(targetBoxxx).hide();
        $(targetBoxxx).show();
    });
});
</script>

	<script>
	$( function() {
		$( "#datepicker" ).datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: '-100y:c+nn'
		});
	} );
	</script>
	
		<script>
	$( function() {
		$( "#datepicker1" ).datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: '-100y:c+nn'
		});
	} );
	</script>
	
			<script>
	$( function() {
		$( "#datepicker2" ).datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: '-100y:c+nn'
		});
	} );
	</script>
	
			<script>
	$( function() {
		$( "#datepicker3" ).datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: '-100y:c+nn'
		});
	} );
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
                    
                    <section class="box-typical sidemenu">
                        <div class="profile-card">
                            <div class="profile-card-name"> Please select your current legal marital status, even if you know it's going to change soon.  </div>

                    </section>     

                    <section class="box-typical sidemenu">
                        <div class="profile-card">
                        <div class="profile-card-name"> Go to Dashboard</div> <br/>

                                <a href="dashboard.php"><button type="button" class="btn btn-inline btn-fcmb" > Go Back </button></a>
                                </div>

                    </section>

                </div><!--.col- -->

                <div class="col-lg-9 col-lg-push-3 col-md-12">
                    
                            <section class="card">
                            <form action="processor/process-marital-children.php" method="post">
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


<?php } ?>
                    
                    <h5 class="with-bo/rder">Marital Status</h5>

                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <p>
                                Please select your current legal marital status, even if you know it's going to change soon. You can always update this in the future. <br>
                                In a relationship but not married? You'll need to select 'Single'. This is your legal marital status.
                            </p>
                        </div>
                    
                <div class="col-md-8 col-sm-12">
                            <div class="radio">
                                <input type="radio" name="mstatus" id="radio-1" value="Single" <?php if($rowms['status'] == 'Single'){ echo ' checked="checked"'; } ?>  required>
                                <label for="radio-1">Single </label>
                                <input type="radio" name="mstatus" id="radio-2" value="Married" <?php if($rowms['status'] == 'Married'){ echo ' checked="checked"'; } ?> required>
                                <label for="radio-2">Married </label>
                                <input type="radio" name="mstatus" id="radio-3" value="Divorced" <?php if($rowms['status'] == 'Divorced'){ echo ' checked="checked"'; } ?> required>
                                <label for="radio-3">Divorced</label>
                                <input type="radio" name="mstatus" id="radio-4" value="Widowed" <?php if($rowms['status'] == 'Widowed'){ echo ' checked="checked"'; } ?> required>
                                <label for="radio-4">Widowed</label> <br>
                                
                            <?php if ($totalrow == NULL) { ?>
                                <button type="button" class="Married box btn btn-inline btn-fcmb" data-toggle="modal" data-target="#exampleModalCenter">
                                                Add Spouse
                                </button>
                            <?php } ?>        
                                        
                            <button type="button" class="Divorced boxxx btn btn-inline btn-fcmb" data-toggle="modal" data-target="#exampleModaldivorce">
                                Add Divorce Certificate
                            </button>
                            
                            
                            </div>
                            <?php if ($totalrow != NULL) { ?>
                                <div id="spouse_table">
                                    <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Spouse Name</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                          </tr>
                                        </thead>
                                        <tbody>    
                                        <?php while($row = mysqli_fetch_array($result)){ ?>
                                            <tr>
                                                <td><?php echo $row["title"].' '.$row["fullname"]; ?></td>
                                                <td><button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#exampleModalCenter<?php echo $row["id"]; ?>">
                                                Edit Spouse Details
                                                </button></td>
                                                <td><a href="processor/process-spousedelete.php?a=<?php echo $row["id"]; ?>"><input type="button" na/me="view" value="Delete" class="btn btn-fcmb btn-xs view_data"  onclick="return confirm('Are you sure you want to delete ?');" /></a></td>
                                            </tr> 
                                        <?php  } ?>
                                        </tbody>
                                    </table>
                                </div> 
                                <br>
                        <button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#exampleModalCenter">
                                                Add Spouse
                                        </button>
                            <?php } ?> 
                            <br>

                           
                </div>

                </div>
                </div>



            </section>




            <section class="card">
                <div class="card-block">
                    
                                                                                  <?php 

if (isset($_GET['c'])) {  
$url = mysqli_real_escape_string($conn, $_GET['c']);

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


<?php } ?>


                    <h5 class="with-bo/rder">Children</h5>

                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <p>
                                Please indicate if you have children. Note that your children are a part of your legacy and should be provided for in your Will. <br>
                                For children under the age of 18years, you will be required to select a Guardian to oversee and make certain legal decisions on their behalf.
                            </p>
                        </div>
                    
                <div class="col-md-8 col-sm-12">

                <!--<form action="processor/process-marital-info.php" method="post">-->
                    <!--<div class="col-md-3 col-sm-6">-->
                            <div class="radio">
                                <input type="radio" name="children" id="radio-5" value="No" <?php if($rowch['status'] == 'No'){ echo ' checked="checked"'; } ?> required>
                                <label for="radio-5">No </label>
                                <input type="radio" name="children" id="radio-6" value="Yes" <?php if($rowch['status'] == 'Yes'){ echo ' checked="checked"'; } ?> required>
                                <label for="radio-6">Yes </label> <br>
                                <?php if ($totalrowchd == NULL) { ?>
                                        <button type="button" class="Yes boxx btn btn-inline btn-fcmb" data-toggle="modal" data-target="#exampleModalChild">
                                                Add Child
                                        </button>
                                <?php } ?>
                            


                            </div>
                        <!--</div>-->

                            <?php if ($totalrowchd != NULL) { ?>
                                <div id="spouse_table">
                                    <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Child's Name</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                          </tr>
                                        </thead>
                                        <tbody>    
                                        <?php while($rowchd = mysqli_fetch_array($resultchd)){ ?>
                                            <tr>
                                                <td><?php echo $rowchd["name"]; ?></td>
                                                <td><button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#exampleModalCenterchild<?php echo $rowchd["id"]; ?>">
                                                Edit Child's Details
                                                </button></td>
                                                <td><a href="processor/process-childdelete.php?a=<?php echo $rowchd["id"]; ?>"><input type="button" na/me="view" value="Delete" class="btn btn-fcmb btn-xs view_data" onclick="return confirm('Are you sure you want to delete ?');" /></a></td>
                                            </tr>
                                        <?php  } ?>
                                        </tbody>
                                    </table>
                                </div>
                        <br>
<button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#exampleModalChild">
                                                Add More Children
                                        </button>
                            <?php } ?>
                            
                </div>

                </div>
                            <input type="hidden" name="mid" value="<?php echo $userid; ?>"  />
                            <input type="submit" value="Save" class="btn btn-inline btn-fcmb" style="float:right;">
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
    <script src="js/bootstrap-datepicker.min.js"></script>
    
    
    <script src="js/lib/notie/notie.js"></script>
<script src="js/lib/notie/notie-init.js"></script>
<script src="js/lib/pnotify/pnotify.js"></script>
<script src="js/lib/pnotify/pnotify-init.js"></script>
<script src="js/lib/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="js/lib/bootstrap-notify/bootstrap-notify-init.js"></script>

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

    <!--MARITAL STATUS MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Spouse Information<br><span style="font-size:13px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:13px;">All fields with asterisk are compulsory</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-addspouse.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Title<span style="color:red;">*</span></label>
                                                <select class="form-control" name="stitle" required>
                                                    <option value=""> -Please Select- </option>
                                                    <option value="Mr" <?php if($_SESSION['stitle'] == 'Mr'){ echo ' selected="selected"'; } ?> > Mr. </option>
                                                    <option value="Ms" <?php if($_SESSION['stitle'] == 'Ms'){ echo ' selected="selected"'; } ?> > Ms. </option>
                                                    <option value="Mrs" <?php if($_SESSION['stitle'] == 'Mrs'){ echo ' selected="selected"'; } ?> > Mrs. </option>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Full Name<span style="color:red;">*</span></label>
                                            <input type="text" name="sfname" class="form-control maxlength-simple" id="exampleInput" required value="<?php echo $_SESSION['sfname'];?>"/>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Email</label>
                                            <input type="email" name="semail" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $_SESSION['semail'];?>" />
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Phone Number<span style="color:red;">*</span></label>
                                                <input type="text" name="sphoneno" class="form-control maxlength-simple" id="exampleInput" required value="<?php echo $_SESSION['sphoneno'];?>">
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <fieldset class="form-group">
                                                                <label class="form-label" for="exampleInputEmail1">Residential Address<span style="color:red;">*</span></label>
                                                                <textarea rows="2" name="saddr" class="form-control maxlength-simple" required><?php echo $_SESSION['saddr'];?></textarea>
                                                            </fieldset>
                                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">City<span style="color:red;">*</span></label>
                                            <input type="text" name="scity" class="form-control maxlength-simple" id="exampleInput" required value="<?php echo $_SESSION['scity'];?>"/>
                                            </fieldset>
                                        </div>

                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">State<span style="color:red;">*</span></label>
                                                <select class="form-control" name="sstate" required>
                                                <option value=""> -Please Select- </option>
                                                <option value="Abia" <?php if($_SESSION['sstate']== 'Abia'){ echo ' selected="selected"'; } ?> > Abia </option>
                                                <option value="Abuja" <?php if($_SESSION['sstate']== 'Abuja'){ echo ' selected="selected"'; } ?>> Abuja </option>
                                                                    <option value="Adamawa" <?php if($_SESSION['sstate']== 'Adamawa'){ echo ' selected="selected"'; } ?>> Adamawa </option>
                                                                    <option value="Akwa Ibom" <?php if($_SESSION['sstate']== 'Akwa Ibom'){ echo ' selected="selected"'; } ?>> Akwa Ibom </option>
                                                                    <option value="Anambra" <?php if($_SESSION['sstate']== 'Anambra'){ echo ' selected="selected"'; } ?> > Anambra </option>
                                                                    <option value="Bauchi" <?php if($_SESSION['sstate']== 'Bauchi'){ echo ' selected="selected"'; } ?>> Bauchi </option>
                                                                    <option value="Bayelsa" <?php if($_SESSION['sstate']== 'Bayelsa'){ echo ' selected="selected"'; } ?> > Bayelsa </option>
                                                                    <option value="Benue" <?php if($_SESSION['sstate']== 'Benue'){ echo ' selected="selected"'; } ?>> Benue </option>
                                                                    <option value="Borno" <?php if($_SESSION['sstate']== 'Borno'){ echo ' selected="selected"'; } ?> > Borno </option>
                                                                    <option value="Cross River" <?php if($_SESSION['sstate']== 'Cross River'){ echo ' selected="selected"'; } ?> > Cross River </option>
                                                                    <option value="Delta" <?php if($_SESSION['sstate']== 'Delta'){ echo ' selected="selected"'; } ?> > Delta </option>
                                                                    <option value="Ebonyi" <?php if($_SESSION['sstate']== 'Ebonyi'){ echo ' selected="selected"'; } ?> > Ebonyi </option>
                                                                    <option value="Enugu" <?php if($_SESSION['sstate']== 'Enugu'){ echo ' selected="selected"'; } ?> > Enugu </option>
                                                                    <option value="Edo" <?php if($_SESSION['sstate']== 'Edo'){ echo ' selected="selected"'; } ?> > Edo </option>
                                                                    <option value="Ekiti" <?php if($_SESSION['sstate']== 'Ekiti'){ echo ' selected="selected"'; } ?> > Ekiti </option>
                                                                    <option value="Gombe" <?php if($_SESSION['sstate']== 'Gombe'){ echo ' selected="selected"'; } ?>> Gombe </option>
                                                                    <option value="Imo" <?php if($_SESSION['sstate']== 'Imo'){ echo ' selected="selected"'; } ?>> Imo </option>
                                                                    <option value="Jigawa" <?php if($_SESSION['sstate']== 'Jigawa'){ echo ' selected="selected"'; } ?> > Jigawa </option>
                                                                    <option value="Kaduna" <?php if($_SESSION['sstate']== 'Kaduna'){ echo ' selected="selected"'; } ?>> Kaduna </option>
                                                                    <option value="Kano" <?php if($_SESSION['sstate']== 'Kano'){ echo ' selected="selected"'; } ?>> Kano </option>
                                                                    <option value="Katsina" <?php if($_SESSION['sstate']== 'Katsina'){ echo ' selected="selected"'; } ?> > Katsina </option>
                                                                    <option value="Kebbi" <?php if($_SESSION['sstate']== 'Kebbi'){ echo ' selected="selected"'; } ?> > Kebbi </option>
                                                                    <option value="Kogi" <?php if($_SESSION['sstate']== 'Kogi'){ echo ' selected="selected"'; } ?> > Kogi </option>
                                                                    <option value="Kwara" <?php if($_SESSION['sstate']== 'Kwara'){ echo ' selected="selected"'; } ?> > Kwara </option>
                                                                    <option value="Lagos" <?php if($_SESSION['sstate']== 'Lagos'){ echo ' selected="selected"'; } ?> > Lagos </option>
                                                                    <option value="Nasarawa" <?php if($rowedt['Nasarawa'] == 'Abia'){ echo ' selected="selected"'; } ?>> Nasarawa </option>
                                                                    <option value="Niger" <?php if($_SESSION['sstate']== 'Niger'){ echo ' selected="selected"'; } ?> > Niger </option>
                                                                    <option value="Ogun" <?php if($_SESSION['sstate']== 'Ogun'){ echo ' selected="selected"'; } ?>> Ogun </option>
                                                                    <option value="Ondo" <?php if($_SESSION['sstate']== 'Ondo'){ echo ' selected="selected"'; } ?>> Ondo </option>
                                                                    <option value="Osun" <?php if($_SESSION['sstate']== 'Osun'){ echo ' selected="selected"'; } ?>> Osun </option>
                                                                    <option value="Oyo" <?php if($_SESSION['sstate']== 'Oyo'){ echo ' selected="selected"'; } ?> > Oyo </option>
                                                                    <option value="Plateau" <?php if($_SESSION['sstate']== 'Plateau'){ echo ' selected="selected"'; } ?> > Plateau </option>
                                                                    <option value="Rivers" <?php if($_SESSION['sstate']== 'Rivers'){ echo ' selected="selected"'; } ?>> Rivers </option>
                                                                    <option value="Sokoto" <?php if($_SESSION['sstate']== 'Sokoto'){ echo ' selected="selected"'; } ?>> Sokoto </option>
                                                                    <option value="Taraba" <?php if($_SESSION['sstate']== 'Taraba'){ echo ' selected="selected"'; } ?>> Taraba </option>
                                                                    <option value="Yobe" <?php if($_SESSION['sstate']== 'Yobe'){ echo ' selected="selected"'; } ?>> Yobe </option>
                                                                    <option value="Zamfara" <?php if($_SESSION['sstate']== 'Zamfara'){ echo ' selected="selected"'; } ?>> Zamfara </option>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <fieldset class="form-group">                                        <label>Date of Birth (MM/DD/YYYY)<span style="color:red;">*</span></label>
                                            
                                            <input type="text" name="sdob" class="form-control" autocomplete="off" value="<?php echo $_SESSION['sdob'];?>" id="datepicker2" required >
                                        </fieldset>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Marriage Type<span style="color:red;">*</span></label>
                                                <select class="form-control" name="stype" required>
                                                <option value=""> -Please Select- </option>
                                                                    <option value="Customary"> Customary </option>
                                                                    <option value="Court"> Court </option>
                                                                    <option value="Christian"> Christian </option>
                                                                    <option value="Islamic"> Islamic </option>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Marriage Year<span style="color:red;">*</span></label>
                                            <input type="number" name="syear" class="input-md input-rounded form-control" cla/ss="form-control" required value="<?php echo $_SESSION['syear'];?>" >
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Marriage Certificate No.</label>
                                                <input type="text" name="scert" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $_SESSION['scert'];?>">
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">City of Marriage<span style="color:red;">*</span></label>
                                            <input type="text" name="citym" class="form-control maxlength-simple" id="exampleInput" required value="<?php echo $_SESSION['citym'];?>">
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Country of Marriage<span style="color:red;">*</span></label>
                                                <input type="text" name="countrym" class="form-control maxlength-simple" id="exampleInput" required value="<?php echo $_SESSION['countrym'];?>">
                                            </fieldset>
                                        </div>
                                    </div>

                                    <input type="hidden" name="suid" value="<?php echo $userid; ?>"  />
                                    <input type="hidden" name="status" value="Married"  />
                                    <input type="submit" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
    <!--MARITAL MODAL STATUS ENDS HERE-->


    <!--EDIT MARITAL MODAL STARTS HERE -->
    <!-- Modal -->
<?php do {?>
<div class="modal fade" id="exampleModalCenter<?php echo $rowedt['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Details of <?php echo $rowedt['title'].' '.$rowedt['fullname']; ?><br><span style="font-size:13px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:13px;">All fields with asterisk are compulsory</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form method="post" action="processor/process-editspouse.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Title<span style="color:red;">*</span></label>
                                                <select class="form-control" name="stitle" required>
                                                    <option value="Mr" <?php if($rowedt['title'] == 'Mr'){ echo ' selected="selected"'; } ?> > Mr. </option>
                                                    <option value="Ms" <?php if($rowedt['title'] == 'Ms'){ echo ' selected="selected"'; } ?> > Ms. </option>
                                                    <option value="Mrs" <?php if($rowedt['title'] == 'Mrs'){ echo ' selected="selected"'; } ?> > Mrs. </option>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Full Name<span style="color:red;">*</span></label>
                                            <input type="text" name="sfname" value="<?php echo $rowedt['fullname'];?>" class="form-control maxlength-simple" id="exampleInput" required /> 
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Email</label>
                                            <input type="email" name="semail" value="<?php echo $rowedt['email'];?>" class="form-control maxlength-simple" id="exampleInput" >
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Phone Number<span style="color:red;">*</span></label>
                                                <input type="text" name="sphoneno" value="<?php echo $rowedt['phoneno'];?>" class="form-control maxlength-simple" id="exampleInput" required>
                                                            </fieldset>
                                                        </div>
                                    </div>

                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <fieldset class="form-group">
                                                                <label class="form-label" for="exampleInputEmail1">Residential Address<span style="color:red;">*</span></label>
                                                                <textarea rows="2" name="saddr" class="form-control maxlength-simple" required><?php echo $rowedt['addr'];?></textarea>
                                                            </fieldset>
                                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">City<span style="color:red;">*</span></label>
                                            <input type="text" name="scity" value="<?php echo $rowedt['city'];?>" class="form-control maxlength-simple" id="exampleInput" required />
                                            </fieldset>
                                        </div>

                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">State<span style="color:red;">*</span></label>
                                                <select class="form-control" name="sstate" required>
                                                <option value="Abia" <?php if($rowedt['state'] == 'Abia'){ echo ' selected="selected"'; } ?> > Abia </option>
                                                <option value="Abuja" <?php if($rowedt['state'] == 'Abuja'){ echo ' selected="selected"'; } ?>> Abuja </option>
                                                                    <option value="Adamawa" <?php if($rowedt['state'] == 'Adamawa'){ echo ' selected="selected"'; } ?>> Adamawa </option>
                                                                    <option value="Akwa Ibom" <?php if($rowedt['state'] == 'Akwa Ibom'){ echo ' selected="selected"'; } ?>> Akwa Ibom </option>
                                                                    <option value="Anambra" <?php if($rowedt['state'] == 'Anambra'){ echo ' selected="selected"'; } ?> > Anambra </option>
                                                                    <option value="Bauchi" <?php if($rowedt['state'] == 'Bauchi'){ echo ' selected="selected"'; } ?>> Bauchi </option>
                                                                    <option value="Bayelsa" <?php if($rowedt['state'] == 'Bayelsa'){ echo ' selected="selected"'; } ?> > Bayelsa </option>
                                                                    <option value="Benue" <?php if($rowedt['state'] == 'Benue'){ echo ' selected="selected"'; } ?>> Benue </option>
                                                                    <option value="Borno" <?php if($rowedt['state'] == 'Borno'){ echo ' selected="selected"'; } ?> > Borno </option>
                                                                    <option value="Cross River" <?php if($rowedt['state'] == 'Cross River'){ echo ' selected="selected"'; } ?> > Cross River </option>
                                                                    <option value="Delta" <?php if($rowedt['state'] == 'Delta'){ echo ' selected="selected"'; } ?> > Delta </option>
                                                                    <option value="Ebonyi" <?php if($rowedt['state'] == 'Ebonyi'){ echo ' selected="selected"'; } ?> > Ebonyi </option>
                                                                    <option value="Enugu" <?php if($rowedt['state'] == 'Enugu'){ echo ' selected="selected"'; } ?> > Enugu </option>
                                                                    <option value="Edo" <?php if($rowedt['state'] == 'Edo'){ echo ' selected="selected"'; } ?> > Edo </option>
                                                                    <option value="Ekiti" <?php if($rowedt['state'] == 'Ekiti'){ echo ' selected="selected"'; } ?> > Ekiti </option>
                                                                    <option value="Gombe" <?php if($rowedt['state'] == 'Gombe'){ echo ' selected="selected"'; } ?>> Gombe </option>
                                                                    <option value="Imo" <?php if($rowedt['state'] == 'Imo'){ echo ' selected="selected"'; } ?>> Imo </option>
                                                                    <option value="Jigawa" <?php if($rowedt['state'] == 'Jigawa'){ echo ' selected="selected"'; } ?> > Jigawa </option>
                                                                    <option value="Kaduna" <?php if($rowedt['state'] == 'Kaduna'){ echo ' selected="selected"'; } ?>> Kaduna </option>
                                                                    <option value="Kano" <?php if($rowedt['state'] == 'Kano'){ echo ' selected="selected"'; } ?>> Kano </option>
                                                                    <option value="Katsina" <?php if($rowedt['state'] == 'Katsina'){ echo ' selected="selected"'; } ?> > Katsina </option>
                                                                    <option value="Kebbi" <?php if($rowedt['state'] == 'Kebbi'){ echo ' selected="selected"'; } ?> > Kebbi </option>
                                                                    <option value="Kogi" <?php if($rowedt['state'] == 'Kogi'){ echo ' selected="selected"'; } ?> > Kogi </option>
                                                                    <option value="Kwara" <?php if($rowedt['state'] == 'Kwara'){ echo ' selected="selected"'; } ?> > Kwara </option>
                                                                    <option value="Lagos" <?php if($rowedt['state'] == 'Lagos'){ echo ' selected="selected"'; } ?> > Lagos </option>
                                                                    <option value="Nasarawa" <?php if($rowedt['Nasarawa'] == 'Abia'){ echo ' selected="selected"'; } ?>> Nasarawa </option>
                                                                    <option value="Niger" <?php if($rowedt['state'] == 'Niger'){ echo ' selected="selected"'; } ?> > Niger </option>
                                                                    <option value="Ogun" <?php if($rowedt['state'] == 'Ogun'){ echo ' selected="selected"'; } ?>> Ogun </option>
                                                                    <option value="Ondo" <?php if($rowedt['state'] == 'Ondo'){ echo ' selected="selected"'; } ?>> Ondo </option>
                                                                    <option value="Osun" <?php if($rowedt['state'] == 'Osun'){ echo ' selected="selected"'; } ?>> Osun </option>
                                                                    <option value="Oyo" <?php if($rowedt['state'] == 'Oyo'){ echo ' selected="selected"'; } ?> > Oyo </option>
                                                                    <option value="Plateau" <?php if($rowedt['state'] == 'Plateau'){ echo ' selected="selected"'; } ?> > Plateau </option>
                                                                    <option value="Rivers" <?php if($rowedt['state'] == 'Rivers'){ echo ' selected="selected"'; } ?>> Rivers </option>
                                                                    <option value="Sokoto" <?php if($rowedt['state'] == 'Sokoto'){ echo ' selected="selected"'; } ?>> Sokoto </option>
                                                                    <option value="Taraba" <?php if($rowedt['state'] == 'Taraba'){ echo ' selected="selected"'; } ?>> Taraba </option>
                                                                    <option value="Yobe" <?php if($rowedt['state'] == 'Yobe'){ echo ' selected="selected"'; } ?>> Yobe </option>
                                                                    <option value="Zamfara" <?php if($rowedt['state'] == 'Zamfara'){ echo ' selected="selected"'; } ?>> Zamfara </option>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <fieldset class="form-group">       <label>Date of Birth (MM/DD/YYYY)<span style="color:red;">*</span></label> 
                                            <input type="text" name="sdob" class="form-control" 
                                        value="<?php echo $rowedt['dob'];?>" autocomplete="off" id="datepicker" required >
                                        </fieldset>
                                        </div> 

                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Marriage Type<span style="color:red;">*</span></label>
                                                <select class="form-control" name="stype" required>
                                                                    <option value="Customary" <?php if($rowedt['marriagetype'] == 'Customary'){ echo ' selected="selected"'; } ?> > Customary </option>
                                                                    <option value="Court" <?php if($rowedt['marriagetype'] == 'Court'){ echo ' selected="selected"'; } ?> > Court </option>
                                                                    <option value="Christian" <?php if($rowedt['marriagetype'] == 'Christian'){ echo ' selected="selected"'; } ?> > Christian </option>
                                                                    <option value="Islamic" <?php if($rowedt['marriagetype'] == 'Islamic'){ echo ' selected="selected"'; } ?> > Islamic </option>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Marriage Year<span style="color:red;">*</span></label>
                                            <input type="number" name="syear" class="input-md input-rounded form-control" cla/ss="form-control" value="<?php echo $rowedt['marriageyear'];?>" required >
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Marriage Certificate No.</label>
                                                <input type="text" name="scert" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $rowedt['marriagecert'];?>" requi/red>
                                            </fieldset>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">City of Marriage<span style="color:red;">*</span></label>
                                            <input type="text" name="citym" class="input-md input-rounded form-control" cla/ss="form-control" value="<?php echo $rowedt['citym'];?>" required >
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Country of Marriage<span style="color:red;">*</span></label>
                                                <input type="text" name="countrym" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $rowedt['countrym'];?>" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <input type="hidden" name="suid" value="<?php echo $rowedt['id'];?>"  />
                                    <input type="submit" value="Save" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
<?php } while ($rowedt = mysqli_fetch_assoc($resultedt));?>
    <!--EDIT MARITAL STATUS ENDS HERE-->


    <!--CHILD MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="exampleModalChild" tabindex="-1" role="dialog" aria-labelledby="exampleModalChildTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Child<br><span style="font-size:13px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:13px;">All fields with asterisk are compulsory</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-addchild.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Full Name<span style="color:red;">*</span></label>
                                            <input type="text" name="cfname" class="form-control maxlength-simple" id="exampleInput" required value="<?php echo $_SESSION['cfname']; ?>"/>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Gender<span style="color:red;">*</span></label>
                                                <select class="form-control" name="cgender" required>
                                                <option value=""> -Please Select- </option>
                                                <option value="Male" <?php if($_SESSION['cgender'] == 'Male'){ echo ' selected="selected"'; } ?> > Male </option>
                                                 <option value="Female" <?php if($_SESSION['cgender'] == 'Female'){ echo ' selected="selected"'; } ?> > Female </option>
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-md-6">
                                            <fieldset class="form-group">       <label>Date of Birth (MM/DD/YYYY)<span style="color:red;">*</span></label> 
                                            <input type="text" name="cdob" class="form-control" autocomplete="off" value="<?php echo $_SESSION['cdob']; ?>" id="datepicker3" required >
                                            
                                        </fieldset>
                                        </div>
                                    </div>
                                    <input type="hidden" name="cstatus" value="Yes"  />
                                    <input type="hidden" name="cuid" value="<?php echo $userid; ?>"  />
                                    <input type="submit" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
    <!--CHILD MODAL STATUS ENDS HERE-->




    <!--EDIT CHILDS MODAL STARTS-->
<?php do {?>
<div class="modal fade" id="exampleModalCenterchild<?php echo $rowedtch['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Details of <?php echo $rowedtch['name'];?> <br><span style="font-size:13px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:13px;">All fields with asterisk are compulsory</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form method="post" action="processor/process-editchild.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Full Name<span style="color:red;">*</span></label>
                                            <input type="text" name="chname" value="<?php echo $rowedtch['name'];?>" class="form-control maxlength-simple" id="exampleInput" required  />
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Gender<span style="color:red;">*</span></label>
                                                 <select class="form-control" name="chgender" required>
                                                <option value="Male" <?php if($rowedtch['gender'] == 'Male'){ echo ' selected="selected"'; } ?> > Male </option>
                                            <option value="Female" <?php if($rowedtch['gender'] == 'Female'){ echo ' selected="selected"'; } ?>> Female </option>
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-md-6">
                                            <fieldset class="form-group">                                        <label>Date of Birth (MM/DD/YYYY)<span style="color:red;">*</span></label> 
                                         <input type="text" name="chdob" class="form-control" autocomplete="off" value="<?php echo $rowedtch['dob'] ;?>" id="datepicker1" required>
                                        </fieldset>
                                        </div>
                                    </div>
                                    <input type="hidden" name="uid" value="<?php echo $userid;?>"  />
                                    <input type="hidden" name="childid" value="<?php echo $rowedtch['id'];?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Save" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>-->
    </div>
  </div>
</div>
<?php } while ($rowedtch = mysqli_fetch_assoc($resultedtch));?>
    <!--EDIT CHILDS MODAL ENDS-->


    <!--DIVORCE MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="exampleModaldivorce" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Divorce Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-adddivorce.php" method="POST">
                            <div class="row">
                        <div class="col-md-8 col-sm-12">
                            <p>
                               Have you had any marriage which ended in divorce?  
                            </p>
                        </div>
                    
                <div class="col-md-4 col-sm-12">

                <!--<form action="processor/process-marital-info.php" method="post">-->
                    <!--<div class="col-md-3 col-sm-6">-->
                            <div class="radio">
                                <input type="radio" name="divorce" id="radio-20" value="Yes" required>
                                <label for="radio-20">Yes </label>
                                <input type="radio" name="divorce" id="radio-21" value="No" required>
                                <label for="radio-21">No </label> <br>

                            


                            </div>
                            </div>
                            </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">If yes, what year was the divorce? </label>
                                            <input type="text" name="divorceyear" class="form-control maxlength-simple" id="exampleInput" >
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Please supply a copy of your divorce order and any financial orders if you have these available.</label>
                                            <input type="file" name="divorcecert" >
                                            </fieldset>
                                        </div>
                                    </div>

                                    <input type="hidden" name="suid" value="<?php echo $userid; ?>"  />
                                    <input type="hidden" name="status" value="Divorced"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>-->
    </div>
  </div>
</div>
    <!--DIVORCE MODAL STATUS ENDS HERE-->

    <!--DATE PICKER STARTS-->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="js/app.js"></script>
</body>
</html>