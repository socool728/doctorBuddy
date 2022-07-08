@extends('layouts.customerlayout')
@section('content')

<?php $caseFileToHPObjs = $data['caseFileToHPObjs']; ?>
<div class="col-md-12">
    @include('customer.dashboardmenu')
<div class="col-md-12">
    <div class="ibox float-e-margins">
         <div class="ibox-title">
                <h3>Assigned Providers </h3>
        </div>
        <?php if(Session::get('flash_msg')) : ?>
            <div class="success-alert"><?php echo Session::get('flash_msg') ?></div>
        <?php endif ;?>
            
        <div class="ibox-content">
            <div class="row">
                    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table display" width="100%" cellspacing="0" id="health_quotes">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Charge</th>
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
                                        <a href='javascript:void(0);'>Unknown</a>
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
                            <?php $customerDetilId = $caseFileToHPObj->customer_detail_id; ?>
                            <td class="links">
                                <a href="<?php echo asset("customer/conversations/$customerDetilId/$hpId") ?>">Conversations</a>
                                <?php 
                                if($caseFileToHPObj->payment_status==1) {
                                echo "<span style='color:blue;font-weight:bold'>PAID</span>";
                                } else if($caseFileToHPObj->healthcare_charge >0) { ?>
                                <?php $encodedCasefileToHPId = base64_encode($caseFileToHPObj->casefile_to_healthcare_id) ; ?>
                                <a href='<?php echo asset("customer/payment/$encodedCasefileToHPId") ?>'>
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
</div>

<script>
$(document).ready(function() {
    $('#health_quotes').DataTable();
} );
</script>

@stop