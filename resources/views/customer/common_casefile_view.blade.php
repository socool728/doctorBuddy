<div class="col-lg-12 col-sm-12 col-xs-12">
     <div class="ibox-title">
                <h3>Case File Report</h3>
        </div>                                
    <div class="col-lg-8">
    <div class="ibox float-e-margins">
       <div class="ibox-content">

        	<div class="pull-right m-b">
<!--                                        <div id="pdfdv" class="left text-left">
                                            <a href="<?php //echo asset('pdfreports/'.$report['customer_fileno']);?>.pdf" target="_blank">
                                                <button type="button" class="btn btn-red">PDF</button>
                                             </a>
                                        </div>

                                        <div class="left text-left m-l" id="printdv">
                                            <button type="button" class="btn btn-red print" >Print</button> 
                                        </div>-->
                    <div class="left text-left">
                        <button type="button" class="btn btn-red" customer_detail_id="<?php echo $report['customer_detail_id'] ?>" id="print_pdf_button"> Print PDF</button>
                    </div>
                    <div class="left text-left m-l propagation-area" id="propagation">
                    </div>
                </div>
                <div class="row" id="printable">   <!-- in print sections, make all col-lg-  to col-sm- -->
                    <!-- Start: PDF & Print section -->   
                    <div class="col-sm-12  m-b file-num">
                         <label>File No :<?php echo $report['customer_fileno'];?>      <?php $nil='-NIL-';?>  
                    </div>                            
                    <!-- End: PDF & Print section -->     
                   <!-- Start: Customer detail section -->
                    <div class="col-sm-12">
                    <h4>Basic Information</h4>
<!--                        <div class=" col-sm-12 list-casefile ">  
                            <label class="label-left"  > Email :
                            </label>
                            <div class="col-sm-7">
                                <label class=" "><?php //echo $report['customer_email_id'];?></label>
                            </div>
                        </div>-->
                        <div class=" col-sm-12  list-casefile ">
                            <label class="label-left"   >Nick Name :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"> <?php echo ucfirst($report['customer_nickname']);?></label>
                            </div>
                        </div>
                            <?php if($report['customer_for_whom'] != ''){ ?>
                        <div class="col-sm-12  list-casefile ">
                            <label class="label-left"  for="first-name"> For :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"><?php echo ucfirst($report['customer_for_whom']);?></label>
                            </div>
                        </div>
                            <?php } ?>
                            <?php if($report['customer_age'] != ''){ ?>
                        <div class="col-sm-12  list-casefile ">
                            <label class="label-left"   for="first-name"> Age :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"><?php echo ucfirst($report['customer_age']);?></label>
                            </div>
                        </div>
                            <?php } ?>
                            <?php if($report['customer_sex'] != ''){ ?>
                        <div class="col-sm-12  list-casefile ">
                            <label class="label-left"   for="first-name"> Sex :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"><?php echo ucfirst($report['customer_sex']);?></label>
                            </div>
                        </div>
                            <?php } ?>
                        <div class="col-sm-12  list-casefile ">
                            <label class="label-left"   >Country :
                            </label>
                            <div class="col-sm-7 ">

                                <label class="label-ans"> <?php echo ucfirst($report['customer_country']);?></label>
                            </div>
                        </div>
                        <div class="col-sm-12  list-casefile ">
                            <label class="label-left"   >State :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"> <?php echo ucfirst($report['customer_state']);?></label>
                            </div>
                        </div>
                      <div class="col-sm-12  list-casefile ">
                            <label class="label-left"   >City :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"> <?php echo ucfirst($report['customer_city']);?></label>
                            </div>
                        </div>

<!--                    <div class="col-sm-12  list-casefile ">
                        <label class="label-left"   >Area :
                        </label>
                        <div class="col-sm-7 ">
                            <label class="label-ans"> <?php //echo $report['customer_area'];?></label>
                        </div>
                    </div>    -->

                  <div class="col-sm-12  list-casefile ">
                        <label class="label-left"   >Zipcode :
                        </label>
                        <div class="col-sm-7 ">
                            <label class="label-ans"> <?php echo ucfirst($report['customer_zip']);?></label>
                        </div>
                    </div>                                
						
                        
                  <h4 class="m-t-lg left">Symptoms</h4>
                                  
                  <div class="col-sm-12 m-t-0  list-casefile ">
                            <label class="label-left"  >Let me help you further :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"> <?php echo (!empty($report['known_disease']))? ucfirst($report['known_disease']):$nil;?></label>
                            </div>
                        </div>
			<div class="col-sm-12  list-casefile ">			
                            <label class="label-left"   >Past Illness History :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"> <?php echo (!empty($report['customer_past_illness_history']))? ucfirst($report['customer_past_illness_history']):$nil;?></label>
                            </div>
                        </div>

                        <?php
                        $customerDetailId = $report['customer_detail_id'];
                        $files = DB::table('customer_files')->where('customer_detail_id', '=', $customerDetailId)->get();
                        if(count($files)>0){ 
                        ?>
                        <div class="col-sm-12  list-casefile ">
                            <label class="label-left"   >Files :
                            </label>
                            <div class="col-sm-7 label-ans">
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
                            <label  class="label-left"  >Hereditary Disease :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"> <?php echo (!empty($report['customer_hereditary_disease']))? ucfirst($report['customer_hereditary_disease']):$nil;?></label>
                            </div>
                        </div>
                        <div class="col-sm-12  list-casefile ">
                            <label class="label-left"  >Present Medication :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"> <?php echo (!empty($report['customer_present_medication']))? ucfirst($report['customer_present_medication']):$nil;?></label>
                            </div>
                        </div>
                        <div class="col-sm-12  list-casefile ">
                            <label class="label-left"   >Allergic Reaction :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"> <?php echo (!empty($report['customer_allergic_reaction']))? ucfirst($report['customer_allergic_reaction']):$nil;?></label>
                            </div>
                        </div>
                        <div class="col-sm-12  list-casefile ">
                            <label class="label-left"   >Height :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"> <?php echo $report['customer_height'];?> &nbsp; <?php echo ucfirst($report['customer_height_unit']);?></label>
                            </div>
                        </div>
                        <div class="col-sm-12  list-casefile ">
                            <label class="label-left"   >Weight :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"> <?php echo $report['customer_weight'];?>&nbsp; <?php echo ucfirst($report['customer_weight_unit']);?></label>
                            </div>
                        </div>
                        <div class="col-sm-12  list-casefile ">
                            <label class="label-left"   >Created On :
                            </label>
                            <div class="col-sm-7 ">
                                <label class="label-ans"> <?php echo date(Config::get('constants.DATE_FORMAT'),  strtotime($report['created_at']));?></label>
                            </div>
                        </div>
                        <div class="col-sm-12  list-casefile ">
                            <label class="label-left"   >Updated On :
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
                                        
                                        <div class="col-sm-12  title no-pad qus">
                                            <h5>Physical Symptoms</h5>
                                        </div>

                                        
                                        <div  class="sympthisdv">
                                                <div class="col-sm-12  list-casefile ">
                                                    <div class="col-sm-4"><b>Name</b></div>
                                                    <div class="col-sm-2"><b>Rate</b></div>
                                                    <div class="col-sm-3"><b>Customer Note</b></div>
                                                    <div class="col-sm-3"><b>Date</b></div>
                                                </div>
                                        <?php foreach($report['symptoms_his'] as $key=>$symptomshis){
                                                  
                                            foreach($symptomshis as  $symptoms){ ?>

                                                    <div class="col-sm-12  list-casefile "> 
                                                        <div class="col-sm-4">
                                                            <label class=" col-sm-12 no-pad"><?php echo $symptoms['symptom_name'];?> </label>
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
                                                

                                            <?php }  //foreach ?>

                                        <?php }  //foreach $report['symptoms_his']?> 
                                        </div>    
                                        </div>
                                        <?php  } ?>    

                                </div> 
                    <!-- End: Symptoms section -->
                    
                    <!-- Start: Group  question section -->
                    <div class="col-sm-12">
                    
                        <?php if(isset($report['answers']) && count($report['answers'])>0){?>
<h4>Questionnaire </h4>
                        <?php        $group_idarr = array();
                                foreach($report['answers'] as $answers){ ?>
                                    <?php 
                                    if(count($group_idarr)==1 && $answers->group_id!='1'){ ?>
                                    <?php }?>
                    
                                    <?php  if(!in_array($answers->group_id,$group_idarr) && $answers->group_name!=''){
                                        $group_idarr[] = $answers->group_id;
                                     ?>
                                    <div class="col-sm-8 no-pad qus">                                       
                                            <h5 class="left" ><?php echo $answers->group_name;?></h5>
                                     </div>
                                    <?php } ?>
                                    <div>
                                        <div class="col-sm-12  list-casefile ">
                                        <?php if (strpos($answers->question,'OPTION') !== false) {
                                        

                                                $pos = strpos($answers->question,'OPTION');
                                                $questionFirstPart = substr($answers->question,0,$pos-1);
                                                
                                                if($answers->option_val =="SELECT"){
                                                    $optionVal = "No Answer";
                                                }else{
                                                    $optionVal = $answers->option_val;
                                                }
                                                $answer = "<span class='label-ans'>$optionVal.'</span>";
                                                
                                                $questionLastPart = substr($answers->question,$pos+8);
                                                $fullLine = $questionFirstPart." ".$answer." ".$questionLastPart;
                                                echo "<label class='col-sm-12'>$fullLine </label>";
                                            }else{ 
                                                
                                                echo"<label class='col-sm-12'>$answers->question </label>";
                                                
                                                if($answers->option_val =="SELECT"){
                                                    $optionVal = "No Answer";
                                                }else{
                                                    $optionVal = $answers->option_val;
                                                }
                                                
                                                
                                                echo"<label class='col-sm-12 label-ans'>$optionVal</label>";
     
                                            }
                                            ?>
                                                       
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
<script>
     var SITE_URL = "<?php echo $report['site_url'] ?>"; 
</script>
<script src="<?php echo asset('js/customer/casefile_pdf_print.js'); ?>"></script>