<?php require ('Connections/conn.php');
include ('session.php');
if(!isset($userid)){
header('location:index.php');
exit();
}

$update1 = "UPDATE `willtype` SET `name` = 'Simple Will',`amount` = '10500' WHERE `uid` = '$userid' "; 
$update_run1 = mysqli_query($conn, $update1) or die(mysqli_error($conn));


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

$querynextofkin = "SELECT * FROM nextofkin WHERE uid = '$userid' ";
$nextofkin = mysqli_query($conn, $querynextofkin) or die(mysqli_error($conn));
$row_nextofkin = mysqli_fetch_assoc($nextofkin);
$totalnextofkin = mysqli_num_rows($nextofkin);
//isset($startRow_pay)? $orderNum=$startRow_pay :$orderNum=0

$querybeneficiarydump = "SELECT * FROM beneficiary_dump WHERE uid = '$userid' ";
$beneficiarydump = mysqli_query($conn, $querybeneficiarydump) or die(mysqli_error($conn));
$row_beneficiarydump = mysqli_fetch_assoc($beneficiarydump);
$totalbeneficiarydump = mysqli_num_rows($beneficiarydump);
isset($startRow_pay)? $orderNum=$startRow_pay :$orderNum=0;

$querybnk = "SELECT * FROM simplewill_assets_tb WHERE uid = '$userid' AND asset_type = 'bankaccount' "; 
$bnk = mysqli_query($conn, $querybnk) or die(mysqli_error($conn));
$row_bnk = mysqli_fetch_assoc($bnk);
$totalbnk = mysqli_num_rows($bnk);

$querypns = "SELECT * FROM simplewill_assets_tb WHERE uid = '$userid' AND asset_type = 'pension' "; 
$pns = mysqli_query($conn, $querypns) or die(mysqli_error($conn));
$row_pns = mysqli_fetch_assoc($pns);
$totalpns = mysqli_num_rows($pns);

$querywit = "SELECT * FROM witness_tb WHERE uid = '$userid' "; 
$wit = mysqli_query($conn, $querywit) or die(mysqli_error($conn));
$row_wit = mysqli_fetch_assoc($wit);
$totalwit = mysqli_num_rows($wit);

//gets the will/ form type the users selects after the create will/ create trust page.
$querywilltype = "SELECT `uid`,`name`,`amount` FROM willtype WHERE uid = '$userid' "; 
$willtype = mysqli_query($conn, $querywilltype) or die(mysqli_error($conn));
$row_willtype = mysqli_fetch_assoc($willtype);
$totalwilltype = mysqli_num_rows($willtype);
$willname = $row_willtype['name']; 

$querypym = "SELECT `uid`, `willtype` FROM payment_tb WHERE uid = '$userid' AND `willtype` = 'Simple Will' "; 
$pym = mysqli_query($conn, $querypym) or die(mysqli_error($conn));
$row_pym = mysqli_fetch_assoc($pym);
$totalpym = mysqli_num_rows($pym);

//$querypmt = "SELECT `id`, `uid`, `willtype` FROM preview_will WHERE uid = '$userid' AND  `willtype` = '$willname' ";
//$pmt = mysqli_query($conn, $querypmt) or die(mysqli_error($conn));
//$row_pmt = mysqli_fetch_assoc($pmt);
//$totalpmt = mysqli_num_rows($pmt);

//$ref = rand(1000,1000000) ;
//$_SESSION['transactionid'] = $ref;
//$amount = '35625';
//$referrer = $_SERVER['HTTP_REFERER'];

//if($referrer !== 'http://tisvdigital.com/trustees/portal/dashboard.php') {
  //header("location: 404.php");
//}

//$valid_domains = array(
  //  'http://tisvdigital.com/trustees/portal/dashboard.php',
    //'http://tisvdigital.com/trustees/portal/simple-will.php',
//);

// The checking for valid domain
//if (!in_array($_SERVER['HTTP_REFERER'], $valid_domains) ){
  //    header("location: 404.php");
//}


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

<?php if ($totalpym < '1'){?>
                    <section class="box-typical sidemenu">
                        <div class="profile-card">

                                <a href="simplewill-payment.php"><button type="button" class="btn btn-inline btn-fcmb" > Make Payment </button></a>
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
                <h3 class="with-border"> Simple Will<?php //echo $row_willtype['name'];?> </h3>

                <section class="card">
                <div class="card-block">
                
                    <h5 class="with-border">Personal Data </h5>
                    <!--<div class="row">
                        <div class="col-lg-12">
                            <img src="uploads/passport/<?php //echo $row_pi['passport'];?>" style="height:250px; width:250px;" />
                        </div>
                    </div> <br/>-->
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
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5 class="without-border">Mother's Maiden Name</h5>
                                <p><?php echo $row_pi['maidenname'] ;?></p>
                                <input type="hidden" name="maidenname" value="<?php echo $row_pi['maidenname'] ;?>" />
                            </fieldset>
                        </div>
                    </div>

                </div>
            </section>
            
            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Means of Identification  </h5>
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5 class="without-border">Identification Type</h5>
                                <p><?php echo $row_pi['identification_type'];?></p>
                                <input type="hidden" name="identificationtype" value="<?php echo $row_pi['identification_type'];?>" >
                            </fieldset>
                        </div>
                    </div>
 
                     <div class="row">
                        <div class="col-lg-3">
                            <fieldset class="form-group">
                                <h5 class="without-border">ID Number</h5>
                                <p><?php echo $row_pi['identification_number'];?></p>
                                 <input type="hidden" name="idnumber" value="<?php echo $row_identification['identification_number'];?>" >
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-3">
                            <fieldset class="form-group">
                                <h5 class="without-border">Issue Date</h5>
                                <p><?php echo $row_pi['issuedate'];?></p>
                                <input type="hidden" name="issuedate" value="<?php echo $row_identification['issuedate'];?>" >
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-3">
                            <fieldset class="form-group">
                                <h5 class="without-border">Expiry Date</h5>
                                <p><?php echo $row_pi['expirydate'];?></p>
                                <input type="hidden" name="expirydate" value="<?php echo $row_identification['expirydate'];?>" >
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-3">
                            <fieldset class="form-group">
                                <h5 class="without-border">Issue Place</h5>
                                <p><?php echo $row_pi['issuedplace'];?></p>
                                <input type="hidden" name="issueplace" value="<?php echo $row_identification['issueplace'];?>" >
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
                                 <input type="hidden" name="spousename" value="<?php echo $row_sp['title'].' '.$row_sp['fullname'];?>" >
                            </fieldset>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Email Address</h5>
                                <p><?php echo $row_sp['email'];?></p>
                                 <input type="hidden" name="spouseemail" value="<?php echo $row_sp['email'];?>" >
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Phone Number</h5>
                                <p><?php echo $row_sp['phoneno'];?></p>
                                <input type="hidden" name="spousephone" value="<?php echo $row_sp['phoneno'];?>" >
                            </fieldset>
                        </div>

                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Date of Birth</h5>
                                <p><?php echo $row_sp['dob'];?></p>
                                <input type="hidden" name="spousedob" value="<?php echo $row_sp['dob'];?>" / >
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5 class="without-border">Address</h5>
                                <p><?php echo $row_sp['addr'];?></p>
                                <input type="hidden" name="spouseaddr" value="<?php echo $row_sp['addr'];?>" >
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">City</h5>
                                <p><?php echo $row_sp['city'];?></p>
                                <input type="hidden" name="spousecity" value="<?php echo $row_sp['city'];?>" >
                            </fieldset>
                        </div>

                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">State</h5>
                                <p><?php echo $row_sp['state'];?></p>
                                <input type="hidden" name="spousestate" value="<?php echo $row_sp['state'];?>" >
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
                                <input type="hidden" name="cityofmarriage" value="<?php echo $row_sp['citym'];?>" >
                            </fieldset>
                        </div>

                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Country of Marriage</h5>
                                <p><?php echo $row_sp['countrym'];?></p>
                                <input type="hidden" name="countryofmarriage" value="<?php echo $row_sp['countrym'];?>" >
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
            
            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Next of Kin  </h5>
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5 class="without-border">Full Name</h5>
                                <p><?php echo $row_nextofkin['fullname'];?></p>
                                <input type="hidden" name="nextofkinfullname" value="<?php echo $row_nextofkin['fullname'];?>" >
                            </fieldset>
                        </div>
                    </div>
 
                     <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5 class="without-border">Phone Number</h5>
                                <p><?php echo $row_nextofkin['telephone'];?></p>
                                 <input type="hidden" name="nextofkintelephone" value="<?php echo $row_nextofkin['telephone'];?>" >
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5 class="without-border">Email Address</h5>
                                <p><?php echo $row_nextofkin['email'];?></p>
                                <input type="hidden" name="nextofkinemail" value="<?php echo $row_nextofkin['email'];?>" >
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5 class="without-border">Address</h5>
                                <p><?php echo $row_nextofkin['address'];?></p>
                                <input type="hidden" name="nextofkinaddress" value="<?php echo $row_nextofkin['address'];?>" >
                            </fieldset>
                        </div>
                    </div>

          
                    
                </div>
            </section>


            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Beneficiaries</h5>
                    <?php do { ?>
                    <h5 class="with-border">Beneficiary #<?php echo ++$orderNum?></h5>
                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Full Name</h5>
<p><?php echo $row_beneficiarydump['title'].' '.$row_beneficiarydump['fullname'];?></p> 
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5 class="without-border">Address</h5>
                                <p><?php echo $row_beneficiarydump['addr'];?></p>
                            </fieldset>
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Email</h5>
                                <p><?php echo $row_beneficiarydump['email'];?></p> 
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Phone Number</h5>
                                <p><?php echo $row_beneficiarydump['phone'];?></p>
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">Relationship</h5>
                                <p><?php echo $row_beneficiarydump['rtionship'];?></p>
                            </fieldset>
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">City</h5>
                                <p><?php echo $row_beneficiarydump['city'];?></p> 
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5 class="without-border">State</h5>
                                <p><?php echo $row_beneficiarydump['state'];?></p>
                            </fieldset>
                        </div>
                        
                    </div> <hr>
<?php } while ($row_beneficiarydump = mysqli_fetch_assoc($beneficiarydump));?> 
                </div>
            </section>


            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Asset Information </h5>

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
$queryaccount = "SELECT * FROM simplewill_overall_asset WHERE propertyid = '$bankaccountid' "; 
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
                                          </tr>
                                        </thead>
                                        <tbody> 
                                        <?php do { 
                                        $accountid = $row_account['propertyid'];
                                        $queryaccountname = "SELECT * FROM simplewill_assets_tb WHERE id = '$accountid' "; 
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
                        <h5 class="without-border">Pension (<?php echo $row_pns['pension_admin'];?>)</h5>
                        <p>Asset Description</p>
                            <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <!--<th>Name of Pension Provider</th>
                                            <th>Name of Pension Holder</th>-->
                                            <th>RSA Number</th>
                                            <th>Pension Fund Administrator</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                            <tr>
                                               <!-- <td><?php //echo $row_pns['pension_name'];?></td>
                                                <td><?php //echo $row_pns['pension_owner'];?></td>-->
                                                <td><?php echo $row_pns['rsano'] ;?></td>
                                                <td><?php echo $row_pns['pension_admin'] ;?></td>
                                            </tr>
                                       
                                                                                </tbody>
                                    </table><br>
                                    <p>Percentage Sharing</p>
<?php 
$querypension = "SELECT * FROM simplewill_overall_asset WHERE propertyid = '$pensionid' "; 
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
                                          </tr>
                                        </thead>
                                        <tbody> 
                                        <?php do { 
                                        $pensionid = $row_pension['propertyid'];
                                        $querypensionname = "SELECT * FROM simplewill_assets_tb WHERE id = '$pensionid' "; 
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

            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Human Resources Contact</h5>
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5 class="without-border">Name of Company</h5>
                    <p><?php echo $row_pi['nameofcompany'];?></p>
    <input type="hidden" name="nameofcompany" value="<?php echo $row_humanresourcescontact['nameofcompany'];?>" >
                            </fieldset>
                        </div>
                    </div>
 
                     <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5 class="without-border">Telephone Number</h5>
                                <p><?php echo $row_pi['company_telephone'];?></p>
                                 <input type="hidden" name="humanresourcescontacttelephone" value="<?php echo $row_humanresourcescontact['telephone'];?>" >
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5 class="without-border">Email Address</h5>
                                <p><?php echo $row_pi['company_email'];?></p>
                                <input type="hidden" name="humanresourcescontactemailaddress" value="<?php echo $row_humanresourcescontact['emailaddress'];?>" >
                            </fieldset>
                        </div>
                    </div>

                </div>
            </section>
            

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