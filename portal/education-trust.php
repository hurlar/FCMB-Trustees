<?php require ('Connections/conn.php');
include ('session.php');
$querypi = "SELECT * FROM personal_info WHERE uid = '$userid' ";
$pi = mysqli_query($conn, $querypi) or die(mysqli_error($conn));
$row_pi = mysqli_fetch_assoc($pi);
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

$querymts = "SELECT * FROM marital_status WHERE uid = '$userid' "; 
$mts = mysqli_query($conn, $querymts) or die(mysqli_error($conn));
$row_mts = mysqli_fetch_assoc($mts);
//$email = $row_usr['email'];
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

$queryprt = "SELECT * FROM property_tb WHERE uid = '$userid' ";
$prt = mysqli_query($conn, $queryprt) or die(mysqli_error($conn));
$row_prt = mysqli_fetch_assoc($prt);
$totalprt = mysqli_num_rows($prt);

$queryshs = "SELECT * FROM shares_tb WHERE uid = '$userid' "; 
$shs = mysqli_query($conn, $queryshs) or die(mysqli_error($conn));
$row_shs = mysqli_fetch_assoc($shs);
$totalshs = mysqli_num_rows($shs);

$queryins = "SELECT * FROM insurance_tb WHERE uid = '$userid' "; 
$ins = mysqli_query($conn, $queryins) or die(mysqli_error($conn));
$row_ins = mysqli_fetch_assoc($ins);
$totalins = mysqli_num_rows($ins);

$querybnk = "SELECT * FROM bank_details WHERE uid = '$userid' "; 
$bnk = mysqli_query($conn, $querybnk) or die(mysqli_error($conn));
$row_bnk = mysqli_fetch_assoc($bnk);
$totalbnk = mysqli_num_rows($bnk);

$querypns = "SELECT * FROM pension_tb WHERE uid = '$userid' "; 
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

                </div><!--.col- -->

                <div class="col-lg-9 col-lg-push-3 col-md-12">
                <h3 class="with-border">Education Trust Form </h3>
                            <section class="card">
                <div class="card-block">
                <form action="processor/process-education.php" method="post">
                    <h5 class="with-border">Personal Data </h5>
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Full Name</label>
                                <input type="text" name="fullname1" value="<?php echo ucfirst($fname).' '.ucfirst($mname).' '.ucfirst($lname);?>" class="form-control maxlength-simple" id="exampleInput" disabled >
                                <input type="hidden" name="fullname" value="<?php echo ucfirst($fname).' '.ucfirst($mname).' '.ucfirst($lname);?>" />
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Home Address</label>
                                <textarea rows="1" name="addr1" class="form-control maxlength-simple" disabled><?php echo $msg;?></textarea>
                                <input type="hidden" name="addr" value="<?php echo $msg;?>" />
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Mailing Address (If different from Home Address)</label>
                                <textarea rows="1" name="mailingaddr" class="form-control maxlength-simple"></textarea>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Email Address</label>
                      <input type="text" name="email1" value="<?php echo $email ;?>" class="form-control maxlength-simple" disabled id="exampleInput" >
                      <input type="hidden" name="email" value="<?php echo $email ;?>" >
                            </fieldset>
                        </div>


                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Mother's Maiden Name</label>
                                    <input type="text" name="maidenname" class="form-control maxlength-simple" required>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Phone Number</label>
                                <input type="text" name="phone1" value="<?php echo $phone ;?>" disabled class="form-control maxlength-simple" id="exampleInput" >
                                <input type="hidden" name="phone" value="<?php echo $phone ;?>" >
                            </fieldset>
                        </div>
                        <?php if ($row_pi['aphone'] != NULL) { ?>
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Alt. Phone Number</label>
                                <input type="text" name="aphone1" value="<?php echo $row_pi['aphone'];?>" disabled class="form-control maxlength-simple" id="exampleInput" />
                                <input type="hidden" name="aphone" value="<?php echo $row_pi['aphone'];?>" />
                            </fieldset>
                        </div>
                        <?php } ?>
                    </div>

                     <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Marital Status</label>
                                    <input type="text" name="maritalstatus1" value="<?php echo $row_mts['status'];?>" class="form-control maxlength-simple" disabled>
                                    <input type="hidden" name="maritalstatus" value="<?php echo $row_mts['status'];?>" />
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Gender</label>
                                <input type="text" name="gender1" disabled value="<?php echo $row_pi['gender'];?>" class="form-control maxlength-simple" />
                                <input type="hidden" name="gender" value="<?php echo $row_pi['gender'];?>" />
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Date Of Birth</label>
                                <input type="text" name="dob1" value="<?php echo $dob ;?>" class="form-control maxlength-simple" id="exampleInput" disabled >
                                <input type="hidden" name="dob" value="<?php echo $dob ;?>" />
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">State Of Origin</label>
                                <input type="text" name="state1" value="<?php echo $row_pi['state'] ;?>" class="form-control maxlength-simple" id="exampleInput" disabled >     
                                <input type="hidden" name="state" value="<?php echo $row_pi['state'] ;?>" / >                             
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Nationality</label>
                                <input type="text" name="nationality1" value="<?php echo $row_pi['nationality'] ;?>" disabled class="form-control maxlength-simple" id="exampleInput">
                                <input type="hidden" name="nationality" value="<?php echo $row_pi['nationality'] ;?>" />
                            </fieldset>
                        </div>
                    </div> <br>
                    <?php if ($totalsp != NULL) { ?>
                     <h5 class="with-border">Spouse Data </h5>
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Full Name</label>
                                <input type="text" name="spname1" value="<?php echo $row_sp['fullname'];?>" class="form-control maxlength-simple" id="exampleInput" disabled>
                                <input type="hidden" name="spname" value="<?php echo $row_sp['fullname'];?>" >
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Address</label>
                                <textarea rows="1" name="spaddr1" class="form-control maxlength-simple" disabled><?php echo $row_sp['addr'];?></textarea>
                                <input type="hidden" name="spaddr" value="<?php echo $row_sp['addr'];?>" >
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Phone Number</label>
                                <input type="text" name="spphone1" value="<?php echo $row_sp['phoneno'];?>" class="form-control maxlength-simple" id="exampleInput" disabled>
                                <input type="hidden" name="spphone" value="<?php echo $row_sp['phoneno'];?>" >
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Date of Birth</label>
                            <input type="text" name="sdob1" value="<?php echo $row_sp['dob'];?>" class="form-control maxlength-simple" id="exampleInput" disabled>
                            <input type="hidden" name="sdob" value="<?php echo $row_sp['dob'];?>" / >
                            </fieldset>
                        </div>
                    </div>
                    <br>
                    <?php } ?>

                                         <div class="row">
                        <div class="col-md-2">
                            <p>
                                Identification Type
                            </p>
                        </div>
                    
                <div class="col-md-10">

                            <div class="radio">
                                <input type="radio" name="idtype" id="radio-1" value="International Passport" required>
                                <label for="radio-1">International Passport </label>
                                <input type="radio" name="idtype" id="radio-2" value="Driver's License" required>
                                <label for="radio-2">Driver's License </label>
                                <input type="radio" name="idtype" id="radio-3" value="National ID Card" required>
                                <label for="radio-3">National ID Card</label>
                                <input type="radio" name="idtype" id="radio-4" value="INEC Voter's Card" required>
                                <label for="radio-4">INEC Voter's Card</label> <br>

                            </div>
                
                </div>
                </div>

                <div class="row">
                        <div class="col-lg-3">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">ID Number</label>
                                <input type="text" name="idnumber" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                        <div class="col-lg-3">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Issue Date</label>
                            <input type="date" name="issuedate" class="form-control maxlength-simple" id="exampleInput" required>
                            
                            <!--<input type="text" name="issuedate" data-provide="datepicker" data-date-autoclose="true" class="form-control" data-date-format="dd-mm-yyyy" required>-->
                         
                            </fieldset>
                        </div>
                        <div class="col-lg-3">                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Expiry Date</label>
                            <input type="date" name="expirydate" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                        <div class="col-lg-3">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Place of Issue</label>
                            <input type="text" name="placeofissue" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                    </div>
                    
                     <h5 class="with-border">Employment Details </h5>
                     <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Employment Status</label>
                                <input type="text" name="empstatus" value="<?php echo $row_pi['employment_status'];?>" class="form-control maxlength-simple" id="exampleInput" disabled>
                                <input type="hidden" name="empstatus" value="<?php echo $row_pi['employment_status'];?>" > 
                            </fieldset>
                        </div>
                    </div>
                    <?php //if ($row_pi['employment_status'] == 'Employed') { ?>
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Employer</label>
                                <input type="text" name="employer" value="<?php //echo $row_pi['employer'];?>" class="form-control maxlength-simple" id="exampleInput" >
                                <!--<input type="hidden" name="employer" value="<?php //echo $row_pi['employer'];?>" >-->
                            </fieldset>
                        </div>

                    <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Phone Number</label>
                                <input type="text" name="employerphone" value="<?php //echo $row_pi['employerphone'];?>" class="form-control maxlength-simple" id="exampleInput" >
                                <!--<input type="hidden" name="employerphone" value="<?php //echo $row_pi['employerphone'];?>" >-->
                            </fieldset>
                        </div>
                    </div>
        
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Employer's Address</label>
                                <textarea rows="1" name="employeraddr" class="form-control maxlength-simple"></textarea>
                                <!--<input type="hidden" name="employeraddr" value="<?php //echo $row_pi['employeraddr'];?>" >-->
                            </fieldset>
                        </div>
                    </div>
                    <br>
                    <?php //} ?>

                    <div class="row">
                    
                            <div class="col-md-12">
                            <label class="form-label" for="exampleInput">Source of Fund</label>
                            <div class="radio">
                                <input type="radio" name="sfund" id="radio-5" value="Salary" required>
                                <label for="radio-5">Salary</label>
                                <input type="radio" name="sfund" id="radio-6" value="Business" required>
                                <label for="radio-6">Business </label>
                                <input type="radio" name="sfund" id="radio-7" value="Gratuity" required>
                                <label for="radio-7">Gratuity</label>
                                <input type="radio" name="sfund" id="radio-8" value="Properties" required>
                                <label for="radio-8">Properties</label> 
                                <input type="radio" name="sfund" id="radio-9" value="INEC Voter's Card" required>
                                <label for="radio-9">Others (Please Specify)</label> <br>

                            </div>
                
                </div>
                </div>


                <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Annual Income / Turnover</label>
                                <input type="text" name="income" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                    </div>

                    <?php if ($totalcd != NULL) { ?> 
                    <h5 class="with-border">Children</h5>
                     <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered">
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
                        </div><br>
                        <?php } ?>

                        <h5 class="with-border">Assets Data </h5>
                                        <?php if ($totalinsurance != NULL) { ?>
                     <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered">
                                        <thead>
                                          <tr>
                                            <th>Asset</th>
                                            <th>Beneficiary</th>
                                            <th>Percentage</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                        <?php do { 
                                        $insuranceid = $row_insurance['propertyid'];
                                        $queryinsurancename = "SELECT `id`, `company` FROM shares_tb WHERE id = '$insuranceid' "; 
                                        $insurancename = mysqli_query($conn, $queryinsurancename) or die(mysqli_error($conn));
                                        $row_insurancename = mysqli_fetch_assoc($insurancename);

                                        $insurancebeneficiary = $row_insurance['beneficiaryid'];
                                        $queryinsurancebeneficiary = "SELECT `id`, `fullname` FROM beneficiary_dump WHERE id = '$insurancebeneficiary' "; 
                                        $query_run2 = mysqli_query($conn, $queryinsurancebeneficiary) or die(mysqli_error($conn));
                                        $row_insurancebeneficiary = mysqli_fetch_assoc($query_run2);
 
                                         ?>
                                            <tr>
                                                <td><?php echo $row_insurancename['company'];?></td>
                                                <td><?php echo $row_insurancebeneficiary['fullname'];?></td>
                                                <td><?php echo $row_insurance['percentage'];?></td>
                                            </tr>
                                        <?php } while ($row_insurance = mysqli_fetch_assoc($insurance));?>
                                                                                </tbody>
                                    </table>
                        </div>


                    </div><br>
                    <?php }?>




                    <h5>TRUST DEED CREATION DETAILS</h5>
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Please state the purpose/objective of Trust</label>
                                <textarea rows="3" name="purpose" class="form-control maxlength-simple" ></textarea>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Proposed Name of Trust </label>
                                <input type="text" name="trustname" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Please state initial contribution to be provided</label>
                                <textarea rows="3" name="contribution" class="form-control maxlength-simple"  ></textarea>
                            </fieldset>
                        </div>
                    </div> <br>






                    <input type="hidden" name="uid" value="<?php echo $userid ;?>" />
                    <input type="submit" value="SUBMIT" class="btn btn-inline btn-fcmb" style="float:right;">
                </form>
                </div>
            </section>

                </div><!--.col- -->
            </div><!--.row-->
        </div><!--.container-fluid-->
    </div><!--.page-content-->
    
    <script src="js/bootstrap-datepicker.min.js"></script>
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