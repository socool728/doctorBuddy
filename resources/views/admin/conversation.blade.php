@extends('layouts.adminlayout')
@section('content')
<style>
    .c_h_rows {
    border: 1px solid gray;
    border-radius: 10px;
    font-size: 13px !important;
}
.m-b {
    margin-bottom: 15px;
}
.m-r {
    margin-right: 15px;
}
.m-l {
    margin-left: 15px;
}
.propagation-area {
    width: 50px;
}


</style>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Conversation History</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Conversation History </h2><?php if( count($data['conversations'])>0) { ?>
                <div class="pull-right m-b">

                    <div class="left text-left">
                        <button type="button" class="btn btn-red" hp_id="<?php echo $data['healthcare_professional_id'];?>" flag="admin" customer_detail_id="<?php echo $data['customer_detail_id']; ?>" id="print_pdf_button"> Print PDF</button>
                    </div>
                    <h2><div class="left text-left m-l propagation-area" id="propagation">
                    </div></h2>
                </div>
            <?php } ?>
                    <div class="clearfix"> </div>
                </div>
                <div class="x_content">
                    
         <div class="margin-top-20" style="border:1px solid grey;border-radius:10px;padding:10px;" >
            
<div id="conversation_listing">
        <?php foreach ($data['conversations'] as $conversation):  ?>

        <?php
        $hpObj = DB::table('healthcare_professional')->where('healthcare_professional_id','=',$conversation->healthcare_professional_id)->first();
        $hpNamArr = array();
        if($hpObj->healthcare_professional_first_name)
            $hpNamArr[] =$hpObj->healthcare_professional_first_name;
        if($hpObj->healthcare_professional_middle_name)
            $hpNamArr[] =$hpObj->healthcare_professional_middle_name;
        if($hpObj->healthcare_professional_last_name)
            $hpNamArr[] =$hpObj->healthcare_professional_last_name;     
        
        
        $customerDetailObj = DB::table('customer_detail')->where('customer_detail_id','=',$data['customer_detail_id'])->first();
        $nickName = $customerDetailObj->customer_nickname; 
                
        ?>
        <?php if($conversation->customer_comment): ?>
            <div class="row  m-b m-l" >
                <div class="form-group">
                    <div class="col-lg-6  col-sm-6 col-xs-6 c_h_rows">
                        <p><b><?php echo $nickName;?></b></p> 
                        <div class="col-lg-8  col-sm-8 col-xs-8 no-pad"><?php echo  $conversation->customer_comment ?></div>
                        <div class="col-lg-4  col-sm-4 col-xs-4 text-right"><?php echo date(Config::get('constants.DATE_TIME_FORMAT'),  strtotime($conversation->date)); ?></div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="row  m-b m-r">
                <div class="form-group">
                    <div class="col-lg-6  col-sm-6 col-xs-6">
                    </div>
                    <div class="col-lg-6  col-sm-6 col-xs-6 c_h_rows">
                        <p style="color:#00243F"><b><?php echo implode(" ", $hpNamArr); ?></b></p>
                        <div class="col-lg-8  col-sm-8 col-xs-8 no-pad"><?php echo  $conversation->healthcare_comment ?></div>
                        <div class="col-lg-4  col-sm-4 col-xs-4 text-right"><?php echo date(Config::get('constants.DATE_TIME_FORMAT'),  strtotime($conversation->date)); ?></div>
                    </div>                                                                        
                </div>
            </div>
        <?php endif;?>
        <?php endforeach ;?>
    </div>
         </div>
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
<script src="<?php echo asset('js/admin/conversation_pdf_print.js'); ?>"></script>

@stop
