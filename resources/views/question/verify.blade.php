@extends('layouts.homelayout')
@section('content')



<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="dashboard_graph">
            <div class="row x_title">
                <div class="col-md-6 newxpanel">
                    <div class="x_panel">
                        <div class="x_content bs-example-popovers">
                            <div class="alert question-box alert-dismissible fade in" role="alert">
                                Thank you for account activation. Click <a href="<?php echo asset('home/login');?>" class="lnkbtnajx">here</a> to login.
                            </div>
                        </div>
                        
                        
                                        <div class="ln_solid"></div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>    

@stop