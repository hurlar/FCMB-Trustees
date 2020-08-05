<?php require ('Connections/conn.php');
include ('session.php');
if(!isset($userid)){
header('location:index.php');
exit();
}

$queryprt = "SELECT `id`,`uid`,`asset_type`,`bankname`,`accounttype`,`pension_admin` FROM simplewill_assets_tb WHERE uid = '$userid' ";
$prt = mysqli_query($conn, $queryprt) or die(mysqli_error($conn));
//$row_prt = mysqli_fetch_assoc($prt);
$totalprt = mysqli_num_rows($prt); 


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
                    
                    <section class="box-typical sidemenu">
                        <div class="profile-card">
                            <div class="profile-card-name"> This displays the proportional share to each beneficiary as it relates to the specific asset type.Share your assets by specifying percentage splits </div>

                    </section><!--.box-typical-->
                    
                    <section class="box-typical sidemenu">
                        <div class="profile-card">
                        <div class="profile-card-name"> Go to Dashboard</div> <br/>

                                <a href="dashboard.php"><button type="button" class="btn btn-inline btn-fcmb" > Go Back </button></a>
                                </div>

                    </section>

                </div><!--.col- -->

                <div class="col-lg-9 col-lg-push-3 col-md-12">
                <h3 class="with-border">Distribution of Assets </h3>
                                    
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

<?php if($url == 'assetdenied'){  ?>
<div class="alert alert-warning alert-fill alert-close alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <?php echo  ' One or more asset percentage sharing is not equal to 100%' ; ?>
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

<?php if($url == 'updated'){  ?>
<div class="alert alert-success alert-fill alert-close alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <?php echo  ' Update successful' ; ?>
</div>
<?php } ?>


<?php } ?>


            <form action="processor/process-validate-simplewill-percentage-sharing.php" method="post">
            <?php if ($totalprt != NULL) { ?>
            <?php //do { ?>
            <?php while ($row_prt = mysqli_fetch_assoc($prt)) { 
              $propertyid = $row_prt['id']; 
              //$propertytype = $row_prt['property_type']; 
              //$sharescompany = $row_prt['shares_company']; 
              //$insurancecompany = $row_prt['insurance_company']; 
              $bankname = $row_prt['bankname']; 
              $pensionname = $row_prt['pension_admin'];

              ?>
            <section class="card">
                <div class="card-block">
                    
<?php
$queryben = "SELECT `id`,`fullname`,`uid`,`rtionship` FROM simplewill_beneficiary WHERE uid = '$userid' ";
$ben = mysqli_query($conn, $queryben) or die(mysqli_error($conn));
$row_ben = mysqli_fetch_assoc($ben);
$totalben = mysqli_num_rows($ben);

?>
                
                     <h5 class="with-border">
                     <?php if ($row_prt['asset_type'] == 'bankaccount'){
                         echo $bankname;
                     }elseif ($row_prt['asset_type'] == 'pension'){
                         echo $pensionname;
                     } ?>
                     </h5>
                     <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Name</th>
                                            <th>Relationship</th>
                                            <th>Percentage</th>
                                            <th></th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                        <?php do { 
                                            $beneficiaryid = $row_ben['id'];
                                            $propertyid = $row_prt['id']; 
                                            $overallassetid = $row_ben['id'].''.$row_prt['id'];
                                            $querypercentage = "SELECT * FROM simplewill_overall_asset WHERE beneficiaryid = '$beneficiaryid' AND propertyid = '$propertyid' ";
                                            $percentage = mysqli_query($conn, $querypercentage) or die(mysqli_error($conn));
                                            $row_percentage = mysqli_fetch_assoc($percentage);
                                            $totalpercentage = mysqli_num_rows($percentage);
                                            //$overallassetid = $row_percentage['beneficiaryid'].''.$row_percentage['propertyid'];
                                         ?>
                                            <tr>
                                                <td> <?php echo $row_ben['fullname'];?></td>

                                                <td><?php if($row_ben['rtionship'] != NULL){
                                                    echo $row_ben['rtionship']; 
                                                 }else{
                                                    echo "Child";
                                                    } ?>
                                                </td>

                                                <td><?php echo $row_percentage['percentage'];?> %</td>
                                                <?php if($row_percentage['percentage'] == NULL){ ?>
                                               <td><button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#guardianmodal<?php echo $overallassetid; ?>">
                                                Add Percentage
                                                </button></td>
                                                <?php } ?>
                                                <?php if($row_percentage['percentage'] != NULL){ ?>
                                                <td><button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#guardianmodal<?php echo $overallassetid; ?>">
                                                Edit Percentage
                                                </button></td>
                                                <?php } ?>
                                            </tr>
                                        <?php } while ($row_ben = mysqli_fetch_assoc($ben)) ;?>
                                                                                </tbody>
                                    </table>
                                   <!--<strong><span style="color:red; padding-top:10px;">*</span> (Total Percentage sharing must be equal to 100%)</strong>-->
                        </div> 
                    </div><br>

                </div>
            </section>
<?php //} while ($row_prt = mysqli_fetch_assoc($prt)) ;?>
 <?php } ?>
            <?php } ?>
                    <input type="hidden" name="pid" value="<?php echo $row_prt['id'] ;?>" />
                    <input type="hidden" name="uid" value="<?php echo $userid ;?>" /> 
                    <input type="submit" value="Save and Proceed" class="btn btn-inline btn-fcmb" style="float:right;">
                </form>

                </div><!--.col- -->
            </div><!--.row-->
        </div><!--.container-fluid-->
    </div><!--.page-content-->




<?php  
$queryprt2 = "SELECT `id`,`uid` FROM simplewill_assets_tb WHERE uid = '$userid' ";
$prt2 = mysqli_query($conn, $queryprt2) or die(mysqli_error($conn));
//$row_prt2 = mysqli_fetch_assoc($prt2);
$totalprt2 = mysqli_num_rows($prt2); 
while ($row_prt2 = mysqli_fetch_assoc($prt2)) {
$propertyid2 = $row_prt2['id']; 

$querybenadd1 = "SELECT `id`,`fullname`,`uid`,`rtionship` FROM simplewill_beneficiary WHERE uid = '$userid' ";
$benadd1 = mysqli_query($conn, $querybenadd1) or die(mysqli_error($conn));
//$row_benadd1 = mysqli_fetch_assoc($benadd1);
$totalbenadd1 = mysqli_num_rows($benadd1);
    //do {
while ($row_benadd1 = mysqli_fetch_assoc($benadd1)) {
    $beneficiaryid2 = $row_benadd1['id']; 
    $propertyid2 = $row_prt2['id']; 
    $overallassetid2 = $row_benadd1['id'].''.$row_prt2['id'];
    $querypercentage2 = "SELECT * FROM simplewill_overall_asset WHERE beneficiaryid = '$beneficiaryid2' AND propertyid = '$propertyid2' ";
    $percentage2 = mysqli_query($conn, $querypercentage2) or die(mysqli_error($conn));
    $row_percentage2 = mysqli_fetch_assoc($percentage2);
    $totalpercentage2 = mysqli_num_rows($percentage2);
    //$overallassetid2 = $row_percentage2['beneficiaryid'].''.$row_percentage2['propertyid'];

?>
<div class="modal fade" id="guardianmodal<?php echo $overallassetid2;?>" tabindex="-1" role="dialog" aria-labelledby="guardianmodal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <?php if($row_percentage2['percentage'] == NULL){?>
        <h5 class="modal-title" id="exampleModalLongTitle">Add Percentage for <?php echo $row_benadd1['fullname'];?></h5>
      <?php } ?>

      <?php if($row_percentage2['percentage'] != NULL){?>
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Percentage for <?php echo $row_benadd1['fullname'];?></h5>
      <?php } ?>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-simplewill-addpercentage.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Percentage</label>
                                            <input type="text" name="percentage" class="form-control maxlength-simple" value="<?php echo $row_percentage2['percentage'];?>" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <input type="hidden" name="propertyid" value="<?php echo $row_prt2['id'] ; ?>"  /> 
                                    <input type="hidden" name="propertytype" value="Property"  /> 
                                    <input type="hidden" name="uid" value="<?php echo $userid; ?>"  /> 
                                    <input type="hidden" name="beneficiaryid" value="<?php echo $row_benadd1['id'];?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>

<?php //} while ($row_benadd1 = mysqli_fetch_assoc($benadd1));?>
<?php } ?>
<?php } ?>

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