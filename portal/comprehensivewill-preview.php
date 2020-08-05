<?php require ('Connections/conn.php');
include ('session.php');
if(!isset($userid)){
header('location:index.php');
exit();
}

$update1 = "UPDATE `willtype` SET `name` = 'Comprehensive Will',`amount` = ' ' WHERE `uid` = '$userid' "; 
$update_run1 = mysqli_query($conn, $update1) or die(mysqli_error($conn));

$querywill = "SELECT `id`,`uid`, `willtype`, `datecreated` FROM comprehensivewill_tb WHERE uid = '$userid' "; 
$will = mysqli_query($conn, $querywill) or die(mysqli_error($conn));
$row_will = mysqli_fetch_assoc($will);
$willcount = mysqli_num_rows($will);

$querywilltype = "SELECT `uid`,`name`,`amount` FROM willtype WHERE uid = '$userid' "; 
$willtype = mysqli_query($conn, $querywilltype) or die(mysqli_error($conn));
$row_willtype = mysqli_fetch_assoc($willtype);
$totalwilltype = mysqli_num_rows($willtype);
$willname = $row_willtype['name'];

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
$sptitle = $row_sp['title'];
$spfullname = $row_sp['fullname'];
$spemail = $row_sp['email'];
$spphone = $row_sp['phoneno'];
$sdob = $row_sp['dob'];
$spaddr = $row_sp['addr']; 
$spcity = $row_sp['city']; 
$spstate = $row_sp['state']; 
$marriagetype = $row_sp['marriagetype']; 
$marriageyear = $row_sp['marriageyear']; 
$marriagecert = $row_sp['marriagecert']; 
$spcitym = $row_sp['citym']; 
$spcountrym = $row_sp['countrym']; 

$queryms = "SELECT * FROM marital_status WHERE uid = '$userid' ";
$ms = mysqli_query($conn, $queryms) or die(mysqli_error($conn));
$row_ms = mysqli_fetch_assoc($ms);
$totalms = mysqli_num_rows($ms);

$querydv = "SELECT `divorce`, `divorceyear`, `uid` FROM divorce_tb WHERE uid = '$userid' "; 
$dv = mysqli_query($conn, $querydv) or die(mysqli_error($conn));
$row_dv = mysqli_fetch_assoc($dv);
$totaldv = mysqli_num_rows($dv);
$divorce = $row_dv['divorce']; 
$divorceyear = $row_dv['divorceyear']; 

$querycd = "SELECT * FROM children_details WHERE uid = '$userid' ";
$cd = mysqli_query($conn, $querycd) or die(mysqli_error($conn));
$row_cd = mysqli_fetch_assoc($cd);
$totalcd = mysqli_num_rows($cd);
isset($startRow_pay)? $orderNum=$startRow_pay :$orderNum=0;

$queryguardian = "SELECT `id`,`uid`,`age`,`title`,`guardianname`,`addr`,`city`,`state`,`phone` FROM children_details WHERE uid = '$userid' AND `age` < 18 ";
$guardian = mysqli_query($conn, $queryguardian) or die(mysqli_error($conn));
$row_guardian = mysqli_fetch_assoc($guardian);
$totalguardian = mysqli_num_rows($guardian); 
//isset($startRow_pay)? $orderNum=$startRow_pay :$orderNum=0;

$queryphyguardian = "SELECT `id`,`uid`,`title`,`fullname` FROM physical_guardian WHERE uid = '$userid' ";
$phyguardian = mysqli_query($conn, $queryphyguardian) or die(mysqli_error($conn));
$row_phyguardian = mysqli_fetch_assoc($phyguardian);
$totalphyguardian = mysqli_num_rows($phyguardian);

$queryfinguardian = "SELECT `id`,`uid`,`title`,`fullname`,`addr`,`city`,`state`,`phone` FROM financial_guardian WHERE uid = '$userid' ";
$finguardian = mysqli_query($conn, $queryfinguardian) or die(mysqli_error($conn));
$row_finguardian = mysqli_fetch_assoc($finguardian);
$totalfinguardian = mysqli_num_rows($finguardian);

$queryprt = "SELECT * FROM assets_tb WHERE uid = '$userid' AND asset_type = 'property' ";
$prt = mysqli_query($conn, $queryprt) or die(mysqli_error($conn));
$row_prt = mysqli_fetch_assoc($prt);
$totalprt = mysqli_num_rows($prt);

$queryshs = "SELECT * FROM assets_tb WHERE uid = '$userid' AND asset_type = 'shares' "; 
$shs = mysqli_query($conn, $queryshs) or die(mysqli_error($conn));
$row_shs = mysqli_fetch_assoc($shs);
$totalshs = mysqli_num_rows($shs);

$queryinv = "SELECT * FROM assets_tb WHERE uid = '$userid' AND asset_type = 'Other Investments' "; 
$inv = mysqli_query($conn, $queryinv) or die(mysqli_error($conn));
$row_inv = mysqli_fetch_assoc($inv);
$totalinv = mysqli_num_rows($inv);

$queryins = "SELECT * FROM assets_tb WHERE uid = '$userid' AND asset_type = 'insurance' "; 
$ins = mysqli_query($conn, $queryins) or die(mysqli_error($conn));
$row_ins = mysqli_fetch_assoc($ins);
$totalins = mysqli_num_rows($ins);

$querybnk = "SELECT * FROM assets_tb WHERE uid = '$userid' AND asset_type = 'bankaccount' "; 
$bnk = mysqli_query($conn, $querybnk) or die(mysqli_error($conn));
$row_bnk = mysqli_fetch_assoc($bnk);
$totalbnk = mysqli_num_rows($bnk);

$querypns = "SELECT * FROM assets_tb WHERE uid = '$userid' AND asset_type = 'Pension' AND pension_name != 'NULL' "; 
$pns = mysqli_query($conn, $querypns) or die(mysqli_error($conn));
$row_pns = mysqli_fetch_assoc($pns);
$totalpns = mysqli_num_rows($pns);

$querypc = "SELECT * FROM assets_tb WHERE uid = '$userid' AND asset_type = 'Personal Chattels' "; 
$pc = mysqli_query($conn, $querypc) or die(mysqli_error($conn));
$row_pc = mysqli_fetch_assoc($pc);
$totalpc = mysqli_num_rows($pc);

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

$queryexecpower = "SELECT * FROM executor_power WHERE uid = '$userid' AND willtype = 'Comprehensive Will' "; 
$execpower = mysqli_query($conn, $queryexecpower) or die(mysqli_error($conn));
$row_execpower = mysqli_fetch_assoc($execpower);
$totalexecpower = mysqli_num_rows($execpower); 

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
<form action="processor/process-comprehensivepreview.php" method="POST">            
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
<?php 

if (isset($_GET['a'])) {  
$url = mysqli_real_escape_string($conn, $_GET['a']);

?>

<?php if($url == 'error'){  ?>
<div class="alert alert-warning alert-fill alert-close alert-dismissible fade show" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<?php echo  ' Sorry, we can\'t process you request at the moment. Please try again later.' ; ?>
</div>
<?php } ?>

<?php if($url == 'successfull'){  ?>
<div class="alert alert-success alert-fill alert-close alert-dismissible fade show" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<?php echo  ' You have successfully submitted your Will.<br> A representative will contact you shortly. ' ; ?>
</div>
<?php } ?>

<?php } ?>
                <!--<h3 class="with-border"><?php //echo $row_willtype['name'];?> </h3>
                <input type="hidden" name="willtype" value="<?php //echo $row_willtype['name'];?>" />-->

                <section class="card">
                <div class="card-block">
                <p>
                    <?php if($willcount == NULL){?>
                        This is the Last Will & Testament of <?php echo $salutation.' '.ucfirst($fname).' '.ucfirst($mname).' '.ucfirst($lname);?> made this <?php $datecreated = date("Y-m-d"); echo date("jS", strtotime($datecreated)); ?> day of <?php 
                              $datecreated = date("Y-m-d"); echo date("F,", strtotime($datecreated)); ?> <?php 
                              $datecreated = date("Y-m-d"); echo date("Y", strtotime($datecreated)); ?>.  
                    <?php } ?>         
                    
                    <?php if($willcount != NULL){?>
                    This is the Last Will & Testament of <?php echo $salutation.' '.ucfirst($fname).' '.ucfirst($mname).' '.ucfirst($lname);?> made this <?php $datecreated = $row_will['datecreated']; echo date("jS", strtotime($datecreated)); ?> day of <?php 
                      $datecreated = $row_will['datecreated']; echo date("F,", strtotime($datecreated)); ?> <?php 
                      $datecreated = $row_will['datecreated']; echo date("Y", strtotime($datecreated)); ?>
                      <?php } ?> 
                      <br>
                      
                      <h5>A. PRELIMINARY DECLARATIONS </h5>
                      <span style="color:#5C068C; font-size:1.25rem; font-weight: 400;">1.</span> I, <?php echo $salutation;?> <?php echo ucfirst($fname);?> <?php echo ucfirst($mname);?> <?php echo ucfirst($lname);?> of <?php echo $msg;?>, <?php echo $row_pi['state'] ;?> State, Nigeria, born  <?php 
                      $dobnew = $dob; echo date("jS F, Y", strtotime($dobnew)); ?> and being of sound mind and body hereby revoke all previous Wills, Codicils and other testamentary dispositions made by me and therefore declare this Will to be <strong>MY LAST WILL & TESTAMENT</strong>.<br><br>
                      
                      <span style="color:#5C068C; font-size:1.25rem; font-weight: 400;">2.</span> I appoint as Executors 
                      <?php do { ?>
                      <?php echo $row_exe['fullname'];?> of <?php echo $row_exe['addr'];?>, <?php echo $row_exe['phone'];?>,
<?php if($row_exe['email'] != NULL){ ?><?php echo $row_exe['email'];?>,<?php } ?> <?php echo $row_exe['rtionship'];?> and
                      <?php } while ($row_exe = mysqli_fetch_assoc($exe));?>;  (hereinafter called my Executors) which to be the executors of this my Will whether original or substituted.<br><br>
                      
                    <?php if($totalsp > 0){?>  
                      <span style="color:#5C068C; font-size:1.25rem; font-weight: 400;">3.</span> I DECLARE that whenever the word <?php if($row_pi['gender'] == 'Male'){
                                echo '"my wife"';
                      }elseif($row_pi['gender'] == 'Female'){
                                echo '"my husband"';
                      }?> appears it shall be taken to refer to 
                      <?php do { ?> <br>
                      <?php echo $sptitle.' '.$spfullname;?> of <?php echo $spaddr;?>, <?php echo $spcity;?>, <?php echo $spstate;?> who was born on <?php echo date("jS F, Y", strtotime($sdob)); ?> and whom I married in <?php echo $spmarriageyear;?> in <?php echo $spcitym;?>, <?php echo $spcountrym;?>. <br>
                      <?php }while ($row_sp = mysqli_fetch_assoc($sp));?>
                      <br>
                      <?php } ?>  
                      
                    <?php if($totalcd > 0){?> 
                      <span style="color:#5C068C; font-size:1.25rem; font-weight: 400;">4.</span> I declare that the following and no more are my children:<?php do { ?> <br>
                            <em><?php echo ++$orderNum?>.</em> <?php echo $row_cd['name'];?> born on <?php $cddobnew = $row_cd['dob']; echo date("jS F, Y", strtotime($cddobnew)); ?>. <br>
                      <?php } while ($row_cd = mysqli_fetch_assoc($cd));?> and that no other person or persons shall receive any benefit under this Will under that appellation.<br><br>
                    <?php } ?>
                    
                      <?php if ($totalguardian > 0){?>
                      <span style="color:#5C068C; font-size:1.25rem; font-weight: 400;">5.</span> In the event that my <?php if($salutation == 'Mrs'){echo 'husband';}elseif($salutation == 'Mr'){echo 'Wife';}elseif($salutation == 'Ms'){echo 'husband';} ?> predeceases me, I;<br>
                      (a)  nominate and appoint <?php echo $row_guardian['title'];?> <?php echo $row_guardian['guardianname'];?> to be the financial guardians of my children to render financial advice and hold all real estate property and shares intended for (_______) years at the time of my death;<br>
                      (b) nominate and appoint <?php echo $row_guardian['title'];?> <?php echo $row_guardian['guardianname'];?> of <?php echo $row_guardian['addr'];?>, <?php echo $row_guardian['city'];?>, <?php echo $row_guardian['state'];?>, <?php echo $row_guardian['phone'];?> as the physical guardian of my Children and shall have custody of my children during their joint minority.<br><br>
                      <?php } ?>
                      
                      <?php if ($totalguardian == 0){?>
                      <span style="color:#5C068C; font-size:1.25rem; font-weight: 400;">5.</span> In the event that my <?php if($salutation == 'Mrs'){echo 'husband';}elseif($salutation == 'Mr'){echo 'Wife';}elseif($salutation == 'Ms'){echo 'husband';} ?> predeceases me, I;<br>
                      (a)  nominate and appoint <?php echo $row_phyguardian['title'];?> <?php echo $row_phyguardian['fullname'];?> to be the financial guardians of my children to render financial advice and hold all real estate property and shares intended for (_______) years at the time of my death;<br>
                      (b) nominate and appoint <?php echo $row_finguardian['title'];?> <?php echo $row_finguardian['fullname'];?> of <?php echo $row_finguardian['addr'];?>, <?php echo $row_finguardian['city'];?>, <?php echo $row_finguardian['state'];?>, <?php echo $row_finguardian['phone'];?> as the physical guardian of my Children and shall have custody of my children during their joint minority.<br><br>
                      <?php } ?>
                    
                    <?php if($totalinfo > 0){?>
                      <span style="color:#5C068C; font-size:1.25rem; font-weight: 400;">6.  Burial Arrangements and Wishes</span><br>
                      <?php echo $row_info['addinfo'];?><br><br>
                    <?php } ?>
                    
                      <span style="color:#5C068C; font-size:1.25rem; font-weight: 400;">7.</span> I DECLARE that my Estate consists of the following classes of assets:<br>
            <?php if ($totalprt != NULL) { ?>
                            a. Real Estate<br>
                            I own the following properties:<br>
                     <div class="row">
                        <div class="col-lg-12">
                        
                            <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Type Of Property </th>
                                            <th>Location</th>
                                            <th>How Title is registered</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                          <?php do { $propertyid = $row_prt['id']; ?>
                                            <tr>
                                                 <td><?php echo $row_prt['property_type'];?></td>
                                                <td> <?php echo $row_prt['property_location'];?></td>
                                               <td><?php echo $row_prt['property_registered'];?></td>
                                            </tr>
                                          <?php } while ($row_prt = mysqli_fetch_assoc($prt));?>
                                        </tbody>
                                    </table><br>                                    

                        </div>
                      </div>
                    <?php } ?><br>
                    
                    <?php if ($totalbnk != NULL) { ?>
                            b. Cash in Bank<br>
                            I declare that I own and/or operate the following bank accounts (BVN number – <?php echo $row_bnk['bvn'];?>.):<br>
                              <div class="row">
                                  <div class="col-lg-12">
                                      <table class="table table-bordered table-responsive-sm">
                                                  <thead>
                                                    <tr>
                                                      <th>Account Name</th>
                                                      <th>Account Number</th>
                                                      <th>Account Type</th>
                                                      <th>Bank Name</th>
                                                      <th>Branch</th>
                                                      <th>Ownership status</th>
                                                      
                                                    </tr>
                                                  </thead>
                                                  <tbody> 
                                                    <?php do { ?>
                                                      <tr>
                                                          <td><?php echo $row_bnk['account_name'];?></td>
                                                          <td><?php echo $row_bnk['account_no'];?></td>
                                                          <td><?php echo $row_bnk['accounttype'];?></td>
                                                          <td><?php echo $row_bnk['bankname'];?></td>
                                                          <td> </td> 
                                                          <td> </td>
                                                        </tr>
                                                    <?php } while($row_bnk = mysqli_fetch_assoc($bnk));?>
                                                  </tbody>
                                              </table><br>
                                  </div>
                              </div> 
                    <?php } ?>  
                    
                    <?php if($totalshs != NULL){?>
                            c. stocks<br>
                            <?php do { ?>
                            i. I declare that I have a Central Securities Clearing System (CSCS)account with particulars number 
                            <?php if ($row_shs['shares_cscs'] != NULL) { echo $row_shs['shares_cscs']; }else{ echo '_______________';} ?> and CHN Number <?php if ($row_shs['shares_chn'] != NULL) { echo $row_shs['shares_chn']; }else{ echo '_______________';} ?> listing all my publicly quoted shares with <?php if ($row_shs['shares_company'] != NULL) { echo $row_shs['shares_company']; }else{ echo '_______________';} ?> as Stockbroker. <br>
                            
                            ii. I declare that I own <?php if ($row_shs['shares_percent'] != NULL) { echo $row_shs['shares_percent']; }else{ echo '_______________';} ?>% shareholding of <?php echo $row_shs['shares_company'];?> (RC__________), a company incorporated under the laws of the Federal Republic of Nigeria and at the time of writing this Will, having its office at ___________________________.
                            <?php } while ($row_shs = mysqli_fetch_assoc($shs)) ?> <br><br>
                        <?php } ?>    

                        <?php if($totalinv != NULL){?>
                            d. Mutual Fund & Investment Accounts<br>
                                <div class="row">
                                  <div class="col-lg-12">
                                      <table class="table table-bordered table-responsive-sm">
                                                  <thead>
                                                    <tr>
                                                      <th>Investment Type</th>
                                                     <th>Investment Account</th>
                                                      <th>Account Name</th>
                                                      <th>Units</th>
                                                      <th>Face Value</th>
                                                      
                                                    </tr>
                                                  </thead>
                                                  <tbody> 
                                                    <?php do { ?>
                                                      <tr>

                                                          <td><?php echo $row_inv['investment_type'];?></td>
                                                          <td><?php echo $row_inv['investment_account'];?></td>
               <td><?php echo $row_inv['investment_accountname'];?></td>
                                                          <td><?php echo $row_inv['investment_units'];?></td>
                                                          <td><?php echo $row_inv['investment_facevalue'];?> </td> 
                                                        </tr>
                                                    <?php } while($row_inv = mysqli_fetch_assoc($inv));?>
                                                  </tbody>
                                              </table><br>
                                  </div>
                              </div> 
                        <?php } ?>

                        <?php if($totalpc != NULL){?>
                            e. Personal Assets<br>
                            I declare that I own <br>
                            <?php echo $row_pc['personal_chattels'];?>
                            <br><br>
                        <?php } ?>  
                            
                            f. I declare that I am not indebted to any person or company with respect to any of my real estate property listed in Clause 7(a) of this my Will and title documents to these properties are currently in my custody at the time of writing this Will.<br><br>
                            
                            <span style="color:#5C068C; font-size:1.25rem; font-weight: 400;">8. I HEREBY DEVISE AND BEQUETH MY PROPERTIES</span> thus:<br>
                            a. Real Estate Assets<br>
                            <?php                            
                                $query_distinctproperty = "SELECT DISTINCT `propertyid` FROM overall_asset WHERE property_type = 'Property' AND uid = '$userid' ";
                                $distinctproperty = mysqli_query($conn, $query_distinctproperty) or die(mysqli_error($conn));
                                while ($row_distinctproperty = mysqli_fetch_assoc($distinctproperty)) {
                                $propertyid = $row_distinctproperty['propertyid'];

                                $querydoapropertyname = "SELECT `property_type` FROM assets_tb WHERE id = '$propertyid' "; 
                                $doapropertyname = mysqli_query($conn, $querydoapropertyname) or die(mysqli_error($conn));
                                $row_doapropertyname = mysqli_fetch_assoc($doapropertyname);

                                $querydoa = "SELECT * FROM overall_asset WHERE propertyid = '$propertyid' "; 
                                $doa = mysqli_query($conn, $querydoa) or die(mysqli_error($conn));
                                $row_doa = mysqli_fetch_assoc($doa);
                                $totaldoa = mysqli_num_rows($doa);                                
                                if ($totaldoa != NULL) { ?>
                                 <div class="row">
                                    <div class="col-lg-12">
                                      <table class="table table-bordered table-responsive-sm">
                                      <thead>
                                        <th colspan="3"><?php echo $row_doapropertyname['property_type'];?></th>
                                      </thead>
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


                    </div><br>
                    <?php }?>
                               <?php }?>


                    b. Shares<br>
                            <?php                            
                                $query_distinctshares = "SELECT DISTINCT `propertyid` FROM overall_asset WHERE property_type = 'shares' AND uid = '$userid' ";
                                $distinctshares = mysqli_query($conn, $query_distinctshares) or die(mysqli_error($conn));
                                while ($row_distinctshares = mysqli_fetch_assoc($distinctshares)) {
                                $sharesid = $row_distinctshares['propertyid'];

                                $querydoasharesname = "SELECT `shares_company` FROM assets_tb WHERE id = '$sharesid' "; 
                                $doasharesname = mysqli_query($conn, $querydoasharesname) or die(mysqli_error($conn));
                                $row_doasharesname = mysqli_fetch_assoc($doasharesname);

                                $queryshares = "SELECT * FROM overall_asset WHERE propertyid = '$sharesid' "; 
                                $shares = mysqli_query($conn, $queryshares) or die(mysqli_error($conn));
                                $row_shares = mysqli_fetch_assoc($shares);
                                $totalshares = mysqli_num_rows($shares);
                                if ($totalshares != NULL) { ?>
                                <div class="row">
                                  <div class="col-lg-12">
                                      <table class="table table-bordered table-responsive-sm">
                                      <thead>
                                        <th colspan="3"><?php echo $row_doasharesname['shares_company'];?></th>
                                      </thead>
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
                               <?php }?>


                            c. Bank accounts & Cash Gifts<br>
                            <?php 
                                $query_distinctaccount = "SELECT DISTINCT `propertyid` FROM overall_asset WHERE property_type = 'Bank Account' AND uid = '$userid' ";
                                $distinctaccount = mysqli_query($conn, $query_distinctaccount) or die(mysqli_error($conn));
                                while ($row_distinctaccount = mysqli_fetch_assoc($distinctaccount)) {
                                $bankaccountid = $row_distinctaccount['propertyid'];

                                $querydoaaccountname = "SELECT `bankname` FROM assets_tb WHERE id = '$bankaccountid' "; 
                                $doaaccountname = mysqli_query($conn, $querydoaaccountname) or die(mysqli_error($conn));
                                $row_doaaccountname = mysqli_fetch_assoc($doaaccountname);

                            $queryaccount = "SELECT * FROM overall_asset WHERE propertyid = '$bankaccountid' "; 
                            $account = mysqli_query($conn, $queryaccount) or die(mysqli_error($conn));
                            $row_account = mysqli_fetch_assoc($account);
                            $totalaccount = mysqli_num_rows($account);
                            if ($totalaccount != NULL) { ?>
                     <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-responsive-sm">
                                      <thead>
                                        <th colspan="3"><?php echo  $row_doaaccountname['bankname'];?></th>
                                      </thead>
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

                     <?php }?>
                     

                    (d)<span style="color:#5C068C; font-size:1.25rem; font-weight: 400;">EXECUTORS’ POWERS & GENERAL PROVISIONS</span><br>
                    1.  <?php if($row_execpower['question1'] != NULL ){?>
                                <?php echo $row_execpower['question1'];?> 
                        <?php }?><br><br>
                    2.  <?php if($row_execpower['question2'] != NULL ){?>
                                <?php echo $row_execpower['question2'];?> 
                        <?php }?><br><br>
                    3.  <?php if($row_execpower['question3'] != NULL ){?>
                                <?php echo $row_execpower['question3'];?> 
                        <?php }?><br><br>
                    4.  <?php if($row_execpower['question4'] != NULL ){?>
                                <?php echo $row_execpower['question4'];?> 
                        <?php }?><br><br>
                    5.  <?php if($row_execpower['question5'] != NULL ){?>
                                <?php echo $row_execpower['question5'];?> 
                        <?php }?><br><br>
                    6.  <?php if($row_execpower['question6'] != NULL ){?>
                                <?php echo $row_execpower['question6'];?> 
                        <?php }?><br><br>
                    7.  <?php if($row_execpower['question7'] != NULL ){?>
                                <?php echo $row_execpower['question7'];?> 
                        <?php }?><br><br>
                    8.  <?php if($row_execpower['question8'] != NULL ){?>
                                <?php echo $row_execpower['question8'];?> 
                        <?php }?><br><br>
                    9.  <?php if($row_execpower['question9'] != NULL ){?>
                                <?php echo $row_execpower['question9'];?> 
                        <?php }?><br><br>
                    10. <?php if($row_execpower['question10'] != NULL ){?>
                                <?php echo $row_execpower['question10'];?> 
                        <?php }?><br><br>
                    11. <?php if($row_execpower['question11'] != NULL ){?>
                                <?php echo $row_execpower['question11'];?> 
                        <?php }?><br><br>
                    <span style="color:#5C068C; font-size:1.25rem; font-weight: 400;">B.  SUBSTITUTION BEQUEST</span><br>
                         <?php if($row_execpower['question12'] != NULL ){?>
                                <?php echo $row_execpower['question12'];?> 
                        <?php }?><br><br>
                    <span style="color:#5C068C; font-size:1.25rem; font-weight: 400;">C. RESIDUAL BEQUEST </span><br>
                    i.  <?php if($row_execpower['question13'] != NULL ){?>
                                <?php echo $row_execpower['question13'];?> 
                        <?php }?><br>
                    ii. <?php if($row_execpower['question14'] != NULL ){?>
                                <?php echo $row_execpower['question14'];?> 
                        <?php }?><br><br>
                    <span style="color:#5C068C; font-size:1.25rem; font-weight: 400;">D. EXECUTORS/TRUSTEES REMUNERATION </span><br>
                    <?php if($row_execpower['question15'] != NULL ){?>
                                <?php echo $row_execpower['question15'];?> 
                        <?php }?><br><br><br><br>
                    IN WITNESS WHEREOF the TESTATOR has set his hand and seal to be hereunder affixed this ______day of _________2019.<br><br>
                    SIGNED by the above-namedTESTATOR <br>
                    _________________________________<br><br>
                    _________________________________ <br>
                    Signature of the Testator <br><br>
                    Signed by the Testator in our presence and Attested by us in the presence of him and of each other. <br><br>
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
                    </div> 
<?php } while ($row_wit = mysqli_fetch_assoc($wit));?>

<?php if($willcount == NULL){?>
        <h5 class="with-border">Declaration</h5>
            <div class="row">
                        <div class="col-lg-1">
                            <fieldset class="form-group">
                            <input type="checkbox" name="agree" required style="width:50px; height:50px;"/>
                            </fieldset>
                        </div>
                        <div class="col-lg-11">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput"> I hereby undertake and declare that all the statements made above and overleaf are true and correct and that I have not 
withheld any material information. I also agree to give notice to FCMB TRUSTEES LIMITED in the event of any change in the information given.</label>
                            </fieldset>
                        </div>
                    </div>
                    

<input type="hidden" name="willtype" value="Comprehensive Will" />
<input type="hidden" name="uid" value="<?php echo $userid ;?>" />
<input type="hidden" name="fullname" value="<?php echo $salutation.' '.ucfirst($fname).' '.ucfirst($mname).' '.ucfirst($lname);?>" />
<input type="hidden" name="addr" value="<?php echo $msg;?>" />
<input type="hidden" name="email" value="<?php echo $email ;?>" >
<input type="hidden" name="phone" value="<?php echo $phone ;?>" >
<input type="hidden" name="aphone" value="<?php echo $row_pi['aphone'];?>" />
<input type="hidden" name="gender" value="<?php echo $row_pi['gender'];?>" />
<input type="hidden" name="dob" value="<?php echo $dob ;?>" />
<input type="hidden" name="state" value="<?php echo $row_pi['state'] ;?>" / >
<input type="hidden" name="nationality" value="<?php echo $row_pi['nationality'] ;?>" />
<input type="hidden" name="lga"  value="<?php echo $row_pi['lga'];?>" />
<input type="hidden" name="employmentstatus" value="<?php echo $row_pi['employment_status'];?>" >
<input type="hidden" name="employer" value="<?php echo $row_pi['employer'];?>" >
<input type="hidden" name="employerphone" value="<?php echo $row_pi['employerphone'];?>" >
<input type="hidden" name="employeraddr" value="<?php echo $row_pi['employeraddr'];?>" >
<input type="hidden" name="maritalstatus" value="<?php echo $row_ms['status'];?>" >
<input type="hidden" name="spname" value="<?php echo $sptitle.' '.$spfullname;?>" >
<input type="hidden" name="spemail" value="<?php echo $spemail;?>" >
<input type="hidden" name="spphone" value="<?php echo $spphone;?>" >
<input type="hidden" name="sdob" value="<?php echo $sdob; ?>"  >
<input type="hidden" name="spaddr" value="<?php echo $spaddr;?>" >
<input type="hidden" name="spcity" value="<?php echo $spcity;?>" >
<input type="hidden" name="spstate" value="<?php echo $spstate;?>" >
<input type="hidden" name="marriagetype" value="<?php echo $marriagetype;?>" >
<input type="hidden" name="marriageyear" value="<?php echo $marriageyear;?>" >
<input type="hidden" name="marriagecert" value="<?php echo $marriagecert;?>" >
<input type="hidden" name="spcitym" value="<?php echo $spcitym;?>" >
<input type="hidden" name="spcountrym" value="<?php echo $spcountrym;?>" >
<input type="hidden" name="divorce" value="<?php echo $divorce ;?>"  >
<input type="hidden" name="divorceyear" value="<?php echo $divorceyear ;?>" >
<input type="hidden" name="addinfo" value="<?php echo $row_info['addinfo'];?>">
<input type="submit" value="SUBMIT" class="btn btn-inline btn-fcmb" style="float:right;">            
<?php } ?>

 </p>           
    </div>
</section>



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