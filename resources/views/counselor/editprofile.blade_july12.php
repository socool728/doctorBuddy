@extends('layouts.counselorlayout')
@section('content')
<!-- top tiles -->

<?php 
$counselor = $data['counselor']; 
$countries = $data['countries'];
$languages = $data['languages']; 
$specilizations = $data['specilizations']; 
$insurances = $data['insurances']; 

$selectedLanguages = $data['selectedLanguages'];
$selectedSpecilizations = $data['selectedSpecilizations'];

?>


<div class="cd-main-header">		
    <a class="cd-nav-trigger" href="#0">
        <span></span>
    </a>		
</div>
<main class="cd-main-content">
    @include('counselor.dashboardmenu')
     
    <div class="content-wrapper col-lg-9 col-sm-9 col-xs-12">
         <h3>My Account</h3>
        <form action="javascript:void(0);" id="hpform" name="hpform" class="form-label-left" method="post"  role="form" >
            <div class="col-lg-12 col-sm-12  col-xs-12 registration-wrap  no-pad">
                
                <div id="custom_message_wrapper">
                <?php if(Session::get('flash_msg')): ?>
                <div   class="success-alert">
                    <div ><?php echo Session::get('flash_msg') ?></div>
                </div>
                <?php else : ?>
                <div id="message"  class="hide">
                    <div id="message-text"></div>
                </div>
                <?php endif ?>
                </div> 
                
                <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
                    <div class="form-group  col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                        <label> First Name</label> 
                        <input  id="counselors_firstname" name="counselors_firstname"  required="required" title="First Name" class="form-control" type="text" value="<?php echo $counselor->counselors_firstname ?>">
                    </div> 
                    <div class="form-group  col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">
                        <label> Middle Name</label> 
                        <input  id="counselors_middlename" name="counselors_middlename"   title="Middle Name" class="form-control" type="text" value="<?php echo $counselor->counselors_middlename ?>">
                    </div>                     
                </div>
                
                <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
                    <div class="form-group  col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                        <label> Last name</label> 
                        <input  id="counselors_lastname" name="counselors_lastname"  required="required" title="Last Name" class="form-control" type="text" value="<?php echo $counselor->counselors_lastname ?>">
                    </div>
                    <div class="form-group  col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">
                        <label>Email Address </label> 
                        <input id="counselors_email_id" name="counselors_email_id" required="required" title="Email" class="form-control" type="email"  disabled="true" value="<?php echo $counselor->counselors_email_id ?>">
                    </div>                    
                </div>

                <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
                    <div class="form-group  col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                        <label> Country</label> 
                        <select class="form-control required" name="country_id" title="Country"  id="country_id" onchange="javascript:getCountryState(this);">
                                        <option value="" >Select Country</option>
                                            <?php foreach ($countries as $country):?>
                                                 <?php 
                                                    $selected ='';
                                                    if($country->country_id == $counselor->country_id){
                                                        $selected ='selected="selected"';
                                                    }
                                                 ?>
                                            <option value="<?php echo $country->country_id ?>"  phone_code="<?php echo $country->phoneCode ;?>" <?php echo  $selected ?> ><?php echo ucfirst($country->countryname) ?></option>
                                            <?php endforeach ; ?>

                        </select>
                    </div>
                    
                    <div class="form-group  col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">

                        <div class="item" id="state_1">
                            <label>State</label> 
                            <select class="form-control" name="counselors_state_select" title="State"  id="counselors_state_select"></select>
                        </div> 
                        <div class="item" style="display:none" id="state_2"></div>                                 
                    </div>                     
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
                    <div class="form-group  col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                        <label>Zipcode</label> 
                        <input  id="counselors_zip" name="counselors_zip"  required="required" title="Zipcode" class="form-control"  type="text" value="<?php echo $counselor->counselors_zip ?>">
                    </div>                      
                    <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad  left-pad">
                        <label>Phone</label> 
                        <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
                            <div class="col-lg-4 col-sm-4 col-xs-4 item no-pad">
                                <input id="counselors_phone_code" name="counselors_phone_code" value="<?php echo $counselor->counselors_phone_code ?>"    required="required" title="code" class="form-control" type="text"> 
                            </div>
                            <div class="col-lg-8 col-sm-8 col-xs-8 item left-padr0">
                                <input id="counselors_phone" name="counselors_phone" value="<?php echo $counselor->counselors_phone ?>" max="9999999999999"  maxlength="13" required="required" title="Phone" class="form-control" type="number"> 
                            </div>

                        </div>


                    </div> 
                  
                    
                </div>                
                <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
                    <div class="form-group  col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                        <label>City/Area</label> 
                        <input  id="counselors_city" name="counselors_city"   title="City" class="form-control"  type="text" required="required" value="<?php echo $counselor->counselors_city ?>">
                    </div>
                    <div class="form-group  col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">
                        <label> Designation</label> 
                        <input  id="counselors_designation" name="counselors_designation"  title="Designation" class="form-control" type="text" value="<?php echo $counselor->counselors_designation ?>">
                    </div>                    
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
                    <div class="form-group  col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                        <label> Nick Name</label> 
                        <input  id="counselors_nickname" name="counselors_nickname"   title="Nick Name" class="form-control" type="text" value="<?php echo $counselor->counselors_nickname ?>">
                    </div>
                    
                    <div class="form-group  col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">
                        <label> Date Of Birth</label> 
                         <?php
                            if($counselor->counselors_dob != '' && $counselor->counselors_dob != '0000-00-00 00:00:00'){
                                $datetime = new DateTime();
                                $datetime = $datetime->createFromFormat('Y-m-d H:i:s', $counselor->counselors_dob);
                                $dob = $datetime->format('m-d-Y');
                            }else{
                                $dob ="";
                            }
                        ?>
                        <input  id="counselors_dob" name="counselors_dob"   title="Date Of Birth" class="form-control" type="text" value="<?php echo $dob ?>" readonly="true" required="required">

                    </div>                    
                </div>
                
                <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
                    <div class="form-group  col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                        <label>Languages </label> 
                            <select multiple="true" name="language_id[]" id="language_id" title="Languages" class="form-control">
                                <option value="" >Select Languages</option>
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
                    
                    <div class="form-group  col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">
                        <label>Specilizations </label> 
                        <select multiple="true" name="specilization_id[]" id="specilization_id" title="Specilizations" class="form-control">
                            <option value="" >Select Specilizations</option>
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
                    <div class="form-group  col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                        <label> About Me </label> 
                        <textarea  id="counselors_aboutme" name="counselors_aboutme"  title="Profile" class="form-control"><?php echo $counselor->counselors_aboutme ?></textarea>
                    </div>
                    <div class="form-group  col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">
                        <div id="files" class="files">
                            <div class="col-lg-6  ">
                             <span class="btn btn-red fileinput-button">   
                             <span  class="btn btn-red fileinput-button">
                                 <i class="glyphicon glyphicon-plus"></i>Upload Image <input id="fileupload" type="file" name="files"  />
                             </span>
                            </span>
                            </div>
                            <div class="col-lg-6">
                            <?php if($counselor->counselors_photo !=''): ?>
                             <div class="col-lg-9  ">   
                            <img src="<?php echo $data['site_url'].'/uploads/counselor/thumbnail/'.$counselor->counselors_photo ?>">
                            </div>
                                <div class="col-lg-3  ">
                                    <a  onclick="remove_stored_image()" href="javascript:void(0);">
                                        <img src="<?php echo asset('images/delete.png'); ?>">
                                    </a>
                                </div>
                            <?php endif ?>
                            </div>
                        </div>
                        <div id="upfiles" class="files"></div>
                         <input type="hidden" name="document" id="document" value="">                                 
                    </div>                     
                </div>
                
                <div class="col-lg-12 col-sm-12 col-xs-12 no-pad text-right">
                    <button onclick="return edit_profile();" type="submit"  title="Register"  class="btn btn-red" role="button">Save</button>
                    <input type="hidden" name="form_submit" value="save">                     
                </div> 
                
            </div>            
        </form>
        
    </div>
</main>

<script>
    var countryId = "<?php echo $counselor->country_id ?>";
    var stateName = "<?php echo $counselor->counselors_state?>";
    var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>

<!-- Ajax file uploader-->
<link rel="stylesheet" href="<?php echo asset('css/jquery.fileupload.css');?>" />
<script src="<?php echo asset('js/vendor/jquery.ui.widget.js');?>"></script>
<script src="<?php echo asset('js/jquery.iframe-transport.js');?>"></script>
<script src="<?php echo asset('js/jquery.fileupload.js');?>"></script>
<script src="<?php echo asset('js/counselor/file_upload.js');?>"></script>

<script src="<?php echo asset('js/counselor/editprofile.js'); ?>"></script>
@stop