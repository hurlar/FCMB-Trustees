<?php require ('Connections/conn.php');
include ('session.php');
if(!isset($userid)){
header('location:index.php');
exit();
}

$queryt = "SELECT * FROM trustee_tb  WHERE `uid` = '$userid' AND title != 'corporate' ";
$resultt = mysqli_query($conn, $queryt) or die(mysqli_error($conn));
$rowt = mysqli_fetch_assoc($resultt);
$totalrowt = mysqli_num_rows($resultt);

$querytedt = "SELECT * FROM trustee_tb  WHERE `uid` = '$userid' ";
$resulttedt = mysqli_query($conn, $querytedt) or die(mysqli_error($conn));
$rowtedt = mysqli_fetch_assoc($resulttedt);
$totalrowtedt = mysqli_num_rows($resulttedt);

$querycor = "SELECT * FROM trustee_tb  WHERE `uid` = '$userid' AND title = 'corporate' ";
$resultcor = mysqli_query($conn, $querycor) or die(mysqli_error($conn));
$rowcor = mysqli_fetch_assoc($resultcor);
$totalrowcor = mysqli_num_rows($resultcor);

$queryedtcor = "SELECT * FROM trustee_tb  WHERE `uid` = '$userid' AND title = 'corporate' ";
$resultedtcor = mysqli_query($conn, $queryedtcor) or die(mysqli_error($conn));
$rowedtcor = mysqli_fetch_assoc($resultedtcor);
$totalrowedtcor = mysqli_num_rows($resultedtcor);

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
    .box{
        color: #fff;
        /**padding: 20px;**/
        display: none;
        margin-top: 20px;
    }
    .No{ background: #228B22; }

        .boxx{
        color: #fff;
        /**padding: 20px;**/
        display: none;
        margin-top: 20px;
    }
    .yes{ background: #228B22; }

</style>

<script type="text/javascript">
$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        var inputValue = $(this).attr("value");
        var targetBox = $("." + inputValue);
        $(".box").not(targetBox).hide();
        $(targetBox).show();
    });
});
</script>

<script type="text/javascript">
$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        var inputValue = $(this).attr("value");
        var targetBoxx = $("." + inputValue);
        $(".boxx").not(targetBoxx).hide();
        $(targetBoxx).show();
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
                            <div class="profile-card-name">A Trustee is a person who holds property in Trust for the benefit or use of the beneficiaries.</div>

                    </section><!--.box-typical-->
                    
                    <section class="box-typical sidemenu">
                        <div class="profile-card">
                        <div class="profile-card-name"> Go to Dashboard</div> <br/>

                                <a href="dashboard.php"><button type="button" class="btn btn-inline btn-fcmb" > Go Back </button></a>
                                </div>

                    </section>

                </div><!--.col- -->

                <div class="col-lg-9 col-lg-push-3 col-md-12">
                <form action="processor/process-trustees.php" method="post"> 
                <section class="card">
                <div class="card-block">
                    
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
	<?php echo  ' Please add a trustee ' ; ?>
</div>
<?php } ?>


<?php } ?>


                    <h5 class="with-bo/rder">Appoint Trustees</h5>

                    <div class="row">
                    
                <div class="col-md-12 col-sm-12">
                    
                        <!--<div class="col-md-12 col-sm-12">-->
                         <p>In the event that at the time of your demise, who would you choose to manage the assets in your will in a responsible and productive manner, and will be under an absolute obligation to act solely for the benefit of the  beneficiaries.</p>
                    <?php if ($totalrowt != NULL) { ?>
                        <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Trustees Name</th>
                                            <th>Trustees Phone </th>
                                            <th></th>
                                            <th></th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                        <?php do { ?>
                                            <tr>
                                                <td> <?php echo $rowt["title"].' '.$rowt["fullname"]; ?></td>
                                                <td><?php echo $rowt["phone"]; ?></td>
                                                <td><button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#edittrustee<?php echo $rowt["id"]; ?>">
                                                Edit
                                                </button></td>
                                                <td><a href="processor/process-deletetrustees.php?a=<?php echo $rowt["id"]; ?>" onclick="return confirm('Are you sure you want to delete ?');"><button type="button" class="btn btn-inline btn-fcmb" >
                                                Delete
                                                </button></a></td>
                                            </tr>
                                        <?php } while ($rowt = mysqli_fetch_assoc($resultt));?>
                                                                                </tbody>
                                    </table>
                            <?php } ?>
                                    <br/>
                            <button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#addtrustee">
                                Appoint Trustee
                            </button>
                        <!--</div>-->
                
                </div>
                </div>
                </div>
                
                        
            </section>
            
                            <section class="card">
                <div class="card-block">

                    <h5 class="with-bo/rder">Appoint Corporate Trustees</h5>

                    <div class="row">
                <div class="col-md-12 col-sm-12">
                    
                        <!--<div class="col-md-12 col-sm-12">-->
                         
                         
                                             <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <p>Would you like to select a corporate organisation as your Trustee ? </p>
                        </div>
                    
                <div class="col-md-6 col-sm-12">

                            <div class="radio">
                                <input type="radio" name="ctrustee" id="radio-5" value="No" requ/ired>
                                <label for="radio-5">FCMB Trustees </label>
                                
                                <input type="radio" name="ctrustee" id="radio-6" value="Yes" requ/ired>
                                <label for="radio-6">Others (Corporate Entity) </label> <br>
                                        <button type="button" class="Yes boxx btn btn-inline btn-fcmb" data-toggle="modal" data-target="#addcorporatetrustee">
                                                Appoint Corporate Trustee
                                        </button>
                                        
                                        <br>
                                        <button type="button" class="No box btn btn-inline btn-fcmb" data-toggle="modal" data-target="#addfcmbcorporatetrustee">
                                                Appoint FCMB Trustees
                                        </button>

</div>
                            
                            
                            <br>

                </div>

                </div>
                         
                         
                         
                         
                         
                         
                         
                         
                         
                         
                    <?php if ($totalrowcor != NULL) { ?>
                        <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Name</th>
                                            <th>Phone Number </th>
                                            <th></th>
                                            <th></th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                        <?php do { ?>
                                            <tr>
                                                <td> <?php echo $rowcor["fullname"]; ?></td>
                                                <td><?php echo $rowcor["phone"]; ?></td>
                                                <td><button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#editcorporatetrustee<?php echo $rowcor["id"]; ?>">
                                                Edit
                                                </button></td>
                                                
                                                <td><a href="processor/process-deletetrustees.php?a=<?php echo $rowcor["id"]; ?>" onclick="return confirm('Are you sure you want to delete ?');"><button type="button" class="btn btn-inline btn-fcmb" >
                                                Delete
                                                </button></a></td>
                                            </tr>
                                        <?php } while ($rowcor = mysqli_fetch_assoc($resultcor));?>
                                                                                </tbody>
                                    </table>
                            <?php } ?>

                        <!--</div>-->
                
                </div>
                </div>
                </div>
                
                        
            </section>
            
            
            <input type="hidden" name="uid" value="<?php echo $userid?>">
                <input type="submit" name="insert" id="spouseinsert" value="Save" class="btn btn-inline btn-fcmb" style="float:right;">
    </form>
                </div><!--.col- -->



            </div><!--.row-->
        </div><!--.container-fluid-->
    </div><!--.page-content-->

    <!--ADD TRUSTEE MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="addtrustee" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Appoint Trustee<br><span style="font-size:13px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:13px;">All fields with asterisk are compulsory</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-addtrustee.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Title<span style="color:red;">*</span></label>
                                                <select class="form-control" name="ttitle" required>
                                                    <option value=""> -Please Select- </option>
                                                    <option value="Mr" <?php if($_SESSION['gtitle'] == 'Mr'){ echo ' selected="selected"'; } ?> > Mr. </option>
                                                    <option value="Ms" <?php if($_SESSION['gtitle'] == 'Ms'){ echo ' selected="selected"'; } ?> > Ms. </option>
                                                    <option value="Mrs" <?php if($_SESSION['gtitle'] == 'Mrs'){ echo ' selected="selected"'; } ?> > Mrs. </option>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Full Name<span style="color:red;">*</span></label>
                                            <input type="text" name="tname" class="form-control maxlength-simple" id="exampleInput" required value="<?php echo $_SESSION['gname'];?>" >
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Email</label>
                                            <input type="email" name="temail" class="form-control maxlength-simple" id="exampleInput" requi/red value="<?php echo $_SESSION['gemail'];?>">
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Phone Number<span style="color:red;">*</span></label>
                                                <input type="text" name="tphoneno" class="form-control maxlength-simple" id="exampleInput" required value="<?php echo $_SESSION['gphoneno'];?>" >
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Relationship<span style="color:red;">*</span></label>
                                                <select class="form-control" name="trelationship" required>
                                                <option value=""> -Please Select- </option>
                                                <option value="Sibling" <?php if($_SESSION['grelationship'] == 'Sibling'){ echo ' selected="selected"'; } ?> > Sibling </option>
                                                <option value="Parent" <?php if($_SESSION['grelationship'] == 'Parent'){ echo ' selected="selected"'; } ?> > Parent </option>
                                                <option value="Relative" <?php if($_SESSION['grelationship'] == 'Relative'){ echo ' selected="selected"'; } ?> > Relative </option>
                                                <option value="Friend" <?php if($_SESSION['grelationship'] == 'Friend'){ echo ' selected="selected"'; } ?> > Friend </option>
                                                <option value="Colleague" <?php if($_SESSION['grelationship'] == 'Colleague'){ echo ' selected="selected"'; } ?> > Colleague </option>
                                                <option value="Others" <?php if($_SESSION['grelationship'] == 'Others'){ echo ' selected="selected"'; } ?> > Others </option>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-sm-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInputEmail1">Residential Address<span style="color:red;">*</span></label>
                                            <textarea rows="2" name="taddr" class="form-control maxlength-simple" required><?php echo $_SESSION['gaddr'];?></textarea>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">City<span style="color:red;">*</span></label>
                                            <input type="text" name="tcity" class="form-control maxlength-simple" id="exampleInput" required value="<?php echo $_SESSION['gcity'];?>">
                                            </fieldset>
                                        </div>

                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">State<span style="color:red;">*</span></label>
                                                <select class="form-control" name="tstate" required>
                                                <option value=""> -Please Select- </option>
                                                <option value="Abia" <?php if($_SESSION['gstate']== 'Abia'){ echo ' selected="selected"'; } ?> > Abia </option>
                                                <option value="Abuja" <?php if($_SESSION['gstate']== 'Abuja'){ echo ' selected="selected"'; } ?>> Abuja </option>
                                                                    <option value="Adamawa" <?php if($_SESSION['gstate']== 'Adamawa'){ echo ' selected="selected"'; } ?>> Adamawa </option>
                                                                    <option value="Akwa Ibom" <?php if($_SESSION['gstate']== 'Akwa Ibom'){ echo ' selected="selected"'; } ?>> Akwa Ibom </option>
                                                                    <option value="Anambra" <?php if($_SESSION['gstate']== 'Anambra'){ echo ' selected="selected"'; } ?> > Anambra </option>
                                                                    <option value="Bauchi" <?php if($_SESSION['gstate']== 'Bauchi'){ echo ' selected="selected"'; } ?>> Bauchi </option>
                                                                    <option value="Bayelsa" <?php if($_SESSION['gstate']== 'Bayelsa'){ echo ' selected="selected"'; } ?> > Bayelsa </option>
                                                                    <option value="Benue" <?php if($_SESSION['gstate']== 'Benue'){ echo ' selected="selected"'; } ?>> Benue </option>
                                                                    <option value="Borno" <?php if($_SESSION['gstate']== 'Borno'){ echo ' selected="selected"'; } ?> > Borno </option>
                                                                    <option value="Cross River" <?php if($_SESSION['gstate']== 'Cross River'){ echo ' selected="selected"'; } ?> > Cross River </option>
                                                                    <option value="Delta" <?php if($_SESSION['gstate']== 'Delta'){ echo ' selected="selected"'; } ?> > Delta </option>
                                                                    <option value="Ebonyi" <?php if($_SESSION['gstate']== 'Ebonyi'){ echo ' selected="selected"'; } ?> > Ebonyi </option>
                                                                    <option value="Enugu" <?php if($_SESSION['gstate']== 'Enugu'){ echo ' selected="selected"'; } ?> > Enugu </option>
                                                                    <option value="Edo" <?php if($_SESSION['gstate']== 'Edo'){ echo ' selected="selected"'; } ?> > Edo </option>
                                                                    <option value="Ekiti" <?php if($_SESSION['gstate']== 'Ekiti'){ echo ' selected="selected"'; } ?> > Ekiti </option>
                                                                    <option value="Gombe" <?php if($_SESSION['gstate']== 'Gombe'){ echo ' selected="selected"'; } ?>> Gombe </option>
                                                                    <option value="Imo" <?php if($_SESSION['gstate']== 'Imo'){ echo ' selected="selected"'; } ?>> Imo </option>
                                                                    <option value="Jigawa" <?php if($_SESSION['gstate']== 'Jigawa'){ echo ' selected="selected"'; } ?> > Jigawa </option>
                                                                    <option value="Kaduna" <?php if($_SESSION['gstate']== 'Kaduna'){ echo ' selected="selected"'; } ?>> Kaduna </option>
                                                                    <option value="Kano" <?php if($_SESSION['gstate']== 'Kano'){ echo ' selected="selected"'; } ?>> Kano </option>
                                                                    <option value="Katsina" <?php if($_SESSION['gstate']== 'Katsina'){ echo ' selected="selected"'; } ?> > Katsina </option>
                                                                    <option value="Kebbi" <?php if($_SESSION['gstate']== 'Kebbi'){ echo ' selected="selected"'; } ?> > Kebbi </option>
                                                                    <option value="Kogi" <?php if($_SESSION['gstate']== 'Kogi'){ echo ' selected="selected"'; } ?> > Kogi </option>
                                                                    <option value="Kwara" <?php if($_SESSION['gstate']== 'Kwara'){ echo ' selected="selected"'; } ?> > Kwara </option>
                                                                    <option value="Lagos" <?php if($_SESSION['gstate']== 'Lagos'){ echo ' selected="selected"'; } ?> > Lagos </option>
                                                                    <option value="Nasarawa" <?php if($rowedt['Nasarawa'] == 'Abia'){ echo ' selected="selected"'; } ?>> Nasarawa </option>
                                                                    <option value="Niger" <?php if($_SESSION['gstate']== 'Niger'){ echo ' selected="selected"'; } ?> > Niger </option>
                                                                    <option value="Ogun" <?php if($_SESSION['gstate']== 'Ogun'){ echo ' selected="selected"'; } ?>> Ogun </option>
                                                                    <option value="Ondo" <?php if($_SESSION['gstate']== 'Ondo'){ echo ' selected="selected"'; } ?>> Ondo </option>
                                                                    <option value="Osun" <?php if($_SESSION['gstate']== 'Osun'){ echo ' selected="selected"'; } ?>> Osun </option>
                                                                    <option value="Oyo" <?php if($_SESSION['gstate']== 'Oyo'){ echo ' selected="selected"'; } ?> > Oyo </option>
                                                                    <option value="Plateau" <?php if($_SESSION['gstate']== 'Plateau'){ echo ' selected="selected"'; } ?> > Plateau </option>
                                                                    <option value="Rivers" <?php if($_SESSION['gstate']== 'Rivers'){ echo ' selected="selected"'; } ?>> Rivers </option>
                                                                    <option value="Sokoto" <?php if($_SESSION['gstate']== 'Sokoto'){ echo ' selected="selected"'; } ?>> Sokoto </option>
                                                                    <option value="Taraba" <?php if($_SESSION['gstate']== 'Taraba'){ echo ' selected="selected"'; } ?>> Taraba </option>
                                                                    <option value="Yobe" <?php if($_SESSION['gstate']== 'Yobe'){ echo ' selected="selected"'; } ?>> Yobe </option>
                                                                    <option value="Zamfara" <?php if($_SESSION['gstate']== 'Zamfara'){ echo ' selected="selected"'; } ?>> Zamfara </option>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <input type="hidden" name="tid" value="<?php echo $userid; ?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
    <!--ADD TRUSTEES MODAL ENDS HERE-->

<?php do { ?>
    <!--EDIT TRUSTEE MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="edittrustee<?php echo $rowtedt["id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Trustee details of <?php echo $rowtedt["title"]; ?> <?php echo $rowtedt["fullname"]; ?><br><span style="font-size:13px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:13px;">All fields with asterisk are compulsory</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-edittrustees.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Title<span style="color:red;">*</span></label>
                                                <select class="form-control" name="ttitle" required>
                                                    <option value="Mr" <?php if($rowtedt['title'] == 'Mr'){ echo ' selected="selected"'; } ?> > Mr. </option>
                                                    <option value="Ms" <?php if($rowtedt['title'] == 'Ms'){ echo ' selected="selected"'; } ?> > Ms. </option>
                                                    <option value="Mrs" <?php if($rowtedt['title'] == 'Mrs'){ echo ' selected="selected"'; } ?> > Mrs. </option>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Full Name<span style="color:red;">*</span></label>
                                            <input type="text" name="tname" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $rowtedt["fullname"]; ?>" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Email</label>
                                            <input type="email" name="temail" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $rowtedt["email"]; ?>" requ/ired>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Phone Number<span style="color:red;">*</span></label>
                                                <input type="text" name="tphoneno" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $rowtedt["phone"]; ?>" required>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Relationship<span style="color:red;">*</span></label>
                                                <select class="form-control" name="trelationship" required>
                                                <option value=""> -Please Select- </option>
                                                <option value="Sibling" <?php if($rowtedt['rtionship'] == 'Sibling'){ echo ' selected="selected"'; } ?> > Sibling </option>
                                                <option value="Parent" <?php if($rowtedt['rtionship'] == 'Parent'){ echo ' selected="selected"'; } ?> > Parent </option>
                                                <option value="Relative" <?php if($rowtedt['rtionship'] == 'Relative'){ echo ' selected="selected"'; } ?> > Relative </option>
                                                <option value="Friend" <?php if($rowtedt['rtionship'] == 'Friend'){ echo ' selected="selected"'; } ?> > Friend </option>
                                                <option value="Colleague" <?php if($rowtedt['rtionship'] == 'Colleague'){ echo ' selected="selected"'; } ?> > Colleague </option>
                                                <option value="Others" <?php if($rowtedt['rtionship'] == 'Others'){ echo ' selected="selected"'; } ?> > Others </option>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-sm-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInputEmail1">Residential Address<span style="color:red;">*</span></label>
                                            <textarea rows="2" name="taddr" class="form-control maxlength-simple" required><?php echo $rowtedt["addr"]; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">City<span style="color:red;">*</span></label>
                                            <input type="text" name="tcity" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $rowtedt["city"]; ?>" required>
                                            </fieldset>
                                        </div>

                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">State<span style="color:red;">*</span></label>
                                                <select class="form-control" name="tstate" required>
                                                <option value=""> -Please Select- </option>
                                                <option value="Abia" <?php if($rowtedt['state']== 'Abia'){ echo ' selected="selected"'; } ?> > Abia </option>
                                                <option value="Abuja" <?php if($rowtedt['state']== 'Abuja'){ echo ' selected="selected"'; } ?>> Abuja </option>
                                                                    <option value="Adamawa" <?php if($rowtedt['state']== 'Adamawa'){ echo ' selected="selected"'; } ?>> Adamawa </option>
                                                                    <option value="Akwa Ibom" <?php if($rowtedt['state']== 'Akwa Ibom'){ echo ' selected="selected"'; } ?>> Akwa Ibom </option>
                                                                    <option value="Anambra" <?php if($rowtedt['state']== 'Anambra'){ echo ' selected="selected"'; } ?> > Anambra </option>
                                                                    <option value="Bauchi" <?php if($rowtedt['state']== 'Bauchi'){ echo ' selected="selected"'; } ?>> Bauchi </option>
                                                                    <option value="Bayelsa" <?php if($rowtedt['state']== 'Bayelsa'){ echo ' selected="selected"'; } ?> > Bayelsa </option>
                                                                    <option value="Benue" <?php if($rowtedt['state']== 'Benue'){ echo ' selected="selected"'; } ?>> Benue </option>
                                                                    <option value="Borno" <?php if($rowtedt['state']== 'Borno'){ echo ' selected="selected"'; } ?> > Borno </option>
                                                                    <option value="Cross River" <?php if($rowtedt['state']== 'Cross River'){ echo ' selected="selected"'; } ?> > Cross River </option>
                                                                    <option value="Delta" <?php if($rowtedt['state']== 'Delta'){ echo ' selected="selected"'; } ?> > Delta </option>
                                                                    <option value="Ebonyi" <?php if($rowtedt['state']== 'Ebonyi'){ echo ' selected="selected"'; } ?> > Ebonyi </option>
                                                                    <option value="Enugu" <?php if($rowtedt['state']== 'Enugu'){ echo ' selected="selected"'; } ?> > Enugu </option>
                                                                    <option value="Edo" <?php if($rowtedt['state']== 'Edo'){ echo ' selected="selected"'; } ?> > Edo </option>
                                                                    <option value="Ekiti" <?php if($rowtedt['state']== 'Ekiti'){ echo ' selected="selected"'; } ?> > Ekiti </option>
                                                                    <option value="Gombe" <?php if($rowtedt['state']== 'Gombe'){ echo ' selected="selected"'; } ?>> Gombe </option>
                                                                    <option value="Imo" <?php if($rowtedt['state']== 'Imo'){ echo ' selected="selected"'; } ?>> Imo </option>
                                                                    <option value="Jigawa" <?php if($rowtedt['state']== 'Jigawa'){ echo ' selected="selected"'; } ?> > Jigawa </option>
                                                                    <option value="Kaduna" <?php if($rowtedt['state']== 'Kaduna'){ echo ' selected="selected"'; } ?>> Kaduna </option>
                                                                    <option value="Kano" <?php if($rowtedt['state']== 'Kano'){ echo ' selected="selected"'; } ?>> Kano </option>
                                                                    <option value="Katsina" <?php if($rowtedt['state']== 'Katsina'){ echo ' selected="selected"'; } ?> > Katsina </option>
                                                                    <option value="Kebbi" <?php if($rowtedt['state']== 'Kebbi'){ echo ' selected="selected"'; } ?> > Kebbi </option>
                                                                    <option value="Kogi" <?php if($rowtedt['state']== 'Kogi'){ echo ' selected="selected"'; } ?> > Kogi </option>
                                                                    <option value="Kwara" <?php if($rowtedt['state']== 'Kwara'){ echo ' selected="selected"'; } ?> > Kwara </option>
                                                                    <option value="Lagos" <?php if($rowtedt['state']== 'Lagos'){ echo ' selected="selected"'; } ?> > Lagos </option>
                                                                    <option value="Nasarawa" <?php if($rowedt['Nasarawa'] == 'Abia'){ echo ' selected="selected"'; } ?>> Nasarawa </option>
                                                                    <option value="Niger" <?php if($rowtedt['state']== 'Niger'){ echo ' selected="selected"'; } ?> > Niger </option>
                                                                    <option value="Ogun" <?php if($rowtedt['state']== 'Ogun'){ echo ' selected="selected"'; } ?>> Ogun </option>
                                                                    <option value="Ondo" <?php if($rowtedt['state']== 'Ondo'){ echo ' selected="selected"'; } ?>> Ondo </option>
                                                                    <option value="Osun" <?php if($rowtedt['state']== 'Osun'){ echo ' selected="selected"'; } ?>> Osun </option>
                                                                    <option value="Oyo" <?php if($rowtedt['state']== 'Oyo'){ echo ' selected="selected"'; } ?> > Oyo </option>
                                                                    <option value="Plateau" <?php if($rowtedt['state']== 'Plateau'){ echo ' selected="selected"'; } ?> > Plateau </option>
                                                                    <option value="Rivers" <?php if($rowtedt['state']== 'Rivers'){ echo ' selected="selected"'; } ?>> Rivers </option>
                                                                    <option value="Sokoto" <?php if($rowtedt['state']== 'Sokoto'){ echo ' selected="selected"'; } ?>> Sokoto </option>
                                                                    <option value="Taraba" <?php if($rowtedt['state']== 'Taraba'){ echo ' selected="selected"'; } ?>> Taraba </option>
                                                                    <option value="Yobe" <?php if($rowtedt['state']== 'Yobe'){ echo ' selected="selected"'; } ?>> Yobe </option>
                                                                    <option value="Zamfara" <?php if($rowtedt['state']== 'Zamfara'){ echo ' selected="selected"'; } ?>> Zamfara </option>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <input type="hidden" name="tid" value="<?php echo $rowtedt["id"]; ?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
    <!--EDIT TRUSTEES MODAL ENDS HERE-->
<?php } while ($rowtedt = mysqli_fetch_assoc($resulttedt));?>


<!--ADD CORPORATE TRUSTEES MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="addcorporatetrustee" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Appoint Corporate Trustees<br><span style="font-size:13px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:13px;">All fields with asterisk are compulsory</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-addcorporatetrustees.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Company's Name<span style="color:red;">*</span></label>
                                            <input type="text" name="cname" class="form-control maxlength-simple" id="exampleInput" required >
                                            </fieldset>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                    <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInputEmail1">Address<span style="color:red;">*</span></label>
                                            <textarea rows="2" name="caddr" class="form-control maxlength-simple" required></textarea>
                                            </fieldset>
                                    </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Email</label>
                                            <input type="email" name="cemail" class="form-control maxlength-simple" id="exampleInput" requ/ired >
                                            </fieldset>
                                        </div>
                                                                                <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Phone Number<span style="color:red;">*</span></label>
                                                <input type="text" name="cphoneno" class="form-control maxlength-simple" id="exampleInput" required >
                                            </fieldset>
                                        </div>
                                    </div>
                                    
<input type="hidden" name="ctitle" value="corporate"  />
                                    <input type="hidden" name="uid" value="<?php echo $userid; ?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
    <!--ADD CORPORATE TRUSTEES MODAL ENDS HERE-->

<?php do { ?>
    <!--EDIT CORPORATE TRUSTEE MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="editcorporatetrustee<?php echo $rowedtcor["id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Corporate Trustee<br><span style="font-size:13px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:13px;">All fields with asterisk are compulsory</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-editcorporatetrustees.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Company's Name<span style="color:red;">*</span></label>
                                            <input type="text" name="tname" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $rowedtcor["fullname"]; ?>" required>
                                            </fieldset>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInputEmail1">Address<span style="color:red;">*</span></label>
                                            <textarea rows="2" name="taddr" class="form-control maxlength-simple" required><?php echo $rowedtcor["addr"]; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Email</label>
                                            <input type="email" name="temail" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $rowedtcor["email"]; ?>" req/uired>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Phone Number<span style="color:red;">*</span></label>
                                                <input type="text" name="tphoneno" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $rowedtcor["phone"]; ?>" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <input type="hidden" name="tid" value="<?php echo $rowedtcor["id"]; ?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
    <!--EDIT CORPORATE TRUSTEES MODAL ENDS HERE-->
<?php } while ($rowedtcor = mysqli_fetch_assoc($resultedtcor));?>


        <!--ADD FCMB TRUSTEES CORPORATE EXECUTOR MODAL ENDS HERE -->
    <!-- Modal -->
<div class="modal fade" id="addfcmbcorporatetrustee" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Appoint FCMB Trustees</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-addfcmbcorporatetrustees.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Company's Name</label>
                                            <input type="text" name="cname1" class="form-control maxlength-simple" id="exampleInput" disabled value="FCMB Trustees">
                                            <input type="hidden" name="cname" class="form-control maxlength-simple" id="exampleInput" value="FCMB Trustees">
                                            </fieldset>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                    <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInputEmail1">Address</label>
                                            <textarea rows="2" name="caddr1" class="form-control maxlength-simple" disabled>Primrose Tower, 2nd Floor, 17A Tinubu Street,
Lagos</textarea>

<textarea rows="2" name="caddr" class="form-control maxlength-simple" hidden>Primrose Tower, 2nd Floor, 17A Tinubu Street,
Lagos</textarea>
                                            </fieldset>
                                    </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Email</label>
                                            <input type="email" name="cemail1" class="form-control maxlength-simple" id="exampleInput" disabled value="fcmbtrustees@fcmb.com">
                                            
                                             <input type="hidden" name="cemail" class="form-control maxlength-simple" id="exampleInput" value="fcmbtrustees@fcmb.com">
                                            </fieldset>
                                        </div>
                                                                                <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Phone Number</label>
                                                <input type="text" name="cphoneno1" class="form-control maxlength-simple" id="exampleInput" disabled value="+234 1 290 2721">
                                                
                                                <input type="hidden" name="cphoneno" class="form-control maxlength-simple" id="exampleInput" value="+234 1 290 2721">
                                            </fieldset>
                                        </div>
                                    </div>
                                    
<input type="hidden" name="ctitle" value="corporate"  />
                                    <input type="hidden" name="uid" value="<?php echo $userid; ?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
    <!--ADD FCMB TRUSTEES CORPORATE EXECUTOR MODAL ENDS HERE-->

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
<script src="js/app.js"></script>
</body>
</html>