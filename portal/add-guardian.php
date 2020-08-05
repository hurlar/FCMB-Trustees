<?php require ('Connections/conn.php');
include ('session.php');
if(!isset($userid)){
header('location:index.php');
exit();
}


//Query to get Age of children < 18 and does a loop for multiple children with reference to the userid
$queryage = "SELECT `id`,`uid`,`name`,`age`, `title`,`guardianname` FROM children_details WHERE uid = '$userid' AND age < 18 ";
$childdetails = mysqli_query($conn, $queryage) or die(mysqli_error($conn));
$row_childdetails = mysqli_fetch_assoc($childdetails);
$realage2 = mysqli_num_rows($childdetails);
//echo $row_childdetails['id']; exit();

//Calls the modal that Adds Guardian
$queryrpm = "SELECT `id`,`uid`,`name`,`age`, `title`,`guardianname` FROM children_details WHERE uid = '$userid' AND age < 18 ";
$rpm = mysqli_query($conn, $queryrpm) or die(mysqli_error($conn));
$row_rpm = mysqli_fetch_assoc($rpm);
$totalrpm = mysqli_num_rows($rpm);
//echo $row_rpm['id']; exit();

//Calls the modal that Edit Guardian
$queryedg = "SELECT `id`,`uid`,`name`,`title`,`guardianname`,`rtionship`,`email`,`phone`,`addr`,`city`,`state`,`stipend` FROM children_details WHERE uid = '$userid' AND age < 18 ";
$edg = mysqli_query($conn, $queryedg) or die(mysqli_error($conn));
$row_edg = mysqli_fetch_assoc($edg);
$totaledg = mysqli_num_rows($edg);
//echo $row_rpm['id']; exit();

//$queryedt = "SELECT * FROM guardian_tb WHERE childid = '$f2' ";
//$queryedt = "SELECT `id` FROM children_details WHERE uid = '$userid' AND age < '18' ";
//$edt = mysqli_query($conn, $queryedt) or die(mysqli_error($conn));
//$row_edg = mysqli_fetch_assoc($edt);
//$totaledt = mysqli_num_rows($edt);
//echo $row_edg['id'];


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

                    <section class="box-typical sidemenu">
                        <div class="profile-card">
                            <div class="profile-card-name"> A Guardian is appointed to look after your minor children if there is no other person with parental responsibility alive at the date of your death. </div>

                    </section><!--.box-typical-->

                </div><!--.col- -->

                <div class="col-lg-9 col-lg-push-3 col-md-12">
<?//php while ( $row_guardian = mysqli_fetch_array($realage1)) {?>

                            <section class="card">
                            <form action="processor/process-personal-accesslevel.php" method="post">
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
	<?php echo  ' Please add guardian ' ; ?>
</div>
<?php } ?>


<?php } ?>
                    <h5 class="with-bo/rder">Appoint a Guardian</h5>
                    <div class="row">
                    <div class="col-md-12 col-sm-6">
                    <p><strong>Please do not choose your spouse as a guardian if they already have parental responsibility over the child.</strong><br>
                                Kindly choose your guardians carefully and discuss with them to know if they are willing to take on the role of guardian in the event of your death. You may be required to select a guardian for your adult child with disability..
                    </p>
                    <table id="table-sm" class="table table-bordered table-hover table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Child's Name</th>
                                            <th>Child's Age </th>
                                            <th>Guardian's Name</th>
                                            <th></th>
                                            <?php if ($row_childdetails["guardianname"] != NULL) { ?>
                                            <th></th>
                                            <?php } ?>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                        <?php do { ?>
                                            <tr>
                                                <td> <?php echo $row_childdetails["name"]; ?></td>
                                                <td><?php echo $row_childdetails["age"]; ?> years</td>
                                                <td><?php echo $row_childdetails["title"].' '.$row_childdetails["guardianname"]; ?> </td>
                                                
                                                <td>
                                                <?php if ($row_childdetails["guardianname"] == NULL) { ?>
                                                <button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#guardianmodal<?php echo $row_childdetails["id"]; ?>">
                                                Add Guardian
                                                </button>
                                                <?php } ?>

                                                <?php if ($row_childdetails["guardianname"] != NULL) { ?>
                                                <button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#editguardianmodal<?php echo $row_childdetails["id"]; ?>">
                                                Edit Guardian
                                                </button>
                                                <?php } ?>
                                                </td>
                                                <?php if ($row_childdetails["guardianname"] != NULL) { ?>
                                                <td><a href="processor/process-deleteguardian.php?a=<?php echo $row_childdetails["id"]; ?>" onclick="return confirm('Are you sure you want to delete ?');"><button type="button" class="btn btn-inline btn-fcmb">Delete</button></a></td>
                                                <?php } ?>
                                            </tr>
                                        <?php } while ($row_childdetails = mysqli_fetch_assoc($childdetails)) ;?>
                                        </tbody>
                                    </table>

                    </div>
                    
                </div>
                </div>

                                    <input type="hidden" name="uid" value="<?php echo $userid; ?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Save and Proceed" class="btn btn-inline btn-fcmb" style="float:right;">

</form>

            </section>


<?php //} ?>





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

    <!--GUARDIAN MODAL STARTS HERE -->
    <!-- Modal -->
<?php do { ?> 
<div class="modal fade" id="guardianmodal<?php echo $row_rpm['id'];?>" tabindex="-1" role="dialog" aria-labelledby="guardianmodal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Guardian For <?php echo $row_rpm['name'];?> <br><span style="font-size:13px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:13px;">All fields with asterisk are compulsory</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-addguardian.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Title<span style="color:red;">*</span></label>
                                                <select class="form-control" name="gtitle" required>
                                                    <option value=""> -Please Select- </option>
                                                    <option value="Mr" <?php if($_SESSION['gtitle'] == 'Mr'){ echo ' selected="selected"'; } ?> > Mr. </option>
                                                    
                                                    <option value="Ms" <?php if($_SESSION['gtitle'] == 'Ms'){ echo ' selected="selected"'; } ?> > Ms. </option>
                                                    
                                                    <option value="Mrs" <?php if($_SESSION['gtitle'] == 'Mrs'){ echo ' selected="selected"'; } ?> > Mrs. </option>
                                                    <option value="Others" <?php if($_SESSION['gtitle'] == 'Others'){ echo ' selected="selected"'; } ?> > Others </option>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Full Name<span style="color:red;">*</span></label>
                                            <input type="text" name="gname" class="form-control maxlength-simple" id="exampleInput" required value="<?php echo $_SESSION['gname'] ;?>" >
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Email</label>
                                            <input type="email" name="gemail" class="form-control maxlength-simple" id="exampleInput" requi/red value="<?php echo $_SESSION['gemail'] ;?>" >
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Phone Number<span style="color:red;">*</span></label>
                                                <input type="text" name="gphoneno" class="form-control maxlength-simple" id="exampleInput" required value="<?php echo $_SESSION['gphoneno'] ;?>" >
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Relationship<span style="color:red;">*</span></label>
                                                <select class="form-control" name="grelationship" required>
                                                <option value=""> -Please Select- </option>
                                                <option value="Sibling" <?php if($_SESSION['grelationship'] == 'Sibling'){ echo ' selected="selected"'; } ?> > Sibling </option>
                                                <option value="Parent" <?php if($_SESSION['grelationship'] == 'Parent'){ echo ' selected="selected"'; } ?> > Parent </option>
                                                <option value="Relative" <?php if($_SESSION['grelationship'] == 'Relative'){ echo ' selected="selected"'; } ?> > Relative </option>
                                                <option value="Friend" <?php if($_SESSION['grelationship'] == 'Friend'){ echo ' selected="selected"'; } ?>> Friend </option>
                                                <option value="Colleague" <?php if($_SESSION['grelationship'] == 'Colleague'){ echo ' selected="selected"'; } ?> > Colleague </option>
                                                <option value="Others" <?php if($_SESSION['grelationship'] == 'Others'){ echo ' selected="selected"'; } ?> > Others </option>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-sm-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInputEmail1">Residential Address<span style="color:red;">*</span></label>
<textarea rows="2" name="gaddr" class="form-control maxlength-simple" required><?php echo $_SESSION['gaddr'] ;?> </textarea>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">City<span style="color:red;">*</span></label>
                                            <input type="text" name="gcity" class="form-control maxlength-simple" id="exampleInput" required value="<?php echo $_SESSION['gcity'] ;?>" >
                                            </fieldset>
                                        </div>

                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">State<span style="color:red;">*</span></label>
                                                <select class="form-control" name="gstate" required>
                                                <option value="Abia" <?php if($_SESSION['gstate']== 'Abia'){ echo ' selected="selected"'; } ?> > Abia </option>
                                                <option value="Abuja" <?php if($_SESSION['gstate']== 'Abuja'){ echo ' selected="selected"'; } ?>> Abuja </option>
                                                                    <option value="Adamawa" <?php if($_SESSION['gstate']== 'Adamawa'){ echo ' selected="selected"'; } ?>> Adamawa </option>
                                                                    <option value="Akwa Ibom" <?php if($_SESSION['gstate']== 'Akwa Ibom'){ echo ' selected="selected"'; } ?>> Akwa Ibom </option>
                                                                    <option value="Anambra" <?php if($_SESSION['gstate']== 'Anambra'){ echo ' selected="selected"'; } ?> > Anambra </option>
                                                                    <option value="Bauchi" <?php if($_SESSION['gstate']== 'Bauchi'){ echo ' selected="selected"'; } ?>> Bauchi </option>
                                                                    <option value="Bayelsa" <?php if($_SESSION['gstate']== 'Bayelsa'){ echo ' selected="selected"'; } ?> > Bayelsa </option>
                                                                    <option value="Benue" <?php if($_SESSION['gstate']== 'Benue'){ echo ' selected="selected"'; } ?>> Benue </option>
                                                                    <option value="Borno" <?php if($_SESSION['gstate']== 'Borno'){ echo ' selected="selected"'; } ?> > Borno </option>
                                                                    <option value="Cross River" <?php if($_SESSION['gstate']== 'Cross River'){ echo ' selected="selected"'; } ?> > Cross River </option>
                                                                    <option value="Delta" <?php if($_SESSION['gstate']== 'Delta'){ echo ' selected="selected"'; } ?> > Delta </option>
                                                                    <option value="Ebonyi" <?php if($_SESSION['gstate']== 'Ebonyi'){ echo ' selected="selected"'; } ?> > Ebonyi </option>
                                                                    <option value="Enugu" <?php if($_SESSION['gstate']== 'Enugu'){ echo ' selected="selected"'; } ?> > Enugu </option>
                                                                    <option value="Edo" <?php if($_SESSION['gstate']== 'Edo'){ echo ' selected="selected"'; } ?> > Edo </option>
                                                                    <option value="Ekiti" <?php if($_SESSION['gstate']== 'Ekiti'){ echo ' selected="selected"'; } ?> > Ekiti </option>
                                                                    <option value="Gombe" <?php if($_SESSION['gstate']== 'Gombe'){ echo ' selected="selected"'; } ?>> Gombe </option>
                                                                    <option value="Imo" <?php if($_SESSION['gstate']== 'Imo'){ echo ' selected="selected"'; } ?>> Imo </option>
                                                                    <option value="Jigawa" <?php if($_SESSION['gstate']== 'Jigawa'){ echo ' selected="selected"'; } ?> > Jigawa </option>
                                                                    <option value="Kaduna" <?php if($_SESSION['gstate']== 'Kaduna'){ echo ' selected="selected"'; } ?>> Kaduna </option>
                                                                    <option value="Kano" <?php if($_SESSION['gstate']== 'Kano'){ echo ' selected="selected"'; } ?>> Kano </option>
                                                                    <option value="Katsina" <?php if($_SESSION['gstate']== 'Katsina'){ echo ' selected="selected"'; } ?> > Katsina </option>
                                                                    <option value="Kebbi" <?php if($_SESSION['gstate']== 'Kebbi'){ echo ' selected="selected"'; } ?> > Kebbi </option>
                                                                    <option value="Kogi" <?php if($_SESSION['gstate']== 'Kogi'){ echo ' selected="selected"'; } ?> > Kogi </option>
                                                                    <option value="Kwara" <?php if($_SESSION['gstate']== 'Kwara'){ echo ' selected="selected"'; } ?> > Kwara </option>
                                                                    <option value="Lagos" <?php if($_SESSION['gstate']== 'Lagos'){ echo ' selected="selected"'; } ?> > Lagos </option>
                                                                    <option value="Nasarawa" <?php if($rowedt['Nasarawa'] == 'Abia'){ echo ' selected="selected"'; } ?>> Nasarawa </option>
                                                                    <option value="Niger" <?php if($_SESSION['gstate']== 'Niger'){ echo ' selected="selected"'; } ?> > Niger </option>
                                                                    <option value="Ogun" <?php if($_SESSION['gstate']== 'Ogun'){ echo ' selected="selected"'; } ?>> Ogun </option>
                                                                    <option value="Ondo" <?php if($_SESSION['gstate']== 'Ondo'){ echo ' selected="selected"'; } ?>> Ondo </option>
                                                                    <option value="Osun" <?php if($_SESSION['gstate']== 'Osun'){ echo ' selected="selected"'; } ?>> Osun </option>
                                                                    <option value="Oyo" <?php if($_SESSION['gstate']== 'Oyo'){ echo ' selected="selected"'; } ?> > Oyo </option>
                                                                    <option value="Plateau" <?php if($_SESSION['gstate']== 'Plateau'){ echo ' selected="selected"'; } ?> > Plateau </option>
                                                                    <option value="Rivers" <?php if($_SESSION['gstate']== 'Rivers'){ echo ' selected="selected"'; } ?>> Rivers </option>
                                                                    <option value="Sokoto" <?php if($_SESSION['gstate']== 'Sokoto'){ echo ' selected="selected"'; } ?>> Sokoto </option>
                                                                    <option value="Taraba" <?php if($_SESSION['gstate']== 'Taraba'){ echo ' selected="selected"'; } ?>> Taraba </option>
                                                                    <option value="Yobe" <?php if($_SESSION['gstate']== 'Yobe'){ echo ' selected="selected"'; } ?>> Yobe </option>
                                                                    <option value="Zamfara" <?php if($_SESSION['gstate']== 'Zamfara'){ echo ' selected="selected"'; } ?>> Zamfara </option>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInputEmail1">Do you want this guardian to receive a stipend/compensation for taking on the responsibilities of guardian, please set forth the details (e.g. monthly, annually etc.).</label>
<textarea rows="2" name="gstipend" class="form-control maxlength-simple"><?php echo $_SESSION['gstipend'] ;?> </textarea>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <input type="hidden" name="uid" value="<?php echo $userid; ?>"  /> 
                                    <input type="hidden" name="childid" value="<?php echo $row_rpm['id'];?>"  />
                                    <input type="submit" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>

    </div>
  </div>
</div>
<?php } while ($row_rpm = mysqli_fetch_assoc($rpm)); ?>
    <!--GUARDIAN MODAL STATUS ENDS HERE-->


<!--EDIT GUARDIANS MODAL STARTS-->
    <!-- Modal -->
<?php do {?>
<div class="modal fade" id="editguardianmodal<?php echo $row_edg['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Guardian Details for <?php echo $row_edg['name'];?> <br><span style="font-size:13px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:13px;">All fields with asterisk are compulsory</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form method="post" action="processor/process-editguardian.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Title<span style="color:red;">*</span></label>
                                                <select class="form-control" name="gtitle" required>
                                                    <option value="Mr" <?php if($row_edg['title'] == 'Mr'){ echo ' selected="selected"'; } ?> > Mr. </option>
                                                    <option value="Ms" <?php if($row_edg['title'] == 'Ms'){ echo ' selected="selected"'; } ?> > Ms. </option>
                                                    <option value="Mrs" <?php if($row_edg['title'] == 'Mrs'){ echo ' selected="selected"'; } ?> > Mrs. </option>
                                                    <option value="Others" <?php if($row_edg['title'] == 'Others'){ echo ' selected="selected"'; } ?> > Others </option>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Full Name<span style="color:red;">*</span></label>
                                            <input type="text" name="gname" value="<?php echo $row_edg['guardianname'];?>" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Email</label>
                                            <input type="email" name="gemail" value="<?php echo $row_edg['email'];?>" class="form-control maxlength-simple" id="exampleInput" requ/ired>
                                            </fieldset>
                                        </div>
                                    </div>
                                   

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Phone Number<span style="color:red;">*</span></label>
                                                <input type="text" name="gphoneno" value="<?php echo $row_edg['phone'];?>" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div> 

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Relationship<span style="color:red;">*</span></label>
                                            <select class="form-control" name="grelationship" required>
                                                <option value="Sibling" <?php if($row_edg['rtionship'] == 'Sibling'){ echo ' selected="selected"'; } ?> > Sibling </option>
                                                <option value="Parent" <?php if($row_edg['rtionship'] == 'Parent'){ echo ' selected="selected"'; } ?> > Parent </option>
                                                <option value="Relative" <?php if($row_edg['rtionship'] == 'Relative'){ echo ' selected="selected"'; } ?> > Relative </option>
                                                <option value="Friend" <?php if($row_edg['rtionship'] == 'Friend'){ echo ' selected="selected"'; } ?> > Friend </option>
                                                <option value="Colleague" <?php if($row_edg['rtionship'] == 'Colleague'){ echo ' selected="selected"'; } ?> > Colleague </option>
                                                <option value="Others" <?php if($row_edg['rtionship'] == 'Others'){ echo ' selected="selected"'; } ?> > Others </option>
                                                </select>
                                            </fieldset>
                                        </div>

                                        

                                         <div class="col-sm-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInputEmail1">Residential Address<span style="color:red;">*</span></label>
                                            <textarea rows="2" name="gaddr" class="form-control maxlength-simple" required><?php echo $row_edg['addr'];?></textarea>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">City<span style="color:red;">*</span></label>
                                            <input type="text" name="gcity" value="<?php echo $row_edg['city'];?>" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>

                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">State<span style="color:red;">*</span></label>
                                                <select class="form-control" name="gstate" required>
                                                <option value="Abia" <?php if($row_edg['state'] == 'Abia'){ echo ' selected="selected"'; } ?> > Abia </option>
                                                <option value="Abuja" <?php if($row_edg['state'] == 'Abuja'){ echo ' selected="selected"'; } ?>> Abuja </option>
                                                                    <option value="Adamawa" <?php if($row_edg['state'] == 'Adamawa'){ echo ' selected="selected"'; } ?>> Adamawa </option>
                                                                    <option value="Akwa Ibom" <?php if($row_edg['state'] == 'Akwa Ibom'){ echo ' selected="selected"'; } ?>> Akwa Ibom </option>
                                                                    <option value="Anambra" <?php if($row_edg['state'] == 'Anambra'){ echo ' selected="selected"'; } ?> > Anambra </option>
                                                                    <option value="Bauchi" <?php if($row_edg['state'] == 'Bauchi'){ echo ' selected="selected"'; } ?>> Bauchi </option>
                                                                    <option value="Bayelsa" <?php if($row_edg['state'] == 'Bayelsa'){ echo ' selected="selected"'; } ?> > Bayelsa </option>
                                                                    <option value="Benue" <?php if($row_edg['state'] == 'Benue'){ echo ' selected="selected"'; } ?>> Benue </option>
                                                                    <option value="Borno" <?php if($row_edg['state'] == 'Borno'){ echo ' selected="selected"'; } ?> > Borno </option>
                                                                    <option value="Cross River" <?php if($row_edg['state'] == 'Cross River'){ echo ' selected="selected"'; } ?> > Cross River </option>
                                                                    <option value="Delta" <?php if($row_edg['state'] == 'Delta'){ echo ' selected="selected"'; } ?> > Delta </option>
                                                                    <option value="Ebonyi" <?php if($row_edg['state'] == 'Ebonyi'){ echo ' selected="selected"'; } ?> > Ebonyi </option>
                                                                    <option value="Enugu" <?php if($row_edg['state'] == 'Enugu'){ echo ' selected="selected"'; } ?> > Enugu </option>
                                                                    <option value="Edo" <?php if($row_edg['state'] == 'Edo'){ echo ' selected="selected"'; } ?> > Edo </option>
                                                                    <option value="Ekiti" <?php if($row_edg['state'] == 'Ekiti'){ echo ' selected="selected"'; } ?> > Ekiti </option>
                                                                    <option value="Gombe" <?php if($row_edg['state'] == 'Gombe'){ echo ' selected="selected"'; } ?>> Gombe </option>
                                                                    <option value="Imo" <?php if($row_edg['state'] == 'Imo'){ echo ' selected="selected"'; } ?>> Imo </option>
                                                                    <option value="Jigawa" <?php if($row_edg['state'] == 'Jigawa'){ echo ' selected="selected"'; } ?> > Jigawa </option>
                                                                    <option value="Kaduna" <?php if($row_edg['state'] == 'Kaduna'){ echo ' selected="selected"'; } ?>> Kaduna </option>
                                                                    <option value="Kano" <?php if($row_edg['state'] == 'Kano'){ echo ' selected="selected"'; } ?>> Kano </option>
                                                                    <option value="Katsina" <?php if($row_edg['state'] == 'Katsina'){ echo ' selected="selected"'; } ?> > Katsina </option>
                                                                    <option value="Kebbi" <?php if($row_edg['state'] == 'Kebbi'){ echo ' selected="selected"'; } ?> > Kebbi </option>
                                                                    <option value="Kogi" <?php if($row_edg['state'] == 'Kogi'){ echo ' selected="selected"'; } ?> > Kogi </option>
                                                                    <option value="Kwara" <?php if($row_edg['state'] == 'Kwara'){ echo ' selected="selected"'; } ?> > Kwara </option>
                                                                    <option value="Lagos" <?php if($row_edg['state'] == 'Lagos'){ echo ' selected="selected"'; } ?> > Lagos </option>
                                                                    <option value="Nasarawa" <?php if($row_edg['state'] == 'Abia'){ echo ' selected="selected"'; } ?>> Nasarawa </option>
                                                                    <option value="Niger" <?php if($row_edg['state'] == 'Niger'){ echo ' selected="selected"'; } ?> > Niger </option>
                                                                    <option value="Ogun" <?php if($row_edg['state'] == 'Ogun'){ echo ' selected="selected"'; } ?>> Ogun </option>
                                                                    <option value="Ondo" <?php if($row_edg['state'] == 'Ondo'){ echo ' selected="selected"'; } ?>> Ondo </option>
                                                                    <option value="Osun" <?php if($row_edg['state'] == 'Osun'){ echo ' selected="selected"'; } ?>> Osun </option>
                                                                    <option value="Oyo" <?php if($row_edg['state'] == 'Oyo'){ echo ' selected="selected"'; } ?> > Oyo </option>
                                                                    <option value="Plateau" <?php if($row_edg['state'] == 'Plateau'){ echo ' selected="selected"'; } ?> > Plateau </option>
                                                                    <option value="Rivers" <?php if($row_edg['state'] == 'Rivers'){ echo ' selected="selected"'; } ?>> Rivers </option>
                                                                    <option value="Sokoto" <?php if($row_edg['state'] == 'Sokoto'){ echo ' selected="selected"'; } ?>> Sokoto </option>
                                                                    <option value="Taraba" <?php if($row_edg['state'] == 'Taraba'){ echo ' selected="selected"'; } ?>> Taraba </option>
                                                                    <option value="Yobe" <?php if($row_edg['state'] == 'Yobe'){ echo ' selected="selected"'; } ?>> Yobe </option>
                                                                    <option value="Zamfara" <?php if($row_edg['state'] == 'Zamfara'){ echo ' selected="selected"'; } ?>> Zamfara </option>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInputEmail1">Do you want this guardian to receive a stipend/compensation for taking on the responsibilities of guardian, please set forth the details (e.g. monthly, annually etc.).</label>
                                            <textarea rows="2" name="gstipend" class="form-control maxlength-simple"><?php echo $row_edg['stipend'];?></textarea>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <input type="hidden" name="guardianid" value="<?php echo $row_edg['id'];?>"  />
                                    <input type="submit" value="Save" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
<?php } while ($row_edg = mysqli_fetch_assoc($edg));?> 

<!--EDIT GUARDIANS MODAL ENDS-->

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