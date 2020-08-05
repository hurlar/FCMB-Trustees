                <div class="col-lg-9 col-lg-push-3 col-md-12">
                <section class="card">
                <div class="card-block">
                    <h5>Basic Details (ALREADY HAVE AN ACCOUNT)</h5>
                    <p class="paragraphwithborder"> Information about you - Full Name, Date of Birth, Contact Address, Phone Number, Nationality, State of Origin </p> 
                <form action="processor/process-personal-info.php" method="post">
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Title</label>
                                <select class="form-control" name="salutation" required>
                                    <option value="Mr" <?php if($row_pinfo['salutation'] == 'Mr'){ echo ' selected="selected"'; } ?> > Mr. </option>
                                    <option value="Ms" <?php if($row_pinfo['salutation'] == 'Ms'){ echo ' selected="selected"'; } ?> > Ms. </option>
                                    <option value="Mrs" <?php if($row_pinfo['salutation'] == 'Mrs'){ echo ' selected="selected"'; } ?> > Mrs. </option>
                                    <option value="Others" <?php if($row_pinfo['salutation'] == 'Others'){ echo ' selected="selected"'; } ?> > Others </option>
                                    
                                    
                                </select>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">First Name</label>
                                <input type="text" name="fname" value="<?php echo $fname;?>" class="form-control maxlength-simple" id="exampleInput" required onkeydown="return alphaOnly(event);" />
                                <script>
                                       function alphaOnly(event) {
                                  var key = event.keyCode;
                                  return ((key >= 65 && key <= 90) || key == 8);
                                }; 
                                </script>
                            </fieldset>
                        </div>
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInputEmail1">Middle Name</label>
                                <input type="text" name="mname" class="form-control maxlength-custom-message" id="exampleInputEmail1" value="<?php echo $row_pinfo['mname'];?>" onkeydown="return alphaOnly(event);" />
                                <script>
                                       function alphaOnly(event) {
                                  var key = event.keyCode;
                                  return ((key >= 65 && key <= 90) || key == 8);
                                }; 
                                </script>
                            </fieldset>
                        </div>
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInputPassword1">Last Name</label>
                                <input type="text" name="lname" value="<?php echo $lname;?>" class="form-control maxlength-always-show" id="exampleInputPassword1" required onkeydown="return alphaOnly(event);" />
                                <script>
                                       function alphaOnly(event) {
                                  var key = event.keyCode;
                                  return ((key >= 65 && key <= 90) || key == 8);
                                }; 
                                </script>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                        
                                        <label>Date of Birth (MM/DD/YYYY)</label> 
                                        
                                        <input type="text" name="dob" id="popupDatepinfocker" class="form-control" required value="<?php echo $row_pinfo['dob'];?>" >
                            </fieldset>
                        </div>

                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Gender</label>
                                <select class="form-control" name="gender" required>
                                <option value=""> -Please Select-</option>
                                <option value="Male" <?php if($row_gen['gender'] == 'Male'){ echo ' selected="selected"'; } ?> > Male </option>
                                <option value="Female" <?php if($row_gen['gender'] == 'Female'){ echo ' selected="selected"'; } ?> > Female </option>
                                </select>
                            </fieldset>
                        </div>
                    </div>


                    <div class="row">
                        
                        <div class="col-lg-4 col-sm-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Nationality</label>
                                <select class="form-control" name="nationality" Required>
                    <option value="">-Please Select- </option>
                                    <option value="Nigerian" <?php if($row_pinfo['nationality'] == 'Nigerian'){ echo ' selected="selected"'; } ?> > Nigerian</option>
                                    <option value="Others" <?php if($row_pinfo['nationality'] == 'Others'){ echo ' selected="selected"'; } ?> > Others </option>
                                </select>
                            </fieldset>
                        </div>
                        
                        <div class="col-lg-4 col-sm-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">State of Origin</label>
                                <!--<select class="form-control" name="state" required>
                                <option value=""> -Please Select- </option>
                                <?php //do { ?>
                                    <option value="<?php //echo $row_st1['name'];?>"> <?php //echo $row_st1['name'];?> </option>
                                <?php //} while ($row_st1 = mysqli_fetch_assoc($st1));?>
                                </select>-->
                                
                                <select class="form-control" name="state" required>
                                <option value=""> -Please Select- </option>
                                <option value="Abia" <?php if($row_pinfo['state'] == 'Abia'){ echo ' selected="selected"'; } ?> > Abia </option>
                                                <option value="Abuja" <?php if($row_pinfo['state'] == 'Abuja'){ echo ' selected="selected"'; } ?>> Abuja </option>
                                                                    <option value="Adamawa" <?php if($row_pinfo['state'] == 'Adamawa'){ echo ' selected="selected"'; } ?>> Adamawa </option>
                                                                    <option value="Akwa Ibom" <?php if($row_pinfo['state'] == 'Akwa Ibom'){ echo ' selected="selected"'; } ?>> Akwa Ibom </option>
                                                                    <option value="Anambra" <?php if($row_pinfo['state'] == 'Anambra'){ echo ' selected="selected"'; } ?> > Anambra </option>
                                                                    <option value="Bauchi" <?php if($row_pinfo['state'] == 'Bauchi'){ echo ' selected="selected"'; } ?>> Bauchi </option>
                                                                    <option value="Bayelsa" <?php if($row_pinfo['state'] == 'Bayelsa'){ echo ' selected="selected"'; } ?> > Bayelsa </option>
                                                                    <option value="Benue" <?php if($row_pinfo['state'] == 'Benue'){ echo ' selected="selected"'; } ?>> Benue </option>
                                                                    <option value="Borno" <?php if($row_pinfo['state'] == 'Borno'){ echo ' selected="selected"'; } ?> > Borno </option>
                                                                    <option value="Cross River" <?php if($row_pinfo['state'] == 'Cross River'){ echo ' selected="selected"'; } ?> > Cross River </option>
                                                                    <option value="Delta" <?php if($row_pinfo['state'] == 'Delta'){ echo ' selected="selected"'; } ?> > Delta </option>
                                                                    <option value="Ebonyi" <?php if($row_pinfo['state'] == 'Ebonyi'){ echo ' selected="selected"'; } ?> > Ebonyi </option>
                                                                    <option value="Enugu" <?php if($row_pinfo['state'] == 'Enugu'){ echo ' selected="selected"'; } ?> > Enugu </option>
                                                                    <option value="Edo" <?php if($row_pinfo['state'] == 'Edo'){ echo ' selected="selected"'; } ?> > Edo </option>
                                                                    <option value="Ekiti" <?php if($row_pinfo['state'] == 'Ekiti'){ echo ' selected="selected"'; } ?> > Ekiti </option>
                                                                    <option value="Gombe" <?php if($row_pinfo['state'] == 'Gombe'){ echo ' selected="selected"'; } ?>> Gombe </option>
                                                                    <option value="Imo" <?php if($row_pinfo['state'] == 'Imo'){ echo ' selected="selected"'; } ?>> Imo </option>
                                                                    <option value="Jigawa" <?php if($row_pinfo['state'] == 'Jigawa'){ echo ' selected="selected"'; } ?> > Jigawa </option>
                                                                    <option value="Kaduna" <?php if($row_pinfo['state'] == 'Kaduna'){ echo ' selected="selected"'; } ?>> Kaduna </option>
                                                                    <option value="Kano" <?php if($row_pinfo['state'] == 'Kano'){ echo ' selected="selected"'; } ?>> Kano </option>
                                                                    <option value="Katsina" <?php if($row_pinfo['state'] == 'Katsina'){ echo ' selected="selected"'; } ?> > Katsina </option>
                                                                    <option value="Kebbi" <?php if($row_pinfo['state'] == 'Kebbi'){ echo ' selected="selected"'; } ?> > Kebbi </option>
                                                                    <option value="Kogi" <?php if($row_pinfo['state'] == 'Kogi'){ echo ' selected="selected"'; } ?> > Kogi </option>
                                                                    <option value="Kwara" <?php if($row_pinfo['state'] == 'Kwara'){ echo ' selected="selected"'; } ?> > Kwara </option>
                                                                    <option value="Lagos" <?php if($row_pinfo['state'] == 'Lagos'){ echo ' selected="selected"'; } ?> > Lagos </option>
                                                                    <option value="Nasarawa" <?php if($row_pinfo['Nasarawa'] == 'Abia'){ echo ' selected="selected"'; } ?>> Nasarawa </option>
                                                                    <option value="Niger" <?php if($row_pinfo['state'] == 'Niger'){ echo ' selected="selected"'; } ?> > Niger </option>
                                                                    <option value="Ogun" <?php if($row_pinfo['state'] == 'Ogun'){ echo ' selected="selected"'; } ?>> Ogun </option>
                                                                    <option value="Ondo" <?php if($row_pinfo['state'] == 'Ondo'){ echo ' selected="selected"'; } ?>> Ondo </option>
                                                                    <option value="Osun" <?php if($row_pinfo['state'] == 'Osun'){ echo ' selected="selected"'; } ?>> Osun </option>
                                                                    <option value="Oyo" <?php if($row_pinfo['state'] == 'Oyo'){ echo ' selected="selected"'; } ?> > Oyo </option>
                                                                    <option value="Plateau" <?php if($row_pinfo['state'] == 'Plateau'){ echo ' selected="selected"'; } ?> > Plateau </option>
                                                                    <option value="Rivers" <?php if($row_pinfo['state'] == 'Rivers'){ echo ' selected="selected"'; } ?>> Rivers </option>
                                                                    <option value="Sokoto" <?php if($row_pinfo['state'] == 'Sokoto'){ echo ' selected="selected"'; } ?>> Sokoto </option>
                                                                    <option value="Taraba" <?php if($row_pinfo['state'] == 'Taraba'){ echo ' selected="selected"'; } ?>> Taraba </option>
                                                                    <option value="Yobe" <?php if($row_pinfo['state'] == 'Yobe'){ echo ' selected="selected"'; } ?>> Yobe </option>
                                                                    <option value="Zamfara" <?php if($row_pinfo['state'] == 'Zamfara'){ echo ' selected="selected"'; } ?>> Zamfara </option>
                                </select>
                                
                            </fieldset>
                        </div>

                        <div class="col-lg-4 col-sm-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">LGA</label>
                                <input type="text" name="lga" class="form-control maxlength-simple" id="exampleInput" required value="<?php echo $row_pinfo['lga'];?>" />
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Phone Number</label>
                                <input type="number" name="phoneno" value="<?php echo $phone;?>" class="form-control maxlength-simple" id="exampleInput" required>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInputEmail1">Alt. Phone Number</label>
                                <input type="number" name="altphoneno" class="form-control maxlength-custom-message" id="exampleInputEmail1" value="<?php echo $row_pinfo['aphone'];?>">
                            </fieldset>
                        </div>
                        <div class="col-sm-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInputEmail1">Resident Address</label>
                                <textarea rows="2" name="message" class="form-control maxlength-simple" required><?php echo $row_pinfo['msg'];?></textarea>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">City</label>
                                <input type="text" name="city" class="form-control maxlength-simple" id="exampleInput"  value="<?php echo $row_pinfo['city'];?>" required />
                            </fieldset>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">State</label>
                                <select class="form-control" name="rstate" required>
                                <option value=""> - Please Select - </option>
                                <option value="Abia" <?php if($row_pinfo['rstate'] == 'Abia'){ echo ' selected="selected"'; } ?> > Abia </option>
                                                <option value="Abuja" <?php if($row_pinfo['rstate'] == 'Abuja'){ echo ' selected="selected"'; } ?>> Abuja </option>
                                                                    <option value="Adamawa" <?php if($row_pinfo['rstate'] == 'Adamawa'){ echo ' selected="selected"'; } ?>> Adamawa </option>
                                                                    <option value="Akwa Ibom" <?php if($row_pinfo['rstate'] == 'Akwa Ibom'){ echo ' selected="selected"'; } ?>> Akwa Ibom </option>
                                                                    <option value="Anambra" <?php if($row_pinfo['rstate'] == 'Anambra'){ echo ' selected="selected"'; } ?> > Anambra </option>
                                                                    <option value="Bauchi" <?php if($row_pinfo['rstate'] == 'Bauchi'){ echo ' selected="selected"'; } ?>> Bauchi </option>
                                                                    <option value="Bayelsa" <?php if($row_pinfo['rstate'] == 'Bayelsa'){ echo ' selected="selected"'; } ?> > Bayelsa </option>
                                                                    <option value="Benue" <?php if($row_pinfo['rstate'] == 'Benue'){ echo ' selected="selected"'; } ?>> Benue </option>
                                                                    <option value="Borno" <?php if($row_pinfo['rstate'] == 'Borno'){ echo ' selected="selected"'; } ?> > Borno </option>
                                                                    <option value="Cross River" <?php if($row_pinfo['rstate'] == 'Cross River'){ echo ' selected="selected"'; } ?> > Cross River </option>
                                                                    <option value="Delta" <?php if($row_pinfo['rstate'] == 'Delta'){ echo ' selected="selected"'; } ?> > Delta </option>
                                                                    <option value="Ebonyi" <?php if($row_pinfo['rstate'] == 'Ebonyi'){ echo ' selected="selected"'; } ?> > Ebonyi </option>
                                                                    <option value="Enugu" <?php if($row_pinfo['rstate'] == 'Enugu'){ echo ' selected="selected"'; } ?> > Enugu </option>
                                                                    <option value="Edo" <?php if($row_pinfo['rstate'] == 'Edo'){ echo ' selected="selected"'; } ?> > Edo </option>
                                                                    <option value="Ekiti" <?php if($row_pinfo['rstate'] == 'Ekiti'){ echo ' selected="selected"'; } ?> > Ekiti </option>
                                                                    <option value="Gombe" <?php if($row_pinfo['rstate'] == 'Gombe'){ echo ' selected="selected"'; } ?>> Gombe </option>
                                                                    <option value="Imo" <?php if($row_pinfo['rstate'] == 'Imo'){ echo ' selected="selected"'; } ?>> Imo </option>
                                                                    <option value="Jigawa" <?php if($row_pinfo['rstate'] == 'Jigawa'){ echo ' selected="selected"'; } ?> > Jigawa </option>
                                                                    <option value="Kaduna" <?php if($row_pinfo['rstate'] == 'Kaduna'){ echo ' selected="selected"'; } ?>> Kaduna </option>
                                                                    <option value="Kano" <?php if($row_pinfo['rstate'] == 'Kano'){ echo ' selected="selected"'; } ?>> Kano </option>
                                                                    <option value="Katsina" <?php if($row_pinfo['rstate'] == 'Katsina'){ echo ' selected="selected"'; } ?> > Katsina </option>
                                                                    <option value="Kebbi" <?php if($row_pinfo['rstate'] == 'Kebbi'){ echo ' selected="selected"'; } ?> > Kebbi </option>
                                                                    <option value="Kogi" <?php if($row_pinfo['rstate'] == 'Kogi'){ echo ' selected="selected"'; } ?> > Kogi </option>
                                                                    <option value="Kwara" <?php if($row_pinfo['rstate'] == 'Kwara'){ echo ' selected="selected"'; } ?> > Kwara </option>
                                                                    <option value="Lagos" <?php if($row_pinfo['rstate'] == 'Lagos'){ echo ' selected="selected"'; } ?> > Lagos </option>
                                                                    <option value="Nasarawa" <?php if($row_pinfo['Nasarawa'] == 'Abia'){ echo ' selected="selected"'; } ?>> Nasarawa </option>
                                                                    <option value="Niger" <?php if($row_pinfo['rstate'] == 'Niger'){ echo ' selected="selected"'; } ?> > Niger </option>
                                                                    <option value="Ogun" <?php if($row_pinfo['rstate'] == 'Ogun'){ echo ' selected="selected"'; } ?>> Ogun </option>
                                                                    <option value="Ondo" <?php if($row_pinfo['rstate'] == 'Ondo'){ echo ' selected="selected"'; } ?>> Ondo </option>
                                                                    <option value="Osun" <?php if($row_pinfo['rstate'] == 'Osun'){ echo ' selected="selected"'; } ?>> Osun </option>
                                                                    <option value="Oyo" <?php if($row_pinfo['rstate'] == 'Oyo'){ echo ' selected="selected"'; } ?> > Oyo </option>
                                                                    <option value="Plateau" <?php if($row_pinfo['rstate'] == 'Plateau'){ echo ' selected="selected"'; } ?> > Plateau </option>
                                                                    <option value="Rivers" <?php if($row_pinfo['rstate'] == 'Rivers'){ echo ' selected="selected"'; } ?>> Rivers </option>
                                                                    <option value="Sokoto" <?php if($row_pinfo['rstate'] == 'Sokoto'){ echo ' selected="selected"'; } ?>> Sokoto </option>
                                                                    <option value="Taraba" <?php if($row_pinfo['rstate'] == 'Taraba'){ echo ' selected="selected"'; } ?>> Taraba </option>
                                                                    <option value="Yobe" <?php if($row_pinfo['rstate'] == 'Yobe'){ echo ' selected="selected"'; } ?>> Yobe </option>
                                                                    <option value="Zamfara" <?php if($row_pinfo['rstate'] == 'Zamfara'){ echo ' selected="selected"'; } ?>> Zamfara </option>
                                </select>
                            </fieldset>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label" for="exampleInput">Employment Status</label>
                            </fieldset>
                        </div>
                        <div class="col-md-8 col-sm-12">


                            <div class="radio">
                                <input type="radio" name="estatus" id="radio-1" value="Employed" <?php if($row_pinfo['employment_status'] == 'Employed'){ echo ' checked="checked"'; } ?> Required>
                                <label for="radio-1">Employed </label>
                                <input type="radio" name="estatus" id="radio-2" value="Self-Employed" <?php if($row_pinfo['employment_status'] == 'Self-Employed'){ echo ' checked="checked"'; } ?> Required>
                                <label for="radio-2">Self-Employed</label>
                                <input type="radio" name="estatus" id="radio-3" value="Retired" <?php if($row_pinfo['employment_status'] == 'Retired'){ echo ' checked="checked"'; } ?> Required>
                                <label for="radio-3">Retired</label>
                                <input type="radio" name="estatus" id="radio-4" value="Unemployed" <?php if($row_pinfo['employment_status'] == 'Unemployed'){ echo ' checked="checked"'; } ?> Required>
                                <label for="radio-4">Unemployed</label> <br>
                            </div>

                        
                                            
                </div>

                    </div>

                    <div class="row Employed boxxxx">
                                                <div class="col-lg-6">
                                                    <fieldset class="form-group">
                                                        <label class="form-label" for="exampleInput">Employer</label>
                                                        <input type="text" name="employer" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $row_pinfo['employer'];?>">
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-6">
                                                    <fieldset class="form-group">
                                                        <label class="form-label" for="exampleInputEmail1">Office Phone</label>
                                                        <input type="number" name="employerphone" class="form-control maxlength-custom-message" id="exampleInputEmail1" value="<?php echo $row_pinfo['employerphone'];?>" >
                                                    </fieldset>
                                                </div>
                                                <div class="col-sm-12">
                                                    <fieldset class="form-group">
                                                        <label class="form-label" for="exampleInputEmail1">Employer's Address</label>
                                                        <textarea rows="2" name="employeraddr" class="form-control maxlength-simple"><?php echo $row_pinfo['employeraddr'];?></textarea>
                                                    </fieldset>
                                                </div>
                                            </div>
                    <input type="hidden" name="uid" value="<?php echo $userid ;?>" />
                    <input type="submit" value="Save And Proceed" class="btn btn-inline btn-fcmb" style="float:right;">
                </form>
                </div>
            </section>

                </div><!--.col- -->