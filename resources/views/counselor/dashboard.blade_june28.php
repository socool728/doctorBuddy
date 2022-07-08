@extends('layouts.counselorlayout')
@section('content')

<div class="col-lg-12">
@include('counselor.dashboardmenu')
<div class="col-lg-12">
    <form action="javascript:void(0);" id="change_password_from" name="hpform" class="form-label-left" method="post"  role="form" >
        <div class="ibox float-e-margins">
            
            <div id="custom_message_wrapper">    
                <div id="message"  class="hide">
                    <div id="message-text"></div>
                </div>
                 <?php if(Session::get('flash_msg')) : ?>
                <div class="success-alert"><?php echo Session::get('flash_msg') ?></div>
                <?php endif ;?>
            </div>
            
            <div class="ibox-title">
                <h3>Available Customers</h3>
            </div>
            <div class="ibox-content">
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive" id="lastest_reached_customers">

                        </div>              
                    </div>                   
                </div>
 
            </div>                                                                    
        </div>
    </form>
</div>
</div>
<script>
    var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>
<script src="<?php echo asset('js/counselor/dashboard.js'); ?>"></script>
@stop