<?php require ('Connections/conn.php');
include ('session.php');
if(!isset($userid)){
header('location:index.php');
exit();
}

$querypi = "SELECT `id`,`uid`,`salutation` FROM personal_info WHERE uid = '$userid' ";
$pi = mysqli_query($conn, $querypi) or die(mysqli_error($conn));
$row_pi = mysqli_fetch_assoc($pi);
$salutation = $row_pi['salutation'];


$queryexec = "SELECT * FROM executor_power WHERE uid = '$userid' AND willtype = 'Comprehensive Will' "; 
$exec = mysqli_query($conn, $queryexec) or die(mysqli_error($conn));
$row_exec = mysqli_fetch_assoc($exec);
$execcount = mysqli_num_rows($exec);


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
<form action="processor/process-addexecutorpowercomprehensive.php" method="POST">            
            <div class="row">
                <div class="col-lg-3 col-lg-pull-6 col-md-6 col-sm-6">
                    <?php include ('inc/inc_avatar.php');?>

                    <section class="box-typical sidemenu">
                        <div class="profile-card">
                            <div class="profile-card-name">Delete, Edit  or Add duties for the Executors as applicable</div>

                    </section><!--.box-typical-->
                    
                    <section class="box-typical sidemenu">
                        <div class="profile-card">
                        <div class="profile-card-name"> Go to Dashboard</div> <br/>

                                <a href="dashboard.php"><button type="button" class="btn btn-inline btn-fcmb" > Go Back </button></a>
                                </div>

                    </section>

                </div><!--.col- -->

                <div class="col-lg-9 col-lg-push-3 col-md-12">

                <section class="card">
                <div class="card-block" >
                <p><span style="color:#5C068C; font-size:1.25rem; font-weight: 400;">EXECUTORS' POWERS & GENERAL PROVISIONS</span><br>
                <span style="font-size:15px;">N.B:</span> <span style="color:red;">*</span> <span style="font-size:15px;"> Delete, Edit  or Add duties for the Executors as applicable by pasting each point in the box below them, otherwise leave blank to indicate delete</span> <br><br>
                    1.  Following my death, I direct my Executors/Trustees to convene a meeting with my <?php if($salutation == 'Mrs'){echo 'husband';}elseif($salutation == 'Mr'){echo 'Wife';}elseif($salutation == 'Ms'){echo 'husband';} ?> and children and where necessary, take inventory of all chattels, personal properties and documents or items at my residence.<br>
                        <textarea rows="5" name="question1" class="form-control maxlength-simple" ><?php echo $row_exec['question1'];?></textarea>
                        <br>
                    2.  is of sound mind at the time of execution of this my Will.<br>
<textarea rows="5" name="question2" class="form-control maxlength-simple" requ/ired><?php echo $row_exec['question2'];?></textarea>
                    <br>
                    3.  I direct my Executors/Trustees to ensure proper custody of all my personal properties, documents or items at my residence.<br>
<textarea rows="5" name="question3" class="form-control maxlength-simple" requ/ired><?php echo $row_exec['question3'];?></textarea>
                    <br>
                    4.  In the event that my <?php if($salutation == 'Mrs'){echo 'husband';}elseif($salutation == 'Mr'){echo 'Wife';}elseif($salutation == 'Ms'){echo 'husband';} ?> predeceases me, I direct my Executors/Trustees tohold and manage all my assets and lease out my real estate property until attainment of the age of ___________________ (_________________) years by my second child (or surviving child). <br>
<textarea rows="5" name="question4" class="form-control maxlength-simple" requ/ired><?php echo $row_exec['question4'];?></textarea>
                    <br>
                    5.  I direct my Executors/Trustees to open an Estate account in my name called: <strong>ESTATE OF ___________________  (the "Estate Account")</strong> where all rental income, bank balances and dividend payments shall be transferred and deposited.<br>
<textarea rows="5" name="question5" class="form-control maxlength-simple" requ/ired><?php echo $row_exec['question5'];?></textarea>
                    <br>
                    6.  In the event that my <?php if($salutation == 'Mrs'){echo 'husband';}elseif($salutation == 'Mr'){echo 'Wife';}elseif($salutation == 'Ms'){echo 'husband';} ?> predeceases me and upon attainment of the age of _____________ years by my second child(or surviving child), My Executors/Trustees shall distribute in equal proportions, the annual rental income on my real estate property amongst my children.<br>
                        <textarea rows="5" name="question6" class="form-control maxlength-simple" requ/ired><?php echo $row_exec['question6'];?></textarea>
                    <br>
                    7.  In the event that my <?php if($salutation == 'Mrs'){echo 'husband';}elseif($salutation == 'Mr'){echo 'Wife';}elseif($salutation == 'Ms'){echo 'husband';} ?> predeceases me, I direct my Executor__________ to _________________ my cars at most competitive market prices and transfer the proceeds from this sale to the Estate Account.<br>
<textarea rows="5" name="question7" class="form-control maxlength-simple" requ/ired><?php echo $row_exec['question7'];?></textarea>
                    <br>
                    8.  In the event that my <?php if($salutation == 'Mrs'){echo 'husband';}elseif($salutation == 'Mr'){echo 'Wife';}elseif($salutation == 'Ms'){echo 'husband';} ?> predeceases me, the Estate shall cater for the medical and general living expenses of my children until my second child (or surviving child) attains the age of ________________ years old.<br>
                         <textarea rows="5" name="question8" class="form-control maxlength-simple" requ/ired><?php echo $row_exec['question8'];?></textarea>                   
                    <br>
                    9.  In the event that my <?php if($salutation == 'Mrs'){echo 'husband';}elseif($salutation == 'Mr'){echo 'Wife';}elseif($salutation == 'Ms'){echo 'husband';} ?> predeceases me, my Executor/Trustees shall/ shall not sell any of our assets (except it becomes expedient to do so in a particular circumstance such as during an economic meltdown or prior to attainment of the age of ______________) years by my second child (or surviving child). My beneficiaries may thereafter unanimously agree on the sale of some assets to increase liquidity as they may deem necessary.<br>
                         <textarea rows="5" name="question9" class="form-control maxlength-simple" requ/ired><?php echo $row_exec['question9'];?></textarea>                   
                    <br>
                    10. In the event that my <?php if($salutation == 'Mrs'){echo 'husband';}elseif($salutation == 'Mr'){echo 'Wife';}elseif($salutation == 'Ms'){echo 'husband';} ?> predeceases me, I direct my Executors/Trustees to distribute 25% of the annual accrued profit to my Estate equally amongst my children provided my second child(or surviving child) has attained the age of ______. Such distribution shall be carried out after the annual audit exercise on the Estate affairs by the Auditor.<br>
                        <textarea rows="5" name="question10" class="form-control maxlength-simple" requ/ired><?php echo $row_exec['question10'];?></textarea>  
                    <br>
                    11. I direct that whosoever shall object to and or contest my directions and instructions under this my Will shall automatically cease to be a beneficiary and forfeit his/her benefits under this my Will directly or indirectly. Such forfeited benefits shall return to my residuary estate while the cost of engaging an Attorney shall be borne by that beneficiary).<br>
                        <textarea rows="5" name="question11" class="form-control maxlength-simple" requ/ired><?php echo $row_exec['question11'];?></textarea>      
                    <br>
                    <span style="color:#5C068C; font-size:1.25rem; font-weight: 400;">B.  <u>SUBSTITUTION BEQUEST</u></span><br>
                    In the event that my <?php if($salutation == 'Mrs'){echo 'husband';}elseif($salutation == 'Mr'){echo 'Wife';}elseif($salutation == 'Ms'){echo 'husband';} ?> predeceases me and my children also become deceased before receiving their benefits in this Will, such benefits shall be distributed among their offspring per stirpes and if there are no offsprings, such benefits shall stream back into the residuary estate.<br>
<textarea rows="5" name="question12" class="form-control maxlength-simple" requ/ired><?php echo $row_exec['question12'];?></textarea>
                    <br>
                    <span style="color:#5C068C; font-size:1.25rem; font-weight: 400;">C. <u>RESIDUAL BEQUEST </u></span><br><br>
                    i.  <strong>I DIRECT subject to Sections 7 of this Will</strong> that whatsoever assets are owned by me which is not hereby specifically disposed of or devised of in my Will shall pass into the residue of my Estate and be transferred to the Estate Account to be held and managed by my Executors/Trustees for the benefit of my <?php if($salutation == 'Mrs'){echo 'husband';}elseif($salutation == 'Mr'){echo 'Wife';}elseif($salutation == 'Ms'){echo 'husband';} ?> and children. <br>
                         <textarea rows="5" name="question13" class="form-control maxlength-simple" requ/ired><?php echo $row_exec['question13'];?></textarea>                   
                    <br>
                    ii. In the event that all my <?php if($salutation == 'Mrs'){echo 'husband';}elseif($salutation == 'Mr'){echo 'Wife';}elseif($salutation == 'Ms'){echo 'husband';} ?> and children are unable to receive the benefits of  this my Will due to their demise, I DIRECT that my Executors/Trustees transfer my assets to _____________________________________ <br>
                         <textarea rows="5" name="question14" class="form-control maxlength-simple" requ/ired><?php echo $row_exec['question14'];?></textarea>                   
                    <br>
                    <span style="color:#5C068C; font-size:1.25rem; font-weight: 400;">D. <u>EXECUTORS/TRUSTEES REMUNERATION </u></span><br>
                    My Executors shall be / shall not be entitled to an annual fee as follows:<br>
<textarea rows="5" name="question15" class="form-control maxlength-simple" requ/ired><?php echo $row_exec['question15'];?></textarea>

 </p>

</div>
            </section>
            <input type="hidden" name="willtype" value="Comprehensive Will" />
            
            <input type="hidden" name="uid" value="<?php echo $userid;?>" />
            
           <input type="submit" value="Save and Proceed" class="btn btn-inline btn-fcmb" style="float:right;"/>

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