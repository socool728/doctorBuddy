@extends('layouts.customerlayout')
@section('content')
<div class="col-lg-12">
@include('healthcare_professional.dashboardmenu')
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
                <h3>Case File Report</h3>
        </div>
        <div class="ibox-content">
            <?php $printId=1;  ?>
            <?php $report = $data['report']; ?>

            <div class="row" id="printable_<?php echo $printId ?>">
                 <!-- Start: PDF & Print section -->
                 <div class="col-lg-12  m-b-xl">
                     <div class="col-lg-12">
                                 <div class="col-lg-6 text-left" >
                                     <label>FIle No :<?php echo $report['customer_fileno'];?>                                       </label>
                                 </div>
                                 <div class="col-lg-6">
                                     <div id="pdfdv_<?php echo $printId ?>" class="col-lg-3 text-left">
                                         <a href="<?php echo asset('pdfreports/'.$report['customer_fileno']);?>.pdf" target="_blank">
                                             <button type="button" class="btn btn-primary">PDF</button>
                                          </a>
                                     </div>

                                     <div class="col-lg-3 text-left" id="printdv_<?php echo $printId ?>">
                                         <button type="button" class="btn btn-primary print" print-id="<?php echo $printId ?>">Print</button> 
                                     </div>
                                 </div>

                     </div>   
                 </div>                            
                 <!-- End: PDF & Print section -->     
                <!-- Start: Customer detail section -->
                 <div class="col-lg-12 small">
                  <!--   <div class=" col-lg-12 list-casefile ">  
                         <label class=" col-lg-5 " for="last-name"> Email :
                         </label>
                         <div class="col-lg-7">
                             <label class=" "><strong><?php echo $report['customer_email_id'];?></strong></label>
                         </div>
                     </div>-->
                     <div class=" col-lg-12  list-casefile ">
                         <label class=" col-lg-5 " for="last-name">Nick Name :
                         </label>
                         <div class="col-lg-7 ">
                             <label class=""><strong> <?php echo $report['customer_nickname'];?></strong></label>
                         </div>
                     </div>
                         <?php if($report['customer_for_whom'] != ''){ ?>
                     <div class="col-lg-12  list-casefile ">
                         <label class=" col-lg-5 " for="first-name"> For :
                         </label>
                         <div class="col-lg-7 ">
                             <label class=""><strong><?php echo $report['customer_for_whom'];?></strong></label>
                         </div>
                     </div>
                         <?php } ?>
                         <?php if($report['customer_age'] != ''){ ?>
                     <div class="col-lg-12  list-casefile ">
                         <label class=" col-lg-5 " for="first-name"> Age :
                         </label>
                         <div class="col-lg-7 ">
                             <label class=""><strong><?php echo $report['customer_age'];?></strong></label>
                         </div>
                     </div>
                         <?php } ?>
                         <?php if($report['customer_sex'] != ''){ ?>
                     <div class="col-lg-12  list-casefile ">
                         <label class=" col-lg-5 " for="first-name"> Sex :
                         </label>
                         <div class="col-lg-7 ">
                             <label class=""><strong><?php echo $report['customer_sex'];?></strong></label>
                         </div>
                     </div>
                         <?php } ?>
                     <div class="col-lg-12  list-casefile ">
                         <label class=" col-lg-5 " for="last-name">Country :
                         </label>
                         <div class="col-lg-7 ">

                             <label class=""><strong> <?php echo $report['customer_country'];?></strong></label>
                         </div>
                     </div>
                     <div class="col-lg-12  list-casefile ">
                         <label class=" col-lg-5 " for="last-name">State :
                         </label>
                         <div class="col-lg-7 ">
                             <label class=""> <strong><?php echo $report['customer_state'];?></strong></label>
                         </div>
                     </div>
                   <div class="col-lg-12  list-casefile ">
                         <label class=" col-lg-5 " for="last-name">City :
                         </label>
                         <div class="col-lg-7 ">
                             <label class=""> <strong><?php echo $report['customer_city'];?></strong></label>
                         </div>
                     </div>

                 <div class="col-lg-12  list-casefile ">
                     <label class=" col-lg-5 " for="last-name">Area :
                     </label>
                     <div class="col-lg-7 ">
                         <label class=""> <strong><?php echo $report['customer_area'];?></strong></label>
                     </div>
                 </div>    

               <div class="col-lg-12  list-casefile ">
                     <label class=" col-lg-5 " for="last-name">Zipcode :
                     </label>
                     <div class="col-lg-7 ">
                         <label class=""> <strong><?php echo $report['customer_zip'];?></strong></label>
                     </div>
                 </div>                                

                     <div class="col-lg-12 m-t-0  list-casefile ">
                         <label class=" col-lg-5 " for="last-name">Known Disease :
                         </label>
                         <div class="col-lg-7 ">
                             <label class=""> <strong><?php echo $report['known_disease'];?></strong></label>
                         </div>
                     </div>





                     <div class="col-lg-12  list-casefile ">
                         <label class=" col-lg-5 " for="last-name">Past Illness History :
                         </label>
                         <div class="col-lg-7 ">
                             <label class=""> <strong><?php echo $report['customer_past_illness_history'];?></strong></label>
                         </div>
                     </div>

                     <div class="col-lg-12  list-casefile ">
                         <label class=" col-lg-5 " for="last-name">Medical Report :
                         </label>
                         <div class="col-lg-7 ">
                             <label class=""> 
                                 <?php if(isset($report['customer_medicalreport']) && $report['customer_medicalreport'] !='') : ?>
                                 <strong>
                                     <a href="<?php echo asset("uploads/files/".$report['customer_medicalreport']);?>">
                                         Download 
                                     </a>    
                                 </strong>
                                 <?php endif;?>
                             </label>
                         </div>
                     </div>

                     <div class="col-lg-12  list-casefile ">
                         <label class=" col-lg-5 " for="last-name">Hereditary Disease :
                         </label>
                         <div class="col-lg-7 ">
                             <label class=""> <strong><?php echo $report['customer_hereditary_disease'];?></strong></label>
                         </div>
                     </div>
                     <div class="col-lg-12  list-casefile ">
                         <label class=" col-lg-5 " for="last-name">Present Medication :
                         </label>
                         <div class="col-lg-7 ">
                             <label class=""> <strong><?php echo $report['customer_present_medication'];?></strong></label>
                         </div>
                     </div>
                     <div class="col-lg-12  list-casefile ">
                         <label class=" col-lg-5 " for="last-name">Allergic Reaction :
                         </label>
                         <div class="col-lg-7 ">
                             <label class=""> <strong><?php echo $report['customer_allergic_reaction'];?></strong></label>
                         </div>
                     </div>
                     <div class="col-lg-12  list-casefile ">
                         <label class=" col-lg-5 " for="last-name">Height :
                         </label>
                         <div class="col-lg-7 ">
                             <label class=""> <strong><?php echo $report['customer_height'];?> &nbsp; <?php echo $report['customer_height_unit'];?></strong></label>
                         </div>
                     </div>
                     <div class="col-lg-12  list-casefile ">
                         <label class=" col-lg-5 " for="last-name">Weight :
                         </label>
                         <div class="col-lg-7 ">
                             <label class=""> <strong><?php echo $report['customer_weight'];?>&nbsp; <?php echo $report['customer_weight_unit'];?></strong></label>
                         </div>
                     </div>
                     <div class="col-lg-12  list-casefile ">
                         <label class=" col-lg-5 " for="last-name">Created On :
                         </label>
                         <div class="col-lg-7 ">
                             <label class=""> <strong><?php echo $report['created_at'];?></strong></label>
                         </div>
                     </div>
                     <div class="col-lg-12  list-casefile ">
                         <label class=" col-lg-5 " for="last-name">Updated On :
                         </label>
                         <div class="col-lg-6 ">
                             <label class=""> <strong><?php echo $report['updated_at'];?></strong></label>
                         </div>
                     </div>                                
                 </div>
                 <!-- End: Customer detail section -->
                 <!-- Start: Symptoms section -->
                 <div class="col-lg-12 small">
                             <?php if(isset($report['symptoms_his']) && count($report['symptoms_his'])>0 ){
                                     $j=1;
                             ?>
                                 <div class="boxqus gainboro">
                                     <div class="   gphd">
                                             <div class="col-lg-12  title">
                                                 <label class=" col-lg-3 " for="last-name">Physical Symptoms</label>
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
                                                 <div class="col-lg-12  list-casefile "> 
                                                     <div class="col-lg-4">
                                                         <?php if($m==0){ ?>
                                                         <label class=" col-lg-12 " for="last-name"><?php echo $symptoms['symptom_name'];?> </label>
                                                         <?php } ?>
                                                     </div>
                                                     <div class="col-lg-2"> <?php
                                                       for($i=1;$i<=$symptoms['symptom_rate'];$i++){
                                                       ?>*
                                                       <?php } ?>
                                                     </div>
                                                     <div class="col-lg-3">
                                                         <?php if($symptoms['customer_note'] !=''){ echo $symptoms['customer_note'];} ?>
                                                     </div> 
                                                     <div class="col-lg-3">
                                                      <?php echo $symptoms['date_added']; ?>
                                                         </div> 
                                                 </div>    
                                             </div>

                                         <?php                                         

                                                  $m++;
                                             }  //foreach ?>

                                     <?php  if($l > 0){  ?>

                                             <div class="col-lg-12  list-casefile ">

                                             </div>
                                     <?php } ?>    
                                       </div>
                                     <?php }  //foreach $report['symptoms_his']?> 

                                     </div>
                                     <?php  } ?>    

                             </div> 
                 <!-- End: Symptoms section -->

                 <!-- Start: Group  question section -->
                 <div class="col-lg-12 small">
                     <?php if(isset($report['answers']) && count($report['answers'])>0){

                             $group_idarr = array();
                             foreach($report['answers'] as $answers){ ?>
                                 <?php 
                                 if(count($group_idarr)==1 && $answers->group_id!='1'){ ?>
                                 <?php }?>
                                 <?php  if(!in_array($answers->group_id,$group_idarr) && $answers->group_name!=''){
                                     $group_idarr[] = $answers->group_id;
                                  ?>
                                 <div class="   gphd">
                                    <div class="col-lg-12  title">
                                         <label class=" col-lg-12 " for="last-name"><?php echo $answers->group_name;?>
                                         </label>
                                     </div>
                                  </div>
                                 <?php } ?>
                                 <div class="   ">
                                     <div class="col-lg-12  list-casefile ">
                                     <label class=" col-lg-12 " for="last-name">
                                                   <?php $qn_remain ='';
                                                   if (strpos($answers->question,'OPTION') !== false) {
                                                       $pos = strpos($answers->question,'OPTION');
                                                       echo substr($answers->question,0,$pos-1);
                                                       $qn_remain = substr($answers->question,$pos+8);
                                                   }else{?>
                                                  <?php    echo $answers->question.":";  ?>
                                                 <?php  }?><em><strong><?php echo $answers->option_val;?></strong></em>
                                                    <?php if($qn_remain != ''){ echo $qn_remain; } ?>
                                             </label>
                                     </div>
                                 </div> 
                     <?php  } }?>
                 </div>
                 <!-- End: Group  question section -->                    

             </div>
            <?php $printId ++; ?>
            
        </div>
        
        
        
        <!--
        <div class="ibox-content  margin-top-20" style="border:1px solid grey;border-radius:10px">
            <form action="javascript:void(0);"  id="form_pdf_send" method="POST" class="m-t">
                <div class="margin-top-20">
                    <div id="pdf-message"  class="hide">
                        <div id="pdf-message-text"></div>
                    </div>
                </div>
                
                <div class="row  m-b">
                    <div class="form-group">
                        <div class="col-lg-4">
                            <label class="white-label " for="healthcare_professional_password"> Forward it as Pdf</label>
                        </div>
                        <div class="col-lg-6 item">
                            <input  id="forward_email" name="forward_email"  required="required" title="Forward Email" class="form-control" type="email" placeholder="Email Address">
                        </div>

                    </div>                    
                </div>


                <div class="row  m-b">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-6">
                        <button  onclick="return send_pdf();"type="submit"  title="Register"  class="btn btn-primary" role="button">Send</button>
                        <input type="hidden" name="form_submit" value="save">
                        <?php if(isset($data['customer_detail_id']) && $data['customer_detail_id'] != '') : ?>
                        <input type="hidden" name="customer_detail_id" value="<?php echo $data['customer_detail_id'] ?>">
                        <?php endif; ?>
                    </div>                                    
                </div>                
            </form>

         </div>
        -->
        
<?php //$caseFileToHealthCareObj =DB::table('casefile_to_healthcare')->where("casefile_to_healthcare_id","=",$data['casefile_to_healthcare_id'])->first();?>        
            
        <?php //if($caseFileToHealthCareObj->payment_status !=1) {  // Payment is not done?>
        <div class="ibox-content margin-top-20" style="border:1px solid grey;border-radius:10px">
                <form action="javascript:void(0);"  id="form_healthcare_openion" method="POST" class="m-t">
                          
                    <div class="margin-top-20">
                        <div id="openion-message"  class="hide">
                            <div id="openion-message-text"></div>
                        </div>
                    </div>
                    
                    <div class="row  m-b">
                        <div class="form-group">
                            <div class="col-lg-4">
                                <label class="white-label " for="healthcare_professional_password"> Comments to Customer</label>
                            </div>
                            <div class="col-lg-6 item">
                                <textarea name="healthcare_comment" id="healthcare_comment" required="required"  title="Your comments to the Customer" class="form-control"><?php //echo $caseFileToHealthCareObj->healthcare_comment ?></textarea>
                            </div>

                        </div>
                    </div>
                    <div class="row  m-b">    
                        <div class="form-group">
                            <div class="col-lg-4">
                                <label class="white-label " for="healthcare_professional_password">Your Charge</label>
                            </div>
                            <div class="col-lg-6 item">
                                <input type="text" id="healthcare_charge" name="healthcare_charge" required="required" title="Your Charge" class="form-control"  value="<?php //echo $caseFileToHealthCareObj->healthcare_charge ?>">
                            </div>
                            <label class="white-label col-lg-1 no-padding">$</label>
                        </div>                         
                    </div>                    
 

                    
                    <div class="row  m-b">
                            <div class="col-lg-4">
                            </div>
                            <div class="col-lg-6">

                                <button  onclick="return validate_healthcare_openion();"type="submit"  title="Register"  class="btn btn-primary" role="button">Save</button>
                                <input type="hidden" name="form_submit" value="save">
                                <input type="hidden" name="healthcare_professional_id" value="<?php echo Session::get('hp_id')?>">
                                <?php if(isset($data['customer_detail_id']) && $data['customer_detail_id'] != '') : ?>
                                <input type="hidden" name="customer_detail_id" value="<?php echo $data['customer_detail_id'] ?>">
                                <?php endif; ?>                        
                            </div>                            
                                               
                    
                    </div> 
                </form>
                
            </div>    
        <?php //} ?>
               
    </div>
</div>
</div>
<script>
    var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>
<script src="<?php echo asset('js/healthcare_professional/case_report.js'); ?>"></script>

@stop