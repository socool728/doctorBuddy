@extends('layouts.customerlayout')
@section('content')


 <div class="form-group col-lg-12 col-xs-12">
    <div>
        <div class="hide alert alert-danger" id="em" >This email not exist in our records.</div>
        <?php if($dataoutput['msg'] != ''){?>
        <div class="success-alert" id="nm" ><?php echo $dataoutput['msg'];?></div>
        <?php } ?>
    </div>
</div>

<div class="middle-box text-center loginscreen ">
        <div>
           
            <h3>Forgot Password</h3>
            
            <form class="m-t" role="form" action="javascript:finish();"  id="loginform">
                <div class="form-group item">
                    <input id="user_email_id" name="user_email_id"  value="" title="Email" required="required" class="form-control" type="email" placeholder="Email">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b"   href="finish" role="button">Submit</button>

                <a href="<?php echo asset('customer/login/'); ?>"><small>Login?</small></a>
            </form>
        </div>
</div>

<script>
 var SITE_URL = "<?php echo asset(''); ?>";
</script>
<script src="<?php echo asset('js/customer/forgotpassword.js'); ?>"></script>
@stop