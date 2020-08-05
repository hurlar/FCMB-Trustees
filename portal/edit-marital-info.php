<?php require ('Connections/conn.php');
include ('session.php');

$queryms = "SELECT `uid`,`status` FROM marital_status WHERE `uid` = '$userid' ";
$resultms = mysqli_query($conn, $queryms) or die(mysqli_error($conn));
$row_ms = mysqli_fetch_assoc($resultms);
$totalrowms = mysqli_num_rows($resultms);

$query = "SELECT * FROM spouse_tb WHERE `uid` = '$userid' ";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
$totalrow = mysqli_num_rows($result);

$query = "SELECT * FROM state_tb";
$mi = mysqli_query($conn, $query) or die(mysqli_error($conn));
$row_mi = mysqli_fetch_assoc($mi);

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

                </div><!--.col- -->

                <div class="col-lg-9 col-lg-push-3 col-md-12">
                            <section class="card">
                <div class="card-block">
                    <h5 class="with-bo/rder">Marital Status</h5>

                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <p>
                                Please select your current legal marital status, even if you know it's going to change soon. You can always update this in the future. <br>
                                In a relationship but not married? You'll need to select 'Single'. This is your legal marital status.
                            </p>
                        </div>
                    
                <div class="col-md-8 col-sm-12">


                <form action="processor/edit-process-marital-info.php" method="post">
                    <!--<div class="col-md-3 col-sm-6">-->
                            <div class="radio">
                                <input type="radio" name="mstatus" id="radio-1" value="single" <?php if($row_ms['status'] == 'single'){ echo ' checked="checked"'; } ?> >
                                <label for="radio-1">Single </label>
                                <input type="radio" name="mstatus" id="radio-2" value="married" <?php if($row_ms['status'] == 'married'){ echo ' checked="checked"'; } ?> >
                                <label for="radio-2">Married </label>
                                <input type="radio" name="mstatus" id="radio-3" value="divorced" <?php if($row_ms['status'] == 'divorced'){ echo ' checked="checked"'; } ?> >
                                <label for="radio-3">Divorced</label>
                                <input type="radio" name="mstatus" id="radio-4" value="widowed" <?php if($row_ms['status'] == 'Widowed'){ echo ' checked="checked"'; } ?> >
                                <label for="radio-4">Widowed</label> <br>
                                        <button type="button"
                                            class="married box btn btn-inline btn-fcmb"
                                            data-toggle="modal"
                                            data-target="#add_spouse_Modal">
                                            Add Spouse
                                        </button>

                            


                            </div>
                        <!--</div>-->

                    <input type="hidden" name="uid" value="<?php echo $userid ;?>" />
                    <input type="submit" value="Save" class="btn btn-inline btn-fcmb" style="float:right;">
                </form>
                            <?php if ($totalrow != NULL) { ?>
                                <div id="spouse_table" class="col-md-6">
                                    <table class="table table-bordered">
                                        <thead>
                                          <tr>
                                            <th>Spouse Name</th>
                                            <!--<th>Action</th>-->
                                          </tr>
                                        </thead>
                                        <tbody>    
                                        <?php while($row = mysqli_fetch_array($result)){ ?>
                                            <tr>
                                                <td><?php echo $row["fullname"]; ?></td>
                                                <!--<td><input type="button" name="view" value="View Details" id="<?php //echo $row["uid"]; ?>" class="btn btn-fcmb btn-xs view_data" /></td> -->
                                            </tr>
                                        <?php  } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } ?>

                

                <div class="modal fade"
                     id="add_spouse_Modal"
                     tabindex="-1"
                     role="dialog"
                     aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:#5C3092;">
                                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                    <i class="font-icon-close-2"></i>
                                </button>
                                <h4 class="modal-title" id="myModalLabel"> <span style="color:#fff;">Add Spouse</span></h4>
                            </div>
                            <div class="modal-body">
                                <form method="post" id="spouse_form">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Title</label>
                                                <select class="form-control" name="stitle" required>
                                                    <option value="Mr"> Mr. </option>
                                                    <option value="Ms"> Ms. </option>
                                                    <option value="Mrs"> Mrs. </option>
                                                    <option value="Alhaji"> Alhaji. </option>
                                                    <option value="Alhaja"> Alhaja. </option>
                                                    <option value="Dr"> Dr. </option>
                                                    <option value="Engr"> Engr. </option>
                                                    <option value="Chief"> Chief. </option>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Full Name</label>
                                            <input type="text" name="sfname" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Email</label>
                                            <input type="email" name="semail" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Phone Number</label>
                                                <input type="text" name="sphoneno" class="form-control maxlength-simple" id="exampleInput" required>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <fieldset class="form-group">
                                                                <label class="form-label" for="exampleInputEmail1">Alt. Phone Number</label>
                                                                <input type="text" name="saltphoneno" class="form-control maxlength-custom-message" id="exampleInputEmail1" >
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <fieldset class="form-group">
                                                                <label class="form-label" for="exampleInputEmail1">Resident Address</label>
                                                                <textarea rows="2" name="saddr" class="form-control maxlength-simple"  ></textarea>
                                                            </fieldset>
                                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">City</label>
                                            <input type="text" name="scity" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>

                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">State</label>
                                                <select class="form-control" name="sstate" required>
                                                <?php do { ?>
                                                    <option value="<?php echo $row_mi['name'];?>"> <?php echo $row_mi['name'];?> </option>
                                                <?php } while ($row_mi = mysqli_fetch_assoc($mi)) ;?>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <input type="hidden" name="uid" value="<?php echo $userid; ?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Save" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>

                            </div>
                            <!--<div class="modal-footer">
                                <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-rounded btn-primary">Save changes</button>
                            </div>-->
                        </div>
                    </div>
                </div><!--.modal-->



                <!--EMPTY MODAL FOR SPOUSE DETAILS STARTS-->
                <div class="modal fade"
                     id="dataModal"
                     tabindex="-1"
                     role="dialog"
                     aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:#5C3092;">
                                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                    <i class="font-icon-close-2"></i>
                                </button>
                                <h4 class="modal-title"> <span style="color:#fff;">Spouse Details</span></h4>
                            </div>
                            <div class="modal-body" id="employee_detail">
                                

                            </div>
                            <!--<div class="modal-footer">
                                <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-rounded btn-primary">Save changes</button>
                            </div>-->
                        </div>
                    </div>
                </div><!--.modal-->
                <!--EMPTY MODAL FOR SPOUSE DETAILS ENDS-->

                
                </div>
                </div>
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

    <!-- SPOUSE JS STARTS -->
    <script>  
$(document).ready(function(){
 $('#spouse_form').on("submit", function(event){  
  event.preventDefault();  
  if($('#stitle').val() == "")  
  {  
   alert("Title is required");  
  }   
  else if($('#sfname').val() == '')
  {  
   alert("Fullname is required");  
  }
  else if($('#semail').val() == '')
  {  
   alert("Email is required");  
  }
    else if($('#sphoneno').val() == '')
  {  
   alert("Phone Number is required");  
  }
    else if($('#saddr').val() == '')
  {  
   alert("Address is required");  
  }
    else if($('#scity').val() == '')
  {  
   alert("City is required");  
  }
    else if($('#sstate').val() == '')
  {  
   alert("State is required");  
  }
  else  
  {  
   $.ajax({  
    url:"spouse_insert.php",  
    method:"POST",  
    data:$('#spouse_form').serialize(),  
    beforeSend:function(){  
     $('#spouseinsert').val("Inserting");  
    },  
    success:function(data){  
     $('#spouse_form')[0].reset();  
     $('#add_spouse_Modal').modal('hide');  
     $('#spouse_tb').html(data);  
    }  
   });  
  }  
 });




$(document).on('click', '.view_data', function(){
  //$('#dataModal').modal();
  var spouse_uid = $(this).attr("uid");
  $.ajax({
   url:"spouse_select.php",
   method:"POST",
   data:{spouse_uid:spouse_uid},
   success:function(data){
    $('#spouse_detail').html(data);
    $('#dataModal').modal('show');
   }
  });
 });
});  
 </script>
<!-- SPOUSE JS ENDS -->

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