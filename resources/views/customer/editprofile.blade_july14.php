@extends('layouts.customerlayout')
@section('content')
<div class="cd-main-header">		
    <a class="cd-nav-trigger" href="#0">
        <span></span>
    </a>		
</div>
<main class="cd-main-content">
    @include('customer.dashboardmenu')    
    <div class="content-wrapper col-lg-9 col-sm-9 col-xs-12">
    <h3>My Account</h3>
    <form action="javascript:void(0);" id="custform" name="custform" class="form-label-left" method="post"  role="form" >
    <div class="col-lg-12 col-sm-12  col-xs-12 m-t-xl registration-wrap  no-pad">
        
        
        <?php if(Session::get('flash_msg')): ?>
            <div id="message"  class="success-alert col-lg-12 col-sm-12 col-xs-12">
                <div id="message-text"><?php echo Session::get('flash_msg') ?></div>
            </div>
            <?php else : ?>
            <div id="message"  class="hide col-lg-12 col-sm-12 col-xs-12">
                <div id="message-text"></div>
            </div>
        <?php endif ?> 
        
        <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
            <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                <label>First Name</label> 
                <input id="customer_fname" name="customer_fname" value="<?php echo $data['customer_fname'];?>" title="First Name" required="required" class="form-control" type="text">                                                                       
            </div>
            <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">
                <label>Last Name</label> 
                <input id="customer_lname" name="customer_lname" value="<?php echo $data['customer_lname'];?>" title="Last Name" required="required" class="form-control" type="text"> 
            </div>
        </div>
        
        <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
            
            <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                <label>Email</label> 
                <input id="email" name="email" value="<?php echo $data['customer_email_id'];?>" title="Email" disabled="true" class="form-control" type="text">            
            </div>
            <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">
                <label>Country</label> 
                <?php if(count($country)>0){ ?>
                    <select class="required form-control" name="customer_country" title="Country"  id="customer_country" onchange="javascript:getCountryState(this);">
                    <option value="" >Select Country</option>
                    <?php 
                    foreach($country as $val){  ?>
                    <option value="<?php echo $val['country_id'];?>" phone_code="<?php echo $val['phone_code'];?>" <?php if($data['customer_country']==$val['country_id']){ echo "selected" ;} ?>><?php echo $val['countryname'];?></option>
                    <?php } ?>
                    </select>
                <?php } ?>  
            </div>            
        </div>
        
        <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
            <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                <div id="state_1">
                    <label>State</label> 
                    <select class="form-control" name="customer_state_select" title="State"  id="customer_state_select"></select>
                </div>
                <div id="state_2" style="display:none"></div>

            </div> 
            <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">
                <label>City</label> 
                <input id="customer_city" name="customer_city" value="<?php echo $data['customer_city'];?>" title="City" required="required" class="form-control" type="text">
            </div>            
        </div>
        
        
        <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
            <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                <label>Address</label> 
                <textarea rows="5"  id="customer_area" name="customer_area" value="" class="form-control" required="required"><?php echo $data['customer_area'];?></textarea>
            </div> 
            <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad  left-pad">
                <label>Phone</label> 
                <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
                    <div class="col-lg-4 col-sm-4 col-xs-4 item no-pad">
                        <input id="customer_phone_code" name="customer_phone_code" value="<?php echo $data['customer_phone_code'];?>"   maxlength="13" required="required" title="code" class="form-control" type="text"> 
                    </div>
                    <div class="col-lg-8 col-sm-8 col-xs-8 item left-padr0">
                        <input id="customer_phone" name="customer_phone" value="<?php echo $data['customer_phone'];?>" max="9999999999999"  maxlength="13" required="required" title="Phone" class="form-control" type="number"> 
                    </div>

                </div>


            </div>            

            <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">
                <label>Zip</label> 
                <input id="customer_zip" name="customer_zip" value="<?php echo $data['customer_zip'];?>" title="Zip" required="required" class="form-control" type="text" maxlength="9">
            </div>            
        </div>
        
        <div class="col-lg-12 col-sm-12 col-xs-12 no-pad text-right">
            <button type="submit"  title="Update" onclick="return updatecustprofile();"  class="btn btn-red" role="button">Save</button>
            <input type="hidden" name="form_submit" value="save">            
        </div>
        
        
    </div>
</form>
</div> <!-- .content-wrapper -->        
</main>    

<script>
    var countryId = "<?php echo $data['customer_country']?>";
    var stateName = "<?php echo $data['customer_state']?>";
    var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>
<script src="<?php echo asset('js/customer/editprofile.js'); ?>"></script>

@stop