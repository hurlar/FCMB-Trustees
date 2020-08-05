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

$querywilltype = "SELECT `uid`,`name`,`amount` FROM willtype WHERE uid = '$userid' "; 
$willtype = mysqli_query($conn, $querywilltype) or die(mysqli_error($conn));
$row_willtype = mysqli_fetch_assoc($willtype);
$totalwilltype = mysqli_num_rows($willtype);
$willamount = $row_willtype['amount'];

$paystackcharge = '625';
$amount = $willamount +  $paystackcharge;
$ref = rand(1000,1000000) ;
$_SESSION['transactionid'] = $ref;
$_SESSION['willtype'] = $row_willtype['name'];

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
                    
    <?php //if ($row_willtype['name'] == 'Premium Will'){?> 
                    <section class="box-typical sidemenu">
                        <div class="profile-card">
                        <div class="profile-card-name"> Go to Dashboard</div> <br/>

                                <a href="dashboard.php"><button type="button" class="btn btn-inline btn-fcmb" > Go Back </button></a>
                                </div>

                    </section><!--.box-typical-->

    <?php //} ?>

                </div><!--.col- -->
    <?php if ($row_willtype['name'] == 'Premium Will'){?>  
                <div class="col-lg-9 col-lg-push-3 col-md-12">

            <section class="card" style="height:410px;">
                <div class="card-block">
                
                    <h5 style="color:#000000; text-align:center;">Thank you for completing your form.<br/> You can now proceed to make payment </h5>
                </div>
         
                <section class="tabs-section">
				<div class="tabs-section-nav tabs-section-nav-icons">
					<div class="tbl">
						<ul class="nav" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" href="#tabs-1-tab-1" role="tab" data-toggle="tab">
									<span class="nav-link-in">
										Pay via Paystack
									</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#tabs-1-tab-2" role="tab" data-toggle="tab">
									<span class="nav-link-in">
										Pay via FCMB Internet Banking
									</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#tabs-1-tab-3" role="tab" data-toggle="tab">
									<span class="nav-link-in">
										Pay via Bank Deposit
									</span>
								</a>
							</li>
						</ul>
					</div>
				</div><!--.tabs-section-nav-->

				<div class="tab-content">
					<div role="tabpanel" class="tab-pane fade in active show" id="tabs-1-tab-1">
					    
					    <p>Please note that a standard transfer charge of ₦ 625.00 will apply if you choose to make your payment via Paystack.
					    </p>
					   <p>Cost of Will & VAT <span style="float:right;">₦26,875.00</span> </p>
					   <p>Probate & Processing Fee <span style="float:right;">₦15,000.00</span></p>
					    <p>Paystack (standard transfer charge) <span style="float:right;">₦625.00</span></p>
					    <hr>
					    
					    <p>Total <span style="float:right;">₦42,500.00</span> </p>

					    <p style="margin-top:50px;">
                			<form >
                                <script src="https://js.paystack.co/v1/inline.js"></script>
                                <button type="button" onclick="payWithPaystack()" class="btn btn-inline btn-fcmb" > Make Payment </button>
                            </form>
                        </p>
                                  
            		</div>
				
					
					<div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-2" >
					    <p>Cost of Will & VAT <span style="float:right;">₦26,875.00</span> </p>
					   <p>Probate & Processing Fee <span style="float:right;">₦15,000.00</span></p>
					    <hr>
					    
					    <p>Total <span style="float:right;">₦41,875.00</span> </p>
					    
					    <p>Please make payment transfer into the account details below via FCMB Internet Banking: <br>
                        Account Name: FCMB Trustees Limited CALL<br>
                        Account Number: 0678691020<br>
                        Bank Name: FCMB</p>
                        <p style="margin-top:50px;"><a href="https://www.fcmb.com" target="_blank"><button type="button" class="btn btn-inline btn-fcmb"> Make Payment </button></a></p>
                    </div><!--.tab-pane-->


					<div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-3">
					    <p>Cost of Will & VAT <span style="float:right;">₦26,875.00</span> </p>
					   <p>Probate & Processing Fee <span style="float:right;">₦15,000.00</span></p>
					    <hr>
					    
					    <p>Total <span style="float:right;">₦41,875.00</span> </p>
					    <p>Please make payment into the account details below via Bank deposit: <br>
                            Account Name:  FCMB Trustees Limited CALL <br>
                            Account Number: 0678691020 <br>
                            Bank Name: FCMB</p></div><!--.tab-pane-->


				</div><!--.tab-content-->
				
			</section><!--.tabs-section-->
			
			
            </section>

                </div><!--.col- -->
     <?php } ?>           
     
     <?php if ($row_willtype['name'] == 'Comprehensive Will'){?>  
                <div class="col-lg-9 col-lg-push-3 col-md-12">

            <section class="card" style="height:330px;">
                <div class="card-block pro/file-card">
                
                    <h3 style="color:#000000; mar/gin-top:80px;">Thank you for completing and submitting your form.</h3>
                    <h5 style="color:#000000; mar/gin-top:80px;">A representative will contact you, shortly, to discuss the creation of your <?php echo $row_willtype['name']; ?>,<br> based on the information that you have provided. </h5>
                    <p>Please, feel free to login to your dashboard to view the progress of your form.</p>
                    <a href="dashboard.php"><button type="button" style="margin-top:50px;" class="btn btn-inline btn-fcmb" > Go back to your dashboard</button></a>
                </div>
			
            </section>

                </div><!--.col- -->
     <?php } ?>           
     
     
    <?php if ($row_willtype['name'] == 'Estate Planning Questionnaire Form'){?>  
                <div class="col-lg-9 col-lg-push-3 col-md-12">

            <section class="card" style="height:330px;">
                <div class="card-block pro/file-card">
                
                    <h3 style="color:#000000; mar/gin-top:80px;">Thank you for completing and submitting your form.</h3>
                    <h5 style="color:#000000; mar/gin-top:80px;">A representative will contact you, shortly, to discuss the creation of your <?php echo $row_willtype['name']; ?>, based on the information that you have provided. </h5>
                    <p>Please, feel free to login to your dashboard to view the progress of your form.</p>
                    <a href="dashboard.php"><button type="button" style="margin-top:50px;" class="btn btn-inline btn-fcmb" > Go back to your dashboard</button></a>
                </div>
			
            </section>

                </div><!--.col- -->
     <?php } ?> 
     
     
         <?php if ($row_willtype['name'] == 'Investment Management Trust Form'){?>  
                <div class="col-lg-9 col-lg-push-3 col-md-12">

            <section class="card" style="height:330px;">
                <div class="card-block pro/file-card">
                
                    <h3 style="color:#000000; mar/gin-top:80px;">Thank you for completing and submitting your form.</h3>
                    <h5 style="color:#000000; mar/gin-top:80px;">A representative will contact you, shortly, to discuss the creation of your <?php echo $row_willtype['name']; ?>, based on the information that you have provided. </h5>
                    <p>Please, feel free to login to your dashboard to view the progress of your form.</p>
                    <a href="dashboard.php"><button type="button" style="margin-top:50px;" class="btn btn-inline btn-fcmb" > Go back to your dashboard</button></a>
                </div>
			
            </section>

                </div><!--.col- -->
     <?php } ?> 
     
     
              <?php if ($row_willtype['name'] == 'Reserve Trust Form'){?>  
                <div class="col-lg-9 col-lg-push-3 col-md-12">

            <section class="card" style="height:330px;">
                <div class="card-block pro/file-card">
                
                    <h3 style="color:#000000; mar/gin-top:80px;">Thank you for completing and submitting your form.</h3>
                    <h5 style="color:#000000; mar/gin-top:80px;">A representative will contact you, shortly, to discuss the creation of your <?php echo $row_willtype['name']; ?>, based on the information that you have provided. </h5>
                    <p>Please, feel free to login to your dashboard to view the progress of your form.</p>
                    <a href="dashboard.php"><button type="button" style="margin-top:50px;" class="btn btn-inline btn-fcmb" > Go back to your dashboard</button></a>
                </div>
			
            </section>

                </div><!--.col- -->
     <?php } ?> 
     
     
                
            </div><!--.row-->
        </div><!--.container-fluid-->
    </div><!--.page-content-->
    
    
    
<!-- STARTS HERE-->
    <script
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>

<?php 
$value = $amount * 100 ;  
$_SESSION['value'] = $value/100 ; 
?>



<!------- Back Here ----------> 





 
<script>
  function payWithPaystack(){
    var handler = PaystackPop.setup({
       key: 'pk_test_ae9e2f997144b77c6a3e8d3cbc4c9f6256f34674',
       //key: 'pk_live_cb410844ca5a8c476f77d07a4156278d412e4f15',   Beutymatics live key
       //key: 'pk_test_ae9e2f997144b77c6a3e8d3cbc4c9f6256f34674'  Beutymatics test key
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
    xhr.setRequestHeader('Authorization', 'Bearer sk_test_10c580d65e4ba798cf73391959ab9cc1a6b68f78'); 
        //sk_test_10c580d65e4ba798cf73391959ab9cc1a6b68f78  Beutymatics test key
        //sk_live_5205c257e251f1a7867191c337dacc1bed42b6ae  Beutymatics live key
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