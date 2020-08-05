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


$queryeducationbeneficiary
 = "SELECT * FROM education_beneficiary
 WHERE uid = '$userid' ";
$educationbeneficiary
 = mysqli_query($conn, $queryeducationbeneficiary) or die(mysqli_error($conn));
$row_educationbeneficiary = mysqli_fetch_assoc($educationbeneficiary);
$totaleducationbeneficiary = mysqli_num_rows($educationbeneficiary);
//isset($startRow_pay)? $orderNum=$startRow_pay :$orderNum=0;


$querytrustdeed = "SELECT * FROM trustdeed_tb WHERE uid = '$userid' "; 
$trustdeed = mysqli_query($conn, $querytrustdeed) or die(mysqli_error($conn));
$row_trustdeed = mysqli_fetch_assoc($trustdeed);
$totaltrustdeed = mysqli_num_rows($trustdeed);


//gets the will/ form type the users selects after the create will/ create trust page.
$querywilltype = "SELECT `uid`,`name`,`amount` FROM willtype WHERE uid = '$userid' "; 
$willtype = mysqli_query($conn, $querywilltype) or die(mysqli_error($conn));
$row_willtype = mysqli_fetch_assoc($willtype);
$totalwilltype = mysqli_num_rows($willtype);
$willname = $row_willtype['name'];

$querypayment = "SELECT `id`,`uid`,`willtype` FROM payment_tb WHERE uid = '$userid' AND `willtype` = '$willname' "; 
$payment = mysqli_query($conn, $querypayment) or die(mysqli_error($conn));
$totalpayment = mysqli_num_rows($payment);

$queryactive = "SELECT `id`,`uid` FROM education_tb WHERE uid = '$userid' "; 
$active = mysqli_query($conn, $queryactive) or die(mysqli_error($conn));
$totalactive = mysqli_num_rows($active);


$amount = '25000';
$ref = rand(1000,1000000) ;
$_SESSION['transactionid'] = $ref;
$_SESSION['willtype'] = $row_willtype['name'];


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
<form action="processor/process-educationform.php" method="POST">            
            <div class="row">
                <div class="col-lg-3 col-lg-pull-6 col-md-6 col-sm-6">
                    <?php include ('inc/inc_avatar.php');?>
                    
            <?php if ($totalpayment == NULL AND $totalactive != NULL){?>        
                   <section class="box-typical sidemenu">
                        <div class="profile-card">
                        <div class="profile-card-name"> Engagement Fee <br> #25,000</div> <br/>

                                <form >
                                <script src="https://js.paystack.co/v1/inline.js"></script>
                                <button type="button" onclick="payWithPaystack()" class="btn btn-inline btn-fcmb" > Make Payment </button>
                            </form>
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
                <h3 class="with-border"><?php echo $row_willtype['name'];?> </h3>
                <input type="hidden" name="willtype" value="<?php echo $willname;?>" />

                <section class="card">
                <div class="card-block">
                
                    <h5 class="with-border">Personal Data </h5>
                <?php    if (isset($_GET['a'])) {  
$url = mysqli_real_escape_string($conn, $_GET['a']);

?>

<?php if($url == 'successful'){  ?>
<div class="alert alert-success alert-fill alert-close alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <?php echo  ' Thank you for completing your form. A representative will contact you shortly.<br> You can make payment by clicking the Make Payment button.' ; ?>
</div>
<?php } ?>

<?php } ?>


                    <div class="row">
                        <div class="col-lg-12">
                            <img src="../cms/uploads/passport/<?php echo $row_pi['passport'];?>" height:250px; width:100px; />
                        </div>
                    </div> <br/>
                    
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
                                 <input type="hidden" name="idnumber" value="<?php echo $row_pi['identification_number'];?>" >
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-3">
                            <fieldset class="form-group">
                                <h5 class="without-border">Issue Date</h5>
                                <p><?php echo $row_pi['issuedate'];?></p>
                                <input type="hidden" name="issuedate" value="<?php echo $row_pi['issuedate'];?>" >
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-3">
                            <fieldset class="form-group">
                                <h5 class="without-border">Expiry Date</h5>
                                <p><?php echo $row_pi['expirydate'];?></p>
                                <input type="hidden" name="expirydate" value="<?php echo $row_pi['expirydate'];?>" >
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-3">
                            <fieldset class="form-group">
                                <h5 class="without-border">Issue Place</h5>
                                <p><?php echo $row_pi['issuedplace'];?></p>
                                <input type="hidden" name="issueplace" value="<?php echo $row_pi['issuedplace'];?>" >
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
                    <h5 class="with-border">Source of fund  </h5>
                <?php do { ?> 
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5 class="without-border">Source of fund</h5>
                                <p><?php echo $row_pi['earning_type'];?></p>
                                <input type="hidden" name="earning" value="<?php echo $row_pi ['earning_type'];?>" >
                            </fieldset>
                        </div>
                    </div> 
 
                    <?php if($row_pi ['earning_type'] == 'Others'){?>
                     <div class="row">
                        
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5 class="without-border">Please Specify</h5>
                                <p><?php echo $row_pi ['note'];?></p>
                                <input type="hidden" name="otherspecify" value="<?php echo $row_pi ['note'];?>" >
                            </fieldset>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5 class="without-border">Annual Income</h5>
                                <p><?php echo $row_pi ['annual_income'];?></p>
                                <input type="hidden" name="annualincome" value="<?php echo $row_pi ['annual_income'];?>" >
                            </fieldset>
                        </div>
                    </div> <hr>
    <?php } while ($row_pi = mysqli_fetch_assoc($pi));?>
          
                    
                </div>
            </section>

<?php if ($totaleducationbeneficiary != NULL) { ?>
            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Beneficiaries and Approximate Share in (%) </h5>
                    <div class="row">
                        <div class="col-lg-12">
                       
                            <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Name of child</th>
                                            <th>Date of Birth</th>
                                            <th>Relationship to Settlor</th>
                                            <th>Sex</th>
                                            <th>Approximate Share(%)</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                         <?php do { ?>
                                            <tr>
                                                <td> <?php echo $row_educationbeneficiary['nameofchild'];?></td> 
                                                <td><?php echo $row_educationbeneficiary['dob'];?></td>
                                                <td><?php echo $row_educationbeneficiary['relationship'];?></td>
                                                <td><?php echo $row_educationbeneficiary['sex'];?></td>
                                                <td><?php echo $row_educationbeneficiary['percentage'];?></td>
                                            </tr>
                                  <?php } while ($row_educationbeneficiary = mysqli_fetch_assoc($educationbeneficiary));?>      
                                                                                </tbody>
                                    </table>
                        </div>
                    </div> 
                </div>
            </section>
                    <?php } ?> 
                    

            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Trust Deed Creation Details  </h5>
                <?php do { ?> 
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5 class="without-border">Purpose/ Objective of Trust
</h5>
                                <p><?php echo $row_trustdeed['purposeoftrust'];?></p>
                                <input type="hidden" name="purposeoftrust" value="<?php echo $row_trustdeed ['purposeoftrust'];?>" >
                            </fieldset>
                        </div>
                    </div> 
 
                     <div class="row">
                        
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5 class="without-border">Proposed Name of Trust</h5>
                                <p><?php echo $row_trustdeed ['nameoftrust'];?></p>
                                <input type="hidden" name="nameoftrust" value="<?php echo $row_trustdeed ['nameoftrust'];?>" >
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5 class="without-border">Please state initial contribution to be provided</h5>
                                <p><?php echo $row_trustdeed ['initialcontribution'];?></p>
                                <input type="hidden" name="initialcontribution" value="<?php echo $row_trustdeed ['initialcontribution'];?>" >
                            </fieldset>
                        </div>
                    </div> <hr>
    <?php } while ($row_trustdeed = mysqli_fetch_assoc($trustdeed));?>
          
                    
                </div>
            </section>
            
            


<?php if ($totalactive < '1'){?>
<section class="card">
    <div class="card-block">
        <h5 class="with-border">Declaration</h5>
            <div class="row">
                        <div class="col-lg-1">
                            <fieldset class="form-group">
                            <input type="checkbox" name="agree" required style="width:50px; height:50px;"/>
                            </fieldset>
                        </div>
                        <div class="col-lg-11">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput"> I hereby undertake and declare that all the statements made above are true and correct and that I have not 
withheld any material information. I also agree to give notice to FCMB TRUSTEES LIMITED in the event of any change in the information given.</label>
                            </fieldset>
                        </div>
                    </div>
<input type="hidden" name="uid" value="<?php echo $userid ;?>" />
<input type="submit" value="SUBMIT" class="btn btn-inline btn-fcmb" style="float:right;">            
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