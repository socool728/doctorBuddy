@extends('layouts.customerlayout')
@section('content')
<div class="cd-main-header">		
    <a class="cd-nav-trigger" href="#0">
        <span></span>
    </a>		
</div>
<main class="cd-main-content">
    @include('customer.dashboardmenu')    
    <div class="content-wrapper col-lg-9 col-sm-9 col-xs-12">
        <?php if(Session::has('flash_msg')): ?>
            <div  class="col-lg-12 col-sm-12 col-xs-12 alert alert-success text-center m-t"><?php echo Session::get('flash_msg') ?></div>
        <?php endif;?>
        <?php if(Session::has('error_msg')): ?>
            <div  class="col-lg-12 col-sm-12 col-xs-12 alert alert-danger text-center m-t"><?php echo Session::get('error_msg') ?></div>
        <?php endif;?>
        
    </div>
</main>

@stop