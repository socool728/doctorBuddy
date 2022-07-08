@extends('layouts.adminlayout')
@section('content')
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>tinymce.init({ selector:'textarea',
              height: 240,
              theme: 'modern',
  plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools'
  ],
  toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  toolbar2: 'print preview media | forecolor backcolor emoticons',
  image_advtab: true,
  templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
  ],
  content_css: [
    '../css/custom_extra.css'
  ]
  }
              );</script>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Content</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div id="custom_message_wrapper">    
        <div id="message"  class="hide">
            <div id="message-text"></div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Add Content <small></small></h2>
                    <div class="clearfix"> </div>
                </div>
                <div class="x_content">
                    <br></br>

                    <form action="javascript:add_content();" class="form-horizontal form-label-left" novalidate  method="post"  id="add_content_form">                                        

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Content Title <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="contents_title" class="form-control col-md-7 col-xs-12" data-validate-length-range="" name="contents_title" title="Content Title" required="required" type="text">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Content Position<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="contents_position" name="contents_position"  >

                            <?php if(isset($data['content_position'])){
                                if(count($data['content_position'])>0){
                            foreach($data['content_position'] as $position){ 
                            ?>
                                    <option value="<?php echo $position->content_position_id;?>"><?php echo $position->content_position;?></option> 

                            <?php } } }?>
                                    </select>

                            <ul id="parsley-id-3638" class="parsley-errors-list"></ul>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Content Key <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input data-parsley-id="3648" id="contents_key" name="contents_key" value="" required="required" title="Content Title" class="form-control col-md-7 col-xs-12" type="text" placeholder="This value will display in url." ><ul id="parsley-id-3638" class="parsley-errors-list"></ul>
                        </div>
                    </div>
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Content Description <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea data-parsley-id="3648" id="contents_description" name="contents_description" ></textarea>
                        </div>
                    </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Display Order <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="display_order">
                                <?php for($i=1;$i<50;$i++){ ?>
                                <option value="<?php echo $i;?>" ><?php echo $i;?></option> <?php } ?>
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
                                    <input checked="checked" value="1" id="contents_status" name="contents_status" type="radio"> Enable</label><label>
                                    <input  value="0" id="contents_status" name="contents_status" type="radio"> Disable</label>
                            </div>

                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <a href="<?php echo $data['site_url'] ?>/admin/contents"><button type="button" class="btn btn-primary" name="cancel" id="cancel">Cancel</button></a>
                                <button type="submit" class="btn btn-success" name="add" id="add" href="add_content">Add</button>
                                <input type="hidden" name="form_submit" value="save">
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
</div><script>
 var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>
<script src="<?php echo asset('js/admin/add_content.js'); ?>"></script>
@stop
