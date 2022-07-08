<div class="col-lg-12 col-sm-12 left" >
    <h4>Let us know your location to connect the doctors near you.</h4>
    
    <div class="col-lg-12 col-sm-12  col-xs-12 m-t-xl registration-wrap left no-pad">
        
        <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
            <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                <label>Country</label> 
                <?php if(count($country)>0){ ?>
                <select class="form-control required" name="country" title="Country" id="country"  onchange="javascript:getCountryState(this);">
                <option value="" >Select Country</option>
                <?php 
                foreach($country as $val){  ?>
                <option value="<?php echo $val['country_id'];?>" ><?php echo $val['countryname'];?></option>
                <?php } ?>
                </select>
                <?php } ?>                  
            </div>
            <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad left-pad">
                <label>State/Province</label> 
                 <div id="state_1" class="item">
                    <select class="form-control" name="customer_state" title="State"  id="customer_state_select" ></select>                         
                </div>
                <div id="state_2" style="display:none" class="item"></div>                
            </div>
        </div>
        
        <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
            <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad  right-pad">
                <label  for="first-name">Address (Optional)</label>
                <textarea   id="customer_area" name="customer_area" value="" title="Address" class="form-control" rows="5" ></textarea>                
            </div>
            <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">
                <label  for="first-name">City</label>
                <input id="customer_city" name="customer_city" value="" title="City"  class="form-control" type="text" required="required">                 
            </div> 
            <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">
                <label  for="first-name">Zip/Postal code</label>
                <input id="customer_zip" name="customer_zip" value="" title="Zipcode"  class="form-control" type="text" required="required">                 
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
            <div class="form-group item">    
                <input type="checkbox" name="terms"  id="terms"  title="Terms & Conditions"  required="requiired"> 
                    <span>By checking this box, I acknowledge that I have read, understood and accepted the  
                    <a href="javascript:void(0);"  onclick='window.open("<?php echo asset('home/contents/terms-conditions-customer'); ?>");'>Terms & Conditions</a>  </span>
                <input type="hidden" name="customer_id"  id="customer_id"  value="<?php echo Session::get('customer_id');?>" />
            </div>
        </div>
        
        <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
       <div id="usersection" <?php if(Session::get('customer_id')>0){?> class="hide" <?php } ?>>
        <div class="m-t-lg">
            <div class="col-lg-6 col-sm-6">
                <div class="row">
                    

                <div class="form-group select-user">
                    <input type="radio" name="existing" value="0" onclick="show_userform(this);" checked="checked"/> New User
                </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6">
                 <div class="row">
                <div class="form-group">
                    <input type="radio" name="existing" value="1" onclick="show_userform(this);" /> Existing User
                </div>
                 </div>    
            </div>        

        </div>
        
        <div class="row" id="existuser" style="display:none;">
            <div class="col-lg-12"><p><b>Login</b></p></div>
            
            <div class="col-lg-12">
                <div class="alertuck" id="em" >Invalid username or password</div>
                <div class="alertuck" id="nm" ></div>                   
            </div>
            
            <div class="col-lg-6">
                <div class="form-group item">
                    <label  for="first-name">Email Address</label>
                    <input id="user_email_id" name="user_email_id" value="" title="Email Address"  class="form-control" type="email" required="required">  
                </div> 
            </div>
            
            <div class="col-lg-6">
                <div class="form-group">
                    <label  for="first-name">Password</label>
                    <input data-parsley-id="3639" id="user_password" name="user_password" value="" required="required" title="Password" class="form-control" type="password">
               </div> 
            </div>

            <div class="col-lg-12">
                    <div class="" id="message" >
                        <div id="message-text"></div>
                    </div>
            </div>
            <div class="col-lg-12">              
                <label  for="first-name">Forgot Password? Please enter email & Click <a href="javascript:void(0);" onclick="forgotsend();">here</a> to send password</label>
           </div>
            
        </div>
        
        <div class="row " id="newuser" >
            <div class="col-lg-12 "><p><b>Create Account</b></p></div>
            <div class="col-lg-6">
                <div class="form-group item">
                    <label  for="first-name">Email Address</label>
                    <input id="email" name="email" value="" title="Email Address"  class="form-control" type="email" required="required" <?php if(Session::get('customer_id')>0){?> disabled="disabled" <?php } ?>>  
                    <div class="alertuck" id="exister" >Email id exist.</div>
                </div>  
            </div>
            <div class="col-lg-6">
                <div class="form-group item">
                    <label  for="first-name">Password</label>
                    <input id="password" name="password" value="" title="Password"  class="form-control" type="password" required="required" <?php if(Session::get('customer_id')>0){?> disabled="disabled" <?php } ?>>  
                    <div class="alertuck" id="pwderr" >Password 4 characters required</div>
                </div>
                <div class="form-group item">
                    <label  for="first-name">Repeat Password</label>
                    <input id="password2" name="password2" value="" data-validate-linked="password" title="Repeat Password" class="form-control" type="password" required="required" <?php if(Session::get('customer_id')>0){?> disabled="disabled" <?php } ?>>  
                </div>                 
            </div>            
           
        </div>        
    </div>                  
</div> 
        
        <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">

            <div class="col-lg-12 no-pad">
                <div class="form-group">
                    <label >Do you want to send this file to any particular doctor/provider?</label>
                    <select onchange="javascript:get_send_option(this);" id="send_option" title="Do you want to send this file to any particular doctor/provider?" name="send_option" class="form-control">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>    
            </div>

        </div>
        
        <div class="col-lg-12 col-sm-12 col-xs-12 no-pad" id="send_option_area">
            <div class="col-lg-12 no-pad">         
                <div class="item  form-group" id="forwade_email_div">
                    <label >Please provide his/her email id here</label>
                    <input id="forwade_email" name="forwade_email" value="" title="Email"  class="form-control" required="required" type="email">  
                </div>
            </div>
            <div class="col-lg-12 no-pad">        
                <div class="item form-group">
                    <label >Please provide his/her cell phone number</label>
                    <input id="forwade_phone" name="forwade_phone" value="" title="Phone"  class="optional form-control" type="tel">  
                </div>
            </div>
        </div> 
        
        <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
            <div class="col-lg-6 col-sm-6 col-xs-6 text-left">
                <button type="button" class="btn btn-red" onclick="prevqn('<?php echo $currord;?>')">BACK</button>  
            </div>
            <div class="col-lg-6 col-sm-6 col-xs-6 text-right">
                <button type="submit" class="btn btn-red" role="button" onclick="return finish();">FINISH</button>
            </div>    
        </div>        
    </div>

</div>
