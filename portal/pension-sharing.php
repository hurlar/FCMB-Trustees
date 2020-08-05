<?php require ('Connections/conn.php');
include ('session.php');

$query = "SELECT * FROM pension_tb WHERE `uid` = '$userid' ";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
$totalrow = mysqli_num_rows($result);

//$query = "SELECT * FROM state_tb";
//$st2 = mysqli_query($conn, $query) or die(mysqli_error($conn));
//$row_st2 = mysqli_fetch_assoc($st2);

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
    .married{ background: #228B22; }

        .boxx{
        color: #fff;
        padding: 20px;
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

				</div><!--.col- -->

				<div class="col-lg-9 col-lg-push-3 col-md-12">
							<section class="card">
				<div class="card-block">
					<h5 class="with-bo/rder">Pension & Employment Benefits Percentage Sharing</h5> 


					<div class="row">
					
				<div class="col-md-12 col-sm-12">


				<form action="processor/process-pension-sharing.php" method="post">
					

					<div class="row">
						<div class="col-lg-4">
							<button type="button"
								class="btn btn-inline btn-fcmb"
											data-toggle="modal"
											data-target="#add_spouse_Modal">
											Add
										</button>
						</div>
					</div>
						<!--</div>-->

					<input type="hidden" name="uid" value="<?php echo $userid ;?>" />
					<input type="submit" value="Save And Proceed" class="btn btn-inline btn-fcmb" style="float:right;">
				</form>
							<?php if ($totalrow != NULL) { ?>
                                <div id="spouse_table" class="col-md-8">
                                    <table class="table table-bordered">
                                        <thead>
                                          <tr>
                                            <th>Full names of beneficiary(ies)</th>
                                            <th>Address of Beneficiary</th>
                                            <th>Percentage</th>
					    <th>Comments</th>
                                          </tr>
                                        </thead>
                                        <tbody>    
                                        <?php while($row = mysqli_fetch_array($result)){ ?>
                                            <tr>
                                                <td><?php echo $row["benname"]; ?></td>
                                                <td><?php echo $row["benaddr"]; ?></td>
                                                <td><?php echo $row["percent"]; ?></td>
                                                <td><?php echo $row["comment"]; ?></td>
                                            </tr>
                                        <?php  } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } ?>

				

				<div class="modal fade"
					 id="add_spouse_Modal"
					 tabindex="-1"
					 role="dialog"
					 aria-labelledby="myModalLabel"
					 aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header" style="background-color:#5C3092;">
								<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
									<i class="font-icon-close-2"></i>
								</button>
								<h4 class="modal-title" id="myModalLabel"> <span style="color:#fff;">Pension & Employment Benefits Percentage Sharing</span></h4>
							</div>
							<div class="modal-body">
								<form method="post" id="spouse_form">
									<div class="row">
										<div class="col-lg-12">
											<fieldset class="form-group">
											<label class="form-label" for="exampleInput">Full names of beneficiary(ies) and Relationship</label>
											<input type="text" name="beneficiaries" class="form-control maxlength-simple" id="exampleInput" required>
											</fieldset>
										</div>
									</div>



									<div class="row">
										<div class="col-lg-12">
											<fieldset class="form-group">
											<label class="form-label" for="exampleInput">Address Of Beneficiaries</label>
											<input type="text" name="abeneficiaries" class="form-control maxlength-simple" id="exampleInput" required>
											</fieldset>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-12">
											<fieldset class="form-group">
											<label class="form-label" for="exampleInput">Percentage</label>
											<input type="text" name="percent" class="form-control maxlength-simple" id="exampleInput" required>
											</fieldset>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-12">
											<fieldset class="form-group">
											<label class="form-label" for="exampleInput">Comments (If Any)</label>
											<input type="text" name="comments" class="form-control maxlength-simple" id="exampleInput" required>
											</fieldset>
										</div>
									</div>

									<input type="hidden" name="uid" value="<?php echo $userid; ?>"  />
									<input type="submit" name="insert" id="spouseinsert" value="Save" class="btn btn-inline btn-fcmb" style="float:right;">
								</form>

							</div>
						</div>
					</div>
				</div><!--.modal-->



				<!--EMPTY MODAL FOR SPOUSE DETAILS STARTS-->
				<div class="modal fade"
					 id="dataModal"
					 tabindex="-1"
					 role="dialog"
					 aria-labelledby="myModalLabel"
					 aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header" style="background-color:#5C3092;">
								<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
									<i class="font-icon-close-2"></i>
								</button>
								<h4 class="modal-title"> <span style="color:#fff;">Spouse Details</span></h4>
							</div>
							<div class="modal-body" id="employee_detail">
								

							</div>
							<!--<div class="modal-footer">
								<button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Close</button>
								<button type="button" class="btn btn-rounded btn-primary">Save changes</button>
							</div>-->
						</div>
					</div>
				</div><!--.modal-->
				<!--EMPTY MODAL FOR SPOUSE DETAILS ENDS-->

				
				</div>
				</div>
				</div>
			</section>
				</div><!--.col- -->



			</div><!--.row-->
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

	<!-- SPOUSE JS STARTS -->
	<script>  
$(document).ready(function(){
 $('#spouse_form').on("submit", function(event){  
  event.preventDefault();  
  if($('#stitle').val() == "")  
  {  
   alert("Title is required");  
  }   
  else if($('#sfname').val() == '')
  {  
   alert("Fullname is required");  
  }
  else if($('#semail').val() == '')
  {  
   alert("Email is required");  
  }
    else if($('#sphoneno').val() == '')
  {  
   alert("Phone Number is required");  
  }
    else if($('#saddr').val() == '')
  {  
   alert("Address is required");  
  }
    else if($('#scity').val() == '')
  {  
   alert("City is required");  
  }
    else if($('#sstate').val() == '')
  {  
   alert("State is required");  
  }
  else  
  {  
   $.ajax({  
    url:"pension_insert.php",  
    method:"POST",  
    data:$('#spouse_form').serialize(),  
    beforeSend:function(){  
     $('#spouseinsert').val("Inserting");  
    },  
    success:function(data){  
     $('#spouse_form')[0].reset();  
     $('#add_spouse_Modal').modal('hide');  
     $('#spouse_tb').html(data);  
    }  
   });  
  }  
 });




$(document).on('click', '.view_data', function(){
  //$('#dataModal').modal();
  var spouse_uid = $(this).attr("uid");
  $.ajax({
   url:"spouse_select.php",
   method:"POST",
   data:{spouse_uid:spouse_uid},
   success:function(data){
    $('#spouse_detail').html(data);
    $('#dataModal').modal('show');
   }
  });
 });
});  
 </script>
<!-- SPOUSE JS ENDS -->

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