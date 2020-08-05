<?php require ('Connections/conn.php');
//include ('session.php');
//if(!isset($userid)){
//header('location:index.php');
//exit();
//}

$a = $_GET['a'];
$userid = $a;

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

$querybeneficiarydump = "SELECT * FROM simplewill_beneficiary WHERE uid = '$userid' ";
$beneficiarydump = mysqli_query($conn, $querybeneficiarydump) or die(mysqli_error($conn));
$row_beneficiarydump = mysqli_fetch_assoc($beneficiarydump);
$totalbeneficiarydump = mysqli_num_rows($beneficiarydump);
isset($startRow_pay)? $orderNum=$startRow_pay :$orderNum=0;

$queryguardian = "SELECT * FROM simplewill_guardian WHERE uid = '$userid' ";
$guardian = mysqli_query($conn, $queryguardian) or die(mysqli_error($conn));
$row_guardian = mysqli_fetch_assoc($guardian);
$totalguardian = mysqli_num_rows($guardian);
//isset($startRow_guardian)? $guardianNum=$startRow_guardian :$guardianNum=0;

$queryfinancialguardian = "SELECT * FROM simplewill_financial_guardian WHERE uid = '$userid' ";
$financialguardian = mysqli_query($conn, $queryfinancialguardian) or die(mysqli_error($conn));
$row_financialguardian = mysqli_fetch_assoc($financialguardian);
$totalfinancialguardian = mysqli_num_rows($financialguardian);
//isset($startRow_pay)? $orderNum=$startRow_pay :$orderNum=0;

$querybnk = "SELECT * FROM simplewill_assets_tb WHERE uid = '$userid' AND asset_type = 'bankaccount' "; 
$bnk = mysqli_query($conn, $querybnk) or die(mysqli_error($conn));
$row_bnk = mysqli_fetch_assoc($bnk);
$totalbnk = mysqli_num_rows($bnk);

$querypns = "SELECT * FROM simplewill_assets_tb WHERE uid = '$userid' AND asset_type = 'pension' "; 
$pns = mysqli_query($conn, $querypns) or die(mysqli_error($conn));
$row_pns = mysqli_fetch_assoc($pns);
$totalpns = mysqli_num_rows($pns);

$queryemployment = "SELECT * FROM simplewill_assets_tb WHERE uid = '$userid' AND asset_type = 'pension' "; 
$employment = mysqli_query($conn, $queryemployment) or die(mysqli_error($conn));
$row_employment = mysqli_fetch_assoc($employment);
$totalemployment = mysqli_num_rows($employment);

$querywit = "SELECT * FROM simplewill_witness_tb WHERE uid = '$userid' "; 
$wit = mysqli_query($conn, $querywit) or die(mysqli_error($conn));
$row_wit = mysqli_fetch_assoc($wit);
$totalwit = mysqli_num_rows($wit);

$queryexe = "SELECT * FROM simplewill_executors_tb WHERE uid = '$userid' "; 
$exe = mysqli_query($conn, $queryexe) or die(mysqli_error($conn));
$row_exe = mysqli_fetch_assoc($exe);
$totalexe = mysqli_num_rows($exe);

//CHECK IF SIMPLE WILL HAS BEEN SUBMITTED.
$query_submit = "SELECT `id`,`uid`, `datecreated` FROM simplewill_tb WHERE `uid` = '$userid' "; 
$submit = mysqli_query($conn, $query_submit) or die(mysqli_error($conn));
$row_submit = mysqli_fetch_assoc($submit);
$totalsubmit = mysqli_num_rows($submit);


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


  function Export2Doc(element, filename = ''){
    var preHtml = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'><head><title>Export HTML To Doc</title></head><body>";
    var postHtml = "</body></html>";
    var html = preHtml+document.getElementById(element).innerHTML+postHtml;

    var blob = new Blob(['\ufeff', html], {
        type: 'application/msword'
    });
    
    // Specify link url
    var url = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(html);
    
    // Specify file name
    filename = filename?filename+'.doc':'document.doc';
    
    // Create download link element
    var downloadLink = document.createElement("a");

    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob ){
        navigator.msSaveOrOpenBlob(blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = url;
        
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
    
    document.body.removeChild(downloadLink);
}
</script>

</head>
<body>

<?php include ('inc/inc_header.php');?>

    <div class="page-content">
        <div class="container-fluid">
<form action="#" method="POST">            
            <div class="row">
                <div class="col-lg-3 col-lg-pull-6 col-md-6 col-sm-6">
                    <section class="box-typical sidemenu">
            <div class="profile-card">
              <div class="profile-card-photo">
                <img src="img/fcmb-avatar.png" alt=""/>
              </div>
              <div class="profile-card-name">Hi FCMB Trustees</div>
            </div><!--.profile-card-->

          </section>



                </div><!--.col- -->

                <div class="col-lg-9 col-lg-push-3 col-md-12">

                <!--<button onclick="Export2Doc('exportContent');" class="btn btn-inline btn-fcmb">Export as .doc</button>-->

                <section class="card">
                <div class="card-block" id="exportContent">
                      <p><strong>THIS IS THE LAST WILL & TESTAMENT OF</strong> <?php echo $salutation.' '.ucfirst($fname).' '.ucfirst($mname).' '.ucfirst($lname);?> made this <?php $datecreated = $row_submit['datecreated']; echo date("jS", strtotime($datecreated)); ?> day of <?php 
                      $datecreated = $row_submit['datecreated']; echo date("F,", strtotime($datecreated)); ?> <?php 
                      $datecreated = $row_submit['datecreated']; echo date("Y", strtotime($datecreated)); ?>.  

                      <br>
                      <h5>PRELIMINARY DECLARATIONS </h5>
                      I, <?php echo $salutation;?> <?php echo ucfirst($fname);?> <?php echo ucfirst($mname);?> <?php echo ucfirst($lname);?> of <?php echo $msg;?>, <?php echo $row_pi['state'] ;?> State, Nigeria, born on the
                      <?php $dobnew = $dob; echo date("jS F, Y", strtotime($dobnew)); ?> and being of sound mind and body hereby revoke all previous Wills, Codicils and other testamentary dispositions made by me and therefore declare this Will to be <strong>MY LAST WILL & TESTAMENT</strong>.<br><br>
                      <h5>2. EXECUTORS: </h5>
                      I hereby appoint the following to be the Executors of this my Will:<br>
                      <?php do { ?>
                      <p><?php echo ++$orderNumexe?>. <?php echo $row_exe['fullname'];?> of <?php echo $row_exe['addr'];?> <?php echo $row_exe['phone'];?> <?php echo $row_exe['email'];?> <?php echo $row_exe['rtionship'];?></p>
                      <?php } while ($row_exe = mysqli_fetch_assoc($exe));?>
                      <h5>3. DEFINITION/ INTERPRETATION  </h5>
                      (a)   The term "Estate" refers to my pension benefits and /or all entitlements due from my employer and/or proceeds realised from my personal bank accounts.<br>
                      (b)   The term "Children" refers to my blood descendants as listed in this my Will and no other person(s) shall receive and benefit under this Will under their appellation.</p>
                      <h5>4. BANK ACCOUNTS </h5>
                      I declare that I own and/or operate the following bank accounts (BVN number - <?php echo $row_bnk['bvn'];?>). I hereby give the cumulative proceeds to the persons(s) listed hereunder and such proceeds shall fall part of the Estate to be distributed in the proportions indicated against their respective names with particulars of which are set forth in the schedule below;

                    <?php if ($totalbnk != NULL) { ?>
                    <div class="row">
                        <div class="col-lg-12">
                        <?php do { 
                        $bankaccountid = $row_bnk['id'];
                        ?>
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
                                            <th>Full Names of Beneficiary(ies) and Relationship</th>
                                            <th>Address of Beneficiaries</th>
                                            <th>Percentage</th>
                                            <th>Other Comment (If any)</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                        <?php do { 
                                        $accountid = $row_account['propertyid'];
                                        $queryaccountname = "SELECT * FROM simplewill_assets_tb WHERE id = '$accountid' "; 
                                        $accountname = mysqli_query($conn, $queryaccountname) or die(mysqli_error($conn));
                                        $row_accountname = mysqli_fetch_assoc($accountname);

                                        $accountbeneficiary = $row_account['beneficiaryid'];
                                        $queryaccountbeneficiary = "SELECT `id`, `title`, `fullname`, `rtionship`, `addr` FROM simplewill_beneficiary WHERE id = '$accountbeneficiary' "; 
                                        $query_run3 = mysqli_query($conn, $queryaccountbeneficiary) or die(mysqli_error($conn));
                                        $row_accountbeneficiary = mysqli_fetch_assoc($query_run3);

                                        $queryaltbankdetails = "SELECT `id`, `uid`, `childid`, `title`, `fullname` FROM alt_beneficiary WHERE childid = '$accountbeneficiary' "; 
                                        $query_altbankdetails = mysqli_query($conn, $queryaltbankdetails ) or die(mysqli_error($conn));
                                        $row_altbankdetails = mysqli_fetch_assoc($query_altbankdetails);
 
                                         ?>
                                            <tr>
                                                <td><?php echo $row_accountbeneficiary['title'];?> <?php echo $row_accountbeneficiary['fullname'];?> (<?php echo $row_accountbeneficiary['rtionship'];?>)</td>
                                                <td><?php echo $row_accountbeneficiary['addr'];?></td>
                                                <td><?php echo $row_account['percentage'];?>%</td>
                                                <td></td>
                                            </tr>
                                        <?php } while ($row_account = mysqli_fetch_assoc($account));?>
                                                                                </tbody>
                                    </table>
                        </div>


                    </div><br>
                    <?php }?>
                                    <?php } while($row_bnk = mysqli_fetch_assoc($bnk));?>
                        </div>
                    </div> 
                    <?php } ?>  

                    <h5>5. PENSION  </h5>
                    <strong>RSA No.:</strong> PEN <?php echo $row_pns['rsa'] ;?> <br>
                    <strong>PENSION FUND ADMINISTRATOR:</strong> <?php echo $row_pns['pension_admin'] ;?> <br>
                    I hereby bequeath to the person(s) listed hereunder in the proportions indicated against their respective names all pension benefits due from my employer by virtue of the provisions of the Pension Reform Act 2014 as well as any entitlements due from my employer for my benefit.<br>
                                    <?php if ($totalpns != NULL) { ?>
                    <div class="row">
                        <div class="col-lg-12">

                        <?php do { 
                        $pensionid = $row_pns['id'];
                        ?><br>
                                    <p>Pension Percentage Sharing</p>
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
                                            <th>Full Names of Beneficiary(ies) and Relationship</th>
                                            <th>Address of Beneficiaries</th>
                                            <th>Percentage</th>
                                            <th>Other Comment (If any)</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                        <?php do { 
                                        $pensionid = $row_pension['propertyid'];
                                        $querypensionname = "SELECT * FROM simplewill_assets_tb WHERE id = '$pensionid' "; 
                                        $pensionname = mysqli_query($conn, $querypensionname) or die(mysqli_error($conn));
                                        $row_pensionname = mysqli_fetch_assoc($pensionname);

                                        $pensionbeneficiary = $row_pension['beneficiaryid'];
                                        $querypensionbeneficiary = "SELECT `id`, `title`, `fullname`, `rtionship`, `addr` FROM simplewill_beneficiary WHERE id = '$pensionbeneficiary' "; 
                                        $query_run4 = mysqli_query($conn, $querypensionbeneficiary) or die(mysqli_error($conn));
                                        $row_pensionbeneficiary = mysqli_fetch_assoc($query_run4);

                                        $queryaltpension = "SELECT `id`, `uid`, `childid`, `title`, `fullname` FROM alt_beneficiary WHERE childid = '$pensionbeneficiary' "; 
                                        $query_altpension = mysqli_query($conn, $queryaltpension ) or die(mysqli_error($conn));
                                        $row_altpension = mysqli_fetch_assoc($query_altpension);
 
                                         ?>
                                            <tr>
                                                <td><?php echo $row_pensionbeneficiary['title'];?> <?php echo $row_pensionbeneficiary['fullname'];?> (<?php echo $row_pensionbeneficiary['rtionship'];?>)</td>
                                                <td><?php echo $row_pensionbeneficiary['addr'];?></td>
                                                <td><?php echo $row_pension['percentage'];?>%</td>
                                                <td></td>
                                            </tr>
                                        <?php } while ($row_pension = mysqli_fetch_assoc($pension));?>
                                                                                </tbody>
                                    </table>
                        </div>


                    </div>
                    <?php }?>
                                     <?php } while ($row_pns = mysqli_fetch_assoc($pns)) ;?>
                        </div>
                    </div><br>
                <?php } ?>
                <h5>6. EMPLOYMENT BENEFITS  </h5>
                I hereby direct that all my other employment benefits shall be distributed as follows:<br>
                    <?php if ($totalemployment != NULL) { ?>
                    <div class="row">
                        <div class="col-lg-12">

                        <?php do { 
                        $employmentid = $row_employment['id'];
                        ?>
<?php 
$queryemploy = "SELECT * FROM simplewill_overall_asset WHERE propertyid = '$employmentid' "; 
$employ = mysqli_query($conn, $queryemploy) or die(mysqli_error($conn));
$row_employ = mysqli_fetch_assoc($employ);
$totalemploy = mysqli_num_rows($employ);
                if ($totalemploy != NULL) { ?>
                     <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Full Names of Beneficiary(ies) and Relationship</th>
                                            <th>Address of Beneficiaries</th>
                                            <th>Percentage</th>
                                            <th>Other Comment (If any)</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                        <?php do { 
                                        $employid = $row_employ['propertyid'];
                                        $queryemployname = "SELECT * FROM simplewill_assets_tb WHERE id = '$employid' "; 
                                        $employname = mysqli_query($conn, $queryemployname) or die(mysqli_error($conn));
                                        $row_employname = mysqli_fetch_assoc($employname);

                                        $employbeneficiary = $row_employ['beneficiaryid'];
                                        $queryemploybeneficiary = "SELECT `id`, `title`, `fullname`, `rtionship`, `addr` FROM simplewill_beneficiary WHERE id = '$employbeneficiary' "; 
                                        $query_run5 = mysqli_query($conn, $queryemploybeneficiary) or die(mysqli_error($conn));
                                        $row_employbeneficiary = mysqli_fetch_assoc($query_run5);

            $queryaltemploy = "SELECT `id`, `uid`, `childid`, `title`, `fullname` FROM alt_beneficiary WHERE childid = '$employbeneficiary' "; 
   $query_altemploy = mysqli_query($conn, $queryaltemploy ) or die(mysqli_error($conn));
                                        $row_altemploy = mysqli_fetch_assoc($query_altemploy);
 
                                         ?>
                                            <tr>
                                                <td><?php echo $row_employbeneficiary['title'];?> <?php echo $row_employbeneficiary['fullname'];?> (<?php echo $row_employbeneficiary['rtionship'];?>)</td>
                                                <td><?php echo $row_employbeneficiary['addr'];?></td>
                                                <td><?php echo $row_employ['percentage'];?>%</td>
                                                <td></td>
                                            </tr>
                                        <?php } while ($row_employ = mysqli_fetch_assoc($employ));?>
                                                                                </tbody>
                                    </table>
                        </div>


                    </div>
                    <?php }?>
                                     <?php } while ($row_employment = mysqli_fetch_assoc($employment)) ;?>
                        </div>
                    </div>
                <?php } ?><br>
                    <h5>7. GUARDIANS  </h5>
                    I appoint the undermentioned as the Physical Guardian to this my Will in respect of any of my Beneficiaries who are yet to attain the age of 18 as at the time of my demise.
                    <?php do { ?>
                      <p>i. <?php echo $row_guardian['title'].' '.$row_guardian['fullname'];?> of <?php echo $row_guardian['addr'];?> <?php echo $row_guardian['phone'];?> <?php echo $row_guardian['rtionship'];?>
                      <?php } while ($row_guardian = mysqli_fetch_assoc($guardian));?> </p>
                      <p><span style="color:#5C068C; font-size:1.25rem; font-weight: 400;">8.</span> I appoint the undermentioned as the Financial Guardian to this my Will in respect of any of my Beneficiaries who are yet to attain the age of 18 and above at the time of my demise.<br>
                      <?php do { ?>
                      ii. <?php echo $row_financialguardian['title'].' '.$row_financialguardian['fullname'];?> of <?php echo $row_financialguardian['addr'];?> <?php echo $row_financialguardian['phone'];?> <?php echo $row_financialguardian['rtionship'];?>
                      <?php } while ($row_financialguardian = mysqli_fetch_assoc($financialguardian));?></p>
                       <p><span style="color:#5C068C; font-size:1.25rem; font-weight: 400;">9.</span> I direct my Executors to open an Estate account and to utilize the entitlements due to my minor beneficiaries in the proportion stated by me above strictly for the welfare of my minor beneficiaries until they each attain the age of 18 years or upon completion of their education, whereupon the residues shall then revert to each beneficiary respectively in the proportion to which they are entitled under this my Will. </p>
                       <p><span style="color:#5C068C; font-size:1.25rem; font-weight: 400;">10.</span> In the event that any of my children become deceased before receiving his/her benefits under this Will, such benefits shall be distributed among their children per stirpes and if there are no children, such benefits shall be equally distributed among my living Beneficiaries. </p>
                       <p><span style="color:#5C068C; font-size:1.25rem; font-weight: 400;">11.</span>That the costs, charges and fees whatsoever required to prove and administer this my Will, as well as all other pecuniary liabilities that may arise in course of administering my Will (hereinafter referred to as the "Fees") shall borne by my Estate. The Executors are hereby mandated to deduct the charges from the Estate before paying same over to the beneficiaries in the proportions stated herein.</p>
                       <p><span style="color:#5C068C; font-size:1.25rem; font-weight: 400;">12.</span>Upon the payment of all Charges required to prove and administer my Will, I hereby devise and bestow the residue of all Estate which are specifically disposed under this Will or by any amendment hereto to the beneficiaries listed in clause 3 above, in equal proportions.</p>
                       <p><span style="color:#5C068C; font-size:1.25rem; font-weight: 400;">13.</span> I hereby undertake and declare that all the statements made above and overleaf are true and correct and that I have not withheld any material information. I also agree to give notice to FCMB TRUSTEES LIMITED in the event of any change in the information given.</p><br><br>
                       <strong>IN WITNESS WHEREOF the TESTATOR has executed this Will this</strong> ______of___________, ______________ <br><br>
                        <strong>Name Of Testator:</strong> &nbsp;&nbsp;&nbsp;<u><?php echo $salutation.' '.ucfirst($fname).' '.ucfirst($mname).' '.ucfirst($lname);?></u><br><br>
                        <strong>Signature of the Testator:</strong> ______________________________________________________________________<br><br>
                                        <?php do { ?>
                        <h5>Witness #<?php echo ++$orderNumwit?></h5>
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
                      </p>

                </div>
            </section>
            
            <button onclick="Export2Doc('exportContent');" class="btn btn-inline btn-fcmb">Export as .doc</button>

                </div><!--.col- -->
                
                
            </div><!--.row-->
</form>
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