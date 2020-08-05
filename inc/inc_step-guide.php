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
								<img src="images/step-form-icon.png" class="img-responsive"/>
							</div> 
						</div> 
						<div class="col-xl-9 col-lg-8 col-12">
							<div class="service-content">
							<h3 class="main-title"><?php echo $row_page['pg_title'];?></h3>
							<p><?php echo $row_page['content'];?></p>
                                        			<?php //if ($row_page['pg_url'] != NULL) { ?>
                                        			<?php //include($incpage);?>
                                        			<?php //} ?>
							</div> <!-- /.service-content -->
						</div> <!-- /.col- -->

						
					</div> <!-- /.row -->
				</div> <!-- /.container -->
			</div> <!-- /.service-details -->