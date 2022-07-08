@extends('layouts.customerlayout')
@section('content')

<div class="col-lg-12">
    <div class="alert alert-success">
<!--        Thank you for your interest.Please check your email for activation link.-->
        Thank you for registering with us.For login, please <a href="<?php echo asset('customer/login'); ?>">click here</a> 
    </div>  
</div>
 
@stop