@extends('layouts.customerlayout')
@section('content')
   
<div  id="login-wrap" class="text-center">
        
    <h3>Customer Login </h3>
    <div id="message" class="hide">
         <div  id="message-text" ></div>
     </div>
      <?php if(Session::get('flash_msg') != ''){?>
     <div class="form-group">
        <div class="success-alert" id="" ><?php echo Session::get('flash_msg');?></div>  
     </div>
     <?php } ?>
     <?php if(Session::get('hp_id') != ''){ ?>
     <div class="form-group">
         <div class="warning-alert">Warning : Your Healthcare Professional Session Will Be Cleared.</div>
     </div>
     <?php }elseif (Session::get('counselor_id') != '') { ?>
      <div class="form-group">
         <div class="warning-alert">Warning : Your Counselor Session Will Be Cleared.</div>
     </div>
     <?php  }  ?>            
    <form class="m-t" role="form" action="javascript:void(0);"  id="loginform">
        <div class="form-group item">
            <input id="user_email_id" name="user_email_id" value="" title="Email" required="required" class="form-control" type="email" placeholder="Email">
        </div>
        <div class="form-group item">
            <input id="user_password" name="user_password"  value="" title="Password" required="required" class="form-control" type="password" placeholder="Password">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-red block full-width" onclick=" return login();">Login</button>
        </div>
        

        <p class="text-muted text-center"><a href="<?php echo asset('customer/forgotpassword'); ?>">Forgot password?</a></p>
        <p class="text-muted text-center">Do not have an account?<a href="<?php echo asset('customer/register'); ?>"> Create an account</a></p>
        
    </form>
       
</div>

<script>
    var REDIRECT = "<?php echo$data['redirect'] ?>";
    var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>
<script src="<?php echo asset('js/customer/login.js'); ?>"></script>
@stop
