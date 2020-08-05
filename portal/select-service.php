<?php require ('Connections/conn.php');
include ('session.php');
//$gender = $_SESSION['gender'];
if(!isset($userid)){
header('location:index.php');
exit();
}
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

<link rel="stylesheet" href="css/lib/lobipanel/lobipanel.min.css">
<link rel="stylesheet" href="css/separate/vendor/lobipanel.min.css">
<link rel="stylesheet" href="css/lib/jqueryui/jquery-ui.min.css">
<link rel="stylesheet" href="css/separate/pages/widgets.min.css">

    <link rel="stylesheet" href="css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-50894378-7"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-50894378-7');
</script>

</head>

<body class="horizontal-navigation">

<?php include ('inc/inc_header.php') ;?>

	<div class="page-content">
	    <div class="container-fluid">
	        <div class="row">
	            <div class="col-xl-12">
	                <div class="chart-statistic-box">
	                    <div class="chart-txt">
	                        <div class="chart-txt-top">
	                            <p><span class="number">Welcome <?php echo $fname.' '.$lname; ?> </span></p>
	                            <p>Please select an option </p>
	                        </div>
	                    </div>
	                </div><!--.chart-statistic-box-->
	            </div><!--.col-->
	        </div><!--.row-->
	
	        <div class="row justify-content-center"">
	            <div class="col-xl-4 dahsboard-column">
	           <section class="widget">
                        <div class="tab-content widget-tabs-content">
                            <div class="tab-pane active" id="w-2-tab-1" role="tabpanel">
                                <div align="center">
                                     <a href="select-will.php"><img src="img/icon-will.png" />
                                     <h3 style="margin-top:20px; font-size:20px; color:#5C068C;">WRITE WILL</h3></a>
                                </div>
                            </div>
                        </div>
                    </section>
	            </div><!--.col-->
	            <div class="col-xl-4 dahsboard-column">
	           <section class="widget">
                        <div class="tab-content widget-tabs-content">
                            <div class="tab-pane active" id="w-2-tab-1" role="tabpanel">
                                <div align="center">
                                     <a href="create-trust.php"><img src="img/icon-trust.png" />
                                     <h3 style="margin-top:20px; font-size:20px; color:#5C068C;">CREATE TRUST</h3></a>
                                </div>
                            </div>
                        </div>
                    </section>
	            </div><!--.col-->
	        </div>
	    </div><!--.container-fluid-->
	</div><!--.page-content-->

	<script src="js/lib/jquery/jquery-3.2.1.min.js"></script>
	<script src="js/lib/popper/popper.min.js"></script>
	<script src="js/lib/tether/tether.min.js"></script>
	<script src="js/lib/bootstrap/bootstrap.min.js"></script>
	<script src="js/plugins.js"></script>

	<script type="text/javascript" src="js/lib/jqueryui/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/lib/lobipanel/lobipanel.min.js"></script>
	<script type="text/javascript" src="js/lib/match-height/jquery.matchHeight.min.js"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script>
		$(document).ready(function(){
			try {
				$('.panel').lobiPanel({
					sortable: true
				}).on('dragged.lobiPanel', function(ev, lobiPanel){
					$('.dahsboard-column').matchHeight();
				});
			} catch (err) {}

			google.charts.load('current', {'packages':['corechart']});
			google.charts.setOnLoadCallback(drawChart);
			function drawChart() {
				var dataTable = new google.visualization.DataTable();
				dataTable.addColumn('string', 'Day');
				dataTable.addColumn('number', 'Values');
				// A column for custom tooltip content
				dataTable.addColumn({type: 'string', role: 'tooltip', 'p': {'html': true}});
				dataTable.addRows([
					['MON',  130, ' '],
					['TUE',  130, '130'],
					['WED',  180, '180'],
					['THU',  175, '175'],
					['FRI',  200, '200'],
					['SAT',  170, '170'],
					['SUN',  250, '250'],
					['MON',  220, '220'],
					['TUE',  220, ' ']
				]);

				var options = {
					height: 314,
					legend: 'none',
					areaOpacity: 0.18,
					axisTitlesPosition: 'out',
					hAxis: {
						title: '',
						textStyle: {
							color: '#fff',
							fontName: 'Proxima Nova',
							fontSize: 11,
							bold: true,
							italic: false
						},
						textPosition: 'out'
					},
					vAxis: {
						minValue: 0,
						textPosition: 'out',
						textStyle: {
							color: '#fff',
							fontName: 'Proxima Nova',
							fontSize: 11,
							bold: true,
							italic: false
						},
						baselineColor: '#16b4fc',
						ticks: [0,25,50,75,100,125,150,175,200,225,250,275,300,325,350],
						gridlines: {
							color: '#1ba0fc',
							count: 15
						},
					},
					lineWidth: 2,
					colors: ['#fff'],
					curveType: 'function',
					pointSize: 5,
					pointShapeType: 'circle',
					pointFillColor: '#f00',
					backgroundColor: {
						fill: '#008ffb',
						strokeWidth: 0,
					},
					chartArea:{
						left:0,
						top:0,
						width:'100%',
						height:'100%'
					},
					fontSize: 11,
					fontName: 'Proxima Nova',
					tooltip: {
						trigger: 'selection',
						isHtml: true
					}
				};

				var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
				chart.draw(dataTable, options);
			}
			$(window).resize(function(){
				drawChart();
				setTimeout(function(){
				}, 1000);
			});
		});
	</script>

	<script src="js/lib/asPieProgress/jquery-asPieProgress.min.js"></script>
	<script src="js/lib/select2/select2.full.min.js"></script>
	<script type="text/javascript" src="js/lib/match-height/jquery.matchHeight.min.js"></script>
	<script src="js/lib/slick-carousel/slick.min.js"></script>
	<script>
		$(function() {
			$(".circle-progress-bar").asPieProgress({
				namespace: 'asPieProgress',
				speed: 500
			});

			$(".circle-progress-bar").asPieProgress("start");


			$(".circle-progress-bar-typical").asPieProgress({
				namespace: 'asPieProgress',
				speed: 25
			});

			$(".circle-progress-bar-typical").asPieProgress("start");

			$('.widget-chart-combo-content-in, .widget-chart-combo-side').matchHeight();

			/* ==========================================================================
			 Widget weather slider
			 ========================================================================== */

			$('.widget-weather-slider').slick({
				arrows: false,
				dots: true,
				infinite: false,
				slidesToShow: 4,
				slidesToScroll: 4
			});
		});
	</script>
	

<script src="js/app.js"></script>
</body>
</html>