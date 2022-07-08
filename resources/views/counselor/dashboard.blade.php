@extends('layouts.counselorlayout')
@section('content')
<div class="cd-main-header">		
    <a class="cd-nav-trigger" href="#0">
        <span></span>
    </a>		
</div>
<main class="cd-main-content">
    @include('counselor.dashboardmenu')
     
    <div class="content-wrapper col-lg-9 col-sm-9 col-xs-12">
        
        <div class="col-lg-12 col-sm-12 col-xs-12 ">
            <div class="m-b">
              <h3>Available Customers</h3>
            </div>

            <div id="custom_message_wrapper">    
                <div id="message"  class="hide">
                    <div id="message-text"></div>
                </div>
                 <?php if(Session::get('flash_msg')) : ?>
                <div class="success-alert"><?php echo Session::get('flash_msg') ?></div>
                <?php endif ;?>
            </div>

            <div class="table-responsive" id="lastest_reached_customers">

            </div> 

        </div>        
    </div>
</main>

<script>
    var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>
<script src="<?php echo asset('js/counselor/dashboard.js'); ?>"></script>
@stop