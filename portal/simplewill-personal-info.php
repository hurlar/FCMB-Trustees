<?php require ('Connections/conn.php');
include ('session.php');
if(!isset($userid)){
header('location:index.php');
exit();
}

$query = "SELECT gender FROM users WHERE id = '$userid' ";
$gen = mysqli_query($conn, $query) or die(mysqli_error($conn));
$row_gen = mysqli_fetch_assoc($gen );

//Select from personal info table
$query_pi = "SELECT * FROM personal_info WHERE `uid` = '$userid' ";
$result_pi = mysqli_query($conn, $query_pi) or die(mysqli_error($conn));
$row_pi = mysqli_fetch_assoc($result_pi);
$totalpi = mysqli_num_rows($result_pi);

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
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/separate/pages/widgets.min.css">
    <link rel="stylesheet" href="css/lib/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="css/separate/vendor/flatpickr.min.css">
    <link rel="stylesheet" href="css/separate/vendor/select2.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

        <link rel="stylesheet" type="text/css" href="cssdate/jquery.datepick.css"> 
        <script type="text/javascript" src="jsdate/jquery.plugin.js"></script> 
        <script type="text/javascript" src="jsdate/jquery.datepick.js"></script>
        

    <link rel="stylesheet" href="css/separate/vendor/bootstrap-daterangepicker.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker3.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!--<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>-->

<script>
  $( function() {
    $( "#popupDatepicker" ).datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: '-100y:c+nn',
      //maxDate: '-1d'
      //yearRange: 'c-100:c+10' 
    });
  } );
  
  $( function() {
    $( "#passportissuedate" ).datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: '-11y:c+nn',
      //maxDate: '-1d'
      //yearRange: 'c-100:c+10' 
    });
  } );
  
  $( function() {
    $( "#passportexpirydate" ).datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: 'c:c+11y',
      //maxDate: '-1d'
      //yearRange: 'c-100:c+10' 
    });
  } );
  
  $( function() {
    $( "#licenseissuedate" ).datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: '-11y:c+nn',
      //maxDate: '-1d'
      //yearRange: 'c-100:c+10' 
    });
  } );
  
  $( function() {
    $( "#licenseexpirydate" ).datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: 'c:c+11y',
      //maxDate: '-1d'
      //yearRange: 'c-100:c+10' 
    });
  } );
  
    $( function() {
    $( "#idcardissuedate" ).datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: '-11y:c+nn',
      //maxDate: '-1d'
      //yearRange: 'c-100:c+10' 
    });
  } );
  
  $( function() {
    $( "#idcardexpirydate" ).datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: 'c:c+11y',
      //maxDate: '-1d'
      //yearRange: 'c-100:c+10' 
    });
  } );
</script> 
  
        <script>
           // $(function() {
            //    $('#popupDatepicker').datepick();
            //});
        </script>
        
        <script>
           // $(function() {
            //    $('#issuedate').datepick({
      //changeMonth: true,
      //changeYear: true,
    //  yearRange: 'c:c+11y',
      //maxDate: '-1d'
      //yearRange: 'c-100:c+10' 
    //});
         //   });
        </script>
        
        <script>
           // $(function() {
           //     $('#expirydate').datepick();
           // });
        </script>


<style type="text/css">
    .boxxxx{
        display: none;
    }

    .passpot{
        display: none;
    }
    
    .license{
        display: none;
    }
    
    .IDCard{
        display: none;
    }
    
    .VotersCard{
        display: none;
    }

</style>

<script type="text/javascript">
$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        var inputValue = $(this).attr("value");
        var targetBoxxxx = $("." + inputValue);
        $(".boxxxx").not(targetBoxxxx).hide();
        $(targetBoxxxx).show();
    });
});

$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        var inputValue = $(this).attr("value");
        var targetpasspot = $("." + inputValue);
        $(".passpot").not(targetpasspot).hide();
        $(targetpasspot).show();
    });
});

$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        var inputValue = $(this).attr("value");
        var targetlicense = $("." + inputValue);
        $(".license").not(targetlicense).hide();
        $(targetlicense).show();
    });
});

$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        var inputValue = $(this).attr("value");
        var targetIDCard = $("." + inputValue);
        $(".IDCard").not(targetIDCard).hide();
        $(targetIDCard).show();
    });
});

$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        var inputValue = $(this).attr("value");
        var targetVotersCard = $("." + inputValue);
        $(".VotersCard").not(targetVotersCard).hide();
        $(targetVotersCard).show();
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
                            <div class="profile-card-name"> Information about you - <br>(Full Name, Date of Birth, Contact Address, Phone Number, Nationality, State of Origin). </div>

                    </section>     

                    <section class="box-typical sidemenu">
                        <div class="profile-card">
                        <div class="profile-card-name"> Go to Dashboard</div> <br/>

                                <a href="dashboard.php"><button type="button" class="btn btn-inline btn-fcmb" > Go Back </button></a>
                                </div>

                    </section>

                </div><!--.col- -->

                <div class="col-lg-9 col-lg-push-3 col-md-12">
                <form action="processor/process-simplewill-personal-info.php" method="post" enctype="multipart/form-data">
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

<?php if($url == 'denied'){  ?>
<div class="alert alert-warning alert-fill alert-close alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <?php echo  ' File Size is too large' ; ?>
</div>
<?php } ?>

<?php if($url == 'invalid'){  ?>
<div class="alert alert-warning alert-fill alert-close alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <?php echo  'Invalid file type.' ; ?>
</div>
<?php } ?>


<?php } ?>


                        
                    <h5>Basic Details</h5>
                    <p class="paragraphwithborder"> Information about you - Full Name, Date of Birth, Contact Address, Phone Number, Nationality, State of Origin. <br><span style="font-size:13px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:13px;">All fields with asterisk are compulsory</span></p> 
                    <h5>Personal Data</h5>
                    <div class="row">
                        
                        <div class="col-md-4 col-sm-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Title<span style="color:red;">*</span></label>
                                <select class="form-control" name="salutation" required>
                                    <option value="Mr" <?php if($row_pi['salutation'] == 'Mr'){ echo ' selected="selected"'; } ?> > Mr. </option>
                                    <option value="Ms" <?php if($row_pi['salutation'] == 'Ms'){ echo ' selected="selected"'; } ?> > Ms. </option>
                                    <option value="Mrs" <?php if($row_pi['salutation'] == 'Mrs'){ echo ' selected="selected"'; } ?> > Mrs. </option>
                                    <option value="Others" <?php if($row_pi['salutation'] == 'Others'){ echo ' selected="selected"'; } ?> > Others </option>
                                    
                                    
                                </select>
                            </fieldset>
                        </div>
                    </div>
<hr>

                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">First Name<span style="color:red;">*</span></label>
                                <input type="text" name="fname" value="<?php echo $fname;?>" class="form-control maxlength-simple" id="exampleInput" required/>
                            </fieldset>
                        </div>
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInputEmail1">Middle Name</label>
                                <input type="text" name="mname" class="form-control maxlength-custom-message" id="exampleInputEmail1" value="<?php echo $row_pi['mname'];?>"  />
                            </fieldset>
                        </div>
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInputPassword1">Last Name<span style="color:red;">*</span></label>
                                <input type="text" name="lname" value="<?php echo $lname;?>" class="form-control maxlength-always-show" id="exampleInputPassword1" required />
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                        
                                        <label>Date of Birth (MM/DD/YYYY)<span style="color:red;">*</span></label> 
                                        
                                        <input type="text" name="dob" id="popupDatepicker" autocomplete="off" class="form-control" required 
                                        value="<?php echo $row_pi['dob'];?>" >
                            </fieldset>
                        </div>

                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Gender<span style="color:red;">*</span></label>
                                <select class="form-control" name="gender" required>
                                <option value=""> -Please Select-</option>
                                <option value="Male" <?php if($row_gen['gender'] == 'Male'){ echo ' selected="selected"'; } ?> > Male </option>
                                <option value="Female" <?php if($row_gen['gender'] == 'Female'){ echo ' selected="selected"'; } ?> > Female </option>
                                </select>
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInputMaidenName">Mother's Maiden Name<span style="color:red;">*</span></label>
                                <input type="text" name="mothermaidenname" value="<?php echo $row_pi['maidenname'];?>" class="form-control" id="exampleInputPassword1" required />
                            </fieldset>
                        </div>
                    </div>
<hr>

                    <div class="row">
                        
                        <div class="col-lg-4 col-sm-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Nationality<span style="color:red;">*</span></label>
                                <select class="form-control" name="nationality" required>
                    <option value="">-Please Select- </option>
                                    <option value="Nigerian" <?php if($row_pi['nationality'] == 'Nigerian'){ echo ' selected="selected"'; } ?> > Nigerian</option>
                                    <option value="Others" <?php if($row_pi['nationality'] == 'Others'){ echo ' selected="selected"'; } ?> > Others </option>
                                </select>
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-4 col-sm-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">State of Origin<span style="color:red;">*</span></label>
                                
                                <select class="form-control" name="state" required>
                                <option value=""> -Please Select- </option>
                                <option value="Abia" <?php if($row_pi['state'] == 'Abia'){ echo ' selected="selected"'; } ?> > Abia </option>
                                                <option value="Abuja" <?php if($row_pi['state'] == 'Abuja'){ echo ' selected="selected"'; } ?>> Abuja </option>
                                                                    <option value="Adamawa" <?php if($row_pi['state'] == 'Adamawa'){ echo ' selected="selected"'; } ?>> Adamawa </option>
                                                                    <option value="Akwa Ibom" <?php if($row_pi['state'] == 'Akwa Ibom'){ echo ' selected="selected"'; } ?>> Akwa Ibom </option>
                                                                    <option value="Anambra" <?php if($row_pi['state'] == 'Anambra'){ echo ' selected="selected"'; } ?> > Anambra </option>
                                                                    <option value="Bauchi" <?php if($row_pi['state'] == 'Bauchi'){ echo ' selected="selected"'; } ?>> Bauchi </option>
                                                                    <option value="Bayelsa" <?php if($row_pi['state'] == 'Bayelsa'){ echo ' selected="selected"'; } ?> > Bayelsa </option>
                                                                    <option value="Benue" <?php if($row_pi['state'] == 'Benue'){ echo ' selected="selected"'; } ?>> Benue </option>
                                                                    <option value="Borno" <?php if($row_pi['state'] == 'Borno'){ echo ' selected="selected"'; } ?> > Borno </option>
                                                                    <option value="Cross River" <?php if($row_pi['state'] == 'Cross River'){ echo ' selected="selected"'; } ?> > Cross River </option>
                                                                    <option value="Delta" <?php if($row_pi['state'] == 'Delta'){ echo ' selected="selected"'; } ?> > Delta </option>
                                                                    <option value="Ebonyi" <?php if($row_pi['state'] == 'Ebonyi'){ echo ' selected="selected"'; } ?> > Ebonyi </option>
                                                                    <option value="Enugu" <?php if($row_pi['state'] == 'Enugu'){ echo ' selected="selected"'; } ?> > Enugu </option>
                                                                    <option value="Edo" <?php if($row_pi['state'] == 'Edo'){ echo ' selected="selected"'; } ?> > Edo </option>
                                                                    <option value="Ekiti" <?php if($row_pi['state'] == 'Ekiti'){ echo ' selected="selected"'; } ?> > Ekiti </option>
                                                                    <option value="Gombe" <?php if($row_pi['state'] == 'Gombe'){ echo ' selected="selected"'; } ?>> Gombe </option>
                                                                    <option value="Imo" <?php if($row_pi['state'] == 'Imo'){ echo ' selected="selected"'; } ?>> Imo </option>
                                                                    <option value="Jigawa" <?php if($row_pi['state'] == 'Jigawa'){ echo ' selected="selected"'; } ?> > Jigawa </option>
                                                                    <option value="Kaduna" <?php if($row_pi['state'] == 'Kaduna'){ echo ' selected="selected"'; } ?>> Kaduna </option>
                                                                    <option value="Kano" <?php if($row_pi['state'] == 'Kano'){ echo ' selected="selected"'; } ?>> Kano </option>
                                                                    <option value="Katsina" <?php if($row_pi['state'] == 'Katsina'){ echo ' selected="selected"'; } ?> > Katsina </option>
                                                                    <option value="Kebbi" <?php if($row_pi['state'] == 'Kebbi'){ echo ' selected="selected"'; } ?> > Kebbi </option>
                                                                    <option value="Kogi" <?php if($row_pi['state'] == 'Kogi'){ echo ' selected="selected"'; } ?> > Kogi </option>
                                                                    <option value="Kwara" <?php if($row_pi['state'] == 'Kwara'){ echo ' selected="selected"'; } ?> > Kwara </option>
                                                                    <option value="Lagos" <?php if($row_pi['state'] == 'Lagos'){ echo ' selected="selected"'; } ?> > Lagos </option>
                                                                    <option value="Nasarawa" <?php if($row_pi['Nasarawa'] == 'Abia'){ echo ' selected="selected"'; } ?>> Nasarawa </option>
                                                                    <option value="Niger" <?php if($row_pi['state'] == 'Niger'){ echo ' selected="selected"'; } ?> > Niger </option>
                                                                    <option value="Ogun" <?php if($row_pi['state'] == 'Ogun'){ echo ' selected="selected"'; } ?>> Ogun </option>
                                                                    <option value="Ondo" <?php if($row_pi['state'] == 'Ondo'){ echo ' selected="selected"'; } ?>> Ondo </option>
                                                                    <option value="Osun" <?php if($row_pi['state'] == 'Osun'){ echo ' selected="selected"'; } ?>> Osun </option>
                                                                    <option value="Oyo" <?php if($row_pi['state'] == 'Oyo'){ echo ' selected="selected"'; } ?> > Oyo </option>
                                                                    <option value="Plateau" <?php if($row_pi['state'] == 'Plateau'){ echo ' selected="selected"'; } ?> > Plateau </option>
                                                                    <option value="Rivers" <?php if($row_pi['state'] == 'Rivers'){ echo ' selected="selected"'; } ?>> Rivers </option>
                                                                    <option value="Sokoto" <?php if($row_pi['state'] == 'Sokoto'){ echo ' selected="selected"'; } ?>> Sokoto </option>
                                                                    <option value="Taraba" <?php if($row_pi['state'] == 'Taraba'){ echo ' selected="selected"'; } ?>> Taraba </option>
                                                                    <option value="Yobe" <?php if($row_pi['state'] == 'Yobe'){ echo ' selected="selected"'; } ?>> Yobe </option>
                                                                    <option value="Zamfara" <?php if($row_pi['state'] == 'Zamfara'){ echo ' selected="selected"'; } ?>> Zamfara </option>
                                </select>
                                
                            </fieldset>
                        </div>

                        <div class="col-lg-4 col-sm-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">LGA<span style="color:red;">*</span></label>
                                <input type="text" name="lga" class="form-control maxlength-simple" id="exampleInput" required value="<?php echo $row_pi['lga'];?>" />
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Phone Number<span style="color:red;">*</span></label>
                                <input type="text" name="phoneno" value="<?php echo $phone;?>" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInputEmail1">Alt. Phone Number</label>
                                <input type="text" name="altphoneno" class="form-control maxlength-custom-message" id="exampleInputEmail1" value="<?php echo $row_pi['aphone'];?>">
                            </fieldset>
                        </div>
                    </div>
<hr>
                     <div class="row">
                        <div class="col-sm-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInputEmail1">Residential Address<span style="color:red;">*</span></label>
                                <textarea rows="2" name="message" class="form-control maxlength-simple" required><?php echo $row_pi['msg'];?></textarea>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">City<span style="color:red;">*</span></label>
                                <input type="text" name="city" class="form-control maxlength-simple" id="exampleInput"  value="<?php echo $row_pi['city'];?>" required />
                            </fieldset>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">State<span style="color:red;">*</span></label>
                                <select class="form-control" name="rstate" required>
                                <option value=""> - Please Select - </option>
                                <option value="Abia" <?php if($row_pi['rstate'] == 'Abia'){ echo ' selected="selected"'; } ?> > Abia </option>
                                                <option value="Abuja" <?php if($row_pi['rstate'] == 'Abuja'){ echo ' selected="selected"'; } ?>> Abuja </option>
                                                                    <option value="Adamawa" <?php if($row_pi['rstate'] == 'Adamawa'){ echo ' selected="selected"'; } ?>> Adamawa </option>
                                                                    <option value="Akwa Ibom" <?php if($row_pi['rstate'] == 'Akwa Ibom'){ echo ' selected="selected"'; } ?>> Akwa Ibom </option>
                                                                    <option value="Anambra" <?php if($row_pi['rstate'] == 'Anambra'){ echo ' selected="selected"'; } ?> > Anambra </option>
                                                                    <option value="Bauchi" <?php if($row_pi['rstate'] == 'Bauchi'){ echo ' selected="selected"'; } ?>> Bauchi </option>
                                                                    <option value="Bayelsa" <?php if($row_pi['rstate'] == 'Bayelsa'){ echo ' selected="selected"'; } ?> > Bayelsa </option>
                                                                    <option value="Benue" <?php if($row_pi['rstate'] == 'Benue'){ echo ' selected="selected"'; } ?>> Benue </option>
                                                                    <option value="Borno" <?php if($row_pi['rstate'] == 'Borno'){ echo ' selected="selected"'; } ?> > Borno </option>
                                                                    <option value="Cross River" <?php if($row_pi['rstate'] == 'Cross River'){ echo ' selected="selected"'; } ?> > Cross River </option>
                                                                    <option value="Delta" <?php if($row_pi['rstate'] == 'Delta'){ echo ' selected="selected"'; } ?> > Delta </option>
                                                                    <option value="Ebonyi" <?php if($row_pi['rstate'] == 'Ebonyi'){ echo ' selected="selected"'; } ?> > Ebonyi </option>
                                                                    <option value="Enugu" <?php if($row_pi['rstate'] == 'Enugu'){ echo ' selected="selected"'; } ?> > Enugu </option>
                                                                    <option value="Edo" <?php if($row_pi['rstate'] == 'Edo'){ echo ' selected="selected"'; } ?> > Edo </option>
                                                                    <option value="Ekiti" <?php if($row_pi['rstate'] == 'Ekiti'){ echo ' selected="selected"'; } ?> > Ekiti </option>
                                                                    <option value="Gombe" <?php if($row_pi['rstate'] == 'Gombe'){ echo ' selected="selected"'; } ?>> Gombe </option>
                                                                    <option value="Imo" <?php if($row_pi['rstate'] == 'Imo'){ echo ' selected="selected"'; } ?>> Imo </option>
                                                                    <option value="Jigawa" <?php if($row_pi['rstate'] == 'Jigawa'){ echo ' selected="selected"'; } ?> > Jigawa </option>
                                                                    <option value="Kaduna" <?php if($row_pi['rstate'] == 'Kaduna'){ echo ' selected="selected"'; } ?>> Kaduna </option>
                                                                    <option value="Kano" <?php if($row_pi['rstate'] == 'Kano'){ echo ' selected="selected"'; } ?>> Kano </option>
                                                                    <option value="Katsina" <?php if($row_pi['rstate'] == 'Katsina'){ echo ' selected="selected"'; } ?> > Katsina </option>
                                                                    <option value="Kebbi" <?php if($row_pi['rstate'] == 'Kebbi'){ echo ' selected="selected"'; } ?> > Kebbi </option>
                                                                    <option value="Kogi" <?php if($row_pi['rstate'] == 'Kogi'){ echo ' selected="selected"'; } ?> > Kogi </option>
                                                                    <option value="Kwara" <?php if($row_pi['rstate'] == 'Kwara'){ echo ' selected="selected"'; } ?> > Kwara </option>
                                                                    <option value="Lagos" <?php if($row_pi['rstate'] == 'Lagos'){ echo ' selected="selected"'; } ?> > Lagos </option>
                                                                    <option value="Nasarawa" <?php if($row_pi['Nasarawa'] == 'Abia'){ echo ' selected="selected"'; } ?>> Nasarawa </option>
                                                                    <option value="Niger" <?php if($row_pi['rstate'] == 'Niger'){ echo ' selected="selected"'; } ?> > Niger </option>
                                                                    <option value="Ogun" <?php if($row_pi['rstate'] == 'Ogun'){ echo ' selected="selected"'; } ?>> Ogun </option>
                                                                    <option value="Ondo" <?php if($row_pi['rstate'] == 'Ondo'){ echo ' selected="selected"'; } ?>> Ondo </option>
                                                                    <option value="Osun" <?php if($row_pi['rstate'] == 'Osun'){ echo ' selected="selected"'; } ?>> Osun </option>
                                                                    <option value="Oyo" <?php if($row_pi['rstate'] == 'Oyo'){ echo ' selected="selected"'; } ?> > Oyo </option>
                                                                    <option value="Plateau" <?php if($row_pi['rstate'] == 'Plateau'){ echo ' selected="selected"'; } ?> > Plateau </option>
                                                                    <option value="Rivers" <?php if($row_pi['rstate'] == 'Rivers'){ echo ' selected="selected"'; } ?>> Rivers </option>
                                                                    <option value="Sokoto" <?php if($row_pi['rstate'] == 'Sokoto'){ echo ' selected="selected"'; } ?>> Sokoto </option>
                                                                    <option value="Taraba" <?php if($row_pi['rstate'] == 'Taraba'){ echo ' selected="selected"'; } ?>> Taraba </option>
                                                                    <option value="Yobe" <?php if($row_pi['rstate'] == 'Yobe'){ echo ' selected="selected"'; } ?>> Yobe </option>
                                                                    <option value="Zamfara" <?php if($row_pi['rstate'] == 'Zamfara'){ echo ' selected="selected"'; } ?>> Zamfara </option>
                                </select>
                            </fieldset>
                        </div>

                    </div>
<hr>
<h5>Means of Identification<span style="color:red;">*</span></h5>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">


                            <div class="radio">
                                <input type="radio" name="identification" id="radio-5" value="International Passport" <?php if($row_pi['identification_type'] == 'International Passport'){ echo ' checked="checked"'; } ?> required>
                                <label for="radio-5">International Passport </label>
                                <input type="radio" name="identification" id="radio-6" value="Drivers License" <?php if($row_pi['identification_type'] == 'Drivers License'){ echo ' checked="checked"'; } ?> required>
                                <label for="radio-6">Driver's License</label>
                                <input type="radio" name="identification" id="radio-7" value="National ID Card" <?php if($row_pi['identification_type'] == 'National ID Card'){ echo ' checked="checked"'; } ?> required>
                                <label for="radio-7">National ID Card</label>
                                <input type="radio" name="identification" id="radio-8" value="INEC Voters Card" <?php if($row_pi['identification_type'] == 'INEC Voters Card'){ echo ' checked="checked"'; } ?> required>
                                <label for="radio-8">INEC Voter's Card</label> <br>
                            </div>

                        
                                            
                </div>
</div>
                    <div clas/s="InternationalPassport passpot">
                      <div class="row">
                                    
                        <div class="col-lg-3">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">ID Number</label>
                                <input type="text" name="idnumber" value="<?php echo $row_pi['identification_number'];?>" class="form-control maxlength-simple" id="exampleInput" />
                            </fieldset>
                        </div>
                        <div class="col-lg-3">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInputEmail1">Issue Date (MM/DD/YYYY)</label>
                                <input type="text" name="issuedate" class="form-control" id="passportissuedate" autocomplete="off" value="<?php echo $row_pi['issuedate']; ?>"  />
                            </fieldset>
                        </div>
                        <div class="col-lg-3">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInputPassword1">Expiry Date (MM/DD/YYYY)</label>
                                <input type="text" name="expirydate" value="<?php echo $row_pi['expirydate'];?>" class="form-control" id="passportexpirydate" autocomplete="off" />
                            </fieldset>
                        </div>
                        <div class="col-lg-3">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInputPassword1">Place of Issue</label>
                                <input type="text" name="issuedplace" value="<?php echo $row_pi['issuedplace'];?>" class="form-control" id="exampleInputPassword1" />
                            </fieldset>
                        </div>
                    </div>
                  </div>

                  <!--<div class="DriversLicense license">
                      <div class="row">
                        <div class="col-lg-3">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInputEmail1">Issue Date (MM/DD/YYYY)</label>
                                <input type="text" name="licenseissuedate" class="form-control" id="licenseissuedate" autocomplete="off" value="<?php //echo $row_pi['issuedate']; ?>"  />
                            </fieldset>
                        </div>
                        <div class="col-lg-3">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInputPassword1">Expiry Date (MM/DD/YYYY)</label>
                                <input type="text" name="licenseexpirydate" value="<?php //echo $row_pi['expirydate'];?>" class="form-control" id="licenseexpirydate" autocomplete="off" />
                            </fieldset>
                        </div>
                        <div class="col-lg-3">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInputPassword1">Place of Issue</label>
                                <input type="text" name="licenseissuedplace" value="<?php //echo $row_pi['issuedplace'];?>" class="form-control" id="exampleInputPassword1" />
                            </fieldset>
                        </div>
                    


                    </div>
                  </div>-->
                  
                  <!--<div class="NationalIDCard IDCard">
                        <div class="row">
                        <div class="col-lg-3">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInputEmail1">Issue Date (MM/DD/YYYY)</label>
                                <input type="text" name="idcardissuedate" class="form-control" id="idcardissuedate" autocomplete="off" value="<?php //echo $row_pi['issuedate']; ?>"  />
                            </fieldset>
                        </div>
                        <div class="col-lg-3">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInputPassword1">Expiry Date (MM/DD/YYYY)</label>
                                <input type="text" name="idcardexpirydate" value="<?php //echo $row_pi['expirydate'];?>" class="form-control" id="idcardexpirydate" autocomplete="off" />
                            </fieldset>
                        </div>

                    </div>
                  </div>-->
                  
                    <!--<div class="INECVotersCard VotersCard">
                        <div class="row">


                    </div>
                  </div>-->

<hr>
<h5>Employment Status<span style="color:red;">*</span></h5>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="radio">
                                <input type="radio" name="estatus" id="radio-1" value="Employed" <?php if($row_pi['employment_status'] == 'Employed'){ echo ' checked="checked"'; } ?> required>
                                <label for="radio-1">Employed </label>
                                <input type="radio" name="estatus" id="radio-2" value="Self-Employed" <?php if($row_pi['employment_status'] == 'Self-Employed'){ echo ' checked="checked"'; } ?> required>
                                <label for="radio-2">Self-Employed</label>
                                <input type="radio" name="estatus" id="radio-3" value="Retired" <?php if($row_pi['employment_status'] == 'Retired'){ echo ' checked="checked"'; } ?> required>
                                <label for="radio-3">Retired</label>
                                <input type="radio" name="estatus" id="radio-4" value="Unemployed" <?php if($row_pi['employment_status'] == 'Unemployed'){ echo ' checked="checked"'; } ?> required>
                                <label for="radio-4">Unemployed</label> <br>
                            </div>

                        
                                            
                </div>

                    </div>

                    <div class="Employed boxxxx">
                        <div class="row col-md-12">
                                                <div class="col-md-6">
                                                    <fieldset class="form-group">
                                                        <label class="form-label" for="exampleInput">Employer</label>
                                                        <input type="text" name="employer" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $row_pi['employer'];?>">
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-6">
                                                    <fieldset class="form-group">
                                                        <label class="form-label" for="exampleInputEmail1">Office Phone</label>
                                                        <input type="number" name="employerphone" class="form-control maxlength-custom-message" id="exampleInputEmail1" value="<?php echo $row_pi['employerphone'];?>" >
                                                    </fieldset>
                                                </div>
                                                </div>
                                        <div class="row col-md-12">
                                                <div class="col-md-12">
                                                    <fieldset class="form-group">
                                                        <label class="form-label" for="exampleInputEmail1">Employer's Address</label>
                                                        <textarea rows="2" name="employeraddr" class="form-control maxlength-simple"><?php echo $row_pi['employeraddr'];?></textarea>
                                                    </fieldset>
                                                </div>
                                                </div>
<h5>Human Resources Contact</h5> 
<div class="row col-md-12">
                                        <div class="col-md-12">
                                            <fieldset class="form-group">
                                                        <label class="form-label" for="exampleInput">Name of Company</label>
                                                        <input type="text" name="nameofcompany" class="form-control" id="exampleInput" value="<?php echo $row_pi['nameofcompany'];?>">
                                                    </fieldset>
                                                </div>
                                                </div>
                                                <div class="row col-md-12">
                                                <div class="col-md-6">
                                                    <fieldset class="form-group">
                                                        <label class="form-label" for="exampleInputEmail1">TelePhone</label>
                                            <input type="text" name="companytelephone" class="form-control" id="exampleInputEmail1" value="<?php echo $row_pi['company_telephone'];?>" >
                                                    </fieldset>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <fieldset class="form-group">
                                                        <label class="form-label" for="exampleInputEmail1">Email Address</label>
                                                        <input type="text" name="companyemail" class="form-control" id="exampleInputEmail1" value="<?php echo $row_pi['company_email'];?>" >
                                                    </fieldset>
                                                </div>
                                                
                                            </div>
                                            </div>
<hr/>                
                    <div class="row">
                        <div class="col-sm-12">
                            <fieldset class="form-group">
<label class="form-label" for="exampleInputEmail1">Upload Passport <em>(<span style="color:red;">*</span>Optional.Max. File size is 1MB and must be in either jpeg, jpg, png or gif)</em></label>
                            </fieldset>
                        </div>
                        
                        <div class="col-sm-4">
                            <fieldset class="form-group">
                                
                <input type="file" name="passport"  />

                            </fieldset>
                        </div>
                    </div>
                                            
                    <input type="hidden" name="uid" value="<?php echo $userid ;?>" />
                    <input type="submit" value="Save And Proceed" class="btn btn-inline btn-fcmb" style="float:right;">
                
                </div>
            </section>
</form>
                </div><!--.col- -->
            </div><!--.row-->
        </div><!--.container-fluid-->
    </div><!--.page-content-->

    <!--<script src="js/lib/jquery/jquery-3.2.1.min.js"></script>-->
    <script src="js/lib/popper/popper.min.js"></script>
    <script src="js/lib/tether/tether.min.js"></script>
    <script src="js/lib/bootstrap/bootstrap.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/lib/slick-carousel/slick.min.js"></script>
    <script type="text/javascript" src="js/lib/flatpickr/flatpickr.min.js"></script>
    <script src="js/lib/select2/select2.full.min.js"></script>
    <script src="js/lib/bootstrap-select/bootstrap-select.min.js"></script>

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

<!--DATE PICKER STARTS-->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</body>
</html>