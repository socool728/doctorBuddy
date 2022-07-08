@extends('layouts.healthcarelayout')
@section('content')
<!-- top tiles -->

<?php 
$hp = $data['hp']; 
$languages = $data['languages']; 
$specilizations = $data['specilizations']; 
$insurances = $data['insurances']; 

$selectedLanguages = $data['selectedLanguages'];
$selectedInsurances = $data['selectedInsurances'];
$selectedSpecilizations = $data['selectedSpecilizations'];

?>
<div class="cd-main-header">		
    <a class="cd-nav-trigger" href="#0">
        <span></span>
    </a>		
</div>
<main class="cd-main-content">
    @include('healthcare_professional.dashboardmenu')
    <div class="content-wrapper col-lg-9 col-sm-9 col-xs-12">
        <h3>My Account</h3>
        <form action="javascript:void(0);" id="hpform" name="hpform" class="form-label-left" method="post"  role="form" >
            <div class="col-lg-12 col-sm-12  col-xs-12 registration-wrap  no-pad">

                    <?php if($hpObj->healthcare_professional_status ==4) : ?>
                        <div class="warning-alert">Warning : Please complete your registration to access other areas.</div>
                    <?php endif ?>            
                    <div id="custom_message_wrapper">
                        <?php if(Session::get('flash_msg')): ?>
                        <div  class="success-alert">
                            <div><?php echo Session::get('flash_msg') ?></div>
                        </div>
                        <?php endif ; ?>
                        <div id="message"  class="hide">
                            <div id="message-text"></div>
                        </div>

                    </div>

                    <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
                        <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                            <label> First Name</label> 
                            <input  id="healthcare_professional_first_name" name="healthcare_professional_first_name"  required="required" title="First Name" class="form-control" type="text" value="<?php echo $hp->healthcare_professional_first_name ?>">
                        </div>
                        <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">
                            <label>Middle Name</label> 
                            <input  id="healthcare_professional_middle_name" name="healthcare_professional_middle_name"   title="Middle Name" class="form-control" type="text" value="<?php echo $hp->healthcare_professional_middle_name ?>">
                        </div>                
                    </div> 

                    <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
                        <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                            <label>Last Name</label> 
                            <input  id="healthcare_professional_last_name" name="healthcare_professional_last_name"  required="required" title="Last Name" class="form-control" type="text" value="<?php echo $hp->healthcare_professional_last_name ?>">
                        </div>
                        <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">
                            <label>Email Address</label> 
                            <input id="healthcare_professional_email_address" name="healthcare_professional_email_address" required="required" title="Email" class="form-control" type="email"  value="<?php echo $hp->healthcare_professional_email_address ?>"  disabled="true">
                        </div>                
                    </div>
 
                    <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
                        <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                            <label>Country</label> 
                            <?php if(count($country)>0){ ?>
                                <select class="form-control required" name="healthcare_professional_country" title="Country"  id="healthcare_professional_country" onchange="javascript:getCountryState(this);">
                                <option value="" >Select Country</option>
                                <?php 
                                foreach($country as $val){  ?>
                                <option value="<?php echo $val['country_id'];?>" phone_code="<?php echo $val['phone_code'];?>" <?php if($hp->healthcare_professional_country==$val['country_id']){ echo "selected" ;} ?>><?php echo $val['countryname'];?></option>
                                <?php } ?>
                                </select>
                            <?php } ?> 
                        </div> 

                        <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">                            
                            <div  id="state_1">
                                <label>State</label> 
                                <select class="form-control" name="healthcare_professional_state_select" title="State"  id="healthcare_professional_state_select"></select>
                            </div>
                            <div style="display:none" id="state_2">                                               
                            </div>

                        </div>                
                    </div>

                    <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
                        <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                            <label>City/Area</label> 
                            <input  id="healthcare_professional_city" name="healthcare_professional_city"   title="City" class="form-control"  type="text" required="required" value="<?php echo $hp->healthcare_professional_city ?>">
                        </div>
                        <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">
                            <label>Zipcode</label> 
                            <input  id="healthcare_professional_zip_code" name="healthcare_professional_zip_code"  required="required" title="Zipcode" class="form-control"  maxlength="11" max="99999999999" type="number" value="<?php echo $hp->healthcare_professional_zip_code ?>">
                        </div>                                          
                    </div> 
                    <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
                        <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad  right-pad">
                            <label>Phone</label> 
                            <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
                                <div class="col-lg-4 col-sm-4 col-xs-4 item no-pad">
                                    <input id="healthcare_professional_phone_code" name="healthcare_professional_phone_code" value="<?php echo $hp->healthcare_professional_phone_code?>"   maxlength="13" required="required" title="code" class="form-control" type="text"> 
                                </div>
                                <div class="col-lg-8 col-sm-8 col-xs-8 item left-padr0">
                                    <input id="healthcare_professional_phone_number" name="healthcare_professional_phone_number" value="<?php echo $hp->healthcare_professional_phone_number?>" max="9999999999999"  maxlength="13" required="required" title="Phone" class="form-control" type="number"> 
                                </div>

                            </div>
                        </div>                         
                        <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">
                            <label>Designation</label> 
                            <input  id="healthcare_designation" name="healthcare_designation"  title="Designation" class="form-control" type="text" value="<?php echo $hp->healthcare_designation ?>">
                        </div>               
                    </div>                        

                    <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
                        <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                            <label>Nick Name</label> 
                            <input  id="healthcare_professional_nickname" name="healthcare_professional_nickname"   title="Nick Name" class="form-control" type="text" value="<?php echo $hp->healthcare_professional_nickname ?>">
                        </div>

                        <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">
                            <label>Organization</label> 
                            <input  id="healthcare_professional_organization" name="healthcare_professional_organization"  title="Organization" class="form-control" type="text" value="<?php echo $hp->healthcare_professional_organization ?>">
                        </div>                 
                    </div>

                    <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">

                        <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                            <label>Profile</label> 
                            <textarea  id="healthcare_professional_profile" rows="5" name="healthcare_professional_profile"  title="Profile" class="form-control"><?php echo $hp->healthcare_professional_profile ?></textarea>
                        </div>                
                        <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">
                            <label>Date Of Birth</label> 
                            <?php
                                if($hp->healthcare_professional_dob != '' && $hp->healthcare_professional_dob != '0000-00-00 00:00:00'){
                                    $datetime = new DateTime();
                                    $datetime = $datetime->createFromFormat('Y-m-d H:i:s', $hp->healthcare_professional_dob);
                                    $dob = $datetime->format('m-d-Y');
                                }else{
                                    $dob ="";
                                }
                            ?>                            
                             <input  id="healthcare_professional_dob" name="healthcare_professional_dob"   title="Date Of Birth" class="form-control" type="text" value="<?php echo $dob ?>" readonly="true">
                        </div>
                        <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">
                            <label>Fees</label> 
                            <input  id="healthcare_professional_fees" name="healthcare_professional_fees"   title="Fees" class="form-control" type="text" value="<?php echo $hp->healthcare_professional_fees ?>">
                        </div>                

                    </div>

                    <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">

                        <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                            <label>Introduction</label> 
                            <textarea id="healthcare_professional_introduction" rows="3" name="healthcare_professional_introduction" class="form-control"><?php echo $hp->healthcare_professional_introduction?></textarea>
                        </div>

                        <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">
                            <label>Languages</label> 
                            <select multiple="true" name="language_id[]" id="language_id" title="Languages" class="form-control">
                                <?php foreach ($languages as $language):?>
                                     <?php 
                                        $selected ='';
                                        if(in_array($language->language_id, $selectedLanguages)){
                                            $selected ='selected="selected"';
                                        }
                                     ?>
                                <option value="<?php echo $language->language_id ?>" <?php echo  $selected ?> ><?php echo ucfirst($language->language_name) ?></option>
                                <?php endforeach ; ?>

                            </select>                            
                        </div>                
                    </div>

                    <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">

                        <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                            <label>Insurances</label> 
                            <select multiple="true" name="insurance_id[]" id="insurance_id" title="Insurances" class="form-control">                                
                                <?php foreach ($insurances as $insurance):?>
                                    <?php 
                                        $selected ='';
                                        if(in_array($insurance->insurance_id, $selectedInsurances)){
                                            $selected ='selected="selected"';
                                        }
                                     ?>

                                    <option value="<?php echo $insurance->insurance_id ?>" <?php echo  $selected ?> ><?php echo ucfirst($insurance->insurance_name) ?></option>
                                <?php endforeach ; ?>

                            </select>                            
                        </div> 

                        <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">
                            <label>Specilizations</label> 
                            <select multiple="true" name="specilization_id[]" id="specilization_id" title="Specilizations" class="form-control">
                                 <?php foreach ($specilizations as $specilization):?>
                                         <?php 
                                         $selected ='';
                                         if(in_array($specilization->specilization_id, $selectedSpecilizations)){
                                             $selected ='selected="selected"';
                                         }
                                      ?>

                                     <option value="<?php echo $specilization->specilization_id ?>" <?php echo  $selected ?> ><?php echo ucfirst($specilization->specilization_name) ?></option>
                                 <?php endforeach ; ?>
                            </select>                            
                        </div>                
                    </div>

                    <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
                        <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                            <div id="files_biodata" class="files">
                                <div class="col-lg-6  ">
                                     <span class="btn btn-red fileinput-button">
                                         <span  class="btn btn-red fileinput-button"><i class="glyphicon glyphicon-plus"></i>Upload Biodata <input id="fileupload_biodata" type="file" name="files"  /></span>  
                                    </span>
                                </div>
                                <div class="col-lg-6  " style="margin-top:2%;">
                                     <?php if($hp->healthcare_professional_biodata !=''): ?>
                                    <div class="col-lg-9">
                                     <a href="<?php echo $data['site_url'].'/uploads/healthcare_professional/'.$hp->healthcare_professional_biodata ?>">
                                         <?php echo $hp->healthcare_professional_biodata ?>
                                     </a>
                                    </div>
                                    <div class="col-lg-3">
                                        <a  onclick="remove_stored_biodata()" href="javascript:void(0);"> 
                                             <img src="<?php echo asset('images/delete.png'); ?>">
                                        </a></div>
                                     <?php endif ?>
                                </div>


                            </div>
                            <div id="upfiles_biodata" class="files"></div>
                            <input type="hidden" name="document_biodata" id="document_biodata" value="">  
                        </div>                              
                        <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">
                            <div id="files_image" class="files">
                                <div class="col-lg-6  ">
                                     <span class="btn btn-red fileinput-button">                                                           
                                         <span  class="btn btn-red fileinput-button"><i class="glyphicon glyphicon-plus"></i>Upload Image<input id="fileupload_image" type="file" name="files"  /></span>                                                            
                                    </span>
                                </div>
                                <div class="col-lg-6  " style="margin-top:2%;">
                                   <?php if($hp->healthcare_professional_image !=''): ?>
                                    <div class="col-lg-9">
                                     <img src="<?php echo $data['site_url'].'/uploads/healthcare_professional/thumbnail/'.$hp->healthcare_professional_image ?>">
                                    </div>
                                    <div class="col-lg-3">
                                        <a  onclick="remove_stored_image()" href="javascript:void(0);">
                                            <img src="<?php echo asset('images/delete.png'); ?>">
                                        </a></div>
                                    <?php endif ?> 
                                </div>

                            </div>
                            <div id="upfiles_image" class="files"></div>
                            <input type="hidden" name="document_image" id="document_image" value="">
                        </div>  

                    </div> 

                    <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">

                    </div>  

                    <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
                        <div class="col-lg-12 text-right">
                            <button  onclick="return edit_profile();"type="submit"  title="Update"  class="btn btn-red" role="button">Save</button>
                            <input type="hidden" name="form_submit" value="save">                     
                        </div>
                    </div>    
            </div>    

        </form>        
    </div>
</main>

<script>
    var countryId = "<?php echo $hp->healthcare_professional_country ?>";
    var stateName = "<?php echo $hp->healthcare_professional_state?>";
    var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>

<!-- Ajax file uploader-->
<link rel="stylesheet" href="<?php echo asset('css/jquery.fileupload.css');?>" />
<script src="<?php echo asset('js/vendor/jquery.ui.widget.js');?>"></script>
<script src="<?php echo asset('js/jquery.iframe-transport.js');?>"></script>
<script src="<?php echo asset('js/jquery.fileupload.js');?>"></script>
<script src="<?php echo asset('js/healthcare_professional/file_upload.js');?>"></script>

<script src="<?php echo asset('js/healthcare_professional/editprofile.js'); ?>"></script>

@stop