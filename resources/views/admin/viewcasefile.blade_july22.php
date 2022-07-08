@extends('layouts.adminlayout')
@section('content')

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Report</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <?php $report = $data['report']; ?>
    <div class="row">
        <div class="col-sm-12" id="printable">
            <div class="x_panel">
                <!-- Start: PDF & Print section -->
                                            
                <div class="col-sm-12">
                    <div class="col-sm-6">FIle No :&nbsp;<b><?php echo $report['customer_fileno'];?></b></div>
                    <div class="col-sm-6">
                                 <div id="pdfdv" class="col-sm-6 text-right">
                                     <a href="<?php echo asset('pdfreports/'.$report['customer_fileno']);?>.pdf" target="_blank">
                                         <button type="button" class="btn btn-primary">PDF</button>
                                      </a>
                                 </div>   
                                 <div class="col-sm-6 text-right" id="printdv">
                                     <button type="button" class="btn btn-primary print">Print</button> 
                                 </div>                            
                    </div>
                </div>
                    
                <!-- End: PDF & Print section --> 
                <br><br>
                <div class="x_content">
           
            
            <div class="row" >
    
                <!-- Start: Customer detail section -->
                 <div class="col-sm-12 ">
                  <!--   <div class=" col-sm-12 reportdv list-casefile ">  
                         <label class=" col-sm-5 " for="last-name"> Email :
                         </label>
                         <div class="col-sm-7">
                             <label class=" "><?php //echo $report['customer_email_id'];?></label>
                         </div>
                     </div>-->
                     <div class=" col-sm-12  reportdv list-casefile ">
                         <label class=" col-sm-5 control-rpt " for="last-name">Nick Name :
                         </label>
                         <div class="col-sm-7 ">
                             <label class="control-rpt"> <?php echo $report['customer_nickname'];?></label>
                         </div>
                     </div>
                         <?php if($report['customer_for_whom'] != ''){ ?>
                     <div class="col-sm-12  reportdv list-casefile ">
                         <label class=" col-sm-5 " for="first-name"> For :
                         </label>
                         <div class="col-sm-7 ">
                             <label class=""><?php echo $report['customer_for_whom'];?></label>
                         </div>
                     </div>
                         <?php } ?>
                         <?php if($report['customer_age'] != ''){ ?>
                     <div class="col-sm-12  reportdv list-casefile ">
                         <label class=" col-sm-5 " for="first-name"> Age :
                         </label>
                         <div class="col-sm-7 ">
                             <label class=""><?php echo $report['customer_age'];?></label>
                         </div>
                     </div>
                         <?php } ?>
                         <?php if($report['customer_sex'] != ''){ ?>
                     <div class="col-sm-12  reportdv list-casefile ">
                         <label class=" col-sm-5 " for="first-name"> Sex :
                         </label>
                         <div class="col-sm-7 ">
                             <label class=""><?php echo $report['customer_sex'];?></label>
                         </div>
                     </div>
                         <?php } ?>
                     <div class="col-sm-12  reportdv list-casefile ">
                         <label class=" col-sm-5 " for="last-name">Country :
                         </label>
                         <div class="col-sm-7 ">

                             <label class=""> <?php echo $report['customer_country'];?></label>
                         </div>
                     </div>
                     <div class="col-sm-12  reportdv list-casefile ">
                         <label class=" col-sm-5 " for="last-name">State :
                         </label>
                         <div class="col-sm-7 ">
                             <label class=""> <?php echo $report['customer_state'];?></label>
                         </div>
                     </div>
                   <div class="col-sm-12  reportdv list-casefile ">
                         <label class=" col-sm-5 " for="last-name">City :
                         </label>
                         <div class="col-sm-7 ">
                             <label class=""> <?php echo $report['customer_city'];?></label>
                         </div>
                     </div>

                 <div class="col-sm-12  reportdv list-casefile ">
                     <label class=" col-sm-5 " for="last-name">Area :
                     </label>
                     <div class="col-sm-7 ">
                         <label class=""> <?php echo $report['customer_area'];?></label>
                     </div>
                 </div>    

               <div class="col-sm-12  reportdv list-casefile ">
                     <label class=" col-sm-5 " for="last-name">Zipcode :
                     </label>
                     <div class="col-sm-7 ">
                         <label class=""> <?php echo $report['customer_zip'];?></label>
                     </div>
                 </div>                                

                     <div class="col-sm-12 m-t-0  reportdv list-casefile ">
                         <label class=" col-sm-5 " for="last-name">Known Disease :
                         </label>
                         <div class="col-sm-7 ">
                             <label class=""> <?php echo $report['known_disease'];?></label>
                         </div>
                     </div>





                     <div class="col-sm-12  reportdv list-casefile ">
                         <label class=" col-sm-5 " for="last-name">Past Illness History :
                         </label>
                         <div class="col-sm-7 ">
                             <label class=""> <?php echo $report['customer_past_illness_history'];?></label>
                         </div>
                     </div>

                        <?php
                        $customerDetailId = $report['customer_detail_id'];
                        $files = DB::table('customer_files')->where('customer_detail_id', '=', $customerDetailId)->get();
                        if(count($files)>0){ 
                        ?>
                        <div class="col-sm-12  reportdv list-casefile ">
                            <label class=" col-sm-5 " for="last-name">Files :
                            </label>
                            <div class="col-sm-7 ">
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
                  

                        <!-- Drop box files listing  -->
                        
                        <?php
                        $dropboxFiles = $report['dropbox_files'];
                        if(count($dropboxFiles)>0){
                        ?>
                        <div class="col-sm-12  reportdv list-casefile ">
                            <label class=" col-sm-5 " for="last-name">Drop Box Files :
                            </label>
                            <div class="col-sm-7 ">
                                <?php foreach($dropboxFiles as $dropboxFile) { ?>
                                <p>
                                    <a href="<?php echo $dropboxFile ;?>" target="_blank">
                                    <?php echo $dropboxFile ?>
                                    </a>    
                                </p>
                                <?php } ?>
                                   
                            </div>
                        </div>
                        <?php } ?>
                                                
                                                
                     <div class="col-sm-12  reportdv list-casefile ">
                         <label class=" col-sm-5 " for="last-name">Hereditary Disease :
                         </label>
                         <div class="col-sm-7 ">
                             <label class=""> <?php echo $report['customer_hereditary_disease'];?></label>
                         </div>
                     </div>
                     <div class="col-sm-12  reportdv list-casefile ">
                         <label class=" col-sm-5 " for="last-name">Present Medication :
                         </label>
                         <div class="col-sm-7 ">
                             <label class=""> <?php echo $report['customer_present_medication'];?></label>
                         </div>
                     </div>
                     <div class="col-sm-12  reportdv list-casefile ">
                         <label class=" col-sm-5 " for="last-name">Allergic Reaction :
                         </label>
                         <div class="col-sm-7 ">
                             <label class=""> <?php echo $report['customer_allergic_reaction'];?></label>
                         </div>
                     </div>
                     <div class="col-sm-12  reportdv list-casefile ">
                         <label class=" col-sm-5 " for="last-name">Height :
                         </label>
                         <div class="col-sm-7 ">
                             <label class=""> <?php echo $report['customer_height'];?> &nbsp; <?php echo $report['customer_height_unit'];?></label>
                         </div>
                     </div>
                     <div class="col-sm-12  reportdv list-casefile ">
                         <label class=" col-sm-5 " for="last-name">Weight :
                         </label>
                         <div class="col-sm-7 ">
                             <label class=""> <?php echo $report['customer_weight'];?>&nbsp; <?php echo $report['customer_weight_unit'];?></label>
                         </div>
                     </div>
                     <div class="col-sm-12  reportdv list-casefile ">
                         <label class=" col-sm-5 " for="last-name">Created On :
                         </label>
                         <div class="col-sm-7 ">
                             <label class=""> 
                                 <?php echo date(Config::get('constants.DATE_TIME_FORMAT'),  strtotime($report['created_at']));?></label>
                         </div>
                     </div>
                     <div class="col-sm-12  reportdv list-casefile ">
                         <label class=" col-sm-5 " for="last-name">Updated On :
                         </label>
                         <div class="col-sm-6 ">
                             <label class=""> <?php echo date(Config::get('constants.DATE_TIME_FORMAT'),  strtotime($report['updated_at']));?></label>
                         </div>
                     </div>                                
                 </div>
                 <!-- End: Customer detail section -->
                 <!-- Start: Symptoms section -->
                 <div class="col-sm-12 ">
                             <?php if(isset($report['symptoms_his']) && count($report['symptoms_his'])>0 ){
                                     $j=1;
                             ?>
                                 <div class="boxqus gainboro">
                                     <div class="">
                                             <div class="col-sm-12  title">
                                                 <label class=" col-sm-3 " for="last-name">Physical Symptoms</label>
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
                                                 <div class="col-sm-12  reportdv list-casefile "> 
                                                     <div class="col-sm-4">
                                                         <?php if($m==0){ ?>
                                                         <label class=" col-sm-12 " for="last-name"><?php echo $symptoms['symptom_name'];?> </label>
                                                         <?php } ?>
                                                     </div>
                                                     <div class="col-sm-2"> <?php
                                                       for($i=1;$i<=$symptoms['symptom_rate'];$i++){
                                                       ?>*
                                                       <?php } ?>
                                                     </div>
                                                     <div class="col-sm-3">
                                                         <?php if($symptoms['customer_note'] !=''){ echo $symptoms['customer_note'];} ?>
                                                     </div> 
                                                     <div class="col-sm-3">
                                                      <?php echo date(Config::get('constants.DATE_TIME_FORMAT'),  strtotime($symptoms['created_date'])); ?>                       
                                                      </div> 
                                                 </div>    
                                             </div>

                                         <?php                                         

                                                  $m++;
                                             }  //foreach ?>

                                     <?php  if($l > 0){  ?>

                                             <div class="col-sm-12  reportdv list-casefile ">

                                             </div>
                                     <?php } ?>    
                                       </div>
                                     <?php }  //foreach $report['symptoms_his']?> 

                                     </div>
                                     <?php  } ?>    

                             </div> 
                 <!-- End: Symptoms section -->

                 <!-- Start: Group  question section -->
                 <div class="col-sm-12 ">
                     <?php if(isset($report['answers']) && count($report['answers'])>0){

                             $group_idarr = array();
                             foreach($report['answers'] as $answers){ ?>
                                 <?php 
                                 if(count($group_idarr)==1 && $answers->group_id!='1'){ ?>
                                 <?php }?>
                                 <?php  if(!in_array($answers->group_id,$group_idarr) && $answers->group_name!=''){
                                     $group_idarr[] = $answers->group_id;
                                  ?>
                                 <div class="">
                                    <div class="col-sm-12  title">
                                         <label class=" col-sm-12 " for="last-name"><?php echo $answers->group_name;?>
                                         </label>
                                     </div>
                                  </div>
                                 <?php } ?>
                                 <div class="   ">
                                     <div class="col-sm-12  reportdv list-casefile ">
                                     <label class=" col-sm-12 " for="last-name">
                                                   <?php $qn_remain ='';
                                                   if (strpos($answers->question,'OPTION') !== false) {
                                                       $pos = strpos($answers->question,'OPTION');
                                                       echo substr($answers->question,0,$pos-1);
                                                       $qn_remain = substr($answers->question,$pos+8);
                                                   }else{?>
                                                  <?php    echo $answers->question.":";  ?>
                                                 <?php  }?><em><?php echo $answers->option_val;?></em>
                                                    <?php if($qn_remain != ''){ echo $qn_remain; } ?>
                                             </label>
                                     </div>
                                 </div> 
                     <?php  } }?>
                 </div>
                 <!-- End: Group  question section -->                    

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
<script src="<?php echo asset('js/admin/view_casefile.js'); ?>"></script>
@stop
