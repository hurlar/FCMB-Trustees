<?php require ('Connections/conn.php');
include ('session.php');
if(!isset($userid)){
header('location:index.php');
exit();
}
$querypi = "SELECT * FROM personal_info WHERE uid = '$userid' ";
$pi = mysqli_query($conn, $querypi) or die(mysqli_error($conn));
$row_pi = mysqli_fetch_assoc($pi);
$salutation = $row_pi['salutation'];
$fname = $row_pi['fname'];
$mname = $row_pi['mname'];
$lname = $row_pi['lname'];
$msg = $row_pi['msg'];
$phone = $row_pi['phone'];
$aphone = $row_pi['aphone'];
$gender = $row_pi['gender'];
$dob = $row_pi['dob'];
$state = $row_pi['state'];
$nationality = $row_pi['nationality'];
$lga = $row_pi['lga'];

$queryusr = "SELECT email FROM users WHERE id = '$userid' ";
$usr = mysqli_query($conn, $queryusr) or die(mysqli_error($conn));
$row_usr = mysqli_fetch_assoc($usr);
$email = $row_usr['email'];
//$_SESSION['oldemail'] = $email;

$querysp = "SELECT `fullname`, `phoneno`, `addr`, `dob`, `marriageyear`, `marriagetype`, `marriagecert` FROM spouse_tb WHERE uid = '$userid' ";
$sp = mysqli_query($conn, $querysp) or die(mysqli_error($conn));
$row_sp = mysqli_fetch_assoc($sp);
$totalsp = mysqli_num_rows($sp);

$querycd = "SELECT * FROM children_details WHERE uid = '$userid' ";
$cd = mysqli_query($conn, $querycd) or die(mysqli_error($conn));
$row_cd = mysqli_fetch_assoc($cd);
$totalcd = mysqli_num_rows($cd);

$querygd = "SELECT * FROM guardian_tb WHERE uid = '$userid' ";
$gd = mysqli_query($conn, $querygd) or die(mysqli_error($conn));
$row_gd = mysqli_fetch_assoc($gd);
$totalgd = mysqli_num_rows($gd);

$queryprt = "SELECT * FROM assets_tb WHERE uid = '$userid' AND asset_type = 'property' ";
$prt = mysqli_query($conn, $queryprt) or die(mysqli_error($conn));
$row_prt = mysqli_fetch_assoc($prt);
$totalprt = mysqli_num_rows($prt);

$queryshs = "SELECT * FROM assets_tb WHERE uid = '$userid' AND asset_type = 'shares' "; 
$shs = mysqli_query($conn, $queryshs) or die(mysqli_error($conn));
$row_shs = mysqli_fetch_assoc($shs);
$totalshs = mysqli_num_rows($shs);

$queryins = "SELECT * FROM assets_tb WHERE uid = '$userid' AND asset_type = 'insurance' "; 
$ins = mysqli_query($conn, $queryins) or die(mysqli_error($conn));
$row_ins = mysqli_fetch_assoc($ins);
$totalins = mysqli_num_rows($ins);

$querybnk = "SELECT * FROM assets_tb WHERE uid = '$userid' AND asset_type = 'bankaccount' "; 
$bnk = mysqli_query($conn, $querybnk) or die(mysqli_error($conn));
$row_bnk = mysqli_fetch_assoc($bnk);
$totalbnk = mysqli_num_rows($bnk);

$querypns = "SELECT * FROM assets_tb WHERE uid = '$userid' AND asset_type = 'Pension' "; 
$pns = mysqli_query($conn, $querypns) or die(mysqli_error($conn));
$row_pns = mysqli_fetch_assoc($pns);
$totalpns = mysqli_num_rows($pns);

$queryexe = "SELECT * FROM executor_tb WHERE uid = '$userid' "; 
$exe = mysqli_query($conn, $queryexe) or die(mysqli_error($conn));
$row_exe = mysqli_fetch_assoc($exe);
$totalexe = mysqli_num_rows($exe);

$querywit = "SELECT * FROM witness_tb WHERE uid = '$userid' "; 
$wit = mysqli_query($conn, $querywit) or die(mysqli_error($conn));
$row_wit = mysqli_fetch_assoc($wit);
$totalwit = mysqli_num_rows($wit);

$querytrt = "SELECT * FROM trustee_tb WHERE uid = '$userid' "; 
$trt = mysqli_query($conn, $querytrt) or die(mysqli_error($conn));
$row_trt = mysqli_fetch_assoc($trt);
$totaltrt = mysqli_num_rows($trt);

$querydv = "SELECT `divorce`, `divorceyear`, `uid` FROM divorce_tb WHERE uid = '$userid' "; 
$dv = mysqli_query($conn, $querydv) or die(mysqli_error($conn));
$row_dv = mysqli_fetch_assoc($dv);
$totaldv = mysqli_num_rows($dv);

$querydoa = "SELECT * FROM overall_asset WHERE uid = '$userid' AND property_type = 'Property' "; 
$doa = mysqli_query($conn, $querydoa) or die(mysqli_error($conn));
$row_doa = mysqli_fetch_assoc($doa);
$totaldoa = mysqli_num_rows($doa);

$queryshares = "SELECT * FROM overall_asset WHERE uid = '$userid' AND property_type = 'Shares' "; 
$shares = mysqli_query($conn, $queryshares) or die(mysqli_error($conn));
$row_shares = mysqli_fetch_assoc($shares);
$totalshares = mysqli_num_rows($shares);

$queryinsurance = "SELECT * FROM overall_asset WHERE uid = '$userid' AND property_type = 'Insurance' "; 
$insurance = mysqli_query($conn, $queryinsurance) or die(mysqli_error($conn));
$row_insurance = mysqli_fetch_assoc($insurance);
$totalinsurance = mysqli_num_rows($insurance);

$queryaccount = "SELECT * FROM overall_asset WHERE uid = '$userid' AND property_type = 'Bank Account' "; 
$account = mysqli_query($conn, $queryaccount) or die(mysqli_error($conn));
$row_account = mysqli_fetch_assoc($account);
$totalaccount = mysqli_num_rows($account);

$querypension = "SELECT * FROM overall_asset WHERE uid = '$userid' AND property_type = 'Pension' "; 
$pension = mysqli_query($conn, $querypension) or die(mysqli_error($conn));
$row_pension = mysqli_fetch_assoc($pension);
$totalpension = mysqli_num_rows($pension);


$querydoa1 = "SELECT * FROM shares_tb WHERE uid = '$userid' "; 
$doa1 = mysqli_query($conn, $querydoa1) or die(mysqli_error($conn));
$row_doa1 = mysqli_fetch_assoc($doa1);
$totaldoa1 = mysqli_num_rows($doa1);

$queryinfo = "SELECT * FROM addinfo_tb WHERE uid = '$userid' "; 
$info = mysqli_query($conn, $queryinfo) or die(mysqli_error($conn));
$row_info = mysqli_fetch_assoc($info);
$totalinfo = mysqli_num_rows($info);

$ref = rand(1000,1000000) ;
$_SESSION['transactionid'] = $ref;
$amount = '110000';

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
                    
                    <section class="box-typical sidemenu">
                        <div class="profile-card">
                            <div class="profile-card-name"> Go to Dashboard</div> <br/>

                                <a href="dashboard.php"><button type="button" class="btn btn-inline btn-fcmb" > Go Back </button></a>
                            </div>
                    </section><!--.box-typical-->

                </div><!--.col- -->

                <div class="col-lg-9 col-lg-push-3 col-md-12">
                <h3 class="with-border">Estate Planning Questionnaire Form </h3>
                            <section class="card">
                <div class="card-block">
                                    <div class="alert alert-success" role="alert">
                    <p>
                        Thank you for completing your form. <br> A representative will contact you shortly.
                    </p>
                </div>
                    <h5 class="with-border">Personal Data </h5>
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5>Full Name</h5>
                                <p><?php echo $salutation.' '.ucfirst($fname).' '.ucfirst($mname).' '.ucfirst($lname);?></p>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5>Address</h5>
                                <p><?php echo $msg;?></p>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5>Email Address</h5>
                                <p><?php echo $email ;?></p>
                            </fieldset>
                        </div>

                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5>Phone Number</h5>
                                <p><?php echo $phone ;?></p>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5>Gender</h5>
                                <p><?php echo $row_pi['gender'];?></p>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5>Date Of Birth</h5>
                                <p><?php echo $dob ;?></p>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5>State Of Origin</h5>
                                <p><?php echo $row_pi['state'] ;?></p>                            
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5>Nationality</h5>
                                <p><?php echo $row_pi['nationality'] ;?></p>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5>LGA</h5>
                                <p><?php echo $row_pi['lga'];?></p>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </section>

            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Spouse Data  </h5>
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5>Full Name</h5>
                                <p><?php echo $row_sp['fullname'];?></p>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5>Address</h5>
                                <p><?php echo $row_sp['addr'];?></p>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5>Phone Number</h5>
                                <p><?php echo $row_sp['phoneno'];?></p>
                            </fieldset>
                        </div>

                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5>Date of Birth</h5>
                                <p><?php echo $row_sp['dob'];?></p>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </section>

        <?php if ($totalcd != NULL) { ?> 
            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Children  </h5>
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Full Name</th>
                                            <th>Date Of Birth </th>
                                            <th>Is the Child a minor?</th> 
                                          </tr>
                                        </thead>
                                        <tbody> 
                                        <?php do { ?>
                                            <tr>
                                                <td> <?php echo $row_cd['name'];?></td>
                                                <td><?php echo $row_cd['dob'];?></td>
                                                <td><?php if ($row_cd['age'] < 18) {
                                                    echo "Yes";
                                                }else{
                                                    echo 'No';
                                                }

                                                ?></td>
                                            </tr>
                                            <?php } while ($row_cd = mysqli_fetch_assoc($cd));?>
                                                                          </tbody>
                                    </table>
                        </div>
                    </div>
                </div>
            </section>
<?php } ?>

<?php if($totalsp != NULL) {?>
            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Declaration of Marriage </h5>
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5>Marriage Type</h5>
                                <p><?php echo $row_sp['marriagetype'] ;?></p>
                            </fieldset>
                        </div>

                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5>Marriage Year</h5>
                                <p><?php echo $row_sp['marriageyear'] ;?></p>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5>Marriage Certificate No</h5>
                                <p><?php echo $row_sp['marriagecert'] ;?></p>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </section>
<?php } ?>

<?php if ($totaldv != NULL) { ?>
            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Divorce </h5>
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5>Have you had any marriage which ended in divorce?</h5>
                                <p><?php echo $row_dv['divorce'] ;?></p>
                            </fieldset>
                        </div>
 
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5>If Yes, When was the divorce</h5>
                                <p><?php echo $row_dv['divorceyear'] ;?></p>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </section>
<?php } ?>

        <?php if($totalgd != NULL){ ?>  
            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Guardian Details  </h5>
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Phone Number</th>
                                            <th>Email</th>
                                            <th>Relationship</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                        <?php do { ?>
                                            <tr>
                                                <td> <?php echo $row_gd['fullname'];?></td>
                                                <td><?php echo $row_gd['addr'];?></td>
                                                <td><?php echo $row_gd['city'];?></td>
                                                <td><?php echo $row_gd['state'];?></td>
                                                <td><?php echo $row_gd['phone'];?></td>
                                                <td><?php echo $row_gd['email'];?></td>
                                                <td><?php echo $row_gd['rtionship'];?></td>
                                            </tr>
                                        <?php } while ($row_gd = mysqli_fetch_assoc($gd)) ;?>
                                                                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
<?php } ?>

 
            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Asset Information </h5>

                <?php if ($totalprt != NULL) {?>
                     <div class="row">
                        <div class="col-lg-12">
                        <h5>Property</h5>
                            <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Location</th>
                                            <th>Type of Property</th>
                                            <th>How title is registered</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                        <?php do { ?>
                                            <tr>
                                                <td> <?php echo $row_prt['property_location'];?></td>
                                                <td><?php echo $row_prt['property_type'];?></td>
                                                <td><?php echo $row_prt['property_registered'];?></td>
                                            </tr>
                                            <?php } while ($row_prt = mysqli_fetch_assoc($prt));?>
                                                                                </tbody>
                                    </table>
                        </div>
                    </div><br>
                <?php } ?>
                <?php if ($totalshs != NULL) {?>
                    <div class="row">
                        <div class="col-lg-12">
                        <h5>Shares / Stocks</h5>
                            <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Company</th>
                                            <th>Volume/ Value</th>
                                            <th>Percentage of shareholdings</th>
                                            <th>CSCS No. (If Applicable)</th>
                                            <th>Clearing House No. (CHN)</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                        <?php do { ?>
                                            <tr>
                                                <td> <?php echo $row_shs['shares_company'];?></td>
                                                <td><?php echo $row_shs['shares_volume'];?></td>
                                                <td><?php echo $row_shs['shares_percent'];?></td>
                                                <td><?php echo $row_shs['shares_cscs'];?></td>
                                                <td></td>
                                            </tr>
                                            <?php } while ($row_shs = mysqli_fetch_assoc($shs));?>
                                                                                </tbody>
                                    </table>
                        </div>
                    </div><br/>
                    <?php } ?>
                <?php if ($totalins != NULL) { ?>
                    <div class="row">
                        <div class="col-lg-12">
                        <h5>Life Insurance</h5>
                            <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Company</th>          
                                            <th>Type Of Policy</th>
                                            <th>Name of Policy Holder</th>
                                            <th>Face Value</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                        <?php do { ?>
                                            <tr>
                                                <td><?php echo $row_ins['insurance_company'];?></td>
                                                <td><?php echo $row_ins['insurance_type'];?></td>
                                                <td><?php echo $row_ins['insurance_owner'];?></td>
                                                <td><?php echo $row_ins['insurance_facevalue'];?></td>
                                            </tr>
                                        <?php } while ($row_ins = mysqli_fetch_assoc($ins)) ;?>
                                                                                </tbody>
                                    </table>
                        </div>
                    </div><br/>
                <?php } ?>
                <?php if ($totalbnk != NULL) { ?>
                    <div class="row">
                        <div class="col-lg-12">
                        <h5>Bank Account Details</h5>
                            <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>BVN</th>
                                            <th>Bank Name</th>
                                            <th>Bank Accunt Name</th>
                                            <th>Bank Account Number</th>
                                            <th>Account Type</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                        <?php do { ?>
                                            <tr>
                                                <td> <?php echo $row_bnk['bvn'];?></td> 
                                                <td><?php echo $row_bnk['bankname'];?></td>
                                                <td><?php echo $row_bnk['account_name'];?></td>
                                                <td><?php echo $row_bnk['account_no'];?></td>
                                                <td><?php echo $row_bnk['accounttype'];?></td>
                                            </tr>
                                        <?php } while($row_bnk = mysqli_fetch_assoc($bnk));?>
                                                                                </tbody>
                                    </table>
                        </div>
                    </div> 
                    <?php } ?>                      
                            <br>
                <?php if ($totalpns != NULL) { ?>
                    <div class="row">
                        <div class="col-lg-12">
                        <h5>Pension</h5>
                            <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Name of Pension Provider</th>          
                                            <th>Name of Pension Holder</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                        <?php do { ?>
                                            <tr>
                                                <td><?php echo $row_pns['pension_name'];?></td>
                                                <td><?php echo $row_pns['pension_owner'];?></td>
                                            </tr>
                                        <?php } while ($row_pns = mysqli_fetch_assoc($pns)) ;?>
                                                                                </tbody>
                                    </table>
                        </div>
                    </div><br/>
                <?php } ?>
                </div>
            </section>

            <?php if ($row_pns['pension_plan'] == 'Yes') { ?>
            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Employee Benefits Pension </h5>
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5>RSA Number</h5>
                                <p><?php echo $row_pns['rsano'] ;?></p>
                            </fieldset>
                        </div>

                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5>Pension Fund Administrator</h5>
                                <p><?php echo $row_pns['pension_admin'] ;?></p>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </section>
<?php } ?>

            <?php if ($totalexe != NULL) {?>
            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Executors</h5>
                                         <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Name</th>
                                            <th>Relationship to you</th> 
                                            <th>Contact Address</th>
                                            <th>Phone Number</th>
                                            <th>Email</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                        <?php do { ?>
                                            <tr>
                                                <td> <?php echo $row_exe['fullname'];?></td>
                                                <td><?php echo $row_exe['rtionship'];?></td>
                                                <td><?php echo $row_exe['addr'];?></td>
                                                <td><?php echo $row_exe['phone'];?></td>
                                                <td><?php echo $row_exe['email'];?></td>
                                            </tr>
                                        <?php } while ($row_exe = mysqli_fetch_assoc($exe));?>
                                                                                </tbody>
                                    </table>
                        </div>
                    </div>
                </div>
            </section>
<?php } ?>


    <?php if ($totaltrt != NULL) { ?>
            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Trustees</h5>
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Name</th>
                                            <th>Relationship to you</th> 
                                            <th>Contact Address</th>
                                            <th>Phone Number</th>
                                            <th>Email</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                        <?php do { ?>
                                            <tr>
                                                <td> <?php echo $row_trt['fullname'];?></td>
                                                <td><?php echo $row_trt['rtionship'];?></td>
                                                <td><?php echo $row_trt['addr'];?></td>
                                                <td><?php echo $row_trt['phone'];?></td>
                                                <td><?php echo $row_trt['email'];?></td>
                                            </tr>
                                        <?php } while ($row_trt = mysqli_fetch_assoc($trt)) ;?>
                                                                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
<?php } ?>


            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Distribution of Assets</h5>
                    <?php if ($totaldoa != NULL) { ?>
                     <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Asset (<?php echo $row_doa['property_type']?>)</th>
                                            <th>Beneficiary</th>
                                            <th>Percentage</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                        <?php do { 
                                        $assetid = $row_doa['propertyid'];
                                        $queryprtname = "SELECT `id`, `asset_type`, `property_type` FROM assets_tb WHERE id = '$assetid' "; 
                                        $prtname = mysqli_query($conn, $queryprtname) or die(mysqli_error($conn));
                                        $row_prtname = mysqli_fetch_assoc($prtname);

                                        $beneficiaryname = $row_doa['beneficiaryid'];
                                        $querybeneficiaryname = "SELECT `id`, `fullname` FROM beneficiary_dump WHERE id = '$beneficiaryname' "; 
                                        $query_run = mysqli_query($conn, $querybeneficiaryname) or die(mysqli_error($conn));
                                        $row_beneficiaryname = mysqli_fetch_assoc($query_run);
 
                                         ?>
                                            <tr>
                                                <td><?php echo $row_prtname['property_type'];?></td>
                                                <td><?php echo $row_beneficiaryname['fullname'];?></td>
                                                <td><?php echo $row_doa['percentage'];?></td>
                                            </tr>
                                        <?php } while ($row_doa = mysqli_fetch_assoc($doa));?>
                                                                                </tbody>
                                    </table>
                        </div>


                    </div><br>
                    <?php }?>

                    <?php if ($totalshares != NULL) { ?>
                     <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Asset (<?php echo $row_shares['property_type']?>)</th>
                                            <th>Beneficiary</th>
                                            <th>Percentage</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                        <?php do { 
                                        $sharesid = $row_shares['propertyid'];
                                        $querysharesname = "SELECT `id`, `asset_type`, `shares_company` FROM assets_tb WHERE id = '$sharesid' "; 
                                        $sharesname = mysqli_query($conn, $querysharesname) or die(mysqli_error($conn));
                                        $row_sharesname = mysqli_fetch_assoc($sharesname);

                                        $sharesbeneficiary = $row_shares['beneficiaryid'];
                                        $querysharesbeneficiary = "SELECT `id`, `fullname` FROM beneficiary_dump WHERE id = '$sharesbeneficiary' "; 
                                        $query_run1 = mysqli_query($conn, $querysharesbeneficiary) or die(mysqli_error($conn));
                                        $row_sharesbeneficiary = mysqli_fetch_assoc($query_run1);
 
                                         ?>
                                            <tr>
                                                <td><?php echo $row_sharesname['shares_company'];?></td>
                                                <td><?php echo $row_sharesbeneficiary['fullname'];?></td>
                                                <td><?php echo $row_shares['percentage'];?></td>
                                            </tr>
                                        <?php } while ($row_shares = mysqli_fetch_assoc($shares));?>
                                                                                </tbody>
                                    </table>
                        </div>


                    </div><br>
                    <?php }?>

                                        <?php if ($totalinsurance != NULL) { ?>
                     <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Asset (<?php echo $row_insurance['property_type']?>)</th>
                                            <th>Beneficiary</th>
                                            <th>Percentage</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                        <?php do { 
                                        $insuranceid = $row_insurance['propertyid'];
                                        $queryinsurancename = "SELECT `id`, `insurance_company` FROM assets_tb WHERE id = '$insuranceid' "; 
                                        $insurancename = mysqli_query($conn, $queryinsurancename) or die(mysqli_error($conn));
                                        $row_insurancename = mysqli_fetch_assoc($insurancename);

                                        $insurancebeneficiary = $row_insurance['beneficiaryid'];
                                        $queryinsurancebeneficiary = "SELECT `id`, `fullname` FROM beneficiary_dump WHERE id = '$insurancebeneficiary' "; 
                                        $query_run2 = mysqli_query($conn, $queryinsurancebeneficiary) or die(mysqli_error($conn));
                                        $row_insurancebeneficiary = mysqli_fetch_assoc($query_run2);
 
                                         ?>
                                            <tr>
                                                <td><?php echo $row_insurancename['insurance_company'];?></td>
                                                <td><?php echo $row_insurancebeneficiary['fullname'];?></td>
                                                <td><?php echo $row_insurance['percentage'];?></td>
                                            </tr>
                                        <?php } while ($row_insurance = mysqli_fetch_assoc($insurance));?>
                                                                                </tbody>
                                    </table>
                        </div>


                    </div><br>
                    <?php }?>

                                        <?php if ($totalaccount != NULL) { ?>
                     <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Asset (<?php echo $row_account['property_type']?>)</th>
                                            <th>Beneficiary</th>
                                            <th>Percentage</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                        <?php do { 
                                        $accountid = $row_account['propertyid'];
                                        $queryaccountname = "SELECT `id`, `bankname` FROM assets_tb WHERE id = '$accountid' "; 
                                        $accountname = mysqli_query($conn, $queryaccountname) or die(mysqli_error($conn));
                                        $row_accountname = mysqli_fetch_assoc($accountname);

                                        $accountbeneficiary = $row_account['beneficiaryid'];
                                        $queryaccountbeneficiary = "SELECT `id`, `fullname` FROM beneficiary_dump WHERE id = '$accountbeneficiary' "; 
                                        $query_run3 = mysqli_query($conn, $queryaccountbeneficiary) or die(mysqli_error($conn));
                                        $row_accountbeneficiary = mysqli_fetch_assoc($query_run3);
 
                                         ?>
                                            <tr>
                                                <td><?php echo $row_accountname['bankname'];?></td>
                                                <td><?php echo $row_accountbeneficiary['fullname'];?></td>
                                                <td><?php echo $row_account['percentage'];?></td>
                                            </tr>
                                        <?php } while ($row_account = mysqli_fetch_assoc($account));?>
                                                                                </tbody>
                                    </table>
                        </div>


                    </div><br>
                    <?php }?>

                                        <?php if ($totalpension != NULL) { ?>
                     <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Asset (<?php echo $row_pension['property_type']?>)</th>
                                            <th>Beneficiary</th>
                                            <th>Percentage</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                        <?php do { 
                                        $pensionid = $row_pension['propertyid'];
                                        $querypensionname = "SELECT `id`, `asset_type`, `pension_name` FROM assets_tb WHERE id = '$pensionid' "; 
                                        $pensionname = mysqli_query($conn, $querypensionname) or die(mysqli_error($conn));
                                        $row_pensionname = mysqli_fetch_assoc($pensionname);

                                        $pensionbeneficiary = $row_pension['beneficiaryid'];
                                        $querypensionbeneficiary = "SELECT `id`, `fullname` FROM beneficiary_dump WHERE id = '$pensionbeneficiary' "; 
                                        $query_run4 = mysqli_query($conn, $querypensionbeneficiary) or die(mysqli_error($conn));
                                        $row_pensionbeneficiary = mysqli_fetch_assoc($query_run4);
 
                                         ?>
                                            <tr>
                                                <td><?php echo $row_pensionname['pension_name'];?></td>
                                                <td><?php echo $row_pensionbeneficiary['fullname'];?></td>
                                                <td><?php echo $row_pension['percentage'];?></td>
                                            </tr>
                                        <?php } while ($row_pension = mysqli_fetch_assoc($pension));?>
                                                                                </tbody>
                                    </table>
                        </div>


                    </div><br>
                    <?php }?>


                </div>
            </section>

<?php if ($row_info['addinfo'] != NULL) { ?>
            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Special Wishes</h5>
                    <p><?php echo $row_info['addinfo'];?></p>
                </div>
            </section>
<?php } ?>

                </div><!--.col- -->
            </div><!--.row-->
        </div><!--.container-fluid-->
    </div><!--.page-content-->


<!-- STARTS HERE-->
    <script
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>

<?php 



//$mobile = $_SESSION['custphone'] ;  
//$email =  $_SESSION['custemail'];  
$value = $amount * 100 ;  
$_SESSION['value'] = $value/100 ; 
//$_SESSION['amount'] = $value/100 ;

//key: 'pk_test_82ee676981dab8c58bab2d4c664522e0601b877f', 
//xhr.setRequestHeader('Authorization', 'Bearer sk_test_3f82be4a79b55cd6988736fa8b303810ea9f82d4'); 

//key: 'pk_live_e9e2a18b4bd6baf581f09e72f5be61fbe3865ee7', 
//xhr.setRequestHeader('Authorization', 'Bearer sk_live_05f513364d0e4b7acde31a8f1b73b68ad567a14e'); 
?>



<!------- Back Here ----------> 





 
<script>
  function payWithPaystack(){
    var handler = PaystackPop.setup({
       key: 'pk_test_13a6d3f0829d0f3a60c1e6a526cf84302d448271',
      email: '<?php echo $email ; ?>',
      amount: "<?php echo $value ; ?>",
      ref: "<?php echo $ref ; ?>",
      metadata: {
         custom_fields: [
            {
                display_name: "Mobile Number",
                variable_name: "mobile_number",
                value: "<?php echo $mobile ; ?>"
            }
         ]
      },
      callback: function(response){
var trans_ref = response.reference;
          //alert('success. transaction ref is ' + response.reference);

$.ajax({
url:  'https://api.paystack.co/transaction/verify/'+trans_ref,
type: 'GET',
beforeSend: function (xhr) {
    xhr.setRequestHeader('Authorization', 'Bearer sk_test_29743cfc317b21e129a5acb577c6c95f1be2c773'); 
  
},
data: {},
success: function (result) {
//var result = JSON.parse(result);
console.log(result);
 if (result.data.status == "success") {
        var    paid = result.data.amount/100,

//Since payment was confirmed, you can use the trans_ref and amount paid to credit the database of the user.
    trans_ref = trans_ref,
    user_id = user_id,
            amount =  paid;

window.location ='processor-paystack.php';

//window.location ='https://tisvdigital.com/processor-paystack.php?transact_ref=<?php echo  $ref ;?>';

        }else{
           $('#paymentstatus').html('Payment Error, try again')

        }
        //return  $result; 
},
error: function () { },
});


      },
      onClose: function(){
          alert('window closed');
      }
    });
    handler.openIframe();
  }
</script>
<!-- ENDS HERE-->


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