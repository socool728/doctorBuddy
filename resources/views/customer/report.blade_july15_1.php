@extends('layouts.customerlayout')
@section('content')
<div class="cd-main-header">		
    <a class="cd-nav-trigger" href="#0">
        <span></span>
    </a>		
</div>
<main class="cd-main-content">
    @include('customer.dashboardmenu')
    <?php $report = $reportsArr[0]; ?>   
    <div class="content-wrapper col-lg-10 col-sm-10 col-xs-12">
        <div class="col-lg-12 col-sm-12 col-xs-12">
     <div class="ibox-title">
                <h3>Case File Report</h3>
        </div>                                
    <div class="col-lg-8">
    <div class="ibox float-e-margins">
       <div class="ibox-content">

        		<div class="pull-right m-b">
                                        <div id="pdfdv" class="left text-left">
                                            <a href="<?php echo asset('pdfreports/'.$report['customer_fileno']);?>.pdf" target="_blank">
                                                <button type="button" class="btn btn-red">PDF</button>
                                             </a>
                                        </div>

                                        <div class="left text-left m-l" id="printdv">
                                            <button type="button" class="btn btn-red print" >Print</button> 
                                        </div>
                                    </div>
                <div class="row" id="printable">   <!-- in print sections, make all col-lg-  to col-sm- -->
                    <!-- Start: PDF & Print section -->
                    <div class="col-sm-12 header-print">
     <img src="<?php echo asset("images/logo-xs.png");?>">                          
	</div>   
                    <div class="col-sm-12  m-b file-num">
                         <label>FIle No :<?php echo $report['customer_fileno'];?>      
                    </div>                            
                    <!-- End: PDF & Print section -->     
                   <!-- Start: Customer detail section -->
                    <div class="col-sm-12">
                    <h4>Basic Information</h4>
<!--                        <div class=" col-sm-12 list-casefile ">  
                            <label class="label-left"  for="last-name"> Email :
                            </label>
                            <div class="col-sm-7">
                                <label class=" "><?php //echo $report['customer_email_id'];?></label>
                            </div>
                        </div>-->
                        <div class=" col-sm-12  list-casefile ">
                            <label class="label-left"   for="last-name">Nick Name :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"> <?php echo $report['customer_nickname'];?></label>
                            </div>
                        </div>
                            <?php if($report['customer_for_whom'] != ''){ ?>
                        <div class="col-sm-12  list-casefile ">
                            <label class="label-left"  for="first-name"> For :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"><?php echo $report['customer_for_whom'];?></label>
                            </div>
                        </div>
                            <?php } ?>
                            <?php if($report['customer_age'] != ''){ ?>
                        <div class="col-sm-12  list-casefile ">
                            <label class="label-left"   for="first-name"> Age :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"><?php echo $report['customer_age'];?></label>
                            </div>
                        </div>
                            <?php } ?>
                            <?php if($report['customer_sex'] != ''){ ?>
                        <div class="col-sm-12  list-casefile ">
                            <label class="label-left"   for="first-name"> Sex :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"><?php echo $report['customer_sex'];?></label>
                            </div>
                        </div>
                            <?php } ?>
                        <div class="col-sm-12  list-casefile ">
                            <label class="label-left"   for="last-name">Country :
                            </label>
                            <div class="col-sm-7 ">

                                <label class="label-ans"> <?php echo $report['customer_country'];?></label>
                            </div>
                        </div>
                        <div class="col-sm-12  list-casefile ">
                            <label class="label-left"   for="last-name">State :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"> <?php echo $report['customer_state'];?></label>
                            </div>
                        </div>
                      <div class="col-sm-12  list-casefile ">
                            <label class="label-left"   for="last-name">City :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"> <?php echo $report['customer_city'];?></label>
                            </div>
                        </div>

                    <div class="col-sm-12  list-casefile ">
                        <label class="label-left"   for="last-name">Area :
                        </label>
                        <div class="col-sm-7 ">
                            <label class="label-ans"> <?php echo $report['customer_area'];?></label>
                        </div>
                    </div>    

                  <div class="col-sm-12  list-casefile ">
                        <label class="label-left"   for="last-name">Zipcode :
                        </label>
                        <div class="col-sm-7 ">
                            <label class="label-ans"> <?php echo $report['customer_zip'];?></label>
                        </div>
                    </div>                                
						
                        
                  <h4 class="m-t-lg left">Symptoms</h4>
                                  
                  <div class="col-sm-12 m-t-0  list-casefile ">
                            <label class="label-left"  for="last-name">Known Disease :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"> <?php echo $report['known_disease'];?></label>
                            </div>
                        </div>
						<div class="col-sm-12  list-casefile ">			
                            <label class="label-left"   for="last-name">Past Illness History :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"> <?php echo $report['customer_past_illness_history'];?></label>
                            </div>
                        </div>

                        <?php
                        $customerDetailId = $report['customer_detail_id'];
                        $files = DB::table('customer_files')->where('customer_detail_id', '=', $customerDetailId)->get();
                        if(count($files)>0){ 
                        ?>
                        <div class="col-sm-12  list-casefile ">
                            <label class="label-left"   for="last-name">Files :
                            </label>
                            <div class="col-sm-7">
                                <?php foreach($files as $file) { ?>
                                <p>
                                    <a href="<?php echo asset("uploads/files/".$file->file_name);?>" target="_blank">
                                    <?php echo $file->file_name ?>
                                    </a>    
                                </p>
                                <?php } ?>
                                   
                            </div>
                        </div>
                        <?php } ?>
                        
                        <div class="col-sm-12  list-casefile ">
                            <label  class="label-left"  for="last-name">Hereditary Disease :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"> <?php echo $report['customer_hereditary_disease'];?></label>
                            </div>
                        </div>
                        <div class="col-sm-12  list-casefile ">
                            <label class="label-left"  for="last-name">Present Medication :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"> <?php echo $report['customer_present_medication'];?></label>
                            </div>
                        </div>
                        <div class="col-sm-12  list-casefile ">
                            <label class="label-left"   for="last-name">Allergic Reaction :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"> <?php echo $report['customer_allergic_reaction'];?></label>
                            </div>
                        </div>
                        <div class="col-sm-12  list-casefile ">
                            <label class="label-left"   for="last-name">Height :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"> <?php echo $report['customer_height'];?> &nbsp; <?php echo $report['customer_height_unit'];?></label>
                            </div>
                        </div>
                        <div class="col-sm-12  list-casefile ">
                            <label class="label-left"   for="last-name">Weight :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"> <?php echo $report['customer_weight'];?>&nbsp; <?php echo $report['customer_weight_unit'];?></label>
                            </div>
                        </div>
                        <div class="col-sm-12  list-casefile ">
                            <label class="label-left"   for="last-name">Created On :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"> <?php echo date(Config::get('constants.DATE_FORMAT'),  strtotime($report['created_at']));?></label>
                            </div>
                        </div>
                        <div class="col-sm-12  list-casefile ">
                            <label class="label-left"   for="last-name">Updated On :
                            </label>
                            <div class="col-sm-6 ">
                                <label class="label-ans"> <?php echo date(Config::get('constants.DATE_FORMAT'),  strtotime($report['updated_at']));?></label>
                            </div>
                        </div>                                
                    </div>
                    <!-- End: Customer detail section -->
                    <!-- Start: Symptoms section -->
                    <div class="col-sm-12">
                                <?php if(isset($report['symptoms_his']) && count($report['symptoms_his'])>0 ){
                                        $j=1;
                                ?>
                                    <div class="boxqus gainboro">
                                        <div class="   gphd">
                                                <div class="col-sm-12  title">
                                                    <label class=" col-sm-3 " for="last-name"><b>Physical Symptoms</b></label>
                                                </div>

                                        </div>
                                        <?php 
                                            $l=0;$key_mod = array();
                                            foreach($report['symptoms_his'] as $key=>$symptomshis){                                    
                                        ?>
                                        <?php $l++; $key_mod[] = $key; $m =0;?>

                                        <div id="div<?php echo $key;?>" class="sympthisdv">
                                            <?php      
                                            foreach($symptomshis as  $symptoms){ 
                                            ?>

                                                <div class="">
                                                    <div class="col-sm-12  list-casefile "> 
                                                        <div class="col-sm-4">
                                                            <?php if($m==0){ ?>
                                                            <label class=" col-sm-12 " for="last-name"><?php echo $symptoms['symptom_name'];?> </label>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-sm-2"> 
                                                          <?php if($symptoms['symptom_rate'] !=''){ echo $symptoms['symptom_rate'];} ?>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <?php if($symptoms['customer_note'] !=''){ echo $symptoms['customer_note'];} ?>
                                                        </div> 
                                                        <div class="col-sm-3">
                                                         <?php echo date(Config::get('constants.DATE_FORMAT'),  strtotime($symptoms['created_date']));?>
                                                            </div> 
                                                    </div>    
                                                </div>

                                            <?php                                         

                                                     $m++;
                                                }  //foreach ?>

                                        <?php  if($l > 0){  ?>

                                        <?php } ?>    
                                          </div>
                                        <?php }  //foreach $report['symptoms_his']?> 

                                        </div>
                                        <?php  } ?>    

                                </div> 
                    <!-- End: Symptoms section -->
                    
                    <!-- Start: Group  question section -->
                    <div class="col-sm-12">
                    <h4>Questionnaire </h4>
                        <?php if(isset($report['answers']) && count($report['answers'])>0){

                                $group_idarr = array();
                                foreach($report['answers'] as $answers){ ?>
                                    <?php 
                                    if(count($group_idarr)==1 && $answers->group_id!='1'){ ?>
                                    <?php }?>
                    
                                    <?php  if(!in_array($answers->group_id,$group_idarr) && $answers->group_name!=''){
                                        $group_idarr[] = $answers->group_id;
                                     ?>
                                    <div class="col-sm-12 no-pad qus">
                                       
                                            <h5 class="left" for="last-name"><?php echo $answers->group_name;?>
                                            </h5>
                                   
                                     </div>
                                    <?php } ?>
                                    <div>
                                        <div class="col-sm-12  list-casefile ">
                                        <label class="col-sm-12 ">
                                                      <?php $qn_remain ='';
                                                      if (strpos($answers->question,'OPTION') !== false) {
                                                          $pos = strpos($answers->question,'OPTION');
                                                          echo substr($answers->question,0,$pos-1);
                                                          $qn_remain = substr($answers->question,$pos+8);
                                                      }else{?>
                                                     <div><?php    echo $answers->question."";  ?></div>
                                                    <div class="label-ans"><em><?php echo $answers->option_val;?></em></div>
                                                     <?php  }?>
                                                       <?php if($qn_remain != ''){ echo $qn_remain; } ?>
                                        </label>
                                        </div>
                                    </div> 
                        <?php  
                        
                                } 
                        
                        }
                        ?>
                    </div>
                    <!-- End: Group  question section -->                    

                </div>


        </div>
    </div>
</div>
    </div>
    </div>
</main>



<script src="<?php echo asset('js/customer/report.js'); ?>"></script>
@stop