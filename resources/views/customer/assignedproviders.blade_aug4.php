@extends('layouts.customerlayout')
@section('content')
<div class="cd-main-header">		
    <a class="cd-nav-trigger" href="#0">
        <span></span>
    </a>		
</div>
<main class="cd-main-content">
    @include('customer.dashboardmenu')
     
    <?php $caseFileToHPObjs = $data['caseFileToHPObjs']; ?>
    <div class="content-wrapper col-lg-9 col-sm-9 col-xs-12">
        <div class="ibox float-e-margins">
         <div class="ibox-title">
                <h3>Assigned Providers </h3>
        </div>
        <?php if(Session::get('flash_msg')) : ?>
            <div class="success-alert"><?php echo Session::get('flash_msg') ?></div>
        <?php endif ;?>
            
        <div class="ibox-content">
            <div class="row" id="paypal_form_div"></div>
            <div class="row">
                    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table display" width="100%" cellspacing="0" id="health_quotes">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Charge</th>
                    <th>Status</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php $i =0 ;?>
                <?php if(count($caseFileToHPObjs) >0) { ?>
                    <?php foreach($caseFileToHPObjs as $caseFileToHPObj){  ?>

                        <tr>
                            <td><?php echo ++$i ?></td>
                            <td> 
                                <?php $hpName = ucfirst($caseFileToHPObj->healthcare_professional_first_name)." ".$caseFileToHPObj->healthcare_professional_last_name ?>   
                                    <?php $hpId = $caseFileToHPObj->healthcare_professional_id ?>
                                    
                                    <?php if($caseFileToHPObj->healthcare_professional_first_name != ''): ?>
                                        <a href='<?php echo asset("healthcare_professional/details/$hpId") ?>'><?php echo $hpName ?></a>
                                    <?php else: ?>
                                        <a href='javascript:void(0);'><?php echo $caseFileToHPObj->healthcare_professional_email ?></a>
                                    <?php endif ;?>
                            </td>
 
                            
                                <?php 
                                  /* if($caseFileToHPObj->commented_date != ''){
                                        $datetime = new DateTime();
                                        $datetime = $datetime->createFromFormat('Y-m-d H:i:s', $caseFileToHPObj->commented_date);
                                        echo $datetime = $datetime->format('m-d-Y H:i:s');
                                   }*/
                                   ?> 
                          
                            <td>
                                    <?php if($caseFileToHPObj->healthcare_charge >0) : ?>
                                    $&nbsp;<?php echo $caseFileToHPObj->healthcare_charge ?>
                                    <?php endif ;?>                                 
                            </td>
                            <td>
                                <?php
                                if($caseFileToHPObj->display_status_for_customer == 2 || $caseFileToHPObj->display_status_for_customer == 6){
                                    $color = 'green'; //status 'new' or waiting your reply'
                                }else if($caseFileToHPObj->display_status_for_customer == 5){
                                    $color = 'black'; //status 'replied'
                                }
                                $statusObj = DB::table('status')->where('status_id','=',$caseFileToHPObj->display_status_for_customer)->first();
                                echo "<span style='color:$color'>$statusObj->status_name</span>";
                                ?>
                            </td>
                            
                            <?php
                            $casefileToHPId = $caseFileToHPObj->casefile_to_healthcare_id; 
                            ?>
                            <td class="links">
                                <a href="<?php echo asset("customer/conversations/$casefileToHPId") ?>">
                                    <i class="fa fa-comments fa-4" aria-hidden="true" title="Conversations"></i>
                                </a>
                                &nbsp;&nbsp;
                                <?php 
                                if($caseFileToHPObj->payment_status==1) {
                                echo "<span style='color:blue;font-weight:bold'>PAID</span>";
                                } else if($caseFileToHPObj->healthcare_charge >0) { ?>
                                <?php  ; ?>
                                <a href='javascript:void(0);' class="make_paypal_form" onclick='make_paypal_form("<?php echo $casefileToHPId ?>")'>
                                    <img src="<?php echo asset('images/paynow.png'); ?>">
                                </a>
                                <?php } ?> 
                            </td>
                        </tr>
                    <?php } ?>                        
                <?php }else{ ?>
                       <tr><td colspan="6" class="text-center">No Quotes to View</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
        </div>
            </div>
        </div>        
    </div>        
    </div>
</main>    

<script>
 var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>
<script>
$(document).ready(function() {
    $('#health_quotes').DataTable();
} );
</script>

<script>
function make_paypal_form (casefileToHPId){   
         $.ajax({
        type: "POST",    
        data: "casefileToHPId="+casefileToHPId,
        url :SITE_URL+"/customer/ajaxpaypalformcreation",
        success : function(response) {            
            $("#paypal_form_div").html(response);  
            $("#paypal_form").submit();
        },
        error : function(){
 
        $("#openion-message-text").html('<i class="fa-fw fa fa-times"></i><strong>Error!</strong> Something went wrong, please try again.');
        $("#openion-message").removeClass('hide');
        $("#openion-message").addClass('alert alert-danger');
        },
        });   
}

</script>
@stop