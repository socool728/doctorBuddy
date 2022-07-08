@extends('layouts.customerlayout')
@section('content')
<h3>Success</h3>
<div class="col-lg-12 col-sm-12  col-sx-12 no-pad">
    <div class="alert alert-success">
<!--        Thank you for your interest.Please check your email for activation link.-->
        Thank you for registering with us.For login, please <a href="<?php echo asset('customer/login'); ?>"><u><i>click here</i></u></a> 
    </div>  
</div>
 
@stop
