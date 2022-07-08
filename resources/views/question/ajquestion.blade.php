
<div class="question-wrapper question-page-3" id="question">
    <div class="form-group  col-lg-12 col-sm-12 col-xs-12"><h3>Intake for Psychosocial Assessment</h3></div>
    
    <div class="form-group  col-lg-12 col-sm-12 col-xs-12">
        <h4>
            <?php
            if(count($question)>0){ 
                $firstQuestion = $question[0];
                $groupId = $firstQuestion['question_group_id'];
                $groupObj =DB::table('questiongroup')->where('group_id', '=', $groupId)->select('group_name')->first();  
                echo $groupObj->group_name;
            }
            ?>
        </h4>
    </div>
    
 <div class=" form-group col-lg-12 col-sm-12 col-xs-12">   
<?php 
if(count($question)>0){   
    $cntqn =0;
    foreach($question as $questiondetails){
        $hide = 0;
        if($questiondetails['depend'] ==1){  
            $hide = 1;                                                
            if(isset($depend[$questiondetails['depend_qn']])){
                $ans_depend = explode(",",$questiondetails['depend_ans']);
                if(count($depend[$questiondetails['depend_qn']])>0){
                    foreach($depend[$questiondetails['depend_qn']] as $selans){
                        if(!is_array($selans)){
                            // for multi checkbox
                            if (strpos($selans, ',') !== false) {
                                $sel_dependans_arr = explode(",",$selans);
                                if(in_array($ans_depend[0],$sel_dependans_arr)){
                                    $hide = 0;
                                }
                            }else{
                                if($ans_depend[0] ==$selans){
                                    $hide = 0;
                                }
                            }
                        }else{
                            // for multi checkbox
                            if(in_array($selans,$ans_depend)){
                                $hide = 0;
                            }
                        }
                    }
                }
            }
        }        
        if($hide ==0){
            // assign group id in hidden field
            if($cntqn ==0){?>
            <script>$('#gpid').val(<?php echo $questiondetails['question_group_id'];?>);</script>
            <?php }
            $cntqn++;
        ?>
                                       
            <div class="item form-group">                                            
                <label  for="first-name">
                    <?php $qn_remain ='';
                    if (strpos($questiondetails['question'],'OPTION') !== false) {
                        $pos = strpos($questiondetails['question'],'OPTION');
                        echo substr($questiondetails['question'],0,$pos-1);
                        $qn_remain = substr($questiondetails['question'],$pos+8);
                    }else{
                    echo $questiondetails['question'];                                                
            }?> 
                </label>

                     <?php if ($questiondetails['question_type'] == 'text') { ?>
                    <input data-parsley-id="3638" name="<?php echo $questiondetails['question_id'];?>" <?php if($questiondetails['field_required']==1){?> required="required" <?php } ?> title="<?php echo $questiondetails['validator_title'];?>" value="" class="form-control col-md-7 col-xs-12 <?php if($qn_remain != ''){?> form-qn <?php } ?>" type="text">   <?php if($qn_remain != ''){ echo '<label>&nbsp;'.$qn_remain.'</label>';} ?>
                     <?php } else if ($questiondetails['question_type'] == 'textarea') { ?>
            <textarea class="form-control <?php if($qn_remain != ''){?> form-qn <?php } ?>" <?php if($questiondetails['field_required']==1){?> required="required" <?php } ?>  name="<?php echo $questiondetails['question_id']; ?>"></textarea>   <?php if($qn_remain != ''){ echo '<label>&nbsp;'.$qn_remain.'</label>';} ?>
                     <?php } else if ($questiondetails['question_type'] == 'radio') { ?>
            <div class="radio radio-btns">
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
                                <select class="form-control <?php if($qn_remain != ''){?> form-qn <?php } ?>"  name="<?php echo $questiondetails['question_id'];?>" <?php if($questiondetails['field_required']==1){?> class="required" <?php } ?> title="<?php echo $questiondetails['validator_title'];?>">
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
                                 $k=1;
                                 foreach ($questiondetails['option_arr'] as $val) { ?>
            <div class="checkbox checkbox-btns">
                <label>
                    <div class="icheckbox_flat-green">
                    <input class="<?php echo $totcnt;?>" type="checkbox" name="<?php echo $questiondetails['question_id'];?>[]" value="<?php echo $val['option_id']; ?>" title="<?php echo $questiondetails['validator_title'];?>" ><?php echo $val['option_name'];?></div>
                </label>
            </div>
                        <?php $k++;} ?>
            <input type="hidden" name="chkbxqn_<?php echo $questiondetails['question_id'];?>" value="<?php echo $questiondetails['question_id'];?>" />
                            <?php } ?>
               <?php if($qn_remain != ''){ echo '<label>'.$qn_remain.'</label>';} ?>
                    <?php } ?>
                    <ul id="parsley-id-3638" class="parsley-errors-list"></ul>
            </div> 
        <?php }
            }//hide
         }?>

 </div>
        <!-- Start: Skip question group section.It will display only in the first step --> 
        <!--
        <?php if (count($questiongroups_except_first)>0) : ?>
        <?php $questiongroupNo =0;?>
        <div class="item form-group">
            <label >Skip Question group</label>
            <div class="col-lg-12">
                <?php foreach($questiongroups_except_first as  $questiongroup) : ?>
                <div class="col-md-3">
                    <div class="checkbox">
                    <label class="white-label">
                        <input type="checkbox" value="<?php echo $questiongroup->group_id ?>"  id="questiongroup_<?php echo $questiongroup->group_id ?>" name="skip_questiongroups[]"> <?php echo $questiongroup->group_name ?>
                    </label>
                    </div>                                        
                </div>

                <?php $questiongroupNo =$questiongroupNo +1;?>

                <?php   if($questiongroupNo %4 == 0) : ?>
                    </div><div class="col-lg-12">
                <?php endif ;?>


                <?php endforeach ; ?>
            </div>
        </div>

        <?php endif; ?>-->
        <!-- End: Skip question group section --> 


        <div class=" form-group  col-lg-12 col-sm-12 col-xs-12 no-padding"> 
            <div class="col-lg-6 col-sm-6 col-xs-6 text-left">
                <a class="btn btn-red btn-back" onclick="prevqn('<?php echo $prev_next_current['current'];?>')">BACK</a>
            </div>
            <div class="col-lg-6 col-sm-6 col-xs-6 text-right">
                <a class="btn btn-red" onclick="getqn('<?php echo $prev_next_current['current'];?>','<?php echo $prev_next_current['next'];?>')">NEXT</a>
            </div>
        </div>
</div>
