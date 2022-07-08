@extends('layouts.customerlayout')
@section('content')

@include('customer.dashboardmenu')

<div  class="text-center" style="width:50%;margin:auto;">
<h3>Change Password</h3>
<form action="javascript:void(0);" id="change_password_from" name="hpform"  method="post"  role="form" class="m-t" >
    <div class="row">
        
        <div id="message"  class="hide form-group ">
            <div id="message-text"></div>
        </div> 

        <div class="form-group item">
            <input  id="customer_password" name="customer_password"  required="required" title="New Password" class="form-control" type="password" placeholder="New Password">
        </div>
        <div class="form-group item">
            <input  data-validate-linked="customer_password"  id="customer_password2" name="customer_password2"  required="required" title="Confirm Password" class="form-control" type="password" placeholder="Confirm Password" >
        </div>             
         
        <div class="form-group">
            <button type="submit"   title="Save" onclick="return change_password();"  class="btn btn-red" role="button">Save</button>
            <input type="hidden" name="form_submit" value="save">                       
        </div>
        
    </div>
</form> 
</div>

<script>
 var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>
<script src="<?php echo asset('js/customer/change_password.js'); ?>"></script>
@stop