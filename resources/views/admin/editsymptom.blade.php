@extends('layouts.adminlayout')
@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Admin Staff</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Edit Symptom <small></small></h2>
                    <div class="clearfix"> </div>
                </div>
                <div class="x_content">
                    <br></br>

                  <form class="form-horizontal form-label-left" novalidate  method="post" >
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Symptom <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input data-parsley-id="3638" id="symptom_name" name="symptom_name" value="<?php echo $data['symptom_name'];?>" required="required" title="Symptom" class="form-control col-md-7 col-xs-12" type="text"><ul id="parsley-id-3638" class="parsley-errors-list"></ul>
                            <input name="symptom_id" type="hidden" value="<?php echo $data['symptom_id'];?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Primary Symptom <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="parent_id" name="parent_id"  >
                                <option value="0" > Primary/Base Symptom</option> 
                        <?php if(isset($data['symptoms'])){
                            if(count($data['symptoms'])>0){
                        foreach($data['symptoms'] as $symptom){ 
                        ?>
                                <option value="<?php echo $symptom->symptom_id;?>" <?php if($symptom->symptom_id == $data['parent_id']){?>selected <?php } ?>><?php echo $symptom->symptom_name;?></option> 

                        <?php } } }?>
                                </select>

                            <ul id="parsley-id-3638" class="parsley-errors-list"></ul>
                        </div>
                    </div>
                   <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Status <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="radio">
                                <label>
                                    <input <?php if($data['status'] == 1){?>checked="checked" <?php } ?>value="1" id="status" name="status" type="radio"> Enable</label><label>
                                    <input <?php if($data['status'] == 0){?>checked="checked" <?php } ?> value="0" id="status" name="status" type="radio"> Disable</label>
                            </div>

                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <a href="../symptom"><button type="button" class="btn btn-primary">Cancel</button></a>
                            <button type="submit" class="btn btn-success" name="update" id="update">Update</button>
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
