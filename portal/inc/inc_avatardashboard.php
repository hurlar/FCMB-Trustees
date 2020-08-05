<section class="box-typical avatardashboard">
						<div class="profile-card">
							<div class="profile-card-photo">
								<?php if ($gender == 'Male') { 
									echo '<img src="img/fcmb-avatar.png" alt=""/>';
								 }elseif ($gender == 'Female') {
								 	echo '<img src="img/fcmb-avatar-temi.png" alt=""/>';
								 }else{
								 	echo '<img src="img/fcmb-avatar.png" alt=""/>';
								 	} ?>
							</div>
							<div class="profile-card-name">Welcome to your dashboard</div>
							<div class="profile-card-name"><?php echo ucfirst($fname).' '.ucfirst($lname); ?></div>
							<!--<div class="profile-card-location" style="color:#5C068C;">You have completed Step 1 </div>
							<button type="button" class="btn btn-rounded">Follow</button>-->
						</div><!--.profile-card-->

					</section><!--.box-typical-->
					