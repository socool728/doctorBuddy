@extends('layouts.adminlayout')
@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Report</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Customer Answers <small></small></h2>
                    <div class="clearfix"> </div>
                </div>
                <div class="x_content">
                    <br></br>
<?php // 
//echo '<>pre>';
//print_r($data);
//echo $data['username']."KK";
//foreach($data as $val){ 
?>
                  <form class="form-horizontal form-label-left" novalidate  method="post" >
                                        <div class="reportdv">
                                            <label class="control-rpt col-md-3 col-sm-3 col-xs-12" for="first-name">Customer Email :<?php echo $data['customer_email_id'];?>
                                            </label>
                                            </div>
                      <div class="reportdv">
                                            <label class="control-rpt col-md-3 col-sm-3 col-xs-12" for="first-name">PDF Report :
                       <?php 
                                            $customer_id = $data['customer_id'];
                                            if($customer_id>0){
                                            $report = DB::table('customer_report')->where('customer_id', '=', $customer_id)->orderBy('customer_report_id', 'DESC')->first();
                                            if(count($report)>0){
                                            $file_name = $report->filepath;
                                        ?>
                                        <a href="<?php echo asset('../pdfreports/'.$file_name);?>" target="_blank"><button type="button" class="btn btn-primary">PDF</button></a>
                                            <?php } }  ?> </label>
                                            </div>
                                          <?php 
                     if(count($data['detail'])>0){
                              
                          foreach($data['detail'] as $id){
                                                if(count($data[$id])>0){
                                                if(isset($data[$id]['detailinfo'])){   
                      ?>
                      <div class="reportdv">
                                            <label class="control-rpt col-md-3 col-sm-3 col-xs-12" for="last-name">FIle No :<?php echo $data[$id]['customer_fileno'];?>
                                            </label>
                                            
                                        </div>
                                        
                                        <div class="reportdv">
                                            <label class="control-rpt col-md-3 col-sm-3 col-xs-12" for="last-name">Nick Name : <?php echo $data[$id]['customer_nickname'];?>
                                            </label>                                            
                                        </div>
                      <?php if($data[$id]['customer_for_whom'] !=''){ ?>
                          <div class="reportdv">
                                            <label class="control-rpt col-md-3 col-sm-3 col-xs-12" for="last-name">For :<?php echo $data[$id]['customer_for_whom'];?>
                                            </label>
                                            
                                        </div>
                      <?php } if($data[$id]['customer_sex'] !=''){ ?>
                                        <div class="reportdv">
                                            <label class="control-rpt col-md-3 col-sm-3 col-xs-12" for="last-name">Sex : <?php echo $data[$id]['customer_sex'];?>
                                            </label>                                            
                                        </div>
                                    <?php } if($data[$id]['customer_age'] !=''){ ?>
                        <div class="reportdv">
                                            <label class="control-rpt col-md-3 col-sm-3 col-xs-12" for="last-name">Age : <?php echo $data[$id]['customer_age'];?>
                                            </label>                                            
                                        </div>
                       <?php }?>
                      <?php if($data[$id]['customer_country'] !=''){ ?>
                          <div class="reportdv">
                                            <label class="control-rpt col-md-3 col-sm-3 col-xs-12" for="last-name">Country :<?php echo $data[$id]['customer_country'];?>
                                            </label>
                                            
                                        </div>
                      <?php } if($data[$id]['customer_state'] !=''){ ?>
                                        <div class="reportdv">
                                            <label class="control-rpt col-md-3 col-sm-3 col-xs-12" for="last-name">State : <?php echo $data[$id]['customer_state'];?>
                                            </label>                                            
                                        </div>
                                    <?php } if($data[$id]['customer_city'] !=''){ ?>
                        <div class="reportdv">
                                            <label class="control-rpt col-md-3 col-sm-3 col-xs-12" for="last-name">City/Area : <?php echo $data[$id]['customer_city'];?>
                                            </label>                                            
                                        </div>
                       <?php } if($data[$id]['customer_zip'] !=''){ ?>
                        <div class="reportdv">
                                            <label class="control-rpt col-md-3 col-sm-3 col-xs-12" for="last-name">ZIP/Postal Code : <?php echo $data[$id]['customer_zip'];?>
                                            </label>                                            
                                        </div>
                       <?php } } ?>
                       <div class="reportdv">
                                            <label class="control-rpt col-md-3 col-sm-3 col-xs-12" for="last-name">Known Disease : <?php echo $data[$id]['known_disease'];?>
                                            </label>                                            
                                        </div>
                        <div class="ln_solid"></div> 
                                       <?php if(isset($data[$id]['answers'])){
                                            $group_idarr = array();
                                            foreach($data[$id]['answers'] as $answers){    ?>
                        <?php //echo count($group_idarr)."KK<br>".$answers->group_id;
                                if(count($group_idarr)==1 && $answers->group_id!='1'){
                                    if(isset($data[$id]['symptoms'])){
                                                if(count($data[$id]['symptoms'])>0){
                                                     $j=1;
                                                     ?>
                                    <div class="reportdv gphd">
                                            <label class="control-rpt col-md-3 col-sm-3 col-xs-12" for="last-name">Physical Symptoms
                                            </label>
                  
                                        </div>
                                            <?php foreach($data[$id]['symptoms'] as $symptoms){ 
                                               
                                            ?>
                      <div class="reportdv">
                              <label class="control-rpt col-md-12 col-sm-3 col-xs-12" for="last-name"><?php echo $j.' '.$symptoms->symptom_name;?> 
                                  <?php
                                  for($i=1;$i<=$symptoms->symptom_rate;$i++){
                                  ?>*
                                  <?php }  if($symptoms->customer_note !=''){ echo ' - '.$symptoms->customer_note;} ?>
                                            </label>
                                            
                                           
                                        </div>
                                             <?php $j++;} } } }?>
                      <?php
                                                if(!in_array($answers->group_id,$group_idarr) && $answers->group_name!=''){
                                                     $group_idarr[] = $answers->group_id;
                                            ?><div class="reportdv gphd">
                          <div class="col-md-12 col-sm-6 col-xs-12">
                                    <label class="control-rpt col-md-12 col-sm-8 col-xs-12" for="last-name"><?php echo $answers->group_name;?>
                                        </label>
                          </div>
                                        </div>
                                                <?php } ?>
                      <div class="reportdv ">
                          <div class="col-md-12 col-sm-6 col-xs-12">
                                    <label class="control-rpt col-md-12 col-sm-8 col-xs-12" for="last-name">
                                         <?php $qn_remain ='';
                                        if (strpos($answers->question,'OPTION') !== false) {
                                            $pos = strpos($answers->question,'OPTION');
                                            echo substr($answers->question,0,$pos-1);
                                            $qn_remain = substr($answers->question,$pos+8);
                                        }else{
                                            echo $answers->question.":";  
                                        }?> 
                                            <?php echo $answers->option_val;?>
                                         <?php if($qn_remain != ''){ echo $qn_remain; } ?>
                                            </label>
                          </div>
                                        </div>
                                                <?php //echo count($group_idarr)."LL<br>".$answers->group_id;
                                               // $group_idarr[] = $answers->group_id;?>
                      
                                           
                     
                      <?php
                      
                        }  } }?>
                      <div class="ln_solid"></div> 
                      <?php                   } }  ?>
                      
  <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <a href="../view/<?php echo $customer_id;?>"><button type="button" class="btn btn-primary">Back</button></a>
                                               
                                            </div>
                                        </div>
                                         

                                    </form>
                    
                 
                </div>
            </div>
        </div>

        <br />
        <br />
        <br />

    </div>
</div>

@stop
