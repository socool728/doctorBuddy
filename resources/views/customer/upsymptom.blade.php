<?php 
if(isset($data['symptoms_his'])){
    if(count($data['symptoms_his'])>0){
       $l=0;$key_mod = array();$m =0;
                 ?>

               <?php foreach($data['symptoms_his'] as $key=>$symptoms){  
     
                   ?>

<?php if($m==0){ ?>



        <div id="updsym<?php echo $data['symptoms_id'];?>" style="display:none;">

       <div class="reportdv">
           <div class="col-md-12 col-sm-6 col-xs-12"> 
               <div class="col-md-4">                                   
                  <label class="control-rpt col-md-12 col-sm-3 col-xs-12" for="last-name"><?php echo $symptoms['symptom_name'];?> </label>                           
               </div>

               <div class="col-md-3">
                   <div class="rate_widget" id="r_<?php echo $symptoms['symptom_id'];?>">

                     <div class="star_1 ratings_plus " data-tooltip="Select severity"></div>
                     <div class="star_2 ratings_plus " data-tooltip="Select severity"></div>
                     <div class="star_3 ratings_plus" data-tooltip="Select severity"></div>
                     <div class="star_4 ratings_plus " data-tooltip="Select severity"></div>
                     <div class="star_5 ratings_plus " data-tooltip="Select severity"></div>    
                     <input name="rate_<?php echo $symptoms['symptom_id'];?>" id="rate_<?php echo $symptoms['symptom_id'];?>" type="hidden" />
                   </div>
               </div>
                   <div class="col-md-3">
                       <input type="text" value="<?php echo $symptoms['customer_note'];?>" name="symcnt_<?php echo $symptoms['symptom_id'];?>" id="symcnt_<?php echo $symptoms['symptom_id'];?>" />
                   </div>




               <div class="col-md-2">
          <button type="button" href="update"  title="Update" onclick="javascript:updatesymptom('<?php echo $data['symptoms_id'];?>');" class="btn btn-secondary" role="button">Update Symptom</button>
               </div> 
           </div>    
       </div>
   </div>

        <div id="editsym<?php echo $data['symptoms_id'];?>">

           <div class="reportdv">
               <div class="col-md-12 col-sm-6 col-xs-12"> 
                   <div class="col-md-4">
                       <?php if($m==0){ ?>
                   <div id="showhis<?php echo $data['symptoms_id'];?>" class="hidedv leftmid">
                       <a href="#" onclick="showsymptom('<?php echo $data['symptoms_id'];?>');">
                        <img src="<?php echo asset('images/plus.png');?>"></a>
                   </div>
                   <div id="hidehis<?php echo $data['symptoms_id'];?>" class="leftmid">
                       <a href="#" onclick="hidesymptom('<?php echo $data['symptoms_id'];?>');"><img src="<?php echo asset('/images/minus.png');?>"></a>
                   </div>
                       <div class="left">
                      <label class="" for="last-name"><?php echo $symptoms['symptom_name'];?> </label>
                       </div>
                     <?php } ?>

                   </div>                             


                   <div class="col-md-1"> 
                       <?php
                       for($i=1;$i<=$symptoms['symptom_rate'];$i++){
                       ?>*
                       <?php } ?>
                   </div>
                   <div class="col-md-3">
                       <?php if($symptoms['customer_note'] !=''){ echo $symptoms['customer_note'];} ?>
                   </div>                                       
                   <div class="col-md-2">
                       <?php echo $symptoms['date_added']; ?>
                   </div> 
                   <div class="col-md-2">
                       <div id="editsympt<?php echo $data['symptoms_id'];?>">
                   <button type="button" href="update"  title="Update" onclick="javascript:editsymptom('<?php echo $data['symptoms_id'];?>');" class="btn btn-secondary" role="button">Edit Symptom</button>
                       </div>
                   </div> 
               </div>    
           </div>

       </div>
         <?php }else{   //m>0?>
                   <?php if($m==1){ ?>
                       <div id="his<?php echo $data['symptoms_id'];?>">
                  <?php } ?>   
               <div class="reportdv">
                   <div class="col-md-12 col-sm-6 col-xs-12"> 
                       <div class="col-md-4">
                           <?php if($m==0){ ?>
                       <div id="showhis<?php echo $data['symptoms_id'];?>" style="display:none;">
                           <a href="#" onclick="showsymptom('<?php echo $data['symptoms_id'];?>');">
                            <img src="<?php echo asset('images/plus.png');?>"></a>
                       </div>
                       <div id="hidehis<?php echo $data['symptoms_id'];?>" >
                           <a href="#" onclick="hidesymptom('<?php echo $data['symptoms_id'];?>');"><img src="<?php echo asset('/images/minus.png');?>"></a>
                       </div>
                          <label class="control-rpt col-md-12 col-sm-3 col-xs-12" for="last-name"><?php echo $symptoms['symptom_name'];?> </label>
                         <?php } ?>

                       </div>


                       <div class="col-md-1"> 
                           <?php
                           for($i=1;$i<=$symptoms['symptom_rate'];$i++){
                           ?>*
                           <?php } ?>
                       </div>
                       <div class="col-md-3">
                           <?php if($symptoms['customer_note'] !=''){ echo $symptoms['customer_note'];} ?>
                       </div>                                       
                       <div class="col-md-2">
                           <?php echo $symptoms['date_added']; ?>
                       </div> 
                       <div class="col-md-2">

                       </div> 
                   </div>    
               </div>
               <?php if(count($data['symptoms_his']) == $m+1){ ?>
                   </div>
        <?php      }                                      
               } //m>0
                $m++;
           }  //foreach ?>




       <?php } } ?>