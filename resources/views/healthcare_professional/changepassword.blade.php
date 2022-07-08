@extends('layouts.healthcarelayout')
@section('content')
<div class="cd-main-header">		
    <a class="cd-nav-trigger" href="#0">
        <span></span>
    </a>		
</div>
<main class="cd-main-content">
    @include('healthcare_professional.dashboardmenu')
    <div class="content-wrapper col-lg-9 col-sm-9 col-xs-12">
        <div  class="text-center" style="width:50%;margin:auto;">
<h3>Change Password</h3>
<form action="javascript:void(0);" id="change_password_from" name="hpform"  method="post"  role="form" class="m-t" >
    <div class="ibox float-e-margins">
        
        <div id="custom_message_wrapper">    
            <div id="message"  class="hide">
                <div id="message-text"></div>
            </div>
             <?php if(Session::get('flash_msg')) : ?>
            <div class="success-alert"><?php echo Session::get('flash_msg') ?></div>
            <?php endif ;?>
        </div>

        <div class="form-group item">
            <input  id="healthcare_professional_password" name="healthcare_professional_password"  required="required" title="New Password" class="form-control" type="password" placeholder="New Password">
        </div>
        <div class="form-group item">
            <input  data-validate-linked="healthcare_professional_password"  id="healthcare_professional_password2" name="healthcare_professional_password2"  required="required" title="Confirm Password" class="form-control" type="password" placeholder="Confirm Password" >
        </div>             
         
        <div class="form-group">
            <button type="submit"   title="Save" onclick="return change_password();"  class="btn btn-red" role="button">Save</button>
            <input type="hidden" name="form_submit" value="save">                       
        </div>
        
    </div>
</form> 
</div>        
    </div>    
</main>

<script>
 var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>
<script src="<?php echo asset('js/healthcare_professional/change_password.js'); ?>"></script>
@stop