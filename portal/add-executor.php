<?php require ('Connections/conn.php');
include ('session.php');
if(!isset($userid)){
header('location:index.php');
exit();
}

$query = "SELECT * FROM executor_tb WHERE `uid` = '$userid' AND `title` != 'corporate' ";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
$row = mysqli_fetch_assoc($result);
$totalrow = mysqli_num_rows($result);

$queryexedt = "SELECT * FROM executor_tb WHERE `uid` = '$userid' ";
$resultexedt = mysqli_query($conn, $queryexedt) or die(mysqli_error($conn));
$rowexedt = mysqli_fetch_assoc($resultexedt);
$totalrowexedt = mysqli_num_rows($resultexedt);

$querycor = "SELECT * FROM executor_tb WHERE `uid` = '$userid' AND `title` = 'corporate'  ";
$resultcor = mysqli_query($conn, $querycor) or die(mysqli_error($conn));
$rowcor = mysqli_fetch_assoc($resultcor);
$totalrowcor = mysqli_num_rows($resultcor);

$queryedtcor = "SELECT * FROM executor_tb WHERE `uid` = '$userid' AND `title` = 'corporate'  ";
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
    <link rel="stylesheet" href="css/lib/bootstrap-sweetalert/sweetalert.css">
    <link rel="stylesheet" href="css/separate/vendor/sweet-alert-animations.min.css">


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
    .married{ background: #228B22; }

        .boxx{
        color: #fff;
        /**padding: 20px;**/
        display: none;
        margin-top: 20px;
    }
    .yes{ background: #228B22; }
    
    .boxxx{
        color: #fff;
        /**padding: 20px;
        margin-top: 20px;**/
        display: none;
    }
    .No{ background: #228B22; }

</style>

<script type="text/javascript">
$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        var inputValue = $(this).attr("value");
        var targetBoxxx = $("." + inputValue);
        $(".boxxx").not(targetBoxxx).hide();
        $(targetBoxxx).show();
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
                            <div class="profile-card-name">An executor is appointed to carry out Your instructions and wishes. You can choose professional executors, or friends and family to act in this capacity.</div>

                    </section><!--.box-typical-->
                    
                    <section class="box-typical sidemenu">
                        <div class="profile-card">
                        <div class="profile-card-name"> Go to Dashboard</div> <br/>

                                <a href="dashboard.php"><button type="button" class="btn btn-inline btn-fcmb" > Go Back </button></a>
                                </div>

                    </section>

                </div><!--.col- -->

                <div class="col-lg-9 col-lg-push-3 col-md-12">
                <form action="processor/process-executor.php" method="post"> 
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
    <?php echo  ' Please add a minimum of 2 executors ' ; ?>
</div>
<?php } ?>

<?php } ?>


                    <h5 class="with-bo/rder">Appoint Executors</h5>

                    <div class="row">
                    
                <div class="col-md-12 col-sm-12">
                    
                        <!--<div class="col-md-12 col-sm-12">-->
                         <p>It is advised you appoint people you trust who will honor your wishes and solve any problems that may arise. We recommend that you appoint at least two Executors especially if you own numerous properties. A beneficiary can be selected as an executor.</p>
                    <?php if ($totalrow != NULL) { ?>
                        <table class="table table-bordered table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th>Excutor's Name</th>
                                            <th>Executor's Phone Number </th>
                                            <th></th>
                                            <th></th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                        <?php do { ?>
                                            <tr>
                                                <td> <?php echo $row["title"].' '.$row["fullname"]; ?></td>
                                                <td><?php echo $row["phone"]; ?></td>
                                                <td><button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#editexecutor<?php echo $row["id"]; ?>">
                                                Edit
                                                </button></td>
                                                <!--<td><a id="delete_executor" data-id="<?php echo $row["id"]; ?>" href="javascript:void(0)"><button type="button" class="btn btn-inline btn-fcmb swal-btn-cancel" >
                                                Delete
                                                </button></a></td>-->
                                                
                                                <td><a href="processor/process-deleteexecutor.php?a=<?php echo $row["id"]; ?>" onclick="return confirm('Are you sure you want to delete ?');"><button type="button" class="btn btn-inline btn-fcmb" >
                                                Delete
                                                </button></a></td>
                                            </tr>
                                        <?php } while ($row = mysqli_fetch_assoc($result));?>
                                                                                </tbody>
                                    </table>
                            <?php } ?>
                                    <br/>
                            <button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#addexecutor">
                                Appoint Executor
                            </button>
                        <!--</div>-->
                
                </div>
                </div>
                </div>
                
                        
            </section>

            <section class="card">
                           
                <div class="card-block">


                    <h5 class="with-bo/rder">Choose a corporate executor</h5>

                    <div class="row">
                    
                <div class="col-md-12 col-sm-12">
                    
                        <!--<div class="col-md-12 col-sm-12">-->
                         
                         
                                             <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <p>Would you like to select a corporate organisation as your executor ? </p>
                        </div>
                    
                <div class="col-md-6 col-sm-12">

                            <div class="radio">
                                <input type="radio" name="cexecutor" id="radio-5" value="No" requ/ired>
                                <label for="radio-5">FCMB Trustees </label>


                                
                                <input type="radio" name="cexecutor" id="radio-6" value="Yes" requ/ired>
                                <label for="radio-6">Others (Corporate Entity) </label> <br>
                                        <button type="button" class="Yes boxx btn btn-inline btn-fcmb" data-toggle="modal" data-target="#addcorporateexecutor">
                                                Appoint Corporate Executor
                                        </button>
                                        
                                                                                <button type="button" class="No boxxx btn btn-inline btn-fcmb" data-toggle="modal" data-target="#addfcmbcorporateexecutor">
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
                                                <td><button type="button" class="btn btn-inline btn-fcmb" data-toggle="modal" data-target="#editcorporateexecutor<?php echo $rowcor["id"]; ?>">
                                                Edit
                                                </button></td>
                                                
                                                <td><a href="processor/process-deleteexecutor.php?a=<?php echo $rowcor["id"]; ?>" onclick="return confirm('Are you sure you want to delete ?');"><button type="button" class="btn btn-inline btn-fcmb" >
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
            
            <input type="submit" value="Save And Proceed" class="btn btn-inline btn-fcmb" style="float:right;">
        </form>
                </div><!--.col- -->



            </div><!--.row-->
        </div><!--.container-fluid-->
    </div><!--.page-content-->


    <!--ADD EXECUTORS MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="addexecutor" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Appoint Executor<br><span style="font-size:13px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:13px;">All fields with asterisk are compulsory</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-addexecutor.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Title<span style="color:red;">*</span></label>
                                                <select class="form-control" name="gtitle" required>
                                                    <option value=""> -Please Select- </option>
                                                    <option value="Mr" <?php if($_SESSION['gtitle'] == 'Mr'){ echo ' selected="selected"'; } ?> > Mr. </option>
                                                    <option value="Ms" <?php if($_SESSION['gtitle'] == 'Ms'){ echo ' selected="selected"'; } ?> > Ms. </option>
                                                    <option value="Mrs" <?php if($_SESSION['gtitle'] == 'Mrs'){ echo ' selected="selected"'; } ?> > Mrs. </option>
                                                    <!--<option value="Others" <?php //if($_SESSION['gtitle'] == 'Others'){ echo ' selected="selected"'; } ?> > Others (Corporate Entity) </option>
                                                    <option value="FCMB Trustees" <?php //if($_SESSION['gtitle'] == 'FCMB Trustees'){ echo ' selected="selected"'; } ?> > FCMB Trustees </option>-->
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Full Name<span style="color:red;">*</span></label>
                                            <input type="text" name="gname" class="form-control maxlength-simple" id="exampleInput" required value="<?php echo $_SESSION['gname'];?>">
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Email</label>
                                            <input type="email" name="gemail" class="form-control maxlength-simple" id="exampleInput" requ/ired value="<?php echo $_SESSION['gemail'];?>">
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Phone Number<span style="color:red;">*</span></label>
                                                <input type="text" name="gphoneno" class="form-control maxlength-simple" id="exampleInput" required value="<?php echo $_SESSION['gphoneno'];?>">
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Relationship<span style="color:red;">*</span></label>
                                                <select class="form-control" name="grelationship" required>
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
                                            <textarea rows="2" name="gaddr" class="form-control maxlength-simple" required><?php echo $_SESSION['gaddr'];?></textarea>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">City<span style="color:red;">*</span></label>
                                            <input type="text" name="gcity" class="form-control maxlength-simple" id="exampleInput" required value="<?php echo $_SESSION['gcity'];?>">
                                            </fieldset>
                                        </div>

                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">State<span style="color:red;">*</span></label>
                                                <select class="form-control" name="gstate" required>
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
                                    <input type="hidden" name="uid" value="<?php echo $userid; ?>"  />
                                    <input type="submit" name="insert" id="spouseinsert" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
    <!--ADD EXECUTOR MODAL ENDS HERE-->
    
    <?php do { ?>
    <!--EDIT EXECUTORS MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="editexecutor<?php echo $rowexedt['id'];?>" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit executor's details of <?php echo $rowexedt['title'];?> <?php echo $rowexedt['fullname'];?><br><span style="font-size:13px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:13px;">All fields with asterisk are compulsory</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-editexecutor.php">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Title<span style="color:red;">*</span></label>
                                                <select class="form-control" name="gtitle" required>
                                                    <option value=""> -Please Select- </option>
                                                    <option value="Mr" <?php if($rowexedt['title'] == 'Mr'){ echo ' selected="selected"'; } ?> > Mr. </option>
                                                    <option value="Ms" <?php if($rowexedt['title'] == 'Ms'){ echo ' selected="selected"'; } ?> > Ms. </option>
                                                    <option value="Mrs" <?php if($rowexedt['title'] == 'Mrs'){ echo ' selected="selected"'; } ?> > Mrs. </option>
                                                    <!--<option value="Others" <?php //if($rowexedt['title'] == 'Others'){ echo ' selected="selected"'; } ?> > Others (Corporate Entity) </option>
                                                    <option value="FCMB Trustees" <?php //if($rowexedt['title'] == 'FCMB Tustees'){ echo ' selected="selected"'; } ?> > FCMB Trustees </option>-->
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Full Name<span style="color:red;">*</span></label>
                                            <input type="text" name="gname" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $rowexedt['fullname'];?>" required>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Email</label>
                                            <input type="email" name="gemail" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $rowexedt['email'];?>" requi/red>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Phone Number<span style="color:red;">*</span></label>
                                                <input type="text" name="gphoneno" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $rowexedt['phone'];?>" required>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Relationship<span style="color:red;">*</span></label>
                                                <select class="form-control" name="grelationship" required>
                                                <option value=""> -Please Select- </option>
                                                <option value="Sibling" <?php if($rowexedt['rtionship'] == 'Sibling'){ echo ' selected="selected"'; } ?> > Sibling </option>
                                                <option value="Parent" <?php if($rowexedt['rtionship'] == 'Parent'){ echo ' selected="selected"'; } ?> > Parent </option>
                                                <option value="Relative" <?php if($rowexedt['rtionship'] == 'Relative'){ echo ' selected="selected"'; } ?> > Relative </option>
                                                <option value="Friend" <?php if($rowexedt['rtionship'] == 'Friend'){ echo ' selected="selected"'; } ?> > Friend </option>
                                                <option value="Colleague" <?php if($rowexedt['rtionship'] == 'Colleague'){ echo ' selected="selected"'; } ?> > Colleague </option>
                                                <option value="Others" <?php if($rowexedt['rtionship'] == 'Others'){ echo ' selected="selected"'; } ?> > Others </option>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-sm-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInputEmail1">Residential Address</label>
                                            <textarea rows="2" name="gaddr" class="form-control maxlength-simple" required><?php echo $rowexedt['addr'];?></textarea>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">City<span style="color:red;">*</span></label>
                                            <input type="text" name="gcity" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $rowexedt['city'];?>" required>
                                            </fieldset>
                                        </div>

                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">State<span style="color:red;">*</span></label>
                                                <select class="form-control" name="gstate" required>
                                                <option value=""> -Please Select- </option>
                                                <option value="Abia" <?php if($rowexedt['state']== 'Abia'){ echo ' selected="selected"'; } ?> > Abia </option>
                                                <option value="Abuja" <?php if($rowexedt['state']== 'Abuja'){ echo ' selected="selected"'; } ?>> Abuja </option>
                                                                    <option value="Adamawa" <?php if($rowexedt['state']== 'Adamawa'){ echo ' selected="selected"'; } ?>> Adamawa </option>
                                                                    <option value="Akwa Ibom" <?php if($rowexedt['state']== 'Akwa Ibom'){ echo ' selected="selected"'; } ?>> Akwa Ibom </option>
                                                                    <option value="Anambra" <?php if($rowexedt['state']== 'Anambra'){ echo ' selected="selected"'; } ?> > Anambra </option>
                                                                    <option value="Bauchi" <?php if($rowexedt['state']== 'Bauchi'){ echo ' selected="selected"'; } ?>> Bauchi </option>
                                                                    <option value="Bayelsa" <?php if($rowexedt['state']== 'Bayelsa'){ echo ' selected="selected"'; } ?> > Bayelsa </option>
                                                                    <option value="Benue" <?php if($rowexedt['state']== 'Benue'){ echo ' selected="selected"'; } ?>> Benue </option>
                                                                    <option value="Borno" <?php if($rowexedt['state']== 'Borno'){ echo ' selected="selected"'; } ?> > Borno </option>
                                                                    <option value="Cross River" <?php if($rowexedt['state']== 'Cross River'){ echo ' selected="selected"'; } ?> > Cross River </option>
                                                                    <option value="Delta" <?php if($rowexedt['state']== 'Delta'){ echo ' selected="selected"'; } ?> > Delta </option>
                                                                    <option value="Ebonyi" <?php if($rowexedt['state']== 'Ebonyi'){ echo ' selected="selected"'; } ?> > Ebonyi </option>
                                                                    <option value="Enugu" <?php if($rowexedt['state']== 'Enugu'){ echo ' selected="selected"'; } ?> > Enugu </option>
                                                                    <option value="Edo" <?php if($rowexedt['state']== 'Edo'){ echo ' selected="selected"'; } ?> > Edo </option>
                                                                    <option value="Ekiti" <?php if($rowexedt['state']== 'Ekiti'){ echo ' selected="selected"'; } ?> > Ekiti </option>
                                                                    <option value="Gombe" <?php if($rowexedt['state']== 'Gombe'){ echo ' selected="selected"'; } ?>> Gombe </option>
                                                                    <option value="Imo" <?php if($rowexedt['state']== 'Imo'){ echo ' selected="selected"'; } ?>> Imo </option>
                                                                    <option value="Jigawa" <?php if($rowexedt['state']== 'Jigawa'){ echo ' selected="selected"'; } ?> > Jigawa </option>
                                                                    <option value="Kaduna" <?php if($rowexedt['state']== 'Kaduna'){ echo ' selected="selected"'; } ?>> Kaduna </option>
                                                                    <option value="Kano" <?php if($rowexedt['state']== 'Kano'){ echo ' selected="selected"'; } ?>> Kano </option>
                                                                    <option value="Katsina" <?php if($rowexedt['state']== 'Katsina'){ echo ' selected="selected"'; } ?> > Katsina </option>
                                                                    <option value="Kebbi" <?php if($rowexedt['state']== 'Kebbi'){ echo ' selected="selected"'; } ?> > Kebbi </option>
                                                                    <option value="Kogi" <?php if($rowexedt['state']== 'Kogi'){ echo ' selected="selected"'; } ?> > Kogi </option>
                                                                    <option value="Kwara" <?php if($rowexedt['state']== 'Kwara'){ echo ' selected="selected"'; } ?> > Kwara </option>
                                                                    <option value="Lagos" <?php if($rowexedt['state']== 'Lagos'){ echo ' selected="selected"'; } ?> > Lagos </option>
                                                                    <option value="Nasarawa" <?php if($rowedt['Nasarawa'] == 'Abia'){ echo ' selected="selected"'; } ?>> Nasarawa </option>
                                                                    <option value="Niger" <?php if($rowexedt['state']== 'Niger'){ echo ' selected="selected"'; } ?> > Niger </option>
                                                                    <option value="Ogun" <?php if($rowexedt['state']== 'Ogun'){ echo ' selected="selected"'; } ?>> Ogun </option>
                                                                    <option value="Ondo" <?php if($rowexedt['state']== 'Ondo'){ echo ' selected="selected"'; } ?>> Ondo </option>
                                                                    <option value="Osun" <?php if($rowexedt['state']== 'Osun'){ echo ' selected="selected"'; } ?>> Osun </option>
                                                                    <option value="Oyo" <?php if($rowexedt['state']== 'Oyo'){ echo ' selected="selected"'; } ?> > Oyo </option>
                                                                    <option value="Plateau" <?php if($rowexedt['state']== 'Plateau'){ echo ' selected="selected"'; } ?> > Plateau </option>
                                                                    <option value="Rivers" <?php if($rowexedt['state']== 'Rivers'){ echo ' selected="selected"'; } ?>> Rivers </option>
                                                                    <option value="Sokoto" <?php if($rowexedt['state']== 'Sokoto'){ echo ' selected="selected"'; } ?>> Sokoto </option>
                                                                    <option value="Taraba" <?php if($rowexedt['state']== 'Taraba'){ echo ' selected="selected"'; } ?>> Taraba </option>
                                                                    <option value="Yobe" <?php if($rowexedt['state']== 'Yobe'){ echo ' selected="selected"'; } ?>> Yobe </option>
                                                                    <option value="Zamfara" <?php if($rowexedt['state']== 'Zamfara'){ echo ' selected="selected"'; } ?>> Zamfara </option>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <input type="hidden" name="uid" value="<?php echo $rowexedt['id'];?>"  />
                                    <input type="submit" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
    <!--EDIT EXECUTOR MODAL ENDS HERE-->
<?php } while ($rowexedt = mysqli_fetch_assoc($resultexedt));?>
    
        <!--ADD CORPORATE EXECUTORS MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="addcorporateexecutor" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Appoint Corporate Executor<br><span style="font-size:13px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:13px;">All fields with asterisk are compulsory</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-addcorporateexecutor.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Company's Name<span style="color:red;">*</span></label>
                                            <input type="text" name="cname" class="form-control maxlength-simple" id="exampleInput" required value="<?php echo $_SESSION['cname'];?>">
                                            </fieldset>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                    <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInputEmail1">Address<span style="color:red;">*</span></label>
                                            <textarea rows="2" name="caddr" class="form-control maxlength-simple" required><?php echo $_SESSION['caddr'];?></textarea>
                                            </fieldset>
                                    </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Email</label>
                                            <input type="email" name="cemail" class="form-control maxlength-simple" id="exampleInput" requ/ired value="<?php echo $_SESSION['cemail'];?>">
                                            </fieldset>
                                        </div>
                                                                                <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Phone Number<span style="color:red;">*</span></label>
                                                <input type="text" name="cphoneno" class="form-control maxlength-simple" id="exampleInput" required value="<?php echo $_SESSION['cphoneno'];?>">
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
    <!--ADD CORPORATE EXECUTOR MODAL ENDS HERE-->

<?php do { ?>
    <!--EDIT CORPORATE EXECUTORS MODAL STARTS HERE -->
    <!-- Modal -->
<div class="modal fade" id="editcorporateexecutor<?php echo $rowedtcor['id'];?>" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Corporate Executor's details for <?php echo $rowedtcor['fullname'];?><br><span style="font-size:13px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:13px;">All fields with asterisk are compulsory</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-editcorporateexecutor.php">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Company's Name<span style="color:red;">*</span></label>
                                            <input type="text" name="gname" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $rowedtcor['fullname'];?>" required>
                                            </fieldset>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInputEmail1">Address<span style="color:red;">*</span></label>
                                            <textarea rows="2" name="gaddr" class="form-control maxlength-simple" required><?php echo $rowedtcor['addr'];?></textarea>
                                            </fieldset>
                                        </div>
                                    </div>
                                        

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                            <label class="form-label" for="exampleInput">Email</label>
                                            <input type="email" name="gemail" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $rowedtcor['email'];?>" req/uired>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInput">Phone Number<span style="color:red;">*</span></label>
                                                <input type="text" name="gphoneno" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $rowedtcor['phone'];?>" required>
                                            </fieldset>
                                        </div>


                                    </div>

                                    <input type="hidden" name="uid" value="<?php echo $rowedtcor['id'];?>"  />
                                    <input type="submit" value="Add" class="btn btn-inline btn-fcmb" style="float:right;">
                                </form>
      </div>
    </div>
  </div>
</div>
    <!--EDIT EXECUTOR MODAL ENDS HERE-->
<?php } while ($rowedtcor = mysqli_fetch_assoc($resultedtcor));?>


        <!--ADD FCMB TRUSTEES CORPORATE EXECUTOR MODAL ENDS HERE -->
    <!-- Modal -->
<div class="modal fade" id="addfcmbcorporateexecutor" tabindex="-1" role="dialog" aria-labelledby="addbeneficiaryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Corporate Executor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" action="processor/process-addfcmbcorporateexecutor.php" method="POST">
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
    <script src="js/lib/bootstrap-sweetalert/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
                  
                  $(document).on('click', '#delete_executor', function(e){
                   
                   var productId = $(this).data('id');
                   SwalDelete(productId);
                   e.preventDefault();
                  });
                  
                 });

            $('.swal-btn-cancel').click(function(e){
                e.preventDefault();
                swal({
                            title: "Are you sure?",
                            //text: "You will not be able to recover this imaginary file!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "Yes, delete it!",
                            cancelButtonText: "No",
                            closeOnConfirm: false,
                            closeOnCancel: false
                            
                               preConfirm: function() {
                                 return new Promise(function(resolve) {
                                 $.ajax({
                                       url: '../process-deleteexecutor.php',
                                       type: 'POST',           
                                       data: 'delete='+productId,
                                       dataType: 'json'
                                    })
                                    //.done(function(response){
                                       //swal('Deleted!', response.message, response.status);
                                       //readProducts();
                                    //})
                                    //.fail(function(){
                                       //swal('Oops...', 'Something went wrong with ajax !', 'error');
                                    //});
                                    
                            function(isConfirm) {
                            if (isConfirm) {
                                swal({
                                    title: "Deleted!",
                                    //text: "Your imaginary file has been deleted.",
                                    type: "success",
                                    confirmButtonClass: "btn-success"
                                });
                            } else {
                                swal({
                                    title: "Cancelled",
                                    //text: "Your imaginary file is safe :)",
                                    type: "error",
                                    confirmButtonClass: "btn-danger"
                                });
                            }
                        });
                                    
                                    
                                 });
                               },
                            
                        },
            });



        });
    </script>
<script src="js/app.js"></script>
</body>
</html>