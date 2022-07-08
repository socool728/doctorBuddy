@extends('layouts.customerlayout')
@section('content')
<div class="text-center" id="login-wrap">
    <h3>Counselor Login </h3>
            
    <form class="m-t" role="form" action="javascript:void(0);"  id="loginform">
                <div class="form-group">
                    <div class="alert alert-danger hide" id="message-text" ></div>
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
                <?php }elseif (Session::get('customer_id') != '') { ?>
                 <div class="form-group">
                    <div class="warning-alert">Warning : Your Customer session Will Be Cleared.</div>
                </div>
                <?php  }  ?>
                <div class="form-group item">
                    <input id="user_email_id" name="user_email_id" value="" title="Email" required="required" class="form-control" type="email" placeholder="Email">
                </div>
                <div class="form-group item">
                    <input id="user_password" name="user_password" value="" title="Password" required="required" class="form-control" type="password" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-red block full-width m-b" onclick="return counselor_login_check();;">Login</button>

                <a href="<?php echo asset('counselor/forgotpassword'); ?>"><small>Forgot password?</small></a>
                <p class="text-muted text-center">
                <small>Do not have an account?
                <a  href="<?php echo asset('counselor/register'); ?>">Create an account</a>
                </small>
                </p>
            </form>
        
</div>

<script>
    var REDIRECT = "<?php echo$data['redirect'] ?>";
    var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>
<script src="<?php echo asset('js/counselor/login.js'); ?>"></script>
@stop