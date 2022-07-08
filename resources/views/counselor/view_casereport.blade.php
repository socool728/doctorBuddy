@extends('layouts.counselorlayout')
@section('content')

<?php 
$report = $data['report']; 
?>
<div class="cd-main-header">		
    <a class="cd-nav-trigger" href="#0">
        <span></span>
    </a>		
</div>
<main class="cd-main-content">
    @include('counselor.dashboardmenu')
    <div class="content-wrapper col-lg-10 col-sm-10 col-xs-12">
        
        <?php if(Session::get('error_message')): ?>
            <div class=" alert alert-danger col-lg-12 col-sm-12 col-xs-12">
                <div ><?php echo Session::get('error_message') ?></div>
            </div>
        <?php else: ?>
        
        @include('customer.common_casefile_view')             
        <?php endif; ?>
    </div>
</main>    

@stop

