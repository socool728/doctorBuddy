@extends('layouts.customerlayout')
@section('content')

<link rel="stylesheet" href="<?php echo asset('css/jquery.fileupload.css');?>" />

<h3>Customer Registration</h3>
<form action="javascript:void(0);" id="qform" name="qform" class="" method="post"  role="form" >
<div class="col-lg-12 col-sm-12  col-sx-12 m-t-xl registration-wrap left no-pad">
    <div id="message"  class="hide col-lg-12 col-sm-12 col-sx-12">
        <div id="message-text"></div>
    </div>
    
    <div class="col-lg-12 col-sm-12 col-sx-12 no-pad">

        <div class="form-group col-lg-6 col-sm-6 col-sx-12 no-pad item right-pad">
            <label>First Name</label> 
            <input  id="customer_fname" name="customer_fname" value="" required="required" title="First Name" class="form-control" type="text">
        </div>
        <div class="form-group col-lg-6 col-sm-6 col-sx-12 no-pad item left-pad">
            <label>Last Name</label> 
            <input  id="customer_lname" name="customer_lname" value="" required="required" title="Last Name" class="form-control" type="text">
        </div>        
    </div>    
    <div class="col-lg-12 col-sm-12 col-sx-12 no-pad">    

        <div class="form-group col-lg-6 col-sm-6 col-sx-12 no-pad item right-pad">
            <label>Email Address </label> 
            <input  id="customer_email_id" name="customer_email_id" value="" required="required" title="Email" class="form-control" type="email">                                
        </div>        
        <div class="form-group col-lg-6 col-sm-6 col-sx-12 no-pad item left-pad">
            <label>Country</label> 
            <?php if(count($country)>0){ ?>
                <select class="form-control required" name="customer_country" title="Country"  id="customer_country" onchange="javascript:getCountryState(this);">
                <option value="" >Select Country</option>
               <?php 
               foreach($country as $val){  ?>
               <option value="<?php echo $val['country_id'];?>" ><?php echo $val['countryname'];?></option>
                <?php } ?>
                </select>
            <?php } ?>                                
        </div>
    </div>
    <div class="col-lg-12 col-sm-12 col-sx-12 no-pad">
        <div class="form-group col-lg-6 col-sm-6 col-sx-12 no-pad item right-pad">
            <label>State</label> 
            <div  id="state_1" class="item">
                <select class="form-control" name="customer_state_select" title="State"  id="customer_state_select"></select>
            </div>                                
            <div style="display:none" id="state_2" class="item"></div>
        </div>
        <div class="form-group col-lg-6 col-sm-6 col-sx-12 no-pad item left-pad">
            <label>City</label> 
            <input id="customer_city" name="customer_city" value="" title="City" required="required" class="form-control" type="text">
        </div>
    </div>  
    <div class="col-lg-12 col-sm-12 col-sx-12 no-pad">
        <div class="form-group col-lg-6 col-sm-6 col-sx-12 no-pad item right-pad">
            <label>Zip</label> 
            <input id="customer_zip" name="customer_zip" value="" title="Zip" required="required" class="form-control" type="text">
        </div>    
        <div class="form-group col-lg-6 col-sm-6 col-sx-12 no-pad item left-pad">
            <label>Phone</label> 
            <input id="customer_phone" name="customer_phone" value="" max="9999999999999"  maxlength="13" required="required" title="Phone" class="form-control" type="number"> 
        </div>
    </div>
    <div class="col-lg-12 col-sm-12 col-sx-12 no-pad">
        <div class="form-group col-lg-6 col-sm-6 col-sx-12 no-pad item right-pad">
            <label>Address </label> 
            <textarea   id="customer_area" name="customer_area" value="" title="Address" class="form-control" required="required" rows="5"></textarea>                                
        </div>
        <div class="form-group col-lg-6 col-sm-6 col-sx-12 no-pad item left-pad">
            <label>Password</label> 
            <input id="password" name="password" value="" required="required" title="Password" class="form-control" type="password">                               
        </div>
        <div class="form-group col-lg-6 col-sm-6 col-sx-12 no-pad item left-pad">
            <label>Repeat Password</label> 
            <input id="password2" name="password2" data-validate-linked="password" value="" required="required" title="Repeat Password" class="form-control" type="password">
        </div>
    </div>
    <div class="col-lg-12 col-sm-12 col-sx-12 no-pad">

        <div class="form-group col-lg-12 col-sm-12 col-sx-12 no-pad ">
            <label>                                            
                Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh.
            </label>

            <span class="col-lg-12 col-sm-12 col-sx-12 no-pad item">
               <input id="captcha_code" name="captcha_code"  required="required" title="Captcha Code" class="form-control" type="text">  
            </span>
            <span class="col-lg-12 col-sm-12 col-sx-12 m-t no-pad">
               <img src="<?php echo asset('js/captcha.php?rand='.rand()); ?>" id='captchaimg'> 
            </span>

            <div class="alertuck" id="captcher" ></div>
        </div>
    </div>
    
        <div class="col-lg-12 col-sm-12 col-sx-12 no-pad">
            <div class="form-group item">    
                <input  id="terms" name="terms" value="1" required="required" title="Terms & Conditions" type="checkbox" />  
                <span>I agree to Doctorbuddy 
                    <a href="javascript:void(0);"  onclick='window.open("<?php echo asset('home/contents/terms-conditions-customer'); ?>");'>Terms & Conditions</a> 
                    ,
                    <a href="javascript:void(0);"  onclick='window.open("<?php echo asset('home/contents/privacy-policy'); ?>");'>Privacy Policy</a>
                </span>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
            <button type="submit" href="finish"  title="Register" onclick="return validate_customer();"  class="btn btn-red" role="button">Register</button>        
        </div>        
<!--    </div>    -->
    
     
</div>
</form>
 
<script src="<?php echo asset('js/customer/register.js'); ?>"></script>
@stop
 