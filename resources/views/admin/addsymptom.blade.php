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
                    <h2>Add Symptom <small></small></h2>
                    <div class="clearfix"> </div>
                </div>
                <div class="x_content">
                    <br></br>

<form class="form-horizontal form-label-left" novalidate  method="post" >

                                        

                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Symptom <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="symptom_name" class="form-control col-md-7 col-xs-12" data-validate-length-range="" name="symptom_name" title="Symptom" required="required" type="text">
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
                                                    <option value="<?php echo $symptom->symptom_id;?>" ><?php echo $symptom->symptom_name;?></option> 

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
                                                        <input checked="checked" value="1" id="status" name="status" type="radio"> Enable</label><label>
                                                        <input  value="0" id="status" name="status" type="radio"> Disable</label>
                                                </div>
                                               
                                            </div>
                                        </div>
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-3">
                                                <a href="../admin/symptom"><button type="button" class="btn btn-primary" name="cancel" id="cancel">Cancel</button></a>
                                                <button type="submit" class="btn btn-success" name="add" id="update">Add</button>
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
