<?php require ('Connections/conn.php');
include ('session.php');
if(!isset($userid)){
header('location:index.php');
exit();
}

$query = "SELECT * FROM education_beneficiary WHERE `uid` = '$userid'";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
$row_child = mysqli_fetch_assoc($result);
$totalchild = mysqli_num_rows($result);

$queryedtm = "SELECT * FROM education_beneficiary WHERE `uid` = '$userid'";
$resultedtm = mysqli_query($conn, $queryedtm) or die(mysqli_error($conn));
$row_edtm = mysqli_fetch_assoc($resultedtm);
$totaledtm = mysqli_num_rows($resultedtm);

$queryeducationsharing = "SELECT * FROM education_beneficiary WHERE `uid` = '$userid'";
$resulteducationsharing = mysqli_query($conn, $queryeducationsharing) or die(mysqli_error($conn));
$row_educationsharing = mysqli_fetch_assoc($resulteducationsharing);
$totaleducationsharing = mysqli_num_rows($resulteducationsharing);

$queryedteducationsharing = "SELECT * FROM education_beneficiary WHERE `uid` = '$userid'";
$edteducationsharing = mysqli_query($conn, $queryedteducationsharing) or die(mysqli_error($conn));
$row_edteducationsharing = mysqli_fetch_assoc($edteducationsharing);
$totaledteducationsharing = mysqli_num_rows($edteducationsharing);

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
    <link rel="stylesheet" href="css/lib/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="css/separate/vendor/flatpickr.min.css">
    <link rel="stylesheet" href="css/separate/vendor/select2.min.css">
    <link rel="stylesheet" href="css/separate/vendor/bootstrap-daterangepicker.min.css">


    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
                    
                    <!--<section class="box-typical sidemenu" >
                        <div class="profile-card">
                            <div class="profile-card-name"> People who inherit from your assets are known as "Beneficiaries". </div>
                        </div>
                    </section>--><!--.box-typical-->

                </div><!--.col- -->

                <div class="col-lg-9 col-lg-push-3 col-md-12">
                    <form action="processor/process-educationvalidataion.php" method="post">
                    <section class="card">
                           
                <div class="card-block">
                    
                                        
                                                              <?php 

if (isset($_GET['a'])) {  
$url = mysqli_real_escape_string($conn, $_GET['a']);

?>
<?php if($url == 'percentage-denied'){  ?>
<div class="alert alert-warning alert-fill alert-close alert-dismissible fade show" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <?php echo  '  Total percentage sharing must be equal to 100%. ' ; ?>
</div>
<?php } ?>

<?php if($url == 'beneficiary-denied'){  ?>
<div class="alert alert-warning alert-fill alert-close alert-dismissible fade show" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <?php echo  ' Please add a child. ' ; ?>
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
  <?php echo  ' Percentage must consist of numbers only. ' ; ?>
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

<?php if($url == 'denied'){  ?>
<div class="alert alert-warning alert-fill alert-close alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <?php echo  ' File Size is too large' ; ?>
</div>
<?php } ?>

<?php if($url == 'invalid'){  ?>
<div class="alert alert-warning alert-fill alert-close alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <?php echo  'Invalid file type.' ; ?>
</div>
<?php } ?>


<?php } ?>


                    <h5 class="with-bo/rder">Add Child</h5>

                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <p>To qualify for the Life Insurance policy, Settlor must have made the Total Contribution of N1,000,000 per child.</p>
                        </div>
                    
                <div class="col-md-8 col-sm-12">
                    
                        <!--<div class="col-md-12 col-sm-12">-->

<?php if ($totalchild != NULL) { ?>
                        <div id="spouse_table">
                                    <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Name of child</th>
                                            <th>Edit </th>
                                            <th>Delete</th>
                                          </tr>
                                        </thead>
                                        <tbody>   
                                        <?php do { ?>
                                             <tr>
                                                <td><?php echo $row_child['nameofchild'];?></td>
                                                <td><button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#editbeneficiary<?php echo $row_child["id"]; ?>">
                                                Edit 
                                                </button></td>
                                                <td><a href="processor/process-educationchilddelete.php?a=<?php echo $row_child["id"]; ?>"><input type="button" na/me="view" value="Delete" class="btn btn-fcmb btn-xs view_data" /></a></td>
                                            </tr>
                                        <?php } while ($row_child = mysqli_fetch_assoc($result)) ;?>
                                                                                </tbody>
                                    </table>
                                </div>
<br/>

<?php } ?>
                    <!--BENEFICIARY RECORDSET ENDS-->
                            <button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#addbeneficiary">
                                Add Child
                            </button>
                        <!--</div>-->
                
                </div>
                </div>
                </div>
                        
            </section>


<?php if ($totaleducationsharing != NULL) { ?>
             <section class="card">
                           
                <div class="card-block">
                    
                    <h5 class="with-bo/rder">Approximate share in percentage</h5>

                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <!--<p>I declare that I own and/or operate the following bank accounts.</p>-->
                        </div>
                    
                <div class="col-md-12 col-sm-12">
                    
                        <!--<div class="col-md-12 col-sm-12">-->

<?php //if ($totaleducationsharing != NULL) { ?>
                        <div id="spouse_table">
                                    <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Name of Child</th>
                                            <th>Date of Birth</th>
                                            <th>Relationship to Settlor</th>
                                            <th>Sex</th>
                                            <th>Approximate Share(%)</th>
                                            <th></th>
                                          </tr>
                                        </thead>
                                        <tbody>   
                                        <?php do { ?>
                                             <tr>
                                        <td><?php echo $row_educationsharing['nameofchild'];?></td>
                                        <td><?php echo $row_educationsharing['dob'];?></td>
                                        <td><?php echo $row_educationsharing['relationship'];?></td>
                                        <td><?php echo $row_educationsharing['sex'];?></td>
                                        <td><?php echo $row_educationsharing['percentage'];?></td>
                                                <td><button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#editeducationpercentage<?php echo $row_educationsharing["id"]; ?>">
<?php if($row_educationsharing["percentage"] == NULL){
    echo "Add Percentage";
}else{
    echo "Edit Percentage";
} ?> 
                                                </button></td>
                                            </tr>
<?php } while ($row_educationsharing = mysqli_fetch_assoc($resulteducationsharing)) ;?>
                                                                                </tbody>
                                    </table>
                                </div>
<br/>

<?php } ?>
                
                </div>
                </div>
                </div>
                        
            </section>
<?php //} ?>

                <input type="hidden" name="uid" value="<?php echo $userid?>">
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

    <!--CHILD MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="addbeneficiary" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Child</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-addeducationchild.php" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Name of child</label>
                                            <input type="text" name="nameofchild" class="form-control maxlength-simple" id="exampleInput" required value="<?php echo $_SESSION['nameofchild']; ?>" >
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                                                 <label>Date of Birth (MM/DD/YYYY)</label>
                                            
                                            <input type="text" name="dob" class="form-control" autocomplete="off" value="<?php echo $_SESSION['dob'];?>" id="datepicker" required >
                                                            </fieldset>
                                        </div>
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Sex</label>
                                                                                                                <select class="form-control" name="sex" required>
                                        <option value=""> -Please Select- </option>
                                                                    <option value="Male" <?php if($_SESSION['sex']== 'Male'){ echo ' selected="selected"'; } ?> > Male </option>
                                                                    <option value="Female" <?php if($_SESSION['sex']== 'Female'){ echo ' selected="selected"'; } ?> > Female </option>

                                                                    </select>
                                                            </fieldset>
                                        </div>
                                    </div>         
                                    <div class="row">
                                    <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInputEmail1">Relationship to Settlor</label>
                                                                <select class="form-control" name="relationship" required>
                                                                    <option value=""> -Please Select- </option>
                                                                    <option value="Son" <?php if($_SESSION['relationship']== 'Son'){ echo ' selected="selected"'; } ?> > Son </option>
                                                                    <option value="Daughter" <?php if($_SESSION['relationship']== 'Daughter'){ echo ' selected="selected"'; } ?> > Daughter </option>
                                                                    <option value="Niece" <?php if($_SESSION['relationship']== 'Niece'){ echo ' selected="selected"'; } ?> > Niece </option>
                                                                    <option value="Nephew" <?php if($_SESSION['relationship']== 'Nephew'){ echo ' selected="selected"'; } ?> > Nephew </option>
                                                                    <option value="Cousin" <?php if($_SESSION['relationship']== 'Cousin'){ echo ' selected="selected"'; } ?> > Cousin </option>
                                                                    <option value="Relative" <?php if($_SESSION['relationship']== 'Relative'){ echo ' selected="selected"'; } ?> > Relative </option>

                                                                    </select>
                                                        </fieldset>
                                                        </div>
                                                        
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInputEmail1">Upload Passport</label>
                                                <input type="file" name="passport" required/>
                                        </div>
                                                        
                                                        </div>

 

                                    <input type="hidden" name="educationuid" value="<?php echo $userid; ?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
    <!--ADD CHILD MODAL ENDS HERE-->


<?php do { ?>
    <!--EDIT CHILD MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="editbeneficiary<?php echo $row_edtm['id'];?>" tabindex="-1" role="dialog" aria-labelledby="editbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Details for <?php echo $row_edtm['nameofchild']; ?> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-editeducationchild.php" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Name of Child</label>
                                            <input type="text" name="edtnameofchild" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $row_edtm['nameofchild']; ?>" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Date of Birth (MM/DD/YYYY)</label>
                                                <input type="text" name="edtdob" class="form-control" autocomplete="off" value="<?php echo $row_edtm['dob'];?>" id="datepicker1" required >
                                                            </fieldset>
                                        </div>
                                        <div class="col-lg-6">
                                                            <fieldset class="form-group">
                                                                <label class="form-label" for="exampleInputEmail1">Sex</label>
                                                                <select class="form-control" name="edtsex" required>
                                                                    <option value=""> -Please Select- </option>
                                                                    <option value="Male" <?php if($row_edtm['sex'] == 'Male'){ echo ' selected="selected"'; } ?> > Male </option>
                                                                    <option value="Female" <?php if($row_edtm['sex'] == 'Female'){ echo ' selected="selected"'; } ?> > Female </option>
                                                                    </select>
                                                            </fieldset>
                                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                                            <fieldset class="form-group">
                                                                <label class="form-label" for="exampleInputEmail1">Relationship</label>
                                                                <select class="form-control" name="edtrelationship" required>
                                                                    <option value=""> -Please Select- </option>
                                                                    <option value="Son" <?php if($row_edtm['relationship'] == 'Son'){ echo ' selected="selected"'; } ?> > Son </option>
                                                                    <option value="Daughter" <?php if($row_edtm['relationship'] == 'Daughter'){ echo ' selected="selected"'; } ?> > Daughter </option>
                                                                    <option value="Niece" <?php if($row_edtm['relationship'] == 'Niece'){ echo ' selected="selected"'; } ?> > Niece </option>
                                                                    <option value="Nephew" <?php if($row_edtm['relationship'] == 'Nephew'){ echo ' selected="selected"'; } ?> > Nephew </option>
                                                                    <option value="Cousin" <?php if($row_edtm['relationship'] == 'Cousin'){ echo ' selected="selected"'; } ?> > Cousin </option>
                                                                    <option value="Relative" <?php if($row_edtm['relationship'] == 'Relative'){ echo ' selected="selected"'; } ?> > Relative </option>
                                                                    </select>
                                                            </fieldset>
                                                        </div>
                                                                                    <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInputEmail1">Upload Passport</label>
                                                <input type="file" name="edtpassport" />
                                        </div>
                                        
                                    </div>

                                    <input type="hidden" name="edtnameofchildid" value="<?php echo $row_edtm['id']; ?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
    <!--EDIT BENEFICIARY MODAL ENDS HERE-->
<?php } while ($row_edtm = mysqli_fetch_assoc($resultedtm));?>


    <!--ADD PERCENTAGE MODAL STARTS HERE -->
    <!-- Modal -->
<?php do { ?>
<div class="modal fade" id="editeducationpercentage<?php echo $row_edteducationsharing['id'];?>" tabindex="-1" role="dialog" aria-labelledby="editeducationpercentage" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Percentage for <?php echo $row_edteducationsharing['nameofchild'];?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-educationpercentage.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Approximate share in %</label>
                                            <input type="text" name="educationpercentage" class="form-control maxlength-simple" id="exampleInput" 
                                            value="<?php echo $row_edteducationsharing['percentage'];?>" required> 
                                            </fieldset>
                                        </div>
                                    </div>

                                    <input type="hidden" name="percentagesharingid" value="<?php echo $row_edteducationsharing['id'];?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
<?php } while ($row_edteducationsharing = mysqli_fetch_assoc($edteducationsharing));?>
    <!--ADD PERCENTAGE MODAL ENDS HERE-->
    
    
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