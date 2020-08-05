<?php require ('Connections/conn.php');
include ('session.php');
if(!isset($userid)){
header('location:index.php');
exit();
}

$update = "UPDATE `willtype` SET `name` = 'Premium Will', `amount` = '35000' WHERE `uid` = '$userid' "; 
$update_run = mysqli_query($conn, $update) or die(mysqli_error($conn));
    
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

$querysp = "SELECT * FROM spouse_tb WHERE uid = '$userid' ";
$sp = mysqli_query($conn, $querysp) or die(mysqli_error($conn));
$row_sp = mysqli_fetch_assoc($sp);
$totalsp = mysqli_num_rows($sp);


$queryms = "SELECT * FROM marital_status WHERE uid = '$userid' ";
$ms = mysqli_query($conn, $queryms) or die(mysqli_error($conn));
$row_ms = mysqli_fetch_assoc($ms);
$totalms = mysqli_num_rows($ms);

$querydv = "SELECT `divorce`, `divorceyear`, `uid` FROM divorce_tb WHERE uid = '$userid' "; 
$dv = mysqli_query($conn, $querydv) or die(mysqli_error($conn));
$row_dv = mysqli_fetch_assoc($dv);
$totaldv = mysqli_num_rows($dv);

$querycd = "SELECT * FROM children_details WHERE uid = '$userid' ";
$cd = mysqli_query($conn, $querycd) or die(mysqli_error($conn));
$row_cd = mysqli_fetch_assoc($cd);
$totalcd = mysqli_num_rows($cd);
isset($startRow_pay)? $orderNum=$startRow_pay :$orderNum=0;

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
isset($startRow_exe)? $orderNumexe = $startRow_exe :$orderNumexe=0;

$querywit = "SELECT * FROM witness_tb WHERE uid = '$userid' "; 
$wit = mysqli_query($conn, $querywit) or die(mysqli_error($conn));
$row_wit = mysqli_fetch_assoc($wit);
$totalwit = mysqli_num_rows($wit);

$querytrt = "SELECT * FROM trustee_tb WHERE uid = '$userid' "; 
$trt = mysqli_query($conn, $querytrt) or die(mysqli_error($conn));
$row_trt = mysqli_fetch_assoc($trt);
$totaltrt = mysqli_num_rows($trt);
isset($startRow_trt)? $orderNumtrt = $startRow_trt :$orderNumtrt=0;

$querydoa1 = "SELECT * FROM shares_tb WHERE uid = '$userid' "; 
$doa1 = mysqli_query($conn, $querydoa1) or die(mysqli_error($conn));
$row_doa1 = mysqli_fetch_assoc($doa1);
$totaldoa1 = mysqli_num_rows($doa1);

$querywilltype = "SELECT `uid`,`name`,`amount` FROM willtype WHERE uid = '$userid' "; 
$willtype = mysqli_query($conn, $querywilltype) or die(mysqli_error($conn));
$row_willtype = mysqli_fetch_assoc($willtype);
$totalwilltype = mysqli_num_rows($willtype);
$willname = $row_willtype['name'];

$queryinfo = "SELECT * FROM addinfo_tb WHERE uid = '$userid' "; 
$info = mysqli_query($conn, $queryinfo) or die(mysqli_error($conn));
$row_info = mysqli_fetch_assoc($info);
$totalinfo = mysqli_num_rows($info);

$querypym = "SELECT `uid`, `willtype` FROM payment_tb WHERE uid = '$userid' AND `willtype` = 'Premium Will' "; 
$pym = mysqli_query($conn, $querypym) or die(mysqli_error($conn));
$row_pym = mysqli_fetch_assoc($pym);
$totalpym = mysqli_num_rows($pym);

$referrer = $_SERVER['HTTP_REFERER'];
if($referrer !== 'http://tisvdigital.com/trustees/portal/select-will.php') {
  header("location: 404.php");
}


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
<form>            
            <div class="row">
                <div class="col-lg-3 col-lg-pull-6 col-md-6 col-sm-6">
                    <?php include ('inc/inc_avatar.php');?>
<?php if ($totalpym < '1'){?>
                    <section class="box-typical sidemenu">
                        <div class="profile-card">

                                <a href="process-completed.php"><button type="button" class="btn btn-inline btn-fcmb" > Make Payment </button></a>
                                </div>

                    </section><!--.box-typical-->
<?php } ?>                   
                    
                    <section class="box-typical sidemenu">
                        <div class="profile-card">
                        <div class="profile-card-name"> Go to Dashboard</div> <br/>

                                <a href="dashboard.php"><button type="button" class="btn btn-inline btn-fcmb" > Go Back </button></a>
                                </div>

                    </section><!--.box-typical-->



                </div><!--.col- -->

                <div class="col-lg-9 col-lg-push-3 col-md-12">
                <h3 class="with-border">Premium Will </h3>
                <input type="hidden" name="willtype" value="<?php echo $row_willtype['name'];?>" />

                <section class="card">
                <div class="card-block">
                
                    <h5 class="with-border">Personal Data </h5>
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5 class="without-border">Full Name</h5>
                                <p><?php echo $salutation.' '.ucfirst($fname).' '.ucfirst($mname).' '.ucfirst($lname);?></p>
                                <input type="hidden" name="fullname" value="<?php echo $salutation.' '.ucfirst($fname).' '.ucfirst($mname).' '.ucfirst($lname);?>" />
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5 class="without-border">Address</h5>
                                <p><?php echo $msg;?></p>
                                <input type="hidden" name="addr" value="<?php echo $msg;?>" />
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Email Address</h5>
                                <p><?php echo $email ;?></p>
                                <input type="hidden" name="email" value="<?php echo $email ;?>" >
                            </fieldset>
                        </div>

                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Phone Number</h5>
                                <p><?php echo $phone ;?></p>
                                <input type="hidden" name="phone" value="<?php echo $phone ;?>" >
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Alt. Phone Number</h5>
                                <p><?php echo $aphone ;?></p>
                            <input type="hidden" name="aphone" value="<?php echo $row_pi['aphone'];?>" />
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Gender</h5>
                                <p><?php echo $row_pi['gender'];?></p>
                                <input type="hidden" name="gender" value="<?php echo $row_pi['gender'];?>" />
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Date Of Birth</h5>
                                <p><?php echo $dob ;?></p>
                                <input type="hidden" name="dob" value="<?php echo $dob ;?>" />
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">State Of Origin</h5>
                                <p><?php echo $row_pi['state'] ;?></p>  
                                <input type="hidden" name="state" value="<?php echo $row_pi['state'] ;?>" / >              
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Nationality</h5>
                                <p><?php echo $row_pi['nationality'] ;?></p>
                                <input type="hidden" name="nationality" value="<?php echo $row_pi['nationality'] ;?>" />
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">LGA</h5>
                                <p><?php echo $row_pi['lga'];?></p>
                                <input type="hidden" name="lga"  value="<?php echo $row_pi['lga'];?>" />
                            </fieldset>
                        </div>
                    </div>

                </div>
            </section>
            
            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Employment Details  </h5>
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5 class="without-border">Employment Status</h5>
                                <p><?php echo $row_pi['employment_status'];?></p>
                                <input type="hidden" name="employmentstatus" value="<?php echo $row_pi['employment_status'];?>" >
                            </fieldset>
                        </div>
                    </div>
            <?php if($row_pi['employment_status'] == 'Employed'){?>   
                     <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5 class="without-border">Employer</h5>
                                <p><?php echo $row_pi['employer'];?></p>
                                 <input type="hidden" name="employer" value="<?php echo $row_pi['employer'];?>" >
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5 class="without-border">Phone Number</h5>
                                <p><?php echo $row_pi['employerphone'];?></p>
                                <input type="hidden" name="employerphone" value="<?php echo $row_pi['employerphone'];?>" >
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5 class="without-border">Address</h5>
                                <p><?php echo $row_pi['employeraddr'];?></p>
                                <input type="hidden" name="employeraddr" value="<?php echo $row_pi['employeraddr'];?>" >
                            </fieldset>
                        </div>
                    </div>

        <?php } ?>            
                    
                </div>
            </section>


            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Marital Information  </h5>
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5 class="without-border">Marital Status</h5>
                                <p><?php echo $row_ms['status'];?></p>
                                <input type="hidden" name="maritalstatus" value="<?php echo $row_ms['status'];?>" >
                            </fieldset>
                        </div>
                    </div>
            <?php if($row_ms['status'] == 'Married'){?>   
            <p style="color:#5C068C;">Spouse Details </p>
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5 class="without-border">Full Name</h5>
                                <p><?php echo $row_sp['title'].' '.$row_sp['fullname'];?></p>
                                 <input type="hidden" name="spname" value="<?php echo $row_sp['title'].' '.$row_sp['fullname'];?>" >
                            </fieldset>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Email Address</h5>
                                <p><?php echo $row_sp['email'];?></p>
                                 <input type="hidden" name="spemail" value="<?php echo $row_sp['email'];?>" >
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Phone Number</h5>
                                <p><?php echo $row_sp['phoneno'];?></p>
                                <input type="hidden" name="spphone" value="<?php echo $row_sp['phoneno'];?>" >
                            </fieldset>
                        </div>

                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Date of Birth</h5>
                                <p><?php echo $row_sp['dob'];?></p>
                                <input type="hidden" name="sdob" value="<?php echo $row_sp['dob'];?>" / >
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5 class="without-border">Address</h5>
                                <p><?php echo $row_sp['addr'];?></p>
                                <input type="hidden" name="spaddr" value="<?php echo $row_sp['addr'];?>" >
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">City</h5>
                                <p><?php echo $row_sp['city'];?></p>
                                <input type="hidden" name="spcity" value="<?php echo $row_sp['city'];?>" >
                            </fieldset>
                        </div>

                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">State</h5>
                                <p><?php echo $row_sp['state'];?></p>
                                <input type="hidden" name="spstate" value="<?php echo $row_sp['state'];?>" >
                            </fieldset>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Marriage Type</h5>
                                <p><?php echo $row_sp['marriagetype'];?></p>
                                <input type="hidden" name="marriagetype" value="<?php echo $row_sp['marriagetype'];?>" >
                            </fieldset>
                        </div>

                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Marriage Year</h5>
                                <p><?php echo $row_sp['marriageyear'];?></p>
                                <input type="hidden" name="marriageyear" value="<?php echo $row_sp['marriageyear'];?>" >
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Marriage Certicate No.</h5>
                                <p><?php echo $row_sp['marriagecert'];?></p>
                                <input type="hidden" name="marriagecert" value="<?php echo $row_sp['marriagecert'];?>" >
                            </fieldset>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">City of Marriage</h5>
                                <p><?php echo $row_sp['citym'];?></p>
                                <input type="hidden" name="spcitym" value="<?php echo $row_sp['citym'];?>" >
                            </fieldset>
                        </div>

                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Country of Marriage</h5>
                                <p><?php echo $row_sp['countrym'];?></p>
                                <input type="hidden" name="spcountrym" value="<?php echo $row_sp['countrym'];?>" >
                            </fieldset>
                        </div>
                    </div>
        <?php } ?>            
                    
                </div>
            </section>
            
            <?php if ($totaldv != NULL) { ?>
            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Divorce </h5>
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5 class="without-border">Have you had any marriage which ended in divorce?</h5>
                                <p><?php echo $row_dv['divorce'] ;?></p>
                                <input type="hidden" name="divorce" value="<?php echo $row_dv['divorce'] ;?>"  >
                            </fieldset>
                        </div>
 
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5 class="without-border">If Yes, When was the divorce</h5>
                                <p><?php echo $row_dv['divorceyear'] ;?></p>
                                  <input type="hidden" name="divorceyear" value="<?php echo $row_dv['divorceyear'] ;?>" >
                            </fieldset>
                        </div>
                    </div>
                </div>
            </section>
            <?php } ?>

        <?php if ($totalcd != NULL) { ?> 
            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Children Information</h5>
                    <?php do { ?>
                    <h5 class="with-border">Child #<?php echo ++$orderNum?></h5>
                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Full Name</h5>
                                <p><?php echo $row_cd['name'];?></p>
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Date Of Birth</h5>
                                <p><?php echo $row_cd['dob'];?></p>
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Is the Child a minor?</h5>
                                <p><?php if ($row_cd['age'] < 18) {
                                                    echo "Yes";
                                                }else{
                                                    echo 'No';
                                                }

                                                ?></p>
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Guardian</h5>
                                <p><?php echo $row_cd['guardianname'];?></p> 
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5 class="without-border">Guardian Address</h5>
                                <p><?php echo $row_cd['addr'];?></p>
                            </fieldset>
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Guardian Email</h5>
                                <p><?php echo $row_cd['email'];?></p> 
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Guardian Phone Number</h5>
                                <p><?php echo $row_cd['phone'];?></p>
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Relationship</h5>
                                <p><?php echo $row_cd['rtionship'];?></p>
                            </fieldset>
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">City</h5>
                                <p><?php echo $row_cd['city'];?></p> 
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">State</h5>
                                <p><?php echo $row_cd['state'];?></p>
                            </fieldset>
                        </div>
                        
                    </div> <hr>
<?php } while ($row_cd = mysqli_fetch_assoc($cd));?> 
                </div>
            </section>
<?php } ?>

            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Asset Information </h5>

                    <?php if ($totalprt != NULL) {?>
                     <div class="row">
                        <div class="col-lg-12">
                        <?php do { 
                        $propertyid = $row_prt['id'];
                        ?>
                        <h5 class="without-border">Property (<?php echo $row_prt['property_type'];?>)</h5>
                        <p>Asset Description</p>
                            <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Type Of Property </th>
                                            <th>Location</th>
                                            <th>How Title is registered</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                        
                                            <tr>
                                                 <td><?php echo $row_prt['property_type'];?></td>
                                                <td> <?php echo $row_prt['property_location'];?></td>
                                               <td><?php echo $row_prt['property_registered'];?></td>
                                            </tr>
                                                                                </tbody>
                                    </table><br>
                                    
                                    <p>Percentage Sharing</p>
<?php                                    
$querydoa = "SELECT * FROM overall_asset WHERE propertyid = '$propertyid' "; 
$doa = mysqli_query($conn, $querydoa) or die(mysqli_error($conn));
$row_doa = mysqli_fetch_assoc($doa);
$totaldoa = mysqli_num_rows($doa);                                    
if ($totaldoa != NULL) { ?>
                     <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Beneficiary</th>
                                            <th>Percentage</th>
                                            <th>Alt. Beneficiary</th>
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
                                        
                                        $queryaltbeneficiary = "SELECT `id`, `uid`, `childid`, `title`, `fullname` FROM alt_beneficiary WHERE childid = '$beneficiaryname' "; 
                                        $query_alt = mysqli_query($conn, $queryaltbeneficiary) or die(mysqli_error($conn));
                                        $row_altbeneficiary = mysqli_fetch_assoc($query_alt);
 
                                         ?>
                                            <tr>
                                                <td><?php echo $row_beneficiaryname['fullname'];?></td>
                                                <td><?php echo $row_doa['percentage'];?>%</td>
                                        <td><?php if($row_altbeneficiary == TRUE){
                                        echo $row_altbeneficiary['fullname'];
                                        }else{
                                        echo 'Their Children';
                                        } ?></td>
                                            </tr>
                                        <?php } while ($row_doa = mysqli_fetch_assoc($doa));?>
                                                                                </tbody>
                                    </table>
                        </div>


                    </div><br><br>
                    <?php }?>

  
                                    
<?php } while ($row_prt = mysqli_fetch_assoc($prt));?>
                        </div>
                    </div><br>
                <?php } ?>


                <?php if ($totalshs != NULL) {

                    ?>
                    <div class="row">
                        <div class="col-lg-12">
                        
                         <?php do { 
                            $sharesid = $row_shs['id'];
                            ?>
                            <h5 class="without-border">Shares/ Stocks (<?php echo $row_shs['shares_company'];?>)</h5>
                        <p>Asset Description</p>
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
                                       
                                            <tr>
                                                <td> <?php echo $row_shs['shares_company'];?></td>
                                                <td><?php echo $row_shs['shares_volume'];?></td>
                                                <td><?php echo $row_shs['shares_percent'];?></td>
                                                <td><?php echo $row_shs['shares_cscs'];?></td>
                                                <td><?php echo $row_shs['shares_chn'];?></td>
                                            </tr>
                                            
                                                                                </tbody>
                                    </table><br>
                                    <p>Percentage Sharing</p>

<?php
$queryshares = "SELECT * FROM overall_asset WHERE propertyid = '$sharesid' "; 
$shares = mysqli_query($conn, $queryshares) or die(mysqli_error($conn));
$row_shares = mysqli_fetch_assoc($shares);
$totalshares = mysqli_num_rows($shares);
if ($totalshares != NULL) { ?>
                     <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                           
                                            <th>Beneficiary</th>
                                            <th>Percentage</th>
                                             <th>Alt. Beneficiary</th>
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

                                        $queryaltshares = "SELECT `id`, `uid`, `childid`, `title`, `fullname` FROM alt_beneficiary WHERE childid = '$sharesbeneficiary' "; 
                                        $query_altshares = mysqli_query($conn, $queryaltshares) or die(mysqli_error($conn));
                                        $row_altshares = mysqli_fetch_assoc($query_altshares);
 
                                         ?>
                                            <tr>
                                              
                                                <td><?php echo $row_sharesbeneficiary['fullname'];?></td>
                                                <td><?php echo $row_shares['percentage'];?>%</td>
                                                <td><?php if($row_altshares == TRUE){
                                                    echo $row_altshares['fullname'];
                                                    }else{
                                                    echo 'Their Children';
                                                    } ?></td>
                                            </tr>
                                        <?php } while ($row_shares = mysqli_fetch_assoc($shares));?>
                                                                                </tbody>
                                    </table>
                        </div>


                    </div><br><br>
                    <?php }?>
                                    <?php } while ($row_shs = mysqli_fetch_assoc($shs));?>
                        </div>
                    </div><br/>
                    <?php } ?>


                <?php if ($totalins != NULL) { ?>
                    <div class="row">
                        <div class="col-lg-12">
                        <?php do { 
                        $insuranceid =  $row_ins['id'];
                        ?>
                        <h5 class="without-border">Life Insurance (<?php echo $row_ins['insurance_company'];?>)</h5>
                        <p>Asset Description</p>
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
                                        
                                            <tr>
                                                <td><?php echo $row_ins['insurance_company'];?></td>
                                                <td><?php echo $row_ins['insurance_type'];?></td>
                                                <td><?php echo $row_ins['insurance_owner'];?></td>
                                                <td><?php echo $row_ins['insurance_facevalue'];?></td>
                                            </tr>
                                        
                                                                                </tbody>
                                    </table><br>
                                    <p>Percentage Sharing</p>
<?php
$queryinsurance = "SELECT * FROM overall_asset WHERE propertyid = '$insuranceid' "; 
$insurance = mysqli_query($conn, $queryinsurance) or die(mysqli_error($conn));
$row_insurance = mysqli_fetch_assoc($insurance);
$totalinsurance = mysqli_num_rows($insurance);
if ($totalinsurance != NULL) { ?>
                     <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Beneficiary</th>
                                            <th>Percentage</th>
                                            <th>Alt. Beneficiary</th>
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

                                        $queryaltinsurance = "SELECT `id`, `uid`, `childid`, `title`, `fullname` FROM alt_beneficiary WHERE childid = '$insurancebeneficiary' "; 
                                        $query_altinsurance = mysqli_query($conn, $queryaltinsurance ) or die(mysqli_error($conn));
                                        $row_altinsurance = mysqli_fetch_assoc($query_altinsurance);
 
                                         ?>
                                            <tr>
                                                <td><?php echo $row_insurancebeneficiary['fullname'];?></td>
                                                <td><?php echo $row_insurance['percentage'];?>%</td>
                                                <td><?php if($row_altinsurance == TRUE){
                                                    echo $row_altinsurance['fullname'];
                                                    }else{
                                                    echo 'Their Children';
                                                    } ?></td>
                                            </tr>
                                        <?php } while ($row_insurance = mysqli_fetch_assoc($insurance));?>
                                                                                </tbody>
                                    </table>
                        </div>


                    </div><br><br>
                    <?php }?>
                                    <?php } while ($row_ins = mysqli_fetch_assoc($ins)) ;?>
                        </div>
                    </div><br/>
                <?php } ?>

                <?php if ($totalbnk != NULL) { ?>
                    <div class="row">
                        <div class="col-lg-12">
                        <?php do { 
                        $bankaccountid = $row_bnk['id'];
                        ?>
                        <h5 class="without-border">Bank Account (<?php echo $row_bnk['bankname'];?>)</h5>
                        <p>Asset Description</p>
                            <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>BVN</th>
                                            <th>Bank Name</th>
                                            <th>Bank Account Name</th>
                                            <th>Bank Account Number</th>
                                            <th>Account Type</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                            <tr>
                                                <td> <?php echo $row_bnk['bvn'];?></td> 
                                                <td><?php echo $row_bnk['bankname'];?></td>
                                                <td><?php echo $row_bnk['account_name'];?></td>
                                                <td><?php echo $row_bnk['account_no'];?></td>
                                                <td><?php echo $row_bnk['accounttype'];?></td>
                                            </tr>
                                        
                                                                                </tbody>
                                    </table><br>
                                    <p>Percentage Sharing</p>
<?php 
$queryaccount = "SELECT * FROM overall_asset WHERE propertyid = '$bankaccountid' "; 
$account = mysqli_query($conn, $queryaccount) or die(mysqli_error($conn));
$row_account = mysqli_fetch_assoc($account);
$totalaccount = mysqli_num_rows($account);
if ($totalaccount != NULL) { ?>
                     <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Beneficiary</th>
                                            <th>Percentage</th>
                                            <th>Alt. Beneficiary</th>
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

                                        $queryaltbankdetails = "SELECT `id`, `uid`, `childid`, `title`, `fullname` FROM alt_beneficiary WHERE childid = '$accountbeneficiary' "; 
                                        $query_altbankdetails = mysqli_query($conn, $queryaltbankdetails ) or die(mysqli_error($conn));
                                        $row_altbankdetails = mysqli_fetch_assoc($query_altbankdetails);
 
                                         ?>
                                            <tr>
                                                <td><?php echo $row_accountbeneficiary['fullname'];?></td>
                                                <td><?php echo $row_account['percentage'];?>%</td>
                                                <td><?php if($row_altbankdetails == TRUE){
                                                    echo $row_altbankdetails['fullname'];
                                                    }else{
                                                    echo 'Their Children';
                                                    } ?></td>
                                            </tr>
                                        <?php } while ($row_account = mysqli_fetch_assoc($account));?>
                                                                                </tbody>
                                    </table>
                        </div>


                    </div><br><br>
                    <?php }?>
                                    <?php } while($row_bnk = mysqli_fetch_assoc($bnk));?>
                        </div>
                    </div> 
                    <?php } ?>                      
                            <br>

                <?php if ($totalpns != NULL) { ?>
                    <div class="row">
                        <div class="col-lg-12">

                        <?php do { 
                        $pensionid = $row_pns['id'];
                        ?>
                        <h5 class="without-border">Pension (<?php echo $row_pns['pension_name'];?>)</h5>
                        <p>Asset Description</p>
                            <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Name of Pension Provider</th>
                                            <th>Name of Pension Holder</th>
                                            <th>RSA Number</th>
                                            <th>Pension Fund Administrator</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                            <tr>
                                                <td><?php echo $row_pns['pension_name'];?></td>
                                                <td><?php echo $row_pns['pension_owner'];?></td>
                                                <td><?php echo $row_pns['rsano'] ;?></td>
                                                <td><?php echo $row_pns['pension_admin'] ;?></td>
                                            </tr>
                                       
                                                                                </tbody>
                                    </table><br>
                                    <p>Percentage Sharing</p>
<?php 
$querypension = "SELECT * FROM overall_asset WHERE propertyid = '$pensionid' "; 
$pension = mysqli_query($conn, $querypension) or die(mysqli_error($conn));
$row_pension = mysqli_fetch_assoc($pension);
$totalpension = mysqli_num_rows($pension);
                if ($totalpension != NULL) { ?>
                     <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            
                                            <th>Beneficiary</th>
                                            <th>Percentage</th>
                                            <th>Alt. Beneficiary</th>
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

                                        $queryaltpension = "SELECT `id`, `uid`, `childid`, `title`, `fullname` FROM alt_beneficiary WHERE childid = '$pensionbeneficiary' "; 
                                        $query_altpension = mysqli_query($conn, $queryaltpension ) or die(mysqli_error($conn));
                                        $row_altpension = mysqli_fetch_assoc($query_altpension);
 
                                         ?>
                                            <tr>
                                                <td><?php echo $row_pensionbeneficiary['fullname'];?></td>
                                                <td><?php echo $row_pension['percentage'];?>%</td>
                                                <td><?php if($row_altpension == TRUE){
                                                    echo $row_altpension['fullname'];
                                                    }else{
                                                    echo 'Their Children';
                                                    } ?></td>
                                            </tr>
                                        <?php } while ($row_pension = mysqli_fetch_assoc($pension));?>
                                                                                </tbody>
                                    </table>
                        </div>


                    </div><br><br>
                    <?php }?>
                                     <?php } while ($row_pns = mysqli_fetch_assoc($pns)) ;?>
                        </div>
                    </div><br/>
                <?php } ?>

                </div>
            </section>

            <?php if ($totalexe != NULL) {?>
            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Executors</h5>
                    <?php do { ?>
                    <p>Executor #<?php echo ++$orderNumexe?></p>
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5 class="without-border">Full Name</h5>
                                <p><?php echo $row_exe['fullname'];?></p>
                            </fieldset>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5 class="without-border">Contact Address</h5>
                                <p><?php echo $row_exe['addr'];?></p>
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Phone Number</h5>
                                <p><?php echo $row_exe['phone'];?></p>
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Email</h5>
                                <p><?php echo $row_exe['email'];?></p>
                            </fieldset>
                        </div>

                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Relationship</h5>
                                <p><?php echo $row_exe['rtionship'];?></p>
                            </fieldset>
                        </div>
                    </div> <hr>
                    <?php } while ($row_exe = mysqli_fetch_assoc($exe));?>

                </div>
            </section>
<?php } ?>


    <?php if ($totaltrt != NULL) { ?>
            <section class="card">
                <div class="card-block">
                     <h5 class="with-border">Trustees</h5>
                    <?php do { ?>
                        <p>Trustee #<?php echo ++$orderNumtrt?></p>
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5 class="without-border">Full Name</h5>
                                <p><?php echo $row_trt['fullname'];?></p>
                            </fieldset>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5 class="without-border">Contact Address</h5>
                                <p><?php echo $row_trt['addr'];?></p>
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Phone Number</h5>
                                <p><?php echo $row_trt['phone'];?></p>
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Email</h5>
                                <p><?php echo $row_trt['email'];?></p>
                            </fieldset>
                        </div>

                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Relationship</h5>
                                <p><?php echo $row_trt['rtionship'];?></p>
                            </fieldset>
                        </div>
                    </div> <hr>
<?php } while ($row_trt = mysqli_fetch_assoc($trt)) ;?>
                </div>
            </section>
<?php } ?>

                <?php if ($totalwit != NULL) { ?>
            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Witness Information</h5>
                <?php do { ?>
                        <p>Witness #<?php echo ++$orderNumwit?></p>
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5 class="without-border">Full Name</h5>
                                <p><?php echo $row_wit['fullname'];?></p>
                            </fieldset>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5 class="without-border">Contact Address</h5>
                                <p><?php echo $row_wit['addr'];?></p>
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Phone Number</h5>
                                <p><?php echo $row_wit['phone'];?></p>
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Email</h5>
                                <p><?php echo $row_wit['email'];?></p>
                            </fieldset>
                        </div>

                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Relationship</h5>
                                <p><?php echo $row_wit['rtionship'];?></p>
                            </fieldset>
                        </div>
                    </div> <hr>
<?php } while ($row_wit = mysqli_fetch_assoc($wit));?>

                </div>
            </section>
<?php } ?>


<?php if ($row_info['addinfo'] != NULL) { ?>
            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Special Wishes</h5>
                    <p><?php echo $row_info['addinfo'];?></p>
                    <input type="hidden" name="addinfo" value="<?php echo $row_info['addinfo'];?>">
                </div>
            </section>
<?php } ?>

                </div><!--.col- -->
                
                
            </div><!--.row-->
</form>
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
       key: 'pk_live_cb410844ca5a8c476f77d07a4156278d412e4f15',
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
    xhr.setRequestHeader('Authorization', 'Bearer sk_live_5205c257e251f1a7867191c337dacc1bed42b6ae'); 
  
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