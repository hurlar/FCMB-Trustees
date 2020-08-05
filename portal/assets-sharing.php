<?php require ('Connections/conn.php');
include ('session.php');
$queryprt = "SELECT * FROM property_tb WHERE uid = '$userid' ";
$prt = mysqli_query($conn, $queryprt) or die(mysqli_error($conn));
$row_prt = mysqli_fetch_assoc($prt);
$totalprt = mysqli_num_rows($prt);

$querysh = "SELECT * FROM shares_tb WHERE uid = '$userid' ";
$sh = mysqli_query($conn, $querysh) or die(mysqli_error($conn));
$row_sh = mysqli_fetch_assoc($sh);
$totalsh = mysqli_num_rows($sh); 

$queryins = "SELECT * FROM insurance_tb WHERE uid = '$userid' ";
$ins = mysqli_query($conn, $queryins) or die(mysqli_error($conn));
$row_ins = mysqli_fetch_assoc($ins);
$totalins = mysqli_num_rows($ins); 

$querybkd = "SELECT * FROM bank_details WHERE uid = '$userid' ";
$bkd = mysqli_query($conn, $querybkd) or die(mysqli_error($conn));
$row_bkd = mysqli_fetch_assoc($bkd);
$totalbkd = mysqli_num_rows($bkd); 

$queryest = "SELECT * FROM estate_tb WHERE uid = '$userid' ";
$est = mysqli_query($conn, $queryest) or die(mysqli_error($conn));
$row_est = mysqli_fetch_assoc($est);
$totalest = mysqli_num_rows($est); 

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
                    <?php if ($totalprt != NULL) { ?>
                            <section class="card">
                <div class="card-block">
                    <h5 class="with-bo/rder">Add sharing percentage for <?php echo $row_prt['type'];?></h5>

                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <p>This shows the proportional share of each beneficiary as it relates to the perticular asset type.<br>
Share your estate/assets by specifying percentage splits.</p>
                        </div>
                    
                <div class="col-md-8 col-sm-12">
                    
                        <div class="col-md-12 col-sm-12">

<!--GET BENEFICIARY DETAILS STARTS-->
<?php
$queryben = "SELECT * FROM beneficiary_tb WHERE uid = '$userid' ";
$ben = mysqli_query($conn, $queryben) or die(mysqli_error($conn));
$row_ben = mysqli_fetch_assoc($ben);
$totalben = mysqli_num_rows($ben);
$beneficiaries = $row_ben['beneficiaries'];
$names_array = explode(',', $beneficiaries);
?>
<!--GET BENEFICIARY DETAILS ENDS-->   

<!--GET BENEFICIARY DETAILS STARTS-->
<?php
$queryben2 = "SELECT * FROM beneficiary_tb WHERE uid = '$userid' ";
$ben2 = mysqli_query($conn, $queryben2) or die(mysqli_error($conn));
$row_ben2 = mysqli_fetch_assoc($ben2);
$totalben2 = mysqli_num_rows($ben2);
?>
<!--GET BENEFICIARY DETAILS ENDS-->              
                                 <table id="table-sm" class="table table-bordered table-hover table-sm">
                                                <thead>
                                                <tr>
                                                    <th>Beneficiary Name</th>
                                                    <th>Percentage</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                            <?php do { ?>
                                                <?php foreach($names_array as $name) { ?>
                                                <tr>
                                                
                                                    <td><?php echo $name.'<br>'; ?></td>
                                                   
                                                    <td>percentage</td>
                                                    <td><button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#addpercentageproperty<?php echo $row_ben['uid'];?>">
                                                        Add Percentage
                                                    </button></td>
                                                </tr>
                                                <?php echo $row_ben['id'];?>
                                                <?php } ?> 
                                            <?php } while ($row_ben = mysqli_fetch_assoc($ben));?>
                                                </tbody>
                                            </table>

<!--ADD PERCENTAGE PROPERTY MODAL-->
<div class="modal fade" id="addpercentageproperty<?php echo $row_ben2['uid'];?>" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add your property</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="#" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Location</label>
                                            <input type="text" name="plocation" value="<?php $row_ben2['uid'];?>" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Type Of Property</label>
                                            <input type="text" name="ptype" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                                            <fieldset class="form-group">
                                                                <label class="form-label" for="exampleInputEmail1">How it is registered ? </label>
                                                                <textarea rows="2" name="pregistered" class="form-control maxlength-simple" required></textarea>
                                                            </fieldset>
                                                        </div>
                                    </div>

                                    <input type="hidden" name="puid" value="<?php echo $userid; ?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
      </div>
    </div>
  </div>
</div>




<!--END PERCENTAGE PROPERTY MODAL-->


<br/>
                            
                        </div>
                
                </div>
                </div>
                </div>
                        
            </section>

            <?php } ?>



                                <?php if ($totalsh != NULL) { ?>
                            <section class="card">
                <div class="card-block">
                    <h5 class="with-bo/rder">Add sharing percentage for?</h5>

                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <p>This shows the proportional share of each beneficiary as it relates to the perticular asset type.<br>
Share your estate/assets by specifying percentage splits.</p>
                        </div>
                    
                <div class="col-md-8 col-sm-12">
                    
                        <div class="col-md-12 col-sm-12">
                            
                            <table id="table-sm" class="table table-bordered table-hover table-sm">
                                                <thead>
                                                <tr>
                                                    <th>Asset</th>
                                                    <th>Beneficiaries</th>
                                                    <th>Option</th>
                                                    <th>Comment</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td><?php echo $row_est['asset'];?></td>
                                                    <td><?php echo $row_est['beneficiaries'];?></td>
                                                    <td><?php echo $row_est['option'];?></td>
                                                    <td><?php echo $row_est['comment'];?></td>
                                                </tbody>
                                            </table>
<br/>
                            <button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#addbeneficiary">
                                Add Beneficiary
                            </button>
                        </div>
                
                </div>
                </div>
                </div>
                        
            </section>

            <?php } ?>


                                            <?php if ($totalins != NULL) { ?>
                            <section class="card">
                <div class="card-block">
                    <h5 class="with-bo/rder">Add sharing percentage for?</h5>

                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <p>This shows the proportional share of each beneficiary as it relates to the perticular asset type.<br>
Share your estate/assets by specifying percentage splits.</p>
                        </div>
                    
                <div class="col-md-8 col-sm-12">
                    
                        <div class="col-md-12 col-sm-12">
                            
                            <table id="table-sm" class="table table-bordered table-hover table-sm">
                                                <thead>
                                                <tr>
                                                    <th>Asset</th>
                                                    <th>Beneficiaries</th>
                                                    <th>Option</th>
                                                    <th>Comment</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td><?php echo $row_est['asset'];?></td>
                                                    <td><?php echo $row_est['beneficiaries'];?></td>
                                                    <td><?php echo $row_est['option'];?></td>
                                                    <td><?php echo $row_est['comment'];?></td>
                                                </tbody>
                                            </table>
<br>
                            <button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#addbeneficiary">
                                Add Beneficiary
                            </button>
                        </div>
                
                </div>
                </div>
                </div>
                        
            </section>

            <?php } ?>


                                            <?php if ($querybkd  != NULL) { ?>
                            <section class="card">
                <div class="card-block">
                    <h5 class="with-bo/rder">Add sharing percentage for?</h5>

                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <p>This shows the proportional share of each beneficiary as it relates to the perticular asset type.<br>
Share your estate/assets by specifying percentage splits.</p>
                        </div>
                    
                <div class="col-md-8 col-sm-12">
                    
                        <div class="col-md-12 col-sm-12">
                            
                            <table id="table-sm" class="table table-bordered table-hover table-sm">
                                                <thead>
                                                <tr>
                                                    <th>Asset</th>
                                                    <th>Beneficiaries</th>
                                                    <th>Option</th>
                                                    <th>Comment</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td><?php echo $row_est['asset'];?></td>
                                                    <td><?php echo $row_est['beneficiaries'];?></td>
                                                    <td><?php echo $row_est['option'];?></td>
                                                    <td><?php echo $row_est['comment'];?></td>
                                                </tbody>
                                            </table>
<br>
                            <button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#addbeneficiary">
                                Add Beneficiary
                            </button>
                        </div>
                
                </div>
                </div>
                </div>
                        
            </section>

            <?php } ?>


                                            <?php if ($totalest != NULL) { ?>
                            <section class="card">
                <div class="card-block">
                    <h5 class="with-bo/rder">Add sharing percentage for?</h5>

                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <p>This shows the proportional share of each beneficiary as it relates to the perticular asset type.<br>
Share your estate/assets by specifying percentage splits.</p>
                        </div>
                    
                <div class="col-md-8 col-sm-12">
                    
                        <div class="col-md-12 col-sm-12">
                            
                            <table id="table-sm" class="table table-bordered table-hover table-sm">
                                                <thead>
                                                <tr>
                                                    <th>Asset</th>
                                                    <th>Beneficiaries</th>
                                                    <th>Option</th>
                                                    <th>Comment</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td><?php echo $row_est['asset'];?></td>
                                                    <td><?php echo $row_est['beneficiaries'];?></td>
                                                    <td><?php echo $row_est['option'];?></td>
                                                    <td><?php echo $row_est['comment'];?></td>
                                                </tbody>
                                            </table>
<br>
                            <button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#addbeneficiary">
                                Add Beneficiary
                            </button>
                        </div>
                
                </div>
                </div>
                </div>
                        
            </section>

            <?php } ?>
                



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

    <!--ADD PROPERTY MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="addproperty" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add your property</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-property.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Location</label>
                                            <input type="text" name="plocation" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Type Of Property</label>
                                            <input type="text" name="ptype" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                                            <fieldset class="form-group">
                                                                <label class="form-label" for="exampleInputEmail1">How it is registered ? </label>
                                                                <textarea rows="2" name="pregistered" class="form-control maxlength-simple" required></textarea>
                                                            </fieldset>
                                                        </div>
                                    </div>

                                    <input type="hidden" name="puid" value="<?php echo $userid; ?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
      </div>
    </div>
  </div>
</div>
    <!--ADD PRPERTY MODAL ENDS HERE-->


<!--ADD SHARES MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="addshares" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add your shares / stocks</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-shares.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Company</label>
                                            <input type="text" name="scompany" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Volume</label>
                                            <input type="text" name="svolume" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Percentage Of Shareholdings</label>
                                            <input type="number" name="spercent" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">CSCS NO. (if applicable)</label>
                                            <input type="text" name="cscs" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    

                                    <input type="hidden" name="suid" value="<?php echo $userid; ?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
      </div>
    </div>
  </div>
</div>
    <!--ADD SHARES MODAL ENDS HERE-->


<!--ADD ISSUARANCE MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="addinsurance" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Life Insurance</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-insurance.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Company</label>
                                            <input type="text" name="lcompany" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Type of Policy</label>
                                            <input type="text" name="lpolicy" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Owner</label>
                                            <input type="text" name="lowner" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Select Beneficiaries for this asset</label>
                                            <!--<input type="email" name="bemail" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>-->
                                            <div class="form-check">
                                                          <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="lbeneficiary[]" value="">                              </label>
                                                          <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="lbeneficiary[]" value="dddddddddd">dddddddddd                              </label>
                                                          <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="lbeneficiary[]" value="Testing the insert inside the beneficiary dump">Testing the insert inside the beneficiary dump                              </label>
                                                          <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="lbeneficiary[]" value="testing testing testing1111111111111111111">testing testing testing1111111111111111111                              </label>
                                                          <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="lbeneficiary[]" value="Michael Alu">Michael Alu                              </label>
                                                          <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="lbeneficiary[]" value="ffff">ffff                              </label>
                             <br/>
                            </div>
                                        </div>



                                    </div>

                                    
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Face Value</label>
                                            <input type="text" name="lvalue" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <input type="hidden" name="luid" value="<?php echo $userid; ?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
      </div>
    </div>
  </div>
</div>
    <!--ADD ISSURANCE MODAL ENDS HERE-->


    <!--ADD ISSUARANCE MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="addaccount" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Bank Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-account.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Bank Account Name</label>
                                            <input type="text" name="anctame" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Bank Account Number</label>
                                            <input type="text" name="actno" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Branch</label>
                                            <input type="text" name="actbranch" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Account Type</label>
                                            <input type="text" name="acttype" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <input type="hidden" name="actuid" value="<?php echo $userid; ?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
      </div>
    </div>
  </div>
</div>
    <!--ADD ISSURANCE MODAL ENDS HERE-->

    <!--BENEFICIARY MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="addestate" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add your estate</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-estate.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Asset</label>
                                            <input type="text" name="asset" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Select Beneficiaries for this asset</label>
                                            <!--<input type="email" name="bemail" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>-->
                                            <div class="form-check">
                                                          <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="abeneficiary[]" value="">                              </label>
                                                          <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="abeneficiary[]" value="dddddddddd">dddddddddd                              </label>
                                                          <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="abeneficiary[]" value="Testing the insert inside the beneficiary dump">Testing the insert inside the beneficiary dump                              </label>
                                                          <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="abeneficiary[]" value="testing testing testing1111111111111111111">testing testing testing1111111111111111111                              </label>
                                                          <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="abeneficiary[]" value="Michael Alu">Michael Alu                              </label>
                                                          <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="abeneficiary[]" value="ffff">ffff                              </label>
                             <br/>
                            </div>
                                        </div>



                                    </div>

                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <fieldset class="form-group">
                                                                <label class="form-label" for="exampleInputEmail1">Choose Option</label>
                                                                <select class="form-control" name="aoption" required>
                                                                    <option value=""> -Please Select- </option>
                                                                    <option value="Option A"> Option A </option>
                                                                    <option value="Option B"> Option B </option>
                                                                    <option value="Option C"> Option C </option>
                                                                    <option value="Option D"> Option D </option>
                                                                    </select>
                                                            </fieldset>
                                                        </div>
                                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                                            <fieldset class="form-group">
                                                                <label class="form-label" for="exampleInputEmail1">I want my assets to pass in this manner</label>
                                                                <textarea rows="2" name="acomment" class="form-control maxlength-simple" required></textarea>
                                                            </fieldset>
                                                        </div>
                                    </div>

                                    <input type="hidden" name="auid" value="<?php echo $userid; ?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
      </div>
    </div>
  </div>
</div>
    <!--BENEFICIARY MODAL ENDS HERE-->

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