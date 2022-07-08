@extends('layouts.customerlayout')
@section('content')

<div class="col-lg-12">
@include('counselor.dashboardmenu')
<div class="col-lg-12">
    <form action="javascript:void(0);" id="change_password_from" name="hpform" class="form-label-left" method="post"  role="form" >
        <div class="ibox float-e-margins">
            
            <div id="custom_message_wrapper">    
                <div id="message"  class="hide">
                    <div id="message-text"></div>
                </div>
                 <?php if(Session::get('flash_msg')) : ?>
                <div class="success-alert"><?php echo Session::get('flash_msg') ?></div>
                <?php endif ;?>
            </div>
            
            <div class="ibox-title">
                <h3>Change Password</h3>
            </div>
            <div class="ibox-content">
                
                <div class="row">
                    <div class="col-lg-6">
                        
                        <div class="form-group item">
                            <label>New Password</label> 
                             <input  id="counselors_password" name="counselors_password"  required="required" title="New Password" class="form-control" type="password">
                        </div>  
              
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group item">
                            <label>Confirm Password</label> 
                            <input  data-validate-linked="counselors_password"  id="counselors_password2" name="counselors_password2"  required="required" title="Confirm Password" class="form-control" type="password" >
                        </div> 
                    </div>                      
                </div>
 
                <div class="col-lg-12 text-right">
                     <button  onclick="return change_password();"type="submit"  title="Register"  class="btn btn-primary" role="button">Submit</button>
                     <input type="hidden" name="form_submit" value="save">
                </div>
            </div>
                                   
                                 
        </div>
    </form>
</div>
</div>

<script>
 var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>
<script src="<?php echo asset('js/counselor/change_password.js'); ?>"></script>
@stop