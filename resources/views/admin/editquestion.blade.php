@extends('layouts.adminlayout')
@section('content')
<script type="text/javascript">
    var myvar =0;
function add_qnoption(id){
	myvar++;
    var incvar = myvar+1;
	if(myvar == 1){
	document.getElementById('qn_option').innerHTML = '<div class="form-group"><label for="options" class="control-label col-md-3 col-sm-3 col-xs-12">Options Value</label><div class="col-md-6 col-sm-6 col-xs-12"><input data-parsley-id="8125" id="option_name'+id+'" class="form-control col-md-7 col-xs-12" name="option_name[]" type="text"><ul id="parsley-id-8125" class="parsley-errors-list"></ul></div></div><div id="qn_option_2"></div>';
	}else{
	document.getElementById('qn_option_'+myvar).innerHTML = '<div class="form-group"><label for="options" class="control-label col-md-3 col-sm-3 col-xs-12">Options Value</label><div class="col-md-6 col-sm-6 col-xs-12"><input data-parsley-id="8125" id="option_name'+id+'" class="form-control col-md-7 col-xs-12" name="option_name[]" type="text"><ul id="parsley-id-8125" class="parsley-errors-list"></ul></div></div><div id="qn_option_'+incvar+'"></div>';
	}
}
function selectdepend(seltype)
{
   if(seltype.value == '0'){           
        document.getElementById('dependQnid').style.display='none';    
   }else{
        document.getElementById('dependQnid').style.display='block';
   }
}
var currvar =0;
function getoption(id)
{
    var qnid = document.getElementById('depend_option').value;
	currvar++;
         var updvar = currvar+1;
    if(id != '1'){
        document.getElementById('dsp').style.display='none';   
        if (document.getElementById('dependcnt') != null) {
            var depcnt = document.getElementById('dependcnt').value;
            if(depcnt >0 && currvar >0){
                for(i = 0; i < depcnt; i++) {                     
                    document.getElementById('condition_'+i).style.display='none';
                    document.getElementById('depend_ans_'+i).disabled='disabled';	
                } 
                currvar = 1;
            }
        }
        if(updvar >0){
            for(i = 0; i < updvar; i++) {        
                if (document.getElementById('condition_'+i) != null) {
                document.getElementById('condition_'+i).style.display='none';
                document.getElementById('depend_ans_'+i).disabled='disabled';
                }
            }
        }
    }
   
    if(qnid > 0){
      $.ajax({
            type: "POST",
            url: "../option",
            data: {qnid: qnid,divid:updvar},
            success: function(data) {
                if(currvar == 1){
                    document.getElementById('dsp').style.display='block'; 
                    document.getElementById('dependoption').innerHTML=data;
                }else{
                    document.getElementById('dsp').style.display='block'; 
                    document.getElementById('dependoption_'+updvar).innerHTML=data;
                }
            }
        });
    }else{
        document.getElementById('dsp').style.display='none';   
//        if (document.getElementById('dependcnt') != null) {
//            var depcnt = document.getElementById('dependcnt').value;
//            if(depcnt >0 && currvar >0){
//                for(i = 0; i < depcnt; i++) {                     
//                    document.getElementById('condition_'+i).style.display='none';
//                    document.getElementById('depend_ans_'+i).disabled='disabled';	
//                }   
//                currvar = currvar-i;
//            }
//        }
//        if(currvar >0){
//            for(i = 0; i < currvar; i++) {        
//                if (document.getElementById('condition_'+i) != null) {
//                document.getElementById('condition_'+i).style.display='none';
//                document.getElementById('depend_ans_'+i).disabled='disabled';
//                }
//            }
//            currvar = currvar-i;
//        }
    }

}
function close_option(option, id){
	var option;	
	option_val = option.replace(/-/," ");
	if (confirm('Are you sure you want to remove this answer option '+option_val)){	
		document.getElementById('option_'+id).style.display='none';	
		document.getElementById('option_name_'+id).disabled='disabled';	
	}	
}
function close_condition(ans, id){
	var ans;	
	ans_val = ans.replace(/-/," ");
	if (confirm('Are you sure you want to remove this condition for answer '+ans_val)){	
		document.getElementById('condition_'+id).style.display='none';	
		document.getElementById('depend_ans_'+id).disabled='disabled';	
	}	
}
</script>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Questions</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Edit Questions <small></small></h2>
                    <div class="clearfix"> </div>
                </div>
                <div class="x_content">
                    <br></br> 
                                               
                    <form novalidate="" id="demo-form2" data-parsley-validate="" method="post" class="form-horizontal form-label-left">
                   

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Question <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input data-parsley-id="3638" id="question" name="question" value="<?php echo $data['question'];?>" title="Question" required="required" class="form-control col-md-7 col-xs-12" type="text"><ul id="parsley-id-3638" class="parsley-errors-list"></ul>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Display Order <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control" name="display_order">
                                                    <?php for($i=1;$i<99;$i++){ ?>
                                                    <option value="<?php echo $i;?>" <?php if($data['display_order'] == $i){?>selected <?php } ?> ><?php echo $i;?></option> <?php } ?>
                                                </select>
                                               <input name="question_id" type="hidden" value="<?php echo $data['question_id'];?>" />
                                                <ul id="parsley-id-3638" class="parsley-errors-list"></ul>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Question Group <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control" name="question_group_id">
                                                     <?php if(isset($data['questiongroups'])){
                                                if(count($data['questiongroups'])>0){
                                            foreach($data['questiongroups'] as $questiongroup){ 
                                            ?>
                                                    <option value="<?php echo $questiongroup->group_id;?>" <?php if($data['question_group_id'] == $questiongroup->group_id){?>selected <?php } ?>><?php echo $questiongroup->group_name;?></option> 
                                            <?php } } }?>                                                    
                                                </select>
                                                <ul id="parsley-id-3638" class="parsley-errors-list"></ul>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Question Type <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="radio">
                                                    <label>
                                                         <?php if(in_array($data['question_type'],array('text','textarea'))){?>
                                                        <input <?php if($data['question_type'] == 'text'){?>checked="checked" <?php } ?> value="text" id="question_type" name="question_type" type="radio"> Text</label><label>
                                                            <?php } ?>
                                                        <?php if(in_array($data['question_type'],array('radio','select','check'))){?>
                                                            <input <?php if($data['question_type'] == 'radio'){?>checked="checked" <?php } ?> value="radio" id="question_type" name="question_type" type="radio"> Radio Button</label><label>
                                                        <input <?php if($data['question_type'] == 'select'){?>checked="checked" <?php } ?> type="radio" id="question_type" name="question_type" value="select"> Select Box</label><label>
                                                        <input <?php if($data['question_type'] == 'check'){?>checked="checked" <?php } ?> type="radio" id="question_type" name="question_type" value="check"> Check Box</label><label>
                                                        <?php }else{ ?>
                                                        <input <?php if($data['question_type'] == 'textarea'){?>checked="checked" <?php } ?> type="radio" id="question_type" name="question_type" value="textarea"> Text Area</label> <?php } ?>
                                                    </label>
                                                </div>
                                               <input name="question_id" type="hidden" value="<?php echo $data['question_id'];?>" />
                                            </div>
                                        </div>
                                        <?php $i=0;
                                        if(isset($data['options'])){
                                            if(count($data['options'])>0){                                        
                                        foreach($data['options'] as $option){  ?>
                                        <div class="form-group" id="option_<?php echo $i;?>">
                                            <label for="options" class="control-label col-md-3 col-sm-3 col-xs-12"> Options Value</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input data-parsley-id="8125" id="option_name_<?php echo $i;?>" value="<?php echo $option['option_name'];?>" class="form-control col-md-7 col-xs-12" name="option_name[]" type="text"><ul id="parsley-id-8125" class="parsley-errors-list"><a href="javascript:void(0);" onclick="javascript: close_option('<?php echo $option['option_name'];?>','<?php echo $i;?>');">Delete option</a> </ul>
<!--                                                    <img src="<?php echo asset('images/delete.png'); ?>" alt="Delete" class="">-->
                                            </div>
                                        </div>
                                        <?php $i++; } } }?>
                                       
                                        <div id="qn_option"></div>
                                        <?php if(in_array($data['question_type'],array('radio','select','check'))){?>
                                        <div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">
                                            </label><div class="col-md-6 col-sm-6 col-xs-12"><a href="javascript:void(0);" onclick="javascript: add_qnoption('<?=$i;?>');">Add more Options</a></div>
                                        </div>
                                        <?php } ?>
                                        <?php if(in_array($data['question_type'],array('text','select','check','textarea'))){?>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Required question? <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="radio">
                                                    <label>
                                                        <input  value="1" <?php if($data['field_required'] == 1){?>checked="checked" <?php } ?> name="field_required" type="radio"> Yes</label><label>
                                                        <input value="0" <?php if($data['field_required'] == 0){?>checked="checked" <?php } ?> name="field_required" type="radio"> No</label>
                                                </div>
                                               
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Validate Message? <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">                                          
                                                        <input value="<?php echo $data['validator_title'];?>" name="validator_title" />
                                                </div>
                                               
                                            </div>
                                        <?php } ?>
                                        
                                        
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Is Depend question? <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="radio">
                                                    <label>
                                                        <input  value="1" <?php if($data['dependable_question'] == 1){?>checked="checked" <?php } ?> onchange="javascript:selectdepend(this);" id="dependable_question" name="dependable_question" type="radio"> Yes</label><label>
                                                        <input <?php if($data['dependable_question'] == 0){?>checked="checked" <?php } ?> onchange="javascript:selectdepend(this);"  value="0" id="dependable_question" name="dependable_question" type="radio"> No</label>
                                                </div>
                                               
                                            </div>
                                        </div>
                        
                        <div id="dependQnid" <?php if($data['dependable_question'] == 0){?> style="display: none;" <?php } ?>>
                                         <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Depend question <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control" id="depend_option" name="depend_option" onchange="javascript:getoption(this);" >
                                                    <option value="0" >Select depend question</option> 
                                            <?php if(isset($data['questions'])){
                                                if(count($data['questions'])>0){
                                            foreach($data['questions'] as $question){ 
                                            ?>
                                                    <option value="<?php echo $question->question_id;?>" <?php if(isset($data['depend_question_id'])){ if($data['depend_question_id'] == $question->question_id){?>selected <?php } }?> ><?php echo $question->question;?></option> 

                                            <?php } } }?>
                                                    </select>
                                               
                                                <ul id="parsley-id-3638" class="parsley-errors-list"></ul>
                                            </div>
                                        </div>
                            <?php $j=0; if(isset($data['depend_question_ans'])){
                            if(count($data['depend_question_ans'])>0){                                 
                                foreach($data['depend_question_ans'] as $ans){
                                    $optiondetail = array();
                                    $ans_val ='';
                                    if($ans>0)
                                    $optiondetail = DB::table('options')->where('options.option_id', '=', $ans)->first();
                                    if(count($optiondetail)>0){
                                     $ans_val  = $optiondetail->option_name;    
                                    }
                                    if($ans_val == '')
                                        $ans_val  = $ans;
                                    ?>
                            <div class="form-group" id="condition_<?php echo $j;?>">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Display if Answer is<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control" id="depend_ans_<?php echo $j;?>" name="depend_ans[]" >
                                                    <option value="<?php echo $ans;?>" ><?php echo $ans_val;?></option>
                                                </select>
                                                <ul id="parsley-id-3638" class="parsley-errors-list"><a href="javascript:void(0);" onclick="javascript: close_condition('<?php echo $ans;?>','<?php echo $j;?>');">Delete option</a> </ul>
                                            </div>
                                        </div>
                                <?php $j++; }
                                }
                            }
?>
                            <div id="dependoption">
                                <input type="hidden" name="dependcnt" id="dependcnt" value="<?php echo $j;?>"/>
                            </div>
                            <div class="form-group" id="dsp" <?php if(!isset($data['depend_question_ans'])){?> style="display: none;" <?php }else if(isset($data['depend_question_ans'])){
                            if(count($data['depend_question_ans'])>0){ ?> style="display: block;" <?php } } ?>><label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">
                                            </label><div class="col-md-6 col-sm-6 col-xs-12"><a href="javascript:void(0);" onclick="javascript: getoption('1');">Add more conditions </a></div>
                                        </div>
                                                     
                        </div>
                                        <?php if(isset($data['depend_question_ans'])){
                                        if(count($data['depend_question_ans'])>0){ ?>
                                        <div class="form-group ">                                                  
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 notebox"><label>
                                                Logic Note: Depend logic work, if 'Question Group' other than '<?php echo $data['depend_group_name'];?>' & have higher display order.                                  
                                                </label>
                                            </div>
                                        </div>
                                        <?php } }?>
                                        <div class="ln_solid"></div>
                                        <?php if(count($data['driving_question'])>0){ ?>
                                        <div class="form-group ">                                                  
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 notebox"><label>
                                                Update Note: If you update this question, please update the following depend question also.<br/>
                                                <?php $k =1;
                                                foreach($data['driving_question'] as $qn){
                                                    echo $k.' '.$qn.'<br>';
                                                    $k++;
                                                }?>                                      
                                                </label>
                                            </div>
                                        </div>
                                        <?php  }?>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <a href="../questions"> <button type="button" class="btn btn-primary">Cancel</button></a>                                                
                                                <?php //if($data['depend_qn']==0){?>
                                                <button type="submit" name="update" class="btn btn-success">Update</button>
                                            
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
<script>
$('form')
    .on('blur', 'input[required], input.optional, select.required', validator.checkField)
    .on('change', 'select.required', validator.checkField)
    .on('keypress', 'input[required][pattern]', validator.keypress);

$('.multi.required')
    .on('keyup blur', 'input', function () {
        validator.checkField.apply($(this).siblings().last()[0]);
    });
    $('form').submit(function (e) {
            e.preventDefault();
            var submit = true;
            // evaluate the form using generic validaing
            if (!validator.checkAll($(this))) {
                submit = false;
            }

            if (submit)
                this.submit();
            return false;
        });
</script>
@stop
