@extends('layouts.adminlayout')
@section('content')

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Customer Payments</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <?php if(Session::get('flash_msg') != ''){?>
            <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="alert alert-success" id="" ><?php echo Session::get('flash_msg');?></div>
            </div>                               
        <?php } ?>
        
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    
                    <h3 class="pagehd">Customer Payments</h3>
                    <div class="clearfix">  </div>
                    
                </div>
                <div class="x_content">
                    <table id="example" class="table table-striped responsive-utilities jambo_table">
                        <thead>
                            <tr class="headings">
                                <th>SL No.</th>
                                <th>Transaction ID</th>
                                <th>Amount</th>
                                <th>Customer</th>
                                <th>Healthcare Professional</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                            $i = 0;
                            foreach($paymentDetails as $paymentDetail){ 
                            ?>

                                <tr class="even pointer">
                                    <td class=" ">{{++$i}}</td>
                                    <td class=" ">{{$paymentDetail->transaction_id}}</td>
                                    <td class=" ">$ {{$paymentDetail->transaction_amount }}</td>
                                    <td class=" ">{{ucfirst($paymentDetail->customer_nickname)}}</td>
                                    <td class=" ">{{ucfirst($paymentDetail->healthcare_professional_first_name)}}  {{$paymentDetail->healthcare_professional_last_name}}</td>
                                    <td class=" ">{{$paymentDetail->payment_status}}</td>
                                    <td class=" ">{{$paymentDetail->payment_date}}</td>
                                </tr>   
                            <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <br />
        <br />
        <br />

    </div>
</div>
<script>
 var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>
<script src="<?php echo asset('js/admin/list_hp.js'); ?>"></script>
@stop

