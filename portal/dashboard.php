<?php require ('Connections/conn.php');
include ('session.php');

$query = "SELECT `uid` FROM personal_info WHERE `uid` = '$userid' ";
$pi = mysqli_query($conn, $query) or die(mysqli_error($conn));
$row_pi = mysqli_fetch_assoc($pi);
$rowpi = $row_pi['uid']; 

//ACCESS LEVEL FOR OTHER FORMS
$query = "SELECT * FROM access_level WHERE `uid` = '$userid' "; 
$ada = mysqli_query($conn, $query) or die(mysqli_error($conn));
$row_ada = mysqli_fetch_assoc($ada);
$rowaccess = $row_ada['access'];

//ACCESS LEVEL FOR SIMPLE WILL FORM
$queryaccesswill = "SELECT * FROM simplewill_access_level WHERE `uid` = '$userid' "; 
$accesswill = mysqli_query($conn, $queryaccesswill) or die(mysqli_error($conn));
$row_accesswill = mysqli_fetch_assoc($accesswill);

//ACCESS LEVEL FOR INVESTMENT FORM
$queryinvestment = "SELECT * FROM investment_access_level WHERE `uid` = '$userid' "; 
$investment = mysqli_query($conn, $queryinvestment) or die(mysqli_error($conn));
$row_investment = mysqli_fetch_assoc($investment);

//ACCESS LEVEL FOR RESERVE FORM
$queryreserve = "SELECT * FROM reserve_access_level WHERE `uid` = '$userid' "; 
$reserve = mysqli_query($conn, $queryreserve) or die(mysqli_error($conn));
$row_reserve = mysqli_fetch_assoc($reserve);

//ACCESS LEVEL FOR EDUCATION TRUST FORM
$queryeducation = "SELECT * FROM education_access_level WHERE `uid` = '$userid' "; 
$education = mysqli_query($conn, $queryeducation) or die(mysqli_error($conn));
$row_education = mysqli_fetch_assoc($education);

//EXTRA CHECK TO SHOW THE SUBMIT BUTTON FOR OTHER FORMS
$querywitness = "SELECT `id`,`uid` FROM witness_tb WHERE uid = '$userid' "; 
$witness = mysqli_query($conn, $querywitness) or die(mysqli_error($conn));
$totalwitness = mysqli_num_rows($witness);

//EXTRA CHECK TO SHOW THE SUBMIT BUTTON FOR SIMPLE WILL FORMS
$querysimplewitness = "SELECT `id`,`uid` FROM simplewill_witness_tb WHERE uid = '$userid' "; 
$simplewitness = mysqli_query($conn, $querysimplewitness) or die(mysqli_error($conn));
$totalsimplewitness = mysqli_num_rows($simplewitness);

//SHOWING THE WILL/ TRUST THAT WAS SELECTED.
$query1 = "SELECT * FROM willtype WHERE `uid` = '$userid' "; 
$wtp = mysqli_query($conn, $query1) or die(mysqli_error($conn));
$row_wtp = mysqli_fetch_assoc($wtp);
$willtyppe = $row_wtp['name']; 
$_SESSION['rowwtpname'] = $willtyppe; 

//CHECK IF PAYMENT HAS BEEN MADE FOR SIMPLE WILL.
$query_pay = "SELECT `id`,`uid`,`willtype` FROM payment_tb WHERE `uid` = '$userid' AND `willtype` = 'Simple Will' "; 
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
<body>

<?php include ('inc/inc_header.php');?>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-lg-pull-6 col-md-6 col-sm-6">
                    <?php include ('inc/inc_avatardashboard.php');?>
                    
                    <section class="box-typical sidemenu">
                        <div class="profile-card">
                            <div class="profile-card-name"> Select Service</div> <br/>

                                <a href="select-service.php"><button type="button" class="btn btn-inline btn-fcmb" > Go Back </button></a>
                        </div>
                    </section><!--.box-typical-->

                </div><!--.col- -->

<!--Display Simple Will Form Starts Here -->                 
    <?php if ($willtyppe == 'Simple Will' ) { ?>
                <div class="col-lg-9 col-lg-push-3 col-md-12">
                <div class="row">
                    <div class="col-lg-4 col-sm-6">

                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="prof/ile-card-photo">
                                <img src="images/icon/personal_information.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Personal <br> Information</div>
                            <?php if ($row_accesswill['access'] == NULL) {
                            echo '<a href="simplewill-personal-info.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>';
                        }elseif ($row_accesswill['access'] >= '1') {
                            echo '<a href="simplewill-personal-info.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>';
                        } ?>
                        </div>

                        </section>

                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="profil/e-card-photo">
                                <img src="images/icon/assets.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Add <br>Beneficiaries</div>
                                <?php if ($row_accesswill['access'] == '1') { ?>
                                    <?php echo '<a href="simplewill-beneficiary.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>'; ?>
                                <?php } ?>

                                <?php if ($row_accesswill['access'] > '1') { ?>
                                    <?php echo '<a href="simplewill-beneficiary.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>'; ?>
                                <?php } ?>
                        </div>

                        </section>
                    
                    </div>

                    <div class="col-lg-4 col-sm-6" title="is a person who participates in the validation of a Will">
                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="profil/e-card-photo">
                                <img src="images/icon/witness.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Add <br/> Representatives</div>
                            <?php if ($row_accesswill['access'] == '2') { ?>
                                    <?php echo '<a href="simplewill-add-witness.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>'; ?>
                                <?php } ?>

                                <?php if ($row_accesswill['access'] > '2') { ?>
                                    <?php echo '<a href="simplewill-add-witness.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>'; ?>
                                <?php } ?>
                        </div>

                        </section>
                    
                    </div>
                </div>

                <div class="row">

                    <?php if ($row_accesswill['access'] == '3' AND $totalpay !='1' ) { ?>
                        <?php if ($willtyppe == 'Simple Will') { ?>
                            <div class="col-lg-12 col-sm-12">
                                    <!--<a href="simplewill-preview.php"><button type="button" style="float:right;" class="btn btn-inline btn-fcmb">Proceed to submit your <?php echo $willtyppe; ?></button></a>-->
                                    <a href="simplewill-payment.php"><button type="button" style="float:right;" class="btn btn-inline btn-fcmb">Proceed to submit your <?php echo $willtyppe; ?></button></a>

                            </div>
                        <?php } ?>

                        
                    <?php } ?>
                    
                    
                    
                    <?php if ($row_accesswill['access'] == '3' AND $totalpay =='1' ) { ?>
                        <?php if ($willtyppe == 'Simple Will') { ?>
                            <div class="col-lg-12 col-sm-12">
                                    <a href="simplewill-preview.php"><button type="button" style="float:right;" class="btn btn-inline btn-fcmb">Preview my Will</button></a>

                            </div>
                        <?php } ?>

                        
                    <?php } ?>

                </div>

                </div>
    <?php } ?>
<!--Display Simple Will Form Ends Here --> 

<!--Display Premium Will Form Starts Here -->  
<?php if ($willtyppe == 'Premium Will') { ?>
                <div class="col-lg-9 col-lg-push-3 col-md-12">
                <div class="row">
                    <div class="col-lg-4 col-sm-6">

                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="prof/ile-card-photo">
                                <img src="images/icon/personal_information.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Personal <br> Information</div>
                            <?php if ($rowaccess == NULL) {
                            echo '<a href="personal-info.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>';
                        }elseif ($rowaccess >= '1') {
                            echo '<a href="edit-personal-info.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>';
                        } ?>
                        </div>

                        </section>

                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="profil/e-card-photo">
                                <img src="images/icon/assets.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Add <br>Assets</div>
                                <?php if ($rowaccess == '1') { ?>
                                    <?php echo '<a href="assets.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>'; ?>
                                <?php } ?>

                                <?php if ($rowaccess > '1') { ?>
                                    <?php echo '<a href="assets.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>'; ?>
                                <?php } ?>
                        </div>

                        </section>
                    
                    </div>

                    <div class="col-lg-4 col-sm-6" title="is appointed to carry out your instructions and wishes">
                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="prof/ile-card-photo">
                                <img src="images/icon/executor.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Add <br/>Executors</div>
                            <?php if ($rowaccess == '2') { ?>
                                    <?php echo '<a href="add-executor.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>'; ?>
                                <?php } ?>

                                <?php if ($rowaccess > '2') { ?>
                                    <?php echo '<a href="add-executor.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>'; ?>
                                <?php } ?>
                        </div><!--.profile-card-->

                        </section>

                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-sm-6" title="is a person or firm that holds your assets for benefit of others">
                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="prof/ile-card-photo">
                                <img src="images/icon/trustee.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Add <br/>Trustees</div>
                            <?php if ($rowaccess == '3') { ?>
                                    <?php echo '<a href="add-trustees.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>'; ?>
                                <?php } ?>

                                <?php if ($rowaccess > '3') { ?>
                                    <?php echo '<a href="add-trustees.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>'; ?>
                                <?php } ?>
                        </div><!--.profile-card-->

                        </section>

                    </div>

                    <div class="col-lg-4 col-sm-6" title="is a person who participates in the validation of a Will">
                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="profil/e-card-photo">
                                <img src="images/icon/witness.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Add <br/> Witnesses</div>
                            <?php if ($rowaccess == '4') { ?>
                                    <?php echo '<a href="add-witness.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>'; ?>
                                <?php } ?>

                                <?php if ($rowaccess > '4') { ?>
                                    <?php echo '<a href="add-witness.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>'; ?>
                                <?php } ?>
                        </div>

                        </section>
                    
                    </div>

                    <div class="col-lg-4 col-sm-6" title="to inform your family of certain things that you wish to have done">
                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="prof/ile-card-photo">
                                <img src="images/icon/special_wishes.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Special<br> Wishes</div>
                            <?php if ($rowaccess == '5') { ?>
                                    <?php echo '<a href="additional-information.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>'; ?>
                                <?php } ?>

                                <?php if ($rowaccess > '5') { ?>
                                    <?php echo '<a href="additional-information.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>'; ?>
                                <?php } ?>
                        </div><!--.profile-card-->

                        </section>

                    </div>

                    <?php if ($rowaccess == '6') { ?>
                        <?php if ($willtyppe == 'Premium Will') { ?>
                            <!--<div class="col-lg-12 col-sm-12">
                                    <a href="premiumwill-preview.php"><button type="button" style="float:right;" class="btn btn-inline btn-fcmb">Proceed to submit your <?php //echo $willtyppe; ?></button></a>

                            </div>-->
                            <div class="col-lg-12 col-sm-12">
                                    <a href="premiumwill-executors-power.php"><button type="button" style="float:right;" class="btn btn-inline btn-fcmb">Proceed to submit your <?php echo $willtyppe; ?></button></a>

                            </div>
                        <?php } ?>

                        
                    <?php } ?>

                </div>

                </div>
    <?php } ?>
 <!--Display Premium Will Form Ends Here -->    
    
    
<!--Display Comprehensive Will Form Starts Here -->  
    <?php if ($willtyppe == 'Comprehensive Will') { ?>
                <div class="col-lg-9 col-lg-push-3 col-md-12">
                <div class="row">
                    <div class="col-lg-4 col-sm-6">

                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="prof/ile-card-photo">
                                <img src="images/icon/personal_information.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Personal <br> Information</div>
                            <?php if ($rowaccess == NULL) {
                            echo '<a href="personal-info.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>';
                        }elseif ($rowaccess >= '1') {
                            echo '<a href="edit-personal-info.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>';
                        } ?>
                        </div>

                        </section>

                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="profil/e-card-photo">
                                <img src="images/icon/assets.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Add <br>Assets</div>
                                <?php if ($rowaccess == '1') { ?>
                                    <?php echo '<a href="assets.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>'; ?>
                                <?php } ?>

                                <?php if ($rowaccess > '1') { ?>
                                    <?php echo '<a href="assets.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>'; ?>
                                <?php } ?>
                        </div>

                        </section>
                    
                    </div>

                    <div class="col-lg-4 col-sm-6" title="is appointed to carry out your instructions and wishes">
                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="prof/ile-card-photo">
                                <img src="images/icon/executor.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Add <br/>Executors</div>
                            <?php if ($rowaccess == '2') { ?>
                                    <?php echo '<a href="add-executor.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>'; ?>
                                <?php } ?>

                                <?php if ($rowaccess > '2') { ?>
                                    <?php echo '<a href="add-executor.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>'; ?>
                                <?php } ?>
                        </div><!--.profile-card-->

                        </section>

                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-sm-6" title="is a person or firm that holds your assets for benefit of others">
                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="prof/ile-card-photo">
                                <img src="images/icon/trustee.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Add <br/>Trustees</div>
                            <?php if ($rowaccess == '3') { ?>
                                    <?php echo '<a href="add-trustees.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>'; ?>
                                <?php } ?>

                                <?php if ($rowaccess > '3') { ?>
                                    <?php echo '<a href="add-trustees.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>'; ?>
                                <?php } ?>
                        </div><!--.profile-card-->

                        </section>

                    </div>

                    <div class="col-lg-4 col-sm-6" title="is a person who participates in the validation of a Will">
                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="profil/e-card-photo">
                                <img src="images/icon/witness.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Add <br/> Witnesses</div>
                            <?php if ($rowaccess == '4') { ?>
                                    <?php echo '<a href="add-witness.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>'; ?>
                                <?php } ?>

                                <?php if ($rowaccess > '4') { ?>
                                    <?php echo '<a href="add-witness.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>'; ?>
                                <?php } ?>
                        </div>

                        </section>
                    
                    </div>

                    <div class="col-lg-4 col-sm-6" title="to inform your family of certain things that you wish to have done">
                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="prof/ile-card-photo">
                                <img src="images/icon/special_wishes.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Special<br> Wishes</div>
                            <?php if ($rowaccess == '5') { ?>
                                    <?php echo '<a href="additional-information.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>'; ?>
                                <?php } ?>

                                <?php if ($rowaccess > '5') { ?>
                                    <?php echo '<a href="additional-information.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>'; ?>
                                <?php } ?>
                        </div><!--.profile-card-->

                        </section>

                    </div>

                    <?php if ($rowaccess == '6') { ?>

                        <?php if ($willtyppe == 'Comprehensive Will') { ?>
                        
                            <!--<div class="col-lg-12 col-sm-12">
                                    <a href="comprehensivewill-preview.php"><button type="button" style="float:right;" class="btn btn-inline btn-fcmb">Proceed to submit your <?php //echo $willtyppe; ?></button></a>

                            </div>-->
                            <div class="col-lg-12 col-sm-12">
                                    <a href="comprehensivewill-executors-power.php"><button type="button" style="float:right;" class="btn btn-inline btn-fcmb">Proceed to submit your <?php echo $willtyppe; ?></button></a>

                            </div>
                        <?php } ?>

                        
                    <?php } ?>

                </div>

                </div>
    <?php } ?>
  <!--Display Comprehensive Will Form Ends Here -->   
    
<!--Display Estate Planning Questionnaire Form Starts Here -->   
    <?php if ($willtyppe == 'Estate Planning Questionnaire Form') { ?>
                <div class="col-lg-9 col-lg-push-3 col-md-12">
                <div class="row">
                    <div class="col-lg-4 col-sm-6">

                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="prof/ile-card-photo">
                                <img src="images/icon/personal_information.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Personal <br> Information</div>
                            <?php if ($rowaccess == NULL) {
                            echo '<a href="personal-info.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>';
                        }elseif ($rowaccess >= '1') {
                            echo '<a href="edit-personal-info.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>';
                        } ?>
                        </div>

                        </section>

                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="profil/e-card-photo">
                                <img src="images/icon/assets.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Add <br>Assets</div>
                                <?php if ($rowaccess == '1') { ?>
                                    <?php echo '<a href="assets.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>'; ?>
                                <?php } ?>

                                <?php if ($rowaccess > '1') { ?>
                                    <?php echo '<a href="assets.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>'; ?>
                                <?php } ?>
                        </div>

                        </section>
                    
                    </div>

                    <div class="col-lg-4 col-sm-6" title="is appointed to carry out your instructions and wishes">
                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="prof/ile-card-photo">
                                <img src="images/icon/executor.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Add <br/>Executors</div>
                            <?php if ($rowaccess == '2') { ?>
                                    <?php echo '<a href="add-executor.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>'; ?>
                                <?php } ?>

                                <?php if ($rowaccess > '2') { ?>
                                    <?php echo '<a href="add-executor.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>'; ?>
                                <?php } ?>
                        </div><!--.profile-card-->

                        </section>

                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-sm-6" title="is a person or firm that holds your assets for benefit of others">
                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="prof/ile-card-photo">
                                <img src="images/icon/trustee.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Add <br/>Trustees</div>
                            <?php if ($rowaccess == '3') { ?>
                                    <?php echo '<a href="add-trustees.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>'; ?>
                                <?php } ?>

                                <?php if ($rowaccess > '3') { ?>
                                    <?php echo '<a href="add-trustees.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>'; ?>
                                <?php } ?>
                        </div><!--.profile-card-->

                        </section>

                    </div>

                    <div class="col-lg-4 col-sm-6" title="is a person who participates in the validation of a Will">
                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="profil/e-card-photo">
                                <img src="images/icon/witness.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Add <br/> Witnesses</div>
                            <?php if ($rowaccess == '4') { ?>
                                    <?php echo '<a href="add-witness.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>'; ?>
                                <?php } ?>

                                <?php if ($rowaccess > '4') { ?>
                                    <?php echo '<a href="add-witness.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>'; ?>
                                <?php } ?>
                        </div>

                        </section>
                    
                    </div>

                    <div class="col-lg-4 col-sm-6" title="to inform your family of certain things that you wish to have done">
                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="prof/ile-card-photo">
                                <img src="images/icon/special_wishes.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Special<br> Wishes</div>
                            <?php if ($rowaccess == '5') { ?>
                                    <?php echo '<a href="additional-information.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>'; ?>
                                <?php } ?>

                                <?php if ($rowaccess > '5') { ?>
                                    <?php echo '<a href="additional-information.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>'; ?>
                                <?php } ?>
                        </div><!--.profile-card-->

                        </section>

                    </div>

                    <?php if ($rowaccess == '6') { ?>

                        <?php if ($willtyppe == 'Estate Planning Questionnaire Form') { ?>
                            <!--<div class="col-lg-12 col-sm-12">
                                    <a href="privatetrust-preview.php"><button type="button" style="float:right;" class="btn btn-inline btn-fcmb">Proceed to submit your <?php //echo $willtyppe; ?></button></a>

                            </div>-->
                            
                            <div class="col-lg-12 col-sm-12">
                                <a href="privatetrust-executors-power.php"><button type="button" style="float:right;" class="btn btn-inline btn-fcmb">Proceed to submit your <?php echo $willtyppe; ?></button></a>

                            </div>
                        <?php } ?>
                        
                    <?php } ?>

                </div>

                </div>
    <?php } ?>
 <!--Display Estate Planning Questionnaire Form Ends Here -->       

<!--Display Education Trust Form Starts Here --> 
        <?php if ($willtyppe == 'Education Trust Form' ) { ?>
                <div class="col-lg-9 col-lg-push-3 col-md-12">
                <div class="row">
                    <div class="col-lg-4 col-sm-6">

                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="prof/ile-card-photo">
                                <img src="images/icon/personal_information.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Personal <br> Information</div>
                            <?php if ($row_education['access'] == NULL) {
                            echo '<a href="education-personal-info.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>';
                        }elseif ($row_education['access'] >= '1') {
                            echo '<a href="education-personal-info.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>';
                        } ?>
                        </div>

                        </section>

                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="profil/e-card-photo">
                                <img src="images/icon/assets.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Add <br>Beneficiaries</div>
                                <?php if ($row_education['access'] == '1') { ?>
                                    <?php echo '<a href="education-beneficiary.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>'; ?>
                                <?php } ?>

                                <?php if ($row_education['access'] > '1') { ?>
                                    <?php echo '<a href="education-beneficiary.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>'; ?>
                                <?php } ?>
                        </div>

                        </section>
                    
                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="profil/e-card-photo">
                                <img src="images/icon/witness.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Trust Deed <br/> Creation Details</div>
                            <?php if ($row_education['access'] == '2') { ?>
                                    <?php echo '<a href="trust-deed.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>'; ?>
                                <?php } ?>

                                <?php if ($row_education['access'] > '2') { ?>
                                    <?php echo '<a href="trust-deed.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>'; ?>
                                <?php } ?>
                        </div>

                        </section>
                    
                    </div>
                </div>

                <div class="row">

                    <?php if ($row_education['access'] == 3 ) { ?>
                        
                        <?php if ($willtyppe == 'Education Trust Form') { ?>
                            <div class="col-lg-12 col-sm-12">
                                    <a href="educationtrustform-preview.php"><button type="button" style="float:right;" class="btn btn-inline btn-fcmb">Proceed to submit your <?php echo $willtyppe; ?></button></a>

                            </div>
                        <?php } ?>

                        
                    <?php } ?>

                </div>

                </div>
    <?php } ?>
<!--Display Education Trust Form Ends Here -->              

<!--Display Reserve Trust Form Starts Here --> 
        <?php if ($willtyppe == 'Reserve Trust Form') { ?>
                <div class="col-lg-9 col-lg-push-3 col-md-12">
                <div class="row">
                    <div class="col-lg-4 col-sm-6">

                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="prof/ile-card-photo">
                                <img src="images/icon/personal_information.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Personal <br> Information</div>
                            <?php if ($row_reserve['access'] == NULL) {
                            echo '<a href="reserve-personal-info.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>';
                        }elseif ($row_reserve['access'] >= 1) {
                            echo '<a href="reserve-personal-info.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>';
                        } ?>
                        </div>

                        </section>

                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="profil/e-card-photo">
                                <img src="images/icon/assets.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Request For <br>Investment Savings</div>
                                <?php if ($row_reserve['access'] == 1) { ?>
                                    <?php echo '<a href="reserve-request-savings.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>'; ?>
                                <?php } ?>

                                <?php if ($row_reserve['access'] > 1) { ?>
                                    <?php echo '<a href="reserve-request-savings.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>'; ?>
                                <?php } ?>
                        </div>

                        </section>
                    
                    </div>

                </div>

                <div class="row">

                    <?php if ($row_reserve['access'] == 2 ) { ?>

                        <?php if ($willtyppe == 'Reserve Trust Form') { ?>
                            <div class="col-lg-12 col-sm-12">
                                    <a href="reservetrustform-preview.php"><button type="button" style="float:right;" class="btn btn-inline btn-fcmb">Proceed to submit your <?php echo $willtyppe; ?></button></a>

                            </div>
                        <?php } ?>
                        
                    <?php } ?>

                </div>

                </div>
    <?php } ?>
    
    <!--Display Reserve Trust Form ends Here --> 
    
    <!--Display Investment Management Trust Form Starts Here --> 
        <?php if ($willtyppe == 'Investment Management Trust Form' ) { ?>
                <div class="col-lg-9 col-lg-push-3 col-md-12">
                <div class="row">
                    <div class="col-lg-4 col-sm-6">

                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="prof/ile-card-photo">
                                <img src="images/icon/personal_information.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Personal <br> Information</div>
                            <?php if ($row_investment['access'] == NULL) {
                            echo '<a href="investment-personal-info.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>';
                        }elseif ($row_investment['access'] >= 1) {
                            echo '<a href="investment-personal-info.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>';
                        } ?>
                        </div>

                        </section>

                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <section class="box-typical" style="height:300px;">
                        <div class="profile-card">
                            <div class="profil/e-card-photo">
                                <img src="images/icon/assets.png" alt=""/>
                            </div>
                            <div class="profile-card-name" style="padding:20px; color:#5C068C;">Request For <br>Investment Savings</div>
                                <?php if ($row_investment['access'] == 1) { ?>
                                    <?php echo '<a href="request-savings.php"><button type="button" class="btn btn-inline btn-fcmb">Get Started</button></a>'; ?>
                                <?php } ?>

                                <?php if ($row_investment['access'] > 1) { ?>
                                    <?php echo '<a href="request-savings.php"><button type="button" class="btn btn-inline btn-fcmb">EDIT</button></a>'; ?>
                                <?php } ?>
                        </div>

                        </section>
                    
                    </div>

                </div>

                <div class="row">

                    <?php if ($row_investment['access'] == '2') { ?>
                        
                        <?php if ($willtyppe == 'Investment Management Trust Form') { ?>
                            <div class="col-lg-12 col-sm-12">
                                    <a href="investmentmanagementtrustform-preview.php"><button type="button" style="float:right;" class="btn btn-inline btn-fcmb">Proceed to submit your <?php echo $willtyppe; ?></button></a>

                            </div>
                        <?php } ?>
                        
                    <?php } ?>

                </div>

                </div>
    <?php } ?>
    
    <!--Display Investment Management Trust Form ends Here --> 
                
                
                
                
                
                
                
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