@extends('layouts.homelayout')
@section('content')

<!-- top tiles -->
<div class="row tile_count">
    <div class="animated flipInY col-sm-4 col-xs-4 tile_stats_count">
        <div class="right"><div class="count"><a href="<?php echo asset('index.php/home'); ?>" class="logolnk">DoctorBuddy</a></div></div>
    </div>
</div>
<!-- /top tiles -->

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="dashboard_graph">
            <div class="row x_title">
                <div class="col-md-6 newxpanel">
                    <div class="x_panel">
                        <div class="x_content bs-example-popovers">
                            <div class="alert question-box alert-dismissible fade in" role="alert">
                                 <?php if($data['logined']=='1'){ ?>
                                Below is the answer of Doctorbuddy questions.
                                <?php }else{ ?>
                                Thank you for answering the questions.
                                <?php } ?>
                                <?php if($data['registration']=='1'){ ?>
                                Please check your email to activate your account.
                                <?php } ?>
                            </div>
                        </div>
                        
                        
                         <div class="reportdv">
                            <label class="control-rpt col-md-3 col-sm-3 col-xs-12" for="first-name"> Name :
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <label class="control-rpt col-md-3 col-sm-3 col-xs-12"><?php echo $data['customer_name'];?></label>
                            </div>
                        </div>
                        <div class="reportdv">
                            <label class="control-rpt col-md-3 col-sm-3 col-xs-12" for="last-name"> Email :
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label class="control-rpt col-md-3 col-sm-3 col-xs-12"><?php echo $data['customer_email_id'];?></label>
                            </div>
                        </div>
                        <div class="reportdv">
                            <label class="control-rpt col-md-3 col-sm-3 col-xs-12" for="last-name">Nick Name :
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label class="control-rpt col-md-3 col-sm-3 col-xs-12"> <?php echo $data['customer_nickname'];?></label>
                            </div>
                        </div>
                        <div class="reportdv">
                            <label class="control-rpt col-md-3 col-sm-3 col-xs-12" for="last-name">Country :
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label class="control-rpt col-md-3 col-sm-3 col-xs-12"> <?php echo $data['customer_country'];?></label>
                            </div>
                        </div>
                        <div class="reportdv">
                            <label class="control-rpt col-md-3 col-sm-3 col-xs-12" for="last-name">State :
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label class="control-rpt col-md-3 col-sm-3 col-xs-12"> <?php echo $data['customer_state'];?></label>
                            </div>
                        </div>
                         <?php if($data['customer_city']!=''){ ?>
                      <div class="reportdv">
                            <label class="control-rpt col-md-3 col-sm-3 col-xs-12" for="last-name">City/Area :
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label class="control-rpt col-md-3 col-sm-3 col-xs-12"> <?php echo $data['customer_city'];?></label>
                            </div>
                        </div>
                      <?php }  ?>
                        <div class="reportdv">
                            <label class="control-rpt col-md-3 col-sm-3 col-xs-12" for="last-name">Known Disease :
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label class="control-rpt col-md-3 col-sm-3 col-xs-12"> <?php echo $data['known_disease'];?></label>
                            </div>
                        </div>
                        
                        
                            <div class="ln_solid"></div>        
                      <?php if(isset($data['answers'])){
                                    if(count($data['answers'])>0){
                                        $group_idarr = array();
                                            foreach($data['answers'] as $answers){ ?>
                        <?php //echo count($group_idarr)."KK<br>".$answers->group_id;
                                if(count($group_idarr)==1 && $answers->group_id!='1'){
                                     if(isset($data['symptoms'])){
//                          print_r($data['answers']);
                                                if(count($data['symptoms'])>0){
                                                     $j=1;
                                                     ?>
                      <div class="reportdv gphd">
                              <label class="control-rpt col-md-3 col-sm-3 col-xs-12" for="last-name">Physical Symptom 
                                            </label>

                  
                                        </div>
                                            <?php foreach($data['symptoms'] as $symptoms){ 
                                               
                                            ?>
                      <div class="reportdv">
                              <label class="control-rpt col-md-3 col-sm-3 col-xs-12" for="last-name"><?php echo $j.' '.$symptoms->symptom_name;?> 
                                  <?php
                                  for($i=1;$i<=$symptoms->symptom_rate;$i++){
                                  ?>*
                                  <?php }  if($symptoms->customer_note !=''){ echo ' - '.$symptoms->customer_note;} ?>
                                            </label>                                            
                                        </div>
                        <?php $j++;} } } }?>
                                        <?php  if(!in_array($answers->group_id,$group_idarr) && $answers->group_name!=''){
                                            $group_idarr[] = $answers->group_id;
                                                 ?><div class="reportdv gphd">
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                          <label class="control-rpt col-md-8 col-sm-8 col-xs-12" for="last-name"><?php echo $answers->group_name;?>
                                                              </label>
                                                </div>
                                             </div>
                                                <?php } ?>
                                    <div class="reportdv">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                              <label class="control-rpt col-md-8 col-sm-8 col-xs-12" for="last-name">
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
                        <?php //$group_idarr[] = $answers->group_id;?>
                       
                        
                      <?php } } }?>
                      
                        
                                        <div class="ln_solid"></div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>    

@stop