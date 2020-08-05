<?php
$a = mysqli_real_escape_string($conn, $_GET['a']);
?>

<div class="theme-inner-banner section-spacing">
				<div class="overlay">
					<div class="container">
						<h2><?php echo $row_page['pg_name'];?></h2>
					</div> <!-- /.container -->
				</div> <!-- /.overlay -->
			</div> <!-- /.theme-inner-banner -->

			<div class="service-details section-spacing">
				<div class="container">
					<div class="row">
						<div class="col-xl-3 col-lg-4 col-md-6 col-sm-8 col-12 theme-sidebar-one">
							<div class="sidebar-box service-categories">
								<ul>
								<?php do { ?>
									<li <?php if ($row_rtd['pg_alias'] == $a) { ?>
                                        class="active"
                                        <?php } ?> ><a href="page.php?a=<?php echo $row_rtd['pg_alias']?>"><?php echo $row_rtd['pg_name']?></a></li>
								<?php } while ($row_rtd = mysqli_fetch_assoc($rtd));?>
								</ul>
							</div> 

							<div class="sidebar-box sidebar-brochures">
								<!--<h5 class="title">Download Resources</h5>-->
								<ul>
								<li><a href="page.php?a=downloads"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Downloadable Forms </a></li>
									
								</ul>
							</div>
							<div class="sidebar-box sidebar-contact">
								<h2 class="title">Contact Us</h2>
								<h6><?php echo $row_lyt['contact-text1'];?></h6>
								<p><?php echo $row_lyt['contact-text2'];?></p>
								<ul>
									<li><a href="mailto:fcmbtrustees@fcmb.com"><i class="fa fa-envelope" aria-hidden="true"></i> <?php echo $row_lyt['contact-text3'];?></a></li>
									<li><a href="tel:23412902721"><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $row_lyt['contact-text4'];?> </a></li>
								</ul>
							</div> 
							<!--<div class="sidebar-box sidebar-brochures">
								<img src="images/contact.png" class="img-responsive"/>
							</div>-->


						</div> 
						<div class="col-xl-9 col-lg-8 col-12">
							<div class="service-content">
								<h3 class="main-title"><?php echo $row_page['pg_title'];?></h3>
								<?php echo $row_page['content'];?>
                                        			<?php if ($row_page['pg_url'] != NULL) { ?>
                                        			<?php include($incpage);?>
                                        			<?php } ?>
							</div> <!-- /.service-content -->
							<?php if($a == 'wills-probate-services'){?>
					
						<a href="https://on.fcmb.com/Write-Your-Will-Now3" target="_blank"><button class="theme-button-one">Write a Will</button></a>
					
							<?php } ?>
						</div> <!-- /.col- -->

						
					</div> <!-- /.row -->
				</div> <!-- /.container -->
			</div> <!-- /.service-details -->