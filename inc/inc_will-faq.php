            <div class="theme-inner-banner section-spacing">
                <div class="overlay">
                    <div class="container">
                        <h2><?php echo $row_page['pg_name'];?></h2>
                    </div> <!-- /.container -->
                </div> <!-- /.overlay -->
            </div> <!-- /.theme-inner-banner -->


            <div class="faq-page section-spacing">
                <div class="container">
                    <div class="theme-title-one">
                        <h2>FREQUENTLY ASKED QUESTIONS</h2>
                        <!--<p>A tale of a fateful trip that started from this tropic port aboard this tiny ship today stillers</p>-->
                    </div> <!-- /.theme-title-one -->

                    <div class="faq-panel">
                        <div class="panel-group theme-accordion" id="accordion">

                    <?php do { ?>
                          <div class="panel">
                            <div class="panel-heading act/ive-p/anel">
                              <h6 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $row_willfaq['id'];?>">
                                <?php echo $row_willfaq['title'];?></a>
                              </h6>
                            </div>
                            <div id="collapse<?php echo $row_willfaq['id'];?>" class="panel-collapse collapse">
                              <div class="panel-body">
                                <p><?php echo $row_willfaq['content'];?></p>
                              </div>
                            </div>
                          </div> 
                    <?php } while ($row_willfaq = mysqli_fetch_assoc($willfaq));?>

                        </div> <!-- end #accordion -->
                    </div> <!-- /.faq-panel -->
                </div> <!-- /.container -->
            </div> <!-- /.faq-page -->