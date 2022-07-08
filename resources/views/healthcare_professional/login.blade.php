@extends('layouts.healthcarelayout')
@section('content')

<div id="login-wrap" class="text-center">
       
           
<h3>Provider Login </h3>
 <div class="hide" id="message">
     <div id="message-text" ></div>
 </div>
  <?php if(Session::get('flash_msg') != ''){?>
 <div class="form-group">
    <div class="success-alert" id="" ><?php echo Session::get('flash_msg');?></div>  
 </div>
 <?php } ?>
 <?php if(isset( $_SESSION['customer_id']) && $_SESSION['customer_id'] != ''){ ?>
 <div class="form-group">
     <div class="warning-alert">Warning : Your Customer Session Will Be Cleared.</div>
 </div>
 <?php }elseif (isset( $_SESSION['counselor_id']) && $_SESSION['counselor_id'] != '') { ?>
  <div class="form-group">
     <div class="warning-alert">Warning : Your Counselor Session Will Be Cleared.</div>
 </div>
 <?php  }  ?>
<form class="m-t" role="form" action="javascript:void(0);"  id="loginform">
    <div class="form-group item">
        <input id="user_email_id" name="user_email_id" value="" title="Email" required="required" class="form-control" type="email" placeholder="Email">
    </div>
    <div class="form-group item">
        <input id="user_password" name="user_password" value="" title="Password" required="required" class="form-control" type="password" placeholder="Password">
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-red block full-width m-b" onclick="return hp_login_check();">Login</button> 
      <a href="<?php echo asset('healthcare_professional/forgotpassword'); ?>"><small>Forgot password?</small></a>
    </div>
    <p class="text-muted text-center"><small>Do not have an account?<a  href="<?php echo asset('healthcare_professional/register'); ?>">Create an account</a></small></p>
    
</form>
       
</div>



 
<script>
    var REDIRECT = "<?php echo$data['redirect'] ?>";
    var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>
<script src="<?php echo asset('js/healthcare_professional/login.js'); ?>"></script>
@stop
