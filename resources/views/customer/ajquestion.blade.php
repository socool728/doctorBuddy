<div class="question-page-3" id="question">
        <?php 
        if(is_numeric($question_id)){
            $idnext=$question_id+1;
        }else{
            $idnext= "f";
        }
        if(count($question)>0){                                        
            if($question_id==1){
            ?>
         <div class="item form-group">
             <div class="col-xs-12 col-sm-6 col-md-6">
                 <label class="control-label" for="first-name">Country</label>
             </div>
             
             <div class="col-md-6 col-sm-6 col-xs-12">
                 <div class="qnoption">
                    <?php if(count($country)>0){ ?>
                     <select class="form-control" name="country" title="Country" id="country">
                          <option value="0" >Select Country</option>
                         <?php 
                         foreach($country as $val){  ?>
                         <option value="<?php echo $val['country_id'];?>" ><?php echo $val['countryname'];?></option>
                    <?php } ?>
                     </select>
                    <?php } ?>                 
                 </div>
                 <div class="alertnck" id="ercntry" style="display:none;" >Please Select country</div>
             </div>
        </div>
    
        <div class="form-group">
            <div class="col-xs-12 col-sm-6 col-md-6">
             <label class="control-label" for="first-name">State</label>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="" id="stated">
                  <input id="statedelt" name="state" value="" title="State"  class="frm-control col-md-7 col-xs-12" type="text">  
                  <div class="alertnck" id="erstate" style="display:none;" >Please Enter State</div>
            </div><div class="qnoption" id="statedv"></div>
            </div>
        </div>
        
        <div class="item form-group">
            <div class="col-xs-12 col-sm-6 col-md-6">
             <label class="control-label" for="first-name">City/Area</label>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                 <input id="city" name="city" value="" title="City" required="required" class="frm-control col-md-7 col-xs-12" type="text">
            </div>
        </div>
             
        <div class="item form-group">
            <div class="col-xs-12 col-sm-6 col-md-6">
             <label class="control-label" for="first-name">ZIP/Postal Code</label>
            </div>
             <div class="col-md-5 col-sm-5 col-xs-12">
                 <input id="zip" name="zip" value="" title="number value in zip" required="required" class="frm-control col-md-7 col-xs-12" type="number">
             </div>
        </div>
                                        <?php }
                                        foreach($question as $questiondetails){
                                            $hide = 0;
                                            if($questiondetails['depend'] ==1){  
                                                $hide = 1;
//                                                print_r($depend);
//                                                echo "BB".$questiondetails['depend_ans']."AA<br>";
                                                if(isset($depend[$questiondetails['depend_qn']])){
                                                    $ans_depend = explode(",",$questiondetails['depend_ans']);
//                                                    print_r($ans_depend);
                                                    if(count($depend[$questiondetails['depend_qn']])>0){
                                                        foreach($depend[$questiondetails['depend_qn']] as $selans){
//                                                        if(in_array($depend[$questiondetails['depend_qn']],$ans_depend)){
//                                                            $hide = 0;
//                                                        }
                                                            if(in_array($selans,$ans_depend)){
                                                                $hide = 0;
                                                            }
                                                        }
                                                    }
                                                }
//                                                echo $questiondetails['question'].$questiondetails['question_id']."<br><br>";
                                            }if($hide ==0){
                                            ?>
                                          
                                        <div class="item form-group">
                                            <div class="col-xs-12 col-sm-6 col-md-6">
                                            <label class="control-label" for="first-name">
                                                <?php $qn_remain ='';
                                                if (strpos($questiondetails['question'],'OPTION') !== false) {
                                                    $pos = strpos($questiondetails['question'],'OPTION');
                                                    echo substr($questiondetails['question'],0,$pos-1);
                                                    $qn_remain = substr($questiondetails['question'],$pos+8);
                                                }else{
                                                echo $questiondetails['question'];                                                
                                        }?> 
                                            </label>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-6">
                                                 <?php if ($questiondetails['question_type'] == 'text') { ?>
                                                <input data-parsley-id="3638" name="<?php echo $questiondetails['question_id'];?>" <?php if($questiondetails['field_required']==1){?> required="required" <?php } ?> title="<?php echo $questiondetails['validator_title'];?>" value="" class="frm-control col-md-7 col-xs-12 <?php if($qn_remain != ''){?> form-qn <?php } ?>" type="text">   <?php if($qn_remain != ''){ echo '<label>&nbsp;'.$qn_remain.'</label>';} ?>
                                                 <?php } else if ($questiondetails['question_type'] == 'textarea') { ?>
                                        <textarea class="form-control <?php if($qn_remain != ''){?> form-qn <?php } ?>" <?php if($questiondetails['field_required']==1){?> required="required" <?php } ?>  name="<?php echo $questiondetails['question_id']; ?>"></textarea>   <?php if($qn_remain != ''){ echo '<label>&nbsp;'.$qn_remain.'</label>';} ?>
                                                 <?php } else if ($questiondetails['question_type'] == 'radio') { ?>
                                        <div class="radio">
                                                       <?php  $i =0;
                                                       foreach ($questiondetails['option_arr'] as $val) {
                                                           ?><label>
                                            <input type="radio" name="<?php echo $questiondetails['question_id'];?>" <?php if($i==0){?>checked="checked"<?php } ?> value="<?php echo $val['option_id'];?>" ><?php echo $val['option_name'];?> </label>
                                                        <?php $i++; } 
                                        if($qn_remain != ''){ echo '<label class="lblradio">&nbsp;'.$qn_remain.'</label>';}?>
                                        </div>
                                                <?php } else if ($questiondetails['question_type'] == 'select') { 
                                                        if(count($questiondetails['option_arr'])>0) {
                                                            ?>
                                        <div class="qnoption">
                                                            <select class="form-control <?php if($qn_remain != ''){?> form-qn <?php } ?>"  name="<?php echo $questiondetails['question_id'];?>" <?php if($questiondetails['field_required']==1){?> required="required" <?php } ?> title="<?php echo $questiondetails['validator_title'];?>">
                                                           <?php if($questiondetails['field_required']==1){?>      <option value="">Select</option><?php } ?>
                                                        <?php foreach ($questiondetails['option_arr'] as $val) { ?>
                                                                    <option value="<?php echo $val['option_id'];?>" ><?php echo $val['option_name'];?></option>
                                                    <?php } ?>
                                                            </select>
                                        </div>
                                        <?php if($qn_remain != ''){ echo '<div class="qnoption"><label>&nbsp;'.$qn_remain.'</label></div>';} ?>
                                                        <?php } ?>
                                                <?php } else if ($questiondetails['question_type'] == 'check') { 
                                                        if(count($questiondetails['option_arr'])>0) {
                                                             $totcnt = count($questiondetails['option_arr']);
                                                             foreach ($questiondetails['option_arr'] as $val) { ?>
                                        <div class="checkbox">
                                            <label><div class="icheckbox_flat-green">
                                                    <input <?php if($questiondetails['field_required']==1){?> required="required" <?php } ?> class="<?php echo $totcnt;?>" type="checkbox" name="<?php echo $questiondetails['question_id'];?>" value="<?php echo $val['option_id']; ?>" title="<?php echo $questiondetails['validator_title'];?>" ><?php echo $val['option_name'];?></div></label></div>
                                                    <?php } ?>
                                        <input type="hidden" name="chkbxqn_<?php echo $questiondetails['question_id'];?>" value="<?php echo $questiondetails['question_id'];?>" />
                                                        <?php } ?>
                                           <?php if($qn_remain != ''){ echo '<label>'.$qn_remain.'</label>';} ?>
                                                <?php } ?>
                                                <ul id="parsley-id-3638" class="parsley-errors-list"></ul>
                                                
                                            </div>
                                        </div> 
                                    <?php }
                                        }//hide
                                     }?>
                                     
                                     <input name="group_id" type="hidden" value="<?php echo $question_id;?>" />
                                     <div class="next">
                                          <a class="btn btn-primary" onclick="prevqn('<?php echo $question_id;?>')">BACK</a>  
                                        <a class="btn btn-primary" onclick="getqn('<?php echo $idnext;?>')">NEXT</a>                                      
                                      
                                    </div>
    </div>
                                      
<div class="leftsidebar animated slideInLeft1 active1" style="color:#fff;">
<div class="style-toggle"></div>
<div class="text-wrap">
    <?php
    if(isset($customer_data)){
        //print_r($customer_data);
        ?>
    <div class="reportdv">
                <label class="seldisp" for="last-name"><?php echo $customer_data['customer_nickname'];?>
                </label>
            </div>
    <?php if(isset($customer_data['customer_country'])){ ?>
        <div class="reportdv">
                <label class="seldisp" for="last-name"><?php echo $customer_data['customer_country'];?>
                </label>
            </div>
    <?php } if(isset($customer_data['customer_state'])){ ?>
    <div class="reportdv">
                <label class="seldisp" for="last-name"><?php echo $customer_data['customer_state'];?>
                </label>
            </div>
     <?php } if(isset($customer_data['customer_city'])){ ?>
    <div class="reportdv">
                <label class="seldisp" for="last-name"><?php echo $customer_data['customer_city'];?>
                </label>
            </div>
     <?php } if(isset($customer_data['customer_zip'])){ ?>
     <div class="reportdv">
                <label class="seldisp" for="last-name"><?php echo $customer_data['customer_zip'];?>
                </label>
            </div>
    <?php } }
    if(isset($sel_symptom)){
        if(count($sel_symptom)>0){
             $j=1;
             ?>
            <div class="reportdv">
                <label class="" for="last-name">Physical Symptoms
                </label>

            </div>
        <?php foreach($sel_symptom as $key=>$symptoms){ 
        ?>
            <div class="reportdv">
                <label class="seldisp" for="last-name"><?php echo $j.' '.$symptoms['symptom_name'];?> 
              <?php
              for($i=1;$i<=$symptoms['symptom_rate'];$i++){
              ?>*
              <?php }  
              if($symptoms['customer_note'] !=''){ echo ' - '.$symptoms['customer_note'];} ?>
                 </label>
            </div>
        <?php $j++;}
        } } ?>
    
    
   <div class="reportdv">
       <?php 
//       echo '<pre>';
//       print_r($customer_ans);
        if(count($customer_ans)>0){        
                foreach($customer_ans as $grp=>$ans){?>
                  <div class="reportdv">
                <label class="" for="last-name"><?php echo $grp;?>
                </label>
                  </div>
       <?php             foreach($ans as $k=>$result){
       ?>
     <div class="reportdv">
       <label class="seldisp" for="last-name">
<?php 
        $qn_remaindisp ='';
        if (strpos($result['question'],'OPTION') !== false) {
            $pos = strpos($result['question'],'OPTION');
            echo substr($result['question'],0,$pos-1);
            $qn_remaindisp = substr($result['question'],$pos+8);
        }else{
            echo $result['question'].":";  
        }?> 

            <?php echo $result['ans'];?>
         <?php if($qn_remaindisp != ''){ echo $qn_remaindisp; } ?>
       
       </label>  </div>
        <?php } } } ?>

</div>
	
</div>
</div>



                                            