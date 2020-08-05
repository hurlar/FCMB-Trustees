            

            <div class="theme-inner-banner section-spacing">

                <div class="overlay">

                    <div class="container">

                        <h2><?php echo $row_page['pg_name'];?></h2>

                    </div> <!-- /.container -->

                </div> <!-- /.overlay -->

            </div> <!-- /.theme-inner-banner -->





            <!--

            =====================================================

                Our Team

            =====================================================

            -->

            <div class="our-team section-spacing">

                <div class="container">

                    <div class="wrapper">

                        <div class="row">


                        <?php do { ?>

                            <div class="col-lg-3 col-sm-6 col-12">

                                <div class="team-member">
				
				<?php if ($row_mgt['image'] != NULL){ ?>
                                    <div class="image-box">

                                        <img src="images/team/<?php echo $row_mgt['image'];?>" alt="">

                                    </div> <!-- /.image-box -->
				<?php } ?>
                                    <div class="text">

                                        <h6><a href="team-details.php?slug=<?php echo $row_mgt['slug'];?>">
                                        <?php echo $row_mgt['name'];?>
                                        </a></h6>
                                        <a href="team-details.php?slug=<?php echo $row_mgt['slug'];?>"><span><?php echo $row_mgt['position'];?></span></a>

                                    </div> <!-- /.text -->

                                </div> <!-- /.team-member -->

                            </div> <!-- /.col- -->

<?php } while ($row_mgt = mysqli_fetch_assoc($mgt));?>


                        </div> <!-- /.row -->

                    </div> <!-- /.wrapper -->

                </div> <!-- /.container -->

            </div> <!-- /.our-team -->
            </br></br>