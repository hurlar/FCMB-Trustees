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

$_SESSION['oldfname'] = $fname;
$_SESSION['oldmname'] =  $mname;
$_SESSION['oldlname'] =  $lname;
$_SESSION['oldmsg'] =  $msg;
$_SESSION['oldphone'] =  $phone;
$_SESSION['oldaphone'] =  $aphone;
$_SESSION['oldgender'] =  $gender;
$_SESSION['olddob'] =  $dob;
$_SESSION['oldstate'] =  $state;
$_SESSION['oldnationality'] =  $nationality;
$_SESSION['oldlga'] =  $lga;

$queryusr = "SELECT * FROM users WHERE id = '$userid' ";
$usr = mysqli_query($conn, $queryusr) or die(mysqli_error($conn));
$row_usr = mysqli_fetch_assoc($usr);
$email = $row_usr['email'];

$_SESSION['oldemail'] = $email;

$querysp = "SELECT `fullname`, `phoneno`, `addr` FROM spouse_tb WHERE uid = '$userid' ";
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

$queryexe = "SELECT * FROM executor_tb WHERE uid = '$userid' "; 
$exe = mysqli_query($conn, $queryexe) or die(mysqli_error($conn));
$row_exe = mysqli_fetch_assoc($exe);
$totalexe = mysqli_num_rows($exe);

$querytrt = "SELECT * FROM trustee_tb WHERE uid = '$userid' "; 
$trt = mysqli_query($conn, $querytrt) or die(mysqli_error($conn));
$row_trt = mysqli_fetch_assoc($trt);
$totaltrt = mysqli_num_rows($trt);

$queryemp = "SELECT * FROM employment_tb WHERE uid = '$userid' "; 
$emp = mysqli_query($conn, $queryemp) or die(mysqli_error($conn));
$row_emp = mysqli_fetch_assoc($emp);
$totalemp = mysqli_num_rows($emp);

$querydcm = "SELECT `marriageyear`, `marriagetype`, `marriagecert`, `uid` FROM spouse_tb WHERE uid = '$userid' "; 
$dcm = mysqli_query($conn, $querydcm) or die(mysqli_error($conn));
$row_dcm = mysqli_fetch_assoc($dcm);
$totaldcm = mysqli_num_rows($dcm);

$querydv = "SELECT `divorce`, `divorceyear`, `uid` FROM divorce_tb WHERE uid = '$userid' "; 
$dv = mysqli_query($conn, $querydv) or die(mysqli_error($conn));
$row_dv = mysqli_fetch_assoc($dv);
$totaldv = mysqli_num_rows($dv);

$querydv = "SELECT `divorce`, `divorceyear`, `uid` FROM divorce_tb WHERE uid = '$userid' "; 
$dv = mysqli_query($conn, $querydv) or die(mysqli_error($conn));
$row_dv = mysqli_fetch_assoc($dv);
$totaldv = mysqli_num_rows($dv);

$querydoa = "SELECT * FROM property_tb WHERE uid = '$userid' "; 
$doa = mysqli_query($conn, $querydoa) or die(mysqli_error($conn));
$row_doa = mysqli_fetch_assoc($doa);
$totaldoa = mysqli_num_rows($doa);

$querydoa1 = "SELECT * FROM shares_tb WHERE uid = '$userid' "; 
$doa1 = mysqli_query($conn, $querydoa1) or die(mysqli_error($conn));
$row_doa1 = mysqli_fetch_assoc($doa1);
$totaldoa1 = mysqli_num_rows($doa1);

$queryms = "SELECT * FROM investment_form WHERE uid = '$userid' "; 
$ms = mysqli_query($conn, $queryms) or die(mysqli_error($conn));
$row_ms = mysqli_fetch_assoc($ms);
$totalms = mysqli_num_rows($ms);

$ref = rand(1000,1000000) ;
$_SESSION['transactionid'] = $ref;
$amount = '110000';

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
            <div class="row">
                <div class="col-lg-3 col-lg-pull-6 col-md-6 col-sm-6">
                    <?php include ('inc/inc_avatar.php');?>
                    
                                        <section class="box-typical" style="height:250px;">
                        <div class="profile-card" style="padding-top:50px;">
                            <div class="profile-card-name"> #110, 000</div> <br/>
                            <form >
                                <script src="https://js.paystack.co/v1/inline.js"></script>
                                <!--<button type="button" onclick="payWithPaystack()" class="btn btn-lg btn-base"  style="background-color:#0066B3;"> btn btn-inline btn-fcmb <span style="color:#fff;">Make Payment</span> </button>--> 
                                <button type="button" onclick="payWithPaystack()" class="btn btn-inline btn-fcmb" > Make Payment </button>
                            </form> 
                    </section><!--.box-typical-->

                </div><!--.col- -->

                <div class="col-lg-9 col-lg-push-3 col-md-12">
                <h3 class="with-border">Investment Management Trust Form </h3>


                <section class="card">
                <div class="card-block">
                                    <div class="alert alert-success" role="alert">
                    <p>
                        Thank you for completing your form. <br> You can now proceed to make payment
                    </p>
                </div>
                    <h5 class="with-border">Personal Information </h5>
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5>Full Name</h5>
                                <p><?php echo ucfirst($fname).' '.ucfirst($mname).' '.ucfirst($lname);?></p>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5>Gender</h5>
                                <p><?php echo $gender;?></p>
                            </fieldset>
                        </div>
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5>Marital Status</h5>
                                <p><?php echo $row_ms['maritalstatus'] ;?></p>
                            </fieldset>
                        </div>

                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5>Date of Birth</h5>
                                <p><?php echo $dob ;?></p>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5>Address</h5>
                                <p><?php echo $msg;?></p>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5>Email Address</h5>
                                <p><?php echo $email ;?></p>                            
                            </fieldset>
                        </div>
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5>Phone Number</h5>
                                <p><?php echo $phone ;?></p>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5>State of Origin</h5>
                                <p><?php echo $state;?></p>
                            </fieldset>
                        </div>
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5>LGA</h5>
                                <p><?php echo $lga;?></p>
                            </fieldset>
                        </div>
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5>Nationality</h5>
                                <p><?php echo $nationality;?></p>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </section>

            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Next of Kin </h5>
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5>Name</h5>
                                <p><?php echo $row_ms['kin'];?></p>
                            </fieldset>
                        </div>

                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5>Address</h5>
                                <p><?php echo $row_ms['kinaddr'];?></p>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </section>

            <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Family Information  </h5>
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5>Spouse Name</h5>
                                <p><?php echo $row_sp['fullname'];?></p>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <h5>Address</h5>
                                <p><?php echo $row_sp['addr'];?></p>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5>Phone Number</h5>
                                <p><?php echo $row_sp['phoneno'];?></p>
                            </fieldset>
                        </div>

                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <h5>Date of Birth</h5>
                                <p><?php echo $row_sp['dob'];?></p>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </section>

<?php if ($totalcd != NULL) { ?> 
                        <section class="card">
                <div class="card-block">
                    <h5 class="with-border">Beneficiaries </h5>
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
                    </div>

                </div>
            </section>
<?php } ?>

<section class="card">
                <div class="card-block">
                    <h5 class="with-border">Means of Identification</h5>
                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5>Identification Type</h5>
                                <p><?php echo $row_ms['idtype'];?></p>
                            </fieldset>
                        </div>

                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5>Date Issued</h5>
                                <p><?php echo $row_ms['dateissued'];?></p>
                            </fieldset>
                        </div>

                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <h5>Expiration Date</h5>
                                <p><?php echo $row_ms['expirydate'];?></p>
                            </fieldset>
                        </div>
                    </div>

                </div>
            </section>

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