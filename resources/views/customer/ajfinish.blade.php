<link rel="stylesheet" href="<?php echo asset('css/jquery.fileupload.css');?>" />
<div class="question" id="question">
      <div class="item form-group">
                                             <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="radio" name="existing" value="0" onclick="show_userform(this);" checked="checked"/>New User
                                                </div>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="radio" name="existing" value="1" onclick="show_userform(this);" />Existing User
                                                </div>
                                        </div>
                                    <div id="existuser" style="display:none;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="control-label " for="first-name"><h3> Existing User</h3></label>
                                            
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-1"><div class="alertuck" id="em" >Invalid username or password</div><div class="alertuck" id="nm" ></div></div>
                                        <div class=" form-group">
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <label class="control-label " for="first-name"> Email Address
                                                    </label>
                                            </div> 
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                         <label class="control-label" for="first-name"> Password 
                                                    </label>
                                            </div>
                                        </div>
                                        <div class=" form-group">
                                            <div class="item form-group col-md-4 col-sm-4 col-xs-12">
                                                   <input data-parsley-id="3638" id="user_email_id" name="user_email_id" value="" required="required" title="Email Address" class="form-control" type="email">
                                            </div> 
                                            <div class="item form-group col-md-4 col-sm-4 col-xs-12">
                                                   <input data-parsley-id="3639" id="user_password" name="user_password" value="" required="required" title="Password" class="form-control" type="password">
                                           </div>
                                        </div>                                          
                                    </div>
                                    <div id="newuser" >
                                        
                                        <div class="item form-group">
                                            <label class="control-label " for="first-name"><h3> New User</h3></label>
                                        </div>
                                        <div class="item form-group">
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <label class="control-label " for="first-name"> Email Address 
                                                    </label>
                                            </div> 
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                         <label class="control-label" for="first-name"> Password 
                                                    </label>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                         <label class="control-label" for="first-name"> Repeat Password 
                                                    </label>
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="item form-group col-md-4 col-sm-4 col-xs-12">
                                                   <input data-parsley-id="3640" id="email" name="email" value="" required="required" title="Email" class="form-control" type="email">
                                                   <div class="alertuck" id="exister" >Email account already exist</div>
                                            </div> 
                                            <div class="item form-group col-md-4 col-sm-4 col-xs-12">
                                                   <input data-parsley-id="3641" id="password" name="password" value="" required="required" title="Password" class="form-control" type="password">
                                           </div>
                                            <div class="item form-group col-md-4 col-sm-4 col-xs-12">
                                                   <input data-parsley-id="3642" id="password2" name="password2" data-validate-linked="password" value="" required="required" title="Repeat Password" class="form-control" type="password">
                                           </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <label class="control-label " for="first-name"> First Name 
                                                    </label>
                                            </div> 
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                         <label class="control-label" for="last-name"> Last Name 
                                                    </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="item form-group col-md-4 col-sm-4 col-xs-12">
                                                   <input data-parsley-id="3638" id="customer_fname" name="customer_fname" value="" required="required" title="First Name" class="form-control" type="text">
                                            </div> 
                                            <div class="item form-group col-md-4 col-sm-4 col-xs-12">
                                                   <input data-parsley-id="3639" id="customer_lname" name="customer_lname" value="" required="required" title="Last Name" class="form-control" type="text">
                                           </div>
                                        </div>
      <div class=" form-group">
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <label class="control-label " for="first-name"> Security Question 
                                                    </label>
                                            </div> 
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                         <label class="control-label" for="first-name"> Captcha 
                                                    </label>
                                            </div>
                                        </div>  
                                        <div class="form-group">
                                            <div class="item form-group col-md-4 col-sm-4 col-xs-12">
                                                   <?php 
                                                   if(isset($sec_question)){
                                                   if(count($sec_question)>0){ ?>
                 <select class="form-control" data-parsley-id="3643" name="sec_question" title="Security Question" required="required" >
                     <?php 
                     foreach($sec_question as $val){  ?>
                     <option value="<?php echo $val['sec_question_id'];?>" ><?php echo $val['sec_question'];?></option>
                <?php } ?>
                 </select>
                                                   <?php } } ?> 
                                            </div> 
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               
                             <img src="<?php echo asset('js/captcha.php?rand='.rand()); ?>" id='captchaimg'><br>
Can't read the image? Click <a href='javascript: refreshCaptcha();'><i>here</i></a> to refresh.
        
                                                  
                                           </div>
                                        </div>
                                        <div class="form-group">
                                            <div class=" col-md-4 col-sm-4 col-xs-12">
                                                    <label class="control-label " for="first-name"> Security Answer
                                                    </label>
                                            </div> 
                                            <div class=" col-md-4 col-sm-4 col-xs-12">
                                                         <label class="control-label" for="first-name"> Enter the code above here : 
                                                    </label>
                                            </div>
                                            
                                        </div>
                                        
      <div class="form-group">
       <div class="item form-group col-md-4 col-sm-4 col-xs-12">
                                                    <input data-parsley-id="3644" id="answer" name="answer" value="" required="required" title="Answer" class="form-control" type="text">
                                            </div> 
        <div class="item form-group col-md-4 col-sm-4 col-xs-12">
             <input data-parsley-id="3638" id="captcha_code" name="captcha_code" value="" required="required" title="Captcha Code" class="form-control" type="text">
                                                     <div class="alertuck" id="captcher" >Email user exist in doctorbuddy</div>

             


        </div>
        
    </div> 
                                        <div class="form-group">
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <label class="control-label " for="first-name"> Password retrieval sms to phone
                                                    </label>
                                            </div> 
                                            <div class="item form-group col-md-4 col-sm-4 col-xs-12">
                                                <input data-parsley-id="3645" id="customer_phone" name="customer_phone" value="" max="9999999999999"  maxlength="13" required="required" title="Phone" class="form-control" type="number">    
                                                <div class="alertuck" id="pher" >Phone number should be valid</div>
                                            </div>
                                           
                                        </div>
                                        <div class="item form-group">
                                            <div class=" form-group col-md-1 col-sm-1 col-xs-12">
                                                <input data-parsley-id="3649" id="terms" name="terms" value="1" required="required" title="Terms" class="form-control" type="checkbox" /> 
                                                </div>
                                            <div class="item form-group col-md-11 col-sm-11 col-xs-12">
                                                <label class="control-label " for="first-name"> I agree to Doctorbuddy Terms & conditions
                                                    </label>    
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                            <div class="alertuck col-md-12 col-sm-12 col-xs-12 fulltxt" id="termer" >Please indicate that you agree the Terms and Conditions</div>
                                          </div>
                                        </div>
  
    <div class="item form-group">
        <div class="container">
    
    <div id="files" class="files">
 
    <!-- The fileinput-button span is used to style the file input field as button -->
    <span class="btn btn-success fileinput-button" >
        <i class="glyphicon glyphicon-plus"></i>
        <span >Add Personal file to this case file</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]"  />
    </span>
    </div>
            <div id="upfiles" class="files"></div>
  <script src="<?php echo asset('js/vendor/jquery.ui.widget.js');?>"></script>
<script src="<?php echo asset('js/jquery.iframe-transport.js');?>"></script>
<script src="<?php echo asset('js/jquery.fileupload.js');?>"></script>
<script>
/*jslint unparam: true */
/*global window, $ */
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : '../uploads/index.php';
    $('#fileupload').fileupload({  
        url: url,
        dataType: 'json',
        done: function (e, data) { //alert(JSON.stringify(data.result));
            $.each(data.result.files, function (index, file) {
                //$('<p/>').text(file.name).appendTo('#files');
                //window.opener.$("#files").text(file.name).appendTo('#files');
                if(file.error){
                    $('<p style="color:red;">').text(file.error).appendTo('#upfiles');
                }else{
                    $("#files").hide();
                    $("#upfiles").html(file.name);
                    $("#upfiles").append('&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" id="del_doc">Remove</a>');
                    $("#upfiles").show();
                    $("#document").val(file.name);
    
                }
                
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>
    
</div>


       
             <input type="hidden" name="document" id="document" value="">
             </div>
             <div class="item form-group">
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <label class="control-label " for="first-name"> Forward case file to email
                                                    </label>
                                            </div> 
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                  <input data-parsley-id="3646" id="forwade_email" name="forwade_email" value="" title="Email" class="form-control" type="text">       
                                            </div>      
                                        </div>

 
    <div class="next">
        <a class="btn btn-primary " onclick="prevqn('<?php echo $question_id;?>')">BACK</a>  
            <a class="btn btn-primary" role="button" onclick="finish();">FINISH</a>
    </div>
</div>
<div class="leftsidebar animated slideInLeft1 active1" style="color:#fff;">
<div class="style-toggle"></div>
<div class="text-wrap">
    <?php
    if(isset($customer_data)){
        //print_r($customer_data);
        ?>
    <div class="reportdv">
                <label class="seldisp" for="last-name"><?php echo $customer_data['customer_nickname'];?>
                </label>
            </div>
    <?php if(isset($customer_data['customer_country'])){ ?>
        <div class="reportdv">
                <label class="seldisp" for="last-name"><?php echo $customer_data['customer_country'];?>
                </label>
            </div>
    <?php } if(isset($customer_data['customer_state'])){ ?>
    <div class="reportdv">
                <label class="seldisp" for="last-name"><?php echo $customer_data['customer_state'];?>
                </label>
            </div>
     <?php } if(isset($customer_data['customer_city'])){ ?>
    <div class="reportdv">
                <label class="seldisp" for="last-name"><?php echo $customer_data['customer_city'];?>
                </label>
            </div>
     <?php } if(isset($customer_data['customer_zip'])){ ?>
     <div class="reportdv">
                <label class="seldisp" for="last-name"><?php echo $customer_data['customer_zip'];?>
                </label>
            </div>
    <?php } }?>
    <div class="ln_solid"></div> 
    <?php
    if(isset($sel_symptom)){
        if(count($sel_symptom)>0){
             $j=1;
             ?>
            <div class="reportdv">
                <label class="" for="last-name">Physical Symptoms
                </label>

            </div>
        <?php foreach($sel_symptom as $key=>$symptoms){ 
        ?>
            <div class="reportdv">
                <label class="seldisp" for="last-name"><?php echo $j.' '.$symptoms['symptom_name'];?> 
              <?php
              for($i=1;$i<=$symptoms['symptom_rate'];$i++){
              ?>*
              <?php }  
              if($symptoms['customer_note'] !=''){ echo ' - '.$symptoms['customer_note'];} ?>
                 </label>
            </div>
        <?php $j++;}
        } } ?>
    
    
   <div class="reportdv">
       <?php 
//       echo '<pre>';
//       print_r($customer_ans);
        if(count($customer_ans)>0){        
                foreach($customer_ans as $grp=>$ans){?>
                  <div class="reportdv">
                <label class="" for="last-name"><?php echo $grp;?>
                </label>
                  </div>
       <?php             foreach($ans as $k=>$result){
       ?>
     <div class="reportdv">
       <label class="seldisp" for="last-name">
<?php 
        $qn_remaindisp ='';
        if (strpos($result['question'],'OPTION') !== false) {
            $pos = strpos($result['question'],'OPTION');
            echo substr($result['question'],0,$pos-1);
            $qn_remaindisp = substr($result['question'],$pos+8);
        }else{
            echo $result['question'].":";  
        }?> 

            <?php echo $result['ans'];?>
         <?php if($qn_remaindisp != ''){ echo $qn_remaindisp; } ?>
       
       </label>  </div>
        <?php } } } ?>

</div>
	
</div>
</div> 
