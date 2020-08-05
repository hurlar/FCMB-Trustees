<?php require ('Connections/conn.php');
include ('session.php');
if(!isset($userid)){
header('location:index.php');
exit();
}
//ADD PROPERTY QUERY
$queryprt = "SELECT `id`,`uid`,`asset_type`, `property_location`, `property_type`, `property_registered` FROM assets_tb WHERE uid = '$userid' AND `asset_type` = 'property' ";
$prt = mysqli_query($conn, $queryprt) or die(mysqli_error($conn));
$row_prt = mysqli_fetch_assoc($prt);
$totalprt = mysqli_num_rows($prt);

//EDIT PROPERTY QUERY
$queryeprt = "SELECT `id`,`uid`,`asset_type`, `property_location`, `property_type`, `property_registered` FROM assets_tb WHERE uid = '$userid' ";
$eprt = mysqli_query($conn, $queryeprt) or die(mysqli_error($conn));
$row_eprt = mysqli_fetch_assoc($eprt);
$totaleprt = mysqli_num_rows($eprt);

//ADD SHARES QUERY
$querysh = "SELECT `id`,`uid`,`shares_company`,`shares_volume`,`shares_percent`,`shares_cscs`,`shares_chn` FROM assets_tb WHERE uid = '$userid' AND `asset_type` = 'shares' ";
$sh = mysqli_query($conn, $querysh) or die(mysqli_error($conn));
$row_sh = mysqli_fetch_assoc($sh);
$totalsh = mysqli_num_rows($sh); 

//EDIT SHARES QUERY
$queryeditsh = "SELECT `id`,`uid`,`shares_company`,`shares_volume`,`shares_percent`,`shares_cscs`,`shares_chn` FROM assets_tb WHERE uid = '$userid' AND `asset_type` = 'shares' ";
$editsh = mysqli_query($conn, $queryeditsh) or die(mysqli_error($conn));
$row_editsh = mysqli_fetch_assoc($editsh);
$totaleditsh = mysqli_num_rows($editsh); 

//ADD INSURANCE QUERY
$queryins = "SELECT `id`,`uid`,`insurance_company`,`insurance_type`,`insurance_owner`,`insurance_facevalue` FROM assets_tb WHERE uid = '$userid' AND `asset_type` = 'insurance' ";
$ins = mysqli_query($conn, $queryins) or die(mysqli_error($conn));
$row_ins = mysqli_fetch_assoc($ins);
$totalins = mysqli_num_rows($ins); 

//EDIT INSURANCE QUERY
$queryeditins = "SELECT `id`,`uid`,`insurance_company`,`insurance_type`,`insurance_owner`,`insurance_facevalue` FROM assets_tb WHERE uid = '$userid' AND `asset_type` = 'insurance' ";
$editins = mysqli_query($conn, $queryeditins) or die(mysqli_error($conn));
$row_editins = mysqli_fetch_assoc($editins);
$totaleditins = mysqli_num_rows($editins); 

//ADD BANK ACCOUNT QUERY
$querybkd = "SELECT `id`,`uid`,`bvn`,`account_name`,`account_no`,`bankname`,`accounttype` FROM assets_tb WHERE uid = '$userid' AND `asset_type` = 'bankaccount' ";
$bkd = mysqli_query($conn, $querybkd) or die(mysqli_error($conn));
$row_bkd = mysqli_fetch_assoc($bkd);
$totalbkd = mysqli_num_rows($bkd); 
//echo $row_bkd['bvn']; exit();

//EDIT BANK ACCOUNT QUERY
$queryeditbkd = "SELECT `id`,`uid`,`bvn`,`account_name`,`account_no`,`bankname`,`accounttype` FROM assets_tb WHERE uid = '$userid' AND `asset_type` = 'bankaccount' ";
$editbkd = mysqli_query($conn, $queryeditbkd) or die(mysqli_error($conn));
$row_editbkd = mysqli_fetch_assoc($editbkd);
$totaleditbkd = mysqli_num_rows($editbkd); 
//echo $row_bkd['bvn']; exit();

//gets the BVN details of the User
$querybkd1 = "SELECT `id`,`uid`,`bvn` FROM assets_tb WHERE uid = '$userid' AND `asset_type` = 'bankaccount' ";
$bkd1 = mysqli_query($conn, $querybkd1) or die(mysqli_error($conn));
$row_bkd1 = mysqli_fetch_assoc($bkd1);
$totalbkd1 = mysqli_num_rows($bkd1); 
//echo $row_bkd['bvn']; exit();

//ADD PENSIONS QUERY
$querypns = "SELECT `id`,`uid`, `pension_name`, `pension_owner`,`pension_plan`,`rsano`,`pension_admin` FROM assets_tb WHERE uid = '$userid' AND `asset_type` = 'Pension' ";
$pns = mysqli_query($conn, $querypns) or die(mysqli_error($conn));
$row_pns = mysqli_fetch_assoc($pns);
$totalpns = mysqli_num_rows($pns); 

//EDIT PENSIONS QUERY
$queryeditpns = "SELECT `id`,`uid`, `pension_name`, `pension_owner`,`pension_plan`,`rsano`,`pension_admin` FROM assets_tb WHERE uid = '$userid' AND `asset_type` = 'Pension' ";
$editpns = mysqli_query($conn, $queryeditpns) or die(mysqli_error($conn));
$row_editpns = mysqli_fetch_assoc($editpns);
$totaleditpns = mysqli_num_rows($editpns); 

//ADD INVESTMENT QUERY
$queryinvestment = "SELECT `id`, `uid`, `investment_type`, `investment_account`,`investment_accountname`, `investment_units`, `investment_facevalue` FROM assets_tb WHERE uid = '$userid' AND `asset_type` = 'Other Investments' ";
$investment = mysqli_query($conn, $queryinvestment) or die(mysqli_error($conn));
$row_investment = mysqli_fetch_assoc($investment);
$totalinvestment = mysqli_num_rows($investment); 

//EDIT INVESTMENT QUERY
$queryeditinvestment = "SELECT `id`,`uid`, `investment_type`, `investment_account`,`investment_accountname`,`investment_units`,`investment_facevalue` FROM assets_tb WHERE uid = '$userid' AND `asset_type` = 'Other Investments' ";
$editinvestment = mysqli_query($conn, $queryeditinvestment) or die(mysqli_error($conn));
$row_editinvestment = mysqli_fetch_assoc($editinvestment);
$totaleditinvestment = mysqli_num_rows($editinvestment); 

//ADD PERSONAL CHATTEL QUERY
$querychattel = "SELECT `id`, `uid`, `personal_chattels` FROM assets_tb WHERE uid = '$userid' AND `asset_type` = 'Personal Chattels' ";
$chattel = mysqli_query($conn, $querychattel) or die(mysqli_error($conn));
$row_chattel = mysqli_fetch_assoc($chattel);
$totalchattel = mysqli_num_rows($chattel);

//EDIT PERSONAL CHATTEL QUERY
$queryeditchattel = "SELECT `id`,`uid`, `personal_chattels` FROM assets_tb WHERE uid = '$userid' AND `asset_type` = 'Personal Chattels' ";
$editchattel = mysqli_query($conn, $queryeditchattel) or die(mysqli_error($conn));
$row_editchattel = mysqli_fetch_assoc($editchattel);
$totaleditchattel = mysqli_num_rows($editchattel); 

//$queryest = "SELECT * FROM estate_tb WHERE uid = '$userid' ";
//$est = mysqli_query($conn, $queryest) or die(mysqli_error($conn));
//$row_est = mysqli_fetch_assoc($est);
//$totalest = mysqli_num_rows($est); 

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

        .boxxxxx{
        /*color: #fff;*/
        display: none;
        margin-top: 20px;
    }
    .Yes{ background: #FFFFFF; }

</style>

<script type="text/javascript">
$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        var inputValue = $(this).attr("value");
        var targetBoxxxxx = $("." + inputValue);
        $(".boxxxxx").not(targetBoxxxxx).hide();
        $(targetBoxxxxx).show();
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
                    
                    <section class="box-typical sidemenu">
                        <div class="profile-card">
                        <div class="profile-card-name"> Go to Dashboard</div> <br/>

                                <a href="dashboard.php"><button type="button" class="btn btn-inline btn-fcmb" > Go Back </button></a>
                                </div>

                    </section>

                </div><!--.col- -->

                <div class="col-lg-9 col-lg-push-3 col-md-12">
       <form action="processor/process-asset.php" method="post">             
                            <section class="card">

                <div class="card-block">
                    <h5 class="with-bo/rder">Add your Assets</h5>

                    <div class="row">
                    
                <div class="col-md-12 col-sm-12">
                <p>Tell us what you own <br>
                                <br>
                <strong> Ensure you give a clear and adequate description of each asset for easy identification.</strong></p>
                
                                                              <?php 

if (isset($_GET['a'])) {  
$url = mysqli_real_escape_string($conn, $_GET['a']);

?>

<?php if($url == 'bankname'){  ?>
<div class="alert alert-warning alert-fill alert-close alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <?php echo  ' Bank name must consist of letters only. ' ; ?>
</div>
<?php } ?>

<?php if($url == 'actname'){  ?>
<div class="alert alert-warning alert-fill alert-close alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <?php echo  ' Account name must consist of letters only. ' ; ?>
</div>
<?php } ?>

<?php if($url == 'bvn'){  ?>
<div class="alert alert-warning alert-fill alert-close alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <?php echo  ' BVN must consist of numbers only and must be 11 characters. ' ; ?>
</div>
<?php } ?>

<?php if($url == 'actno'){  ?>
<div class="alert alert-warning alert-fill alert-close alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <?php echo  ' Account number must consist of numbers only and must be 10 characters. ' ; ?>
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

<?php if($url == 'successful'){  ?>
<div class="alert alert-success alert-fill alert-close alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <?php echo  ' Add successful' ; ?>
</div>
<?php } ?>

<?php if($url == 'update'){  ?>
<div class="alert alert-success alert-fill alert-close alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <?php echo  ' Update successful' ; ?>
</div>
<?php } ?>

<?php if($url == 'delete'){  ?>
<div class="alert alert-success alert-fill alert-close alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <?php echo  ' Delete successful' ; ?>
</div>
<?php } ?>

<?php if($url == 'denied'){  ?>
<div class="alert alert-warning alert-fill alert-close alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <?php echo  ' Please add an asset ' ; ?>
</div>
<?php } ?>


<?php } ?>
                
                
                

                    <section class="widget widget-accordion" id="accordion" role="tablist" aria-multiselectable="true">
                    
                        <article class="panel">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <a data-toggle="collapse"
                                   data-parent="#accordion"
                                   href="#collapseOne"
                                   aria-expanded="true"
                                   aria-controls="collapseOne">
                                    Add Your Property
                                    <i class="font-icon font-icon-arrow-down"></i>
                                </a>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-collapse-in">
                                <?php if ($totalprt != NULL) { ?>
                                    <table id="table-sm" class="table table-bordered table-hover table-responsive">
                                                <thead>
                                                <tr>
                                                    <th>Location</th>
                                                    <th>Type of Property</th>
                                                    <th>How is title Registered</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php do { ?>
                                                <tr>
                                                    <td><?php echo $row_prt['property_location'];?></td>
                                                    <td><?php echo $row_prt['property_type'];?></td>
                                                    <td><?php echo $row_prt['property_registered'];?></td>
                                                    <td><button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#editproperty<?php echo $row_prt['id'];?>">
                                                        Edit
                                                        </button>
                                                    </td>
                                                    <td><a href="processor/process-deleteproperty.php?a=<?php echo $row_prt['id'];?>"><input type="button" na/me="view" value="Delete" class="btn btn-fcmb btn-xs view_data" onclick="return confirm('Are you sure you want to delete ?');"/></a></td>
                                                </tr>
                                                <?php } while ($row_prt = mysqli_fetch_assoc($prt));?>
                                                </tbody>
                                            </table>
                                <?php } ?>
                                            <br/>
                                    <button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#addproperty">
                                        Add Property
                                    </button>
                                </div>
                            </div>
                        </article>
                        <article class="panel">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <a class="collapsed"
                                   data-toggle="collapse"
                                   data-parent="#accordion"
                                   href="#collapseTwo"
                                   aria-expanded="false"
                                   aria-controls="collapseTwo">
                                    Add Your Shares/ Stocks
                                    <i class="font-icon font-icon-arrow-down"></i>
                                </a>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-collapse-in">
                                <?php if ($totalsh != NULL) { ?>
                                <table id="table-sm" class="table table-bordered table-hover table-responsive">
                                                <thead>
                                                <tr>
                                                    <th>Company   </th>
                                                    <th>Volume/ Value</th>
                                                    <th>Percentage of shareholdings</th>
                                                    <th>CSCS No. (If Applicable)</th>
                                                    <th>Clearing House No. (CHN)</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                            <?php do { ?>
                                                <tr>
                                                    <td><?php echo $row_sh['shares_company'] ;?></td>
                                                    <td><?php echo $row_sh['shares_volume'] ;?></td>
                                                    <td><?php echo $row_sh['shares_percent'] ;?></td>
                                                    <td><?php echo $row_sh['shares_cscs'] ;?></td>
                                                    <td><?php echo $row_sh['shares_chn'] ;?></td>
                                                    <td><button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#editshares<?php echo $row_sh['id'];?>">
                                                        Edit
                                                        </button>
                                                    </td>
                                                    <td><a href="processor/process-deleteshares.php?a=<?php echo $row_sh['id'];?>"><input type="button" na/me="view" value="Delete" class="btn btn-fcmb btn-xs view_data" onclick="return confirm('Are you sure you want to delete ?');"/></a></td>
                                                </tr>
                                            <?php } while ($row_sh = mysqli_fetch_assoc($sh));?>
                                                </tbody>
                                            </table>
                                <?php } ?>
                                            <br/>
                                    <button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#addshares">
                                        Add Shares/ Stocks
                                    </button>
                                </div>
                            </div>
                        </article>
                        <article class="panel">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <a class="collapsed"
                                   data-toggle="collapse"
                                   data-parent="#accordion"
                                   href="#collapseThree"
                                   aria-expanded="false"
                                   aria-controls="collapseThree">
                                    Life Insurance
                                    <i class="font-icon font-icon-arrow-down"></i>
                                </a>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-collapse-in">
                                <?php if ($totalins != NULL) { ?>
                                <table id="table-sm" class="table table-bordered table-hover table-responsive">
                                                <thead>
                                                <tr>
                                                    <th>Company   </th>
                                                    <th>Type of Policy</th>
                                                    <th>Name of Policy Holder   </th>
                                                    <th>Face Value</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                            <?php do { ?>   
                                                <tr>
                                                    <td><?php echo $row_ins['insurance_company'];?></td>
                                                    <td><?php echo $row_ins['insurance_type'];?></td>
                                                    <td><?php echo $row_ins['insurance_owner'];?></td>
                                                    <td><?php echo $row_ins['insurance_facevalue'];?></td>
                                                    <td><button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#editinsurance<?php echo $row_ins['id'];?>">
                                                        Edit
                                                        </button>
                                                    </td>
                                                    <td><a href="processor/process-deleteinsurance.php?a=<?php echo $row_ins['id'];?>"><input type="button" na/me="view" value="Delete" class="btn btn-fcmb btn-xs view_data" onclick="return confirm('Are you sure you want to delete ?');"/></a></td>
                                                </tr>
                                            <?php } while ($row_ins = mysqli_fetch_assoc($ins));?>
                                                </tbody>
                                            </table>
                                <?php } ?>
                                            <br/>
                                    <button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#addinsurance">
                                        Add Life Insurance
                                    </button>
                                </div>
                            </div>
                        </article>
                        <article class="panel">
                            <div class="panel-heading" role="tab" id="headingFour">
                                <a class="collapsed"
                                   data-toggle="collapse"
                                   data-parent="#accordion"
                                   href="#collapseFour"
                                   aria-expanded="false"
                                   aria-controls="collapseFour">
                                    Bank Account Details
                                    <i class="font-icon font-icon-arrow-down"></i>
                                </a>
                            </div>
                            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                <div class="panel-collapse-in">
                                <?php if ($totalbkd != NULL) { ?>
                                    <table id="table-sm" class="table table-bordered table-hover table-responsive">
                                                <thead>
                                                <tr>
                                                    <th>Bvn    </th>
                                                    <th>Bank Name</th>
                                                    <th>Bank Account Name </th>
                                                    <th>Bank Account No.</th>
                                                    <th>Account Type</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                            <?php do { ?>   
                                                <tr>
                                                    <td><?php echo $row_bkd['bvn'];?>(<?php echo $row_bkd['id'];?>)</td>
                                                    <td><?php echo $row_bkd['bankname'];?></td>
                                                    <td><?php echo $row_bkd['account_name'];?></td>
                                                    <td><?php echo $row_bkd['account_no'];?></td>
                                                    <td><?php echo $row_bkd['accounttype'];?></td>
                                                    <td><button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#editaccount<?php echo $row_bkd['id'];?>">
                                                        Edit
                                                        </button>
                                                    </td>
                                                    <td><a href="processor/process-deleteaccount.php?a=<?php echo $row_bkd['id'];?>"><input type="button" na/me="view" value="Delete" class="btn btn-fcmb btn-xs view_data" onclick="return confirm('Are you sure you want to delete ?');"/></a></td>
                                                </tr>
                                            <?php } while ($row_bkd = mysqli_fetch_assoc($bkd));?>
                                                </tbody>
                                            </table>
                                <?php } ?>
                                            <br/>

                                    <button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#addaccount">
                                        Add Bank Account Details
                                    </button>
                                </div>
                            </div>
                        </article>
                        <article class="panel">
                            <div class="panel-heading" role="tab" id="headingFive">
                                <a class="collapsed"
                                   data-toggle="collapse"
                                   data-parent="#accordion"
                                   href="#collapseFive"
                                   aria-expanded="false"
                                   aria-controls="collapseFive">
                                    RSA Pension Information
                                    <i class="font-icon font-icon-arrow-down"></i>
                                </a>
                            </div>
                            <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                                <div class="panel-collapse-in">
                                <?php if ($totalpns != NULL) { ?>
                                <table id="table-sm" class="table table-bordered table-hover table-responsive">
                                                <thead>
                                                <tr>
                                                    <th>Name of Pension Provider</th>
                                                    <th>Name of Pension Holder   </th>
                                                    <th>Do you have a pension plan?   </th>
                                                    <th>RSA No.   </th>
                                                    <th>Pension Administrator  </th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                            <?php do { ?>   
                                                <tr>
                                                    <td><?php echo $row_pns['pension_name'];?></td>
                                                    <td><?php echo $row_pns['pension_owner'];?></td>
                                                    <td><?php echo $row_pns['pension_plan'];?></td>
                                                    <td><?php echo $row_pns['rsano'];?></td>
                                                    <td><?php echo $row_pns['pension_admin'];?></td>
                                                    <td><button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#editpension<?php echo $row_pns['id'];?>">
                                                        Edit
                                                        </button>
                                                    </td>
                                                    <td><a href="processor/process-deletepension.php?a=<?php echo $row_pns['id'];?>"><input type="button" na/me="view" value="Delete" class="btn btn-fcmb btn-xs view_data" onclick="return confirm('Are you sure you want to delete ?');"/></a></td>
                                                </tr>
                                            <?php } while ($row_pns = mysqli_fetch_assoc($pns));?>
                                                </tbody>
                                            </table>
                                <?php } ?>
                                            <br/>
                                    <button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#addpension">
                                        Add Pension Information
                                    </button>
                                </div>
                            </div>
                        </article>
                        <article class="panel">
                            <div class="panel-heading" role="tab" id="headingSix">
                                <a class="collapsed"
                                   data-toggle="collapse"
                                   data-parent="#accordion"
                                   href="#collapseSix"
                                   aria-expanded="false"
                                   aria-controls="collapseSix">
                                    Other Investments
                                    <i class="font-icon font-icon-arrow-down"></i>
                                </a>
                            </div>
                            <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
                                <div class="panel-collapse-in">
                                <?php if ($totalinvestment != NULL) { ?>
                                <table id="table-sm" class="table table-bordered table-hover table-responsive">
                                                <thead>
                                                <tr>
                                                    <th>Investment Type</th>
                                                    <th>Investment Account</th>
                                                    <th>Account Name</th>
                                                    <th>Units</th>
                                                    <th>Face Value</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                            <?php do { ?>   
                                                <tr>
                                                    <td><?php echo $row_investment['investment_type'];?></td>
<td><?php echo $row_investment['investment_account'];?></td>
<td><?php echo $row_investment['investment_accountname'];?></td>
<td><?php echo $row_investment['investment_units'];?></td>
<td><?php echo $row_investment['investment_facevalue'];?></td>
                                                    <td><button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#editinvestment<?php echo $row_investment['id'];?>">
                                                        Edit
                                                        </button>
                                                    </td>
                                                    <td><a href="processor/process-deleteinvestment-asset.php?a=<?php echo $row_investment['id'];?>"><input type="button" value="Delete" class="btn btn-fcmb btn-xs view_data" onclick="return confirm('Are you sure you want to delete ?');"/></a></td>
                                                </tr>
                                            <?php } while ($row_investment = mysqli_fetch_assoc($investment));?>
                                                </tbody>
                                            </table>
                                <?php } ?>
                                            <br/>
                                    <button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#addinvestment">
                                        Add Investments
                                    </button>
                                </div>
                            </div>
                        </article>
                        <article class="panel">
                            <div class="panel-heading" role="tab" id="headingSeven">
                                <a class="collapsed"
                                   data-toggle="collapse"
                                   data-parent="#accordion"
                                   href="#collapseSeven"
                                   aria-expanded="false"
                                   aria-controls="collapseSeven">
                                    Personal Chattels<br><br>These include Personal belongings such as your Clothing, Vehicles, Jewelleries, Wrist-watches, Artefacts, Pets, e.t.c. Basically other assets owned by you for sharing to your beneficiaries
                                    <i class="font-icon font-icon-arrow-down"></i>
                                </a>
                            </div>
                            <div id="collapseSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSeven">
                                <div class="panel-collapse-in">
                                <?php if ($totalchattel != NULL) { ?>
<textarea rows="6" class="form-control" disabled><?php echo $row_chattel['personal_chattels'];?></textarea><br/>
                                    <button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#editpersonalchattel<?php echo $row_editchattel['id'];?>">
                                        Edit
                                    </button>
                                    <a href="processor/process-deletepersonalchattel.php?a=<?php echo $row_chattel['id'];?>"><input type="button" value="Delete" class="btn btn-fcmb btn-xs view_data" onclick="return confirm('Are you sure you want to delete ?');"/></a>

                                <?php } ?>
                                <?php if ($totalchattel == NULL) { ?>
                                            <br/>
                                    <button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#addpersonalchattel">
                                        Add Personal Chattels
                                    </button>
                                     <?php } ?>
                                </div>
                            </div>
                        </article>
                    </section><!--.widget-accordion-->
                
                </div>
                </div>
                </div>
            </section>
                            <input type="hidden" name="uid" value="<?php echo $userid?>">
                <input type="submit" value="Save and Proceed" class="btn btn-inline btn-fcmb" style="float:right;">
  </form>

                



                </div><!--.col- -->



            </div><!--.row-->
        </div><!--.container-fluid-->
    </div><!--.page-content-->

    <!--ADD PROPERTY MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="addproperty" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add your property<br><span style="font-size:13px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:13px;">All fields with asterisk are compulsory</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-property.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Location<span style="color:red;">*</span></label>
                                            <input type="text" name="plocation" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Type of Property<span style="color:red;">*</span></label>
                                            <input type="text" name="ptype" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                          <fieldset class="form-group">
                                            <label class="form-label" for="exampleInputEmail1">How title is registered<span style="color:red;">*</span> ? </label>
                                              <textarea rows="2" name="pregistered" class="form-control maxlength-simple" required></textarea>
                                          </fieldset>
                                        </div>
                                    </div>
                                    <input type="hidden" name="assettype" value="property"  />
                                    <input type="hidden" name="puid" value="<?php echo $userid; ?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
    <!--ADD PRPERTY MODAL ENDS HERE-->
    
    <!--EDIT PROPERTY MODAL STARTS HERE -->
    <!-- Modal -->
<?php do { ?>
<div class="modal fade" id="editproperty<?php echo $row_eprt['id']?>" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit property (<?php echo $row_eprt['property_type']?>) <br><span style="font-size:13px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:13px;">All fields with asterisk are compulsory</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-editproperty.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Location<span style="color:red;">*</span></label>
                                            <input type="text" name="edtplocation" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $row_eprt['property_location']?>" required>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Type of Property<span style="color:red;">*</span></label>
                                            <input type="text" name="edtptype" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $row_eprt['property_type']?>" required>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <fieldset class="form-group">
                                              <label class="form-label" for="exampleInputEmail1">How title is registered<span style="color:red;">*</span> ? </label>
                                                <textarea rows="2" name="edtpregistered" class="form-control maxlength-simple" required><?php echo $row_eprt['property_registered']?></textarea>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <input type="hidden" name="edtpuid" value="<?php echo $row_eprt['id']?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
<?php } while ($row_eprt = mysqli_fetch_assoc($eprt));?>
    <!--EDIT PROPERTY MODAL ENDS HERE-->


<!--ADD SHARES MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="addshares" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add your shares/ stocks<br><span style="font-size:13px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:13px;">All fields with asterisk are compulsory</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-shares.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Company<span style="color:red;">*</span></label>
                                            <input type="text" name="scompany" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Volume/ Value<span style="color:red;">*</span></label>
                                            <input type="text" name="svolume" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Percentage of shareholdings</label>
                                            <input type="number" name="spercent" class="form-control maxlength-simple" id="exampleInput" requ/ired>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">CSCS No. (if applicable)</label>
                                            <input type="text" name="cscs" class="form-control maxlength-simple" id="exampleInput">
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Clearing House No. (CHN)</label>
                                            <input type="text" name="chn" class="form-control maxlength-simple" id="exampleInput">
                                            </fieldset>
                                        </div>
                                    </div>

                                    <input type="hidden" name="assettype1" value="shares"  />
                                    <input type="hidden" name="suid" value="<?php echo $userid; ?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
    <!--ADD SHARES MODAL ENDS HERE-->

    <!--EDIT SHARES MODAL STARTS HERE -->
    <!-- Modal -->
<?php do { ?>
<div class="modal fade" id="editshares<?php echo $row_editsh['id']?>" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit shares (<?php echo $row_editsh['shares_company']?>)<br><span style="font-size:13px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:13px;">All fields with asterisk are compulsory</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                                <form method="post" action="processor/process-editshares.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Company<span style="color:red;">*</span></label>
                                            <input type="text" name="editsharescompany" class="form-control maxlength-simple" value="<?php echo $row_editsh['shares_company'];?>" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Volume/ Value<span style="color:red;">*</span></label>
                                            <input type="text" name="editsharesvolume" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $row_editsh['shares_volume'];?>" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Percentage of shareholdings</label>
                                            <input type="number" name="editsharespercentage" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $row_editsh['shares_percent'];?>" requ/ired>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">CSCS No. (if applicable)</label>
                                            <input type="text" name="editsharescscs" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $row_editsh['shares_cscs'];?>" >
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Clearing House No. (CHN)</label>
                                            <input type="text" name="editshareschn" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $row_editsh['shares_chn'];?>" >
                                            </fieldset>
                                        </div>
                                    </div>

                                    <input type="hidden" name="editsharesid" value="<?php echo $row_editsh['id']?>"  />
                                    <input type="submit" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
<?php } while ($row_editsh = mysqli_fetch_assoc($editsh));?>   
    <!--EDIT SHARES MODAL ENDS HERE-->

<!--ADD ISSUARANCE MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="addinsurance" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Life Insurance<br><span style="font-size:13px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:13px;">All fields with asterisk are compulsory</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-insurance.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Company<span style="color:red;">*</span></label>
                                            <input type="text" name="lcompany" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Type of Policy<span style="color:red;">*</span></label>
                                            <input type="text" name="lpolicy" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Name of Policy Holder<span style="color:red;">*</span></label>
                                            <input type="text" name="lowner" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Face Value<span style="color:red;">*</span></label>
                                            <input type="text" name="lvalue" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <input type="hidden" name="assettype2" value="insurance"  />
                                    <input type="hidden" name="luid" value="<?php echo $userid; ?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
    <!--ADD ISSURANCE MODAL ENDS HERE-->

    <!--EDIT INSURANCE MODAL STARTS HERE -->
    <!-- Modal -->
<?php do { ?>
<div class="modal fade" id="editinsurance<?php echo $row_editins['id']?>" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Insurance (<?php echo $row_editins['insurance_company']?>)<br><span style="font-size:13px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:13px;">All fields with asterisk are compulsory</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                                <form method="post" action="processor/process-editinsurance.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Company<span style="color:red;">*</span></label>
                                            <input type="text" name="editinsurancecompany" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $row_editins['insurance_company']?>" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Type of Policy<span style="color:red;">*</span></label>
                                            <input type="text" name="editinsurancetype" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $row_editins['insurance_type']?>" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Name of Policy Holder<span style="color:red;">*</span></label>
                                            <input type="text" name="editinsurancename" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $row_editins['insurance_owner']?>" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Face Value<span style="color:red;">*</span></label>
                                            <input type="text" name="editinsurancevalue" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $row_editins['insurance_facevalue']?>" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <input type="hidden" name="editinsuranceid" value="<?php echo $row_editins['id']; ?>"  />
                                    <input type="submit" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
<?php } while ($row_editins = mysqli_fetch_assoc($editins));?>   
    <!--EDIT INSURANCE MODAL ENDS HERE-->


    <!--ADD BANK DETAILS MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="addaccount" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Bank Details<br><span style="font-size:13px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:13px;">All fields with asterisk are compulsory</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-account.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">BVN<span style="color:red;">*</span></label>
                                            <input type="text" name="bvnnumber" class="form-control maxlength-simple" id="exampleInput" 
                                            value="<?php echo $row_bkd1['bvn'];?>" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Bank Name<span style="color:red;">*</span></label>
                                            <input type="text" name="bankname" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Account Name<span style="color:red;">*</span></label>
                                            <input type="text" name="anctname" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Account Number<span style="color:red;">*</span></label>
                                            <input type="text" name="actno" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Account Type<span style="color:red;">*</span></label>
                                            <input type="text" name="acttype" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <input type="hidden" name="assettype3" value="bankaccount"  />

                                    <input type="hidden" name="actuid" value="<?php echo $userid; ?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
    <!--ADD BANK DETAILS MODAL ENDS HERE-->
    
    
        <!--EDIT BANK DETAILS MODAL STARTS HERE -->
    <!-- Modal -->
<?php do { ?>
<div class="modal fade" id="editaccount<?php echo $row_editbkd['id'];?>" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Details for <?php echo $row_editbkd['bankname'];?> (<?php echo $row_editbkd['account_no'];?>)<br><span style="font-size:13px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:13px;">All fields with asterisk are compulsory</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-editaccount.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">BVN<span style="color:red;">*</span></label>
                                            <input type="text" name="editbvnnumber" class="form-control maxlength-simple" id="exampleInput" 
                                            value="<?php echo $row_editbkd['bvn'];?>" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Bank Name<span style="color:red;">*</span></label>
                                            <input type="text" name="editbankname" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $row_editbkd['bankname'];?>" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Account Name<span style="color:red;">*</span></label>
                                            <input type="text" name="editanctname" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $row_editbkd['account_name'];?>" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Account Number<span style="color:red;">*</span></label>
                                            <input type="text" name="editactno" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $row_editbkd['account_no'];?>" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Account Type<span style="color:red;">*</span></label>
                                            <input type="text" name="editacttype" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $row_editbkd['accounttype'];?>" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <input type="hidden" name="editaccountid" value="<?php echo $row_editbkd['id'];?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
<?php } while ($row_editbkd = mysqli_fetch_assoc($editbkd)) ;?>
    <!--EDIT BANK DETAILS MODAL ENDS HERE-->

<!--ADD PENSION MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="addpension" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">RSA Pension Information<br><span style="font-size:13px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:13px;">All fields with asterisk are compulsory</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-pension.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Name of Pension Provider<span style="color:red;">*</span></label>
                                            <input type="text" name="pensionname" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Name of Pension Holder<span style="color:red;">*</span></label>
                                            <input type="text" name="pensionowner" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                                        <div class="row">
                        <div class="col-md-7 col-sm-12">
                            <p>Are you covered in a qualified pension plan<span style="color:red;">*</span>? </p>
                        </div>
                    
                <div class="col-md-5 col-sm-12">

                            <div class="radio">
                                <input type="radio" name="pension" id="radio-17" value="Yes" required>
                                <label for="radio-17">Yes </label>
                                <input type="radio" name="pension" id="radio-18" value="No" required>
                                <label for="radio-18">No </label> <br>

                            </div>
                
                </div>
                </div>

                <div class="row Yes boxxxxx">
                                                <div class="col-lg-12">
                                                    <fieldset class="form-group">
                                                        <label class="form-label" for="exampleInput">RSA No. :</label>
                                                        <input type="text" name="rsano" class="form-control maxlength-simple" id="exampleInput">
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-12">
                                                    <fieldset class="form-group">
                                                        <label class="form-label" for="exampleInputEmail1">Pension Fund Administrator</label>
                                                        <input type="text" name="pensionadmin" class="form-control maxlength-custom-message" id="exampleInputEmail1" >
                                                    </fieldset>
                                                </div>
                                            </div>
                                    <input type="hidden" name="assettype4" value="Pension"  />
                                    <input type="hidden" name="pensionuid" value="<?php echo $userid; ?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
    <!--ADD PENSION MODAL ENDS HERE-->
 
<?php do { ?>    
    <!--EDIT PENSION MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="editpension<?php echo $row_editpns['id'];?>" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit RSA Pension Information for <?php echo $row_editpns['pension_name'];?><br><span style="font-size:13px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:13px;">All fields with asterisk are compulsory</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-editpension.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Name of Pension Provider<span style="color:red;">*</span></label>
                                            <input type="text" name="editpensionname" class="form-control maxlength-simple" value="<?php echo $row_editpns['pension_name'];?>" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Name of Pension Holder<span style="color:red;">*</span></label>
                                            <input type="text" name="editpensionowner" class="form-control maxlength-simple" value="<?php echo $row_editpns['pension_owner'];?>" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                <div class="row">
                                                <div class="col-lg-12">
                                                    <fieldset class="form-group">
                                                        <label class="form-label" for="exampleInput">RSA No. :</label>
                                                        <input type="text" name="editrsano" value="<?php echo $row_editpns['rsano'];?>" class="form-control maxlength-simple" id="exampleInput">
                                                    </fieldset>
                                                </div>
                                                
                                                <div class="col-lg-12">
                                                    <fieldset class="form-group">
                                                        <label class="form-label" for="exampleInputEmail1">Pension Fund Administrator</label>
                                                        <input type="text" name="editpensionadmin" value="<?php echo $row_editpns['pension_admin'];?>" class="form-control maxlength-custom-message" id="exampleInputEmail1" >
                                                    </fieldset>
                                                </div>
                                            </div>

                                    <input type="hidden" name="editpensionid" value="<?php echo $row_editpns['id'];?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
<?php } while ($row_editpns = mysqli_fetch_assoc($editpns));?>
    <!--EDIT PENSION MODAL ENDS HERE-->

<!--ADD OTHER INVESTMENTS MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="addinvestment" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Investment<br><span style="font-size:13px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:13px;">All fields with asterisk are compulsory</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-investment-assets.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                                                        <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Investment Type<span style="color:red;">*</span></label>
                                <select class="form-control" name="investment" required>
                                        <option value=""> - Please Select - </option>
                                    <option value="Mutual funds"> Mutual funds </option>
                                    <option value="Bonds"> Bonds </option>
                                    <option value="Treasury Bills"> Treasury Bills </option>
                                    <option value="Fixed deposits"> Fixed deposits </option>
                                    <option value="Forex Trading"> Forex Trading </option>
                                    
                                    
                                </select>
                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Investment Account<span style="color:red;">*</span></label>
                                            <input type="text" name="investmentaccount" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>
                                    
                                                                        <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Account Name<span style="color:red;">*</span></label>
                                            <input type="text" name="investmentaccountname" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>
                                    
                                                                        <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Units<span style="color:red;">*</span></label>
                                            <input type="text" name="investmentunits" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>
                                    
                                                                        <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Face Value<span style="color:red;">*</span></label>
                                            <input type="text" name="investmentfacevalue" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <input type="hidden" name="assettype5" value="Other Investments"  />
                                    <input type="hidden" name="investmentuid" value="<?php echo $userid; ?>"  />
                                    <input type="submit" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
    <!--ADD INVESTMENTS MODAL ENDS HERE-->

    
    <?php do { ?>    
    <!--EDIT INVESTMENTS MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="editinvestment<?php echo $row_editinvestment['id'];?>" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Investment Information of <?php echo $row_editinvestment['investment_type'];?><br><span style="font-size:13px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:13px;">All fields with asterisk are compulsory</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-editinvestment-asset.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Investment Type<span style="color:red;">*</span></label>
                                            <input type="text" name="editinvestmenttype" class="form-control maxlength-simple" value="<?php echo $row_editinvestment['investment_type'];?>" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Investment Account<span style="color:red;">*</span></label>
                                            <input type="text" name="editinvestmentaccount" class="form-control maxlength-simple" value="<?php echo $row_editinvestment['investment_account'];?>" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                <div class="row">
                                                <div class="col-lg-12">
                                                    <fieldset class="form-group">
                                        <label class="form-label" for="exampleInput">Account Name</label>
                                                        <input type="text" name="editinvestmentaccountname" value="<?php echo $row_editinvestment['investment_accountname'];?>" class="form-control maxlength-simple" id="exampleInput">
                                                    </fieldset>
                                                </div>
                                                
                                        <div class="col-lg-12">
                                                    <fieldset class="form-group">
                                                        <label class="form-label" for="exampleInputEmail1">Units</label>
                                                        <input type="text" name="editinvestmentunits" value="<?php echo $row_editinvestment['investment_units'];?>" class="form-control maxlength-custom-message" id="exampleInputEmail1" >
                                                    </fieldset>
                                                </div>
                                                
                                                                                <div class="col-lg-12">
                                                    <fieldset class="form-group">
                                                        <label class="form-label" for="exampleInputEmail1">Face Value</label>
                                                        <input type="text" name="editinvestmentfacevalue" value="<?php echo $row_editinvestment['investment_facevalue'];?>" class="form-control maxlength-custom-message" id="exampleInputEmail1" >
                                                    </fieldset>
                                                </div>
                                                
                                            </div>

<input type="hidden" name="editinvestmentid" value="<?php echo $row_editinvestment['id'];?>"  />
                                    <input type="submit" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
<?php } while ($row_editinvestment = mysqli_fetch_assoc($editinvestment));?>
    <!--EDIT INVESTMENTS MODAL ENDS HERE-->
    
    <!--ADD PERSONAL CHATTEL MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="addpersonalchattel" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Personal Chattels<br><span style="font-size:13px;">N.B:</span><span style="font-size:13px;">(Please list assets and mention the beneficiaries in the box below)</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-personal-chattels.php" method="POST">

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Personal Chattels</label>
                                            <textarea rows="4" name="personalchattels" class="form-control" placeholder="Please list assets and mention the beneficiaries in the box below"></textarea>
                                            </fieldset>
                                        </div>
                                    </div>


                                    <input type="hidden" name="assettype6" value="Personal Chattels"  />
                                    <input type="hidden" name="personalchattelsuid" value="<?php echo $userid; ?>"  />
                                    <input type="submit" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
    <!--ADD PERSONAL CHATEL MODAL ENDS HERE-->
    
<?php //do { ?>    
        <!--EDIT PERSONAL CHATTEL MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="editpersonalchattel<?php echo $row_editchattel['id'];?>" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Personal Chattels<br><span style="font-size:13px;">N.B:</span><span style="font-size:13px;">(Please list assets and mention the beneficiaries in the box below)</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-editpersonalchattels.php" method="POST">

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Personal Chattels</label>
                                            <textarea rows="4" name="personalchattels" class="form-control"><?php echo $row_editchattel['personal_chattels'];?></textarea>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <input type="hidden" name="editpersonalchattelsid" value="<?php echo $row_editchattel['id'];?>"  />
                                    <input type="submit" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
    <!--EDIT PERSONAL CHATEL MODAL ENDS HERE-->
<?php //} while ($row_editchattel = mysqli_fetch_assoc($editchattel)); ?>

    <!--BENEFICIARY MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="addestate" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add your estate</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-estate.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Asset</label>
                                            <input type="text" name="asset" class="form-control maxlength-simple" id="exampleInput" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <fieldset class="form-group">
                                                                <label class="form-label" for="exampleInputEmail1">Choose Option</label>
                                                                <select class="form-control" name="aoption" required>
                                                                    <option value=""> -Please Select- </option>
                                                                    <option value="Option A"> Option A </option>
                                                                    <option value="Option B"> Option B </option>
                                                                    <option value="Option C"> Option C </option>
                                                                    <option value="Option D"> Option D </option>
                                                                    </select>
                                                            </fieldset>
                                                        </div>
                                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                                            <fieldset class="form-group">
                                                                <label class="form-label" for="exampleInputEmail1">I want my assets to pass in this manner</label>
                                                                <textarea rows="2" name="acomment" class="form-control maxlength-simple" ></textarea>
                                                            </fieldset>
                                                        </div>
                                    </div>

                                    <input type="hidden" name="auid" value="<?php echo $userid; ?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
    <!--BENEFICIARY MODAL ENDS HERE-->

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
<script src="js/app.js"></script>
</body>
</html>