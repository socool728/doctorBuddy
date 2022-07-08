@extends('layouts.healthcarelayout')
@section('content')
<div class="text-center" id="login-wrap">
    <h3>Forgot Password </h3>
    <form class="m-t" role="form" action="javascript:void(0);"  id="forgotpassword_form">
        <div id="message" class="hide form-group">
            <div id="message-text"></div>
        </div>        
        <div class="form-group item">
             <input id="user_email_id" name="user_email_id" value="" title="Email" required="required" class="form-control" type="email" placeholder="Email">
         </div> 
        <div class="form-group item">
           <button type="submit" class="btn btn-red block full-width m-b" onclick="return validate_forgotpassword();">Submit</button>
           <a href="<?php echo asset('healthcare_professional/login'); ?>"><small>Login?</small></a>
        </div>
        
    </form>
</div>

 
<script>
 var SITE_URL = "<?php echo asset(''); ?>";
</script>
<script src="<?php echo asset('js/healthcare_professional/forgotpassword.js'); ?>"></script>

@stop