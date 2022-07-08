<?php foreach ($conversations as $conversation):  ?>
                        
<?php
$hpObj = DB::table('healthcare_professional')->where('healthcare_professional_id','=',$conversation->healthcare_professional_id)->first();
$hpNamArr = array();
if($hpObj->healthcare_professional_first_name)
    $hpNamArr[] =$hpObj->healthcare_professional_first_name;
if($hpObj->healthcare_professional_middle_name)
    $hpNamArr[] =$hpObj->healthcare_professional_middle_name;
if($hpObj->healthcare_professional_last_name)
    $hpNamArr[] =$hpObj->healthcare_professional_last_name;                            
?>
<?php if($conversation->customer_comment): ?>
<div class="row  m-b" >
    <div class="form-group">
        <div class="col-lg-6 c_h_rows">
            <p><b>You</b></p> 
            <div class="col-lg-8 no-padding"><?php echo  $conversation->customer_comment ?></div>
            <div class="col-lg-4 text-right"><?php echo date(Config::get('constants.DATE_TIME_FORMAT'),  strtotime($conversation->date)); ?></div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="row  m-b">
    <div class="form-group">
        <div class="col-lg-6">
        </div>
        <div class="col-lg-6 c_h_rows">
            <p style="color:#00243F"><b><?php echo implode(" ", $hpNamArr); ?></b></p>
            <div class="col-lg-8 no-padding"><?php echo  $conversation->healthcare_comment ?></div>
            <div class="col-lg-4 text-right"><?php echo date(Config::get('constants.DATE_TIME_FORMAT'),  strtotime($conversation->date)); ?></div>
        </div>                                                                        
    </div>
</div>
<?php endif;?>
<?php endforeach ;?>