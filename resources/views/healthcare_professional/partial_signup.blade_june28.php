@extends('layouts.customerlayout')
@section('content')
<div class="form-group col-lg-12 col-xs-12 ">
    <div class="alert alert-danger hide" id="message-text" >
    </div>
    <?php if(Session::get('flash_msg') != ''){?>
    <div class="success-alert" id="" ><?php echo Session::get('flash_msg');?></div>

    <?php } ?>

    <!-- Already Logined as other type user -->
    <?php if(Session::get('counselor_id') != ''){ ?>
    <div class="warning-alert">Warning : Your Counselor Session Will Be Cleared.</div>
    <?php }elseif (Session::get('customer_id') != '') { ?>
        <div class="warning-alert">Warning : Your Customer Session Will Be Cleared.</div>
    <?php  }  ?>
</div>

<div class="middle-box text-center loginscreen">
    <div>
        <h3>Partial Signup </h3>

    <form action="javascript:void(0);" class="m-t" id="partial-signup-form" method="POST" novalidate>
  
        <?php if(Session::get('flash_msg') != ''){?>
        <div class="success-alert" id="" ><?php echo Session::get('flash_msg');?></div>

        <?php } ?>

        <!-- Already Logined as other type user -->
        <?php if(Session::get('counselor_id') != ''){ ?>
        <div class="warning-alert">Warning : Your Counselor Session Will Be Cleared.</div>
        <?php }elseif (Session::get('customer_id') != '') { ?>
            <div class="warning-alert">Warning : Your Customer Session Will Be Cleared.</div>
        <?php  }  ?>

        <div class="form-group item">
            <input id="healthcare_professional_password" name="healthcare_professional_password" value="" title="Password" required="required" class="form-control" type="password" placeholder="Password">
        </div>
        <div class="form-group item">
            <input id="confirm_healthcare_professional_password" name="confirm_healthcare_professional_password" value="" title="Password" required="required" class="form-control" type="password" placeholder="Confirm Password">
        </div>
        <button type="submit" class="btn btn-primary block full-width m-b" onclick="return hp_partial_signup_check();">Login</button>
         <input type="hidden" name="form_submit" value="submit">
    </form>
    </div>
</div>
<script>
    var REDIRECT = "<?php echo$data['redirect'] ?>";
    var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>
<script src="<?php echo asset('js/healthcare_professional/partial_signup.js'); ?>"></script>
@stop