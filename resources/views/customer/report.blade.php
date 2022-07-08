@extends('layouts.customerlayout')
@section('content')
<div class="cd-main-header">		
    <a class="cd-nav-trigger" href="#0">
        <span></span>
    </a>		
</div>
<main class="cd-main-content">
    @include('customer.dashboardmenu')
    <?php $report = $reportsArr[0]; ?>   
    <div class="content-wrapper col-lg-10 col-sm-10 col-xs-12">
        @include('customer.common_casefile_view')
    </div>
</main>



<script src="<?php echo asset('js/customer/report.js'); ?>"></script>
@stop