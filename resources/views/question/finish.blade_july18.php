@extends('layouts.customerlayout')
@section('content')

    <div class="col-lg-10 col-md-offset-1 ">
        <div class="ibox float-e-margins">
<!--        <div class="ibox-title">
                <h3>Case File Report</h3>
        </div>-->
        <div class="ibox-content">
         
                <?php if(Session::get('flash_msg')): ?>
                    <br/>
                    <div  class="row alert alert-success">
                        <div class="col-lg-12 col-sm-12 col-xs-12"><?php echo Session::get('flash_msg') ?></div>
                    </div>
                    <br/>
                <?php endif ; ?>  
            
                @include('customer.common_casefile_view')     


        </div>
    </div>
    </div>

  
<script src="<?php echo asset('js/jQuery.print.js'); ?>"></script>
<script src="<?php echo asset('js/questions/finish.js'); ?>"></script>
@stop