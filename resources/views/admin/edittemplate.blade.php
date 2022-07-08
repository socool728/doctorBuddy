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
              );
</script>
<?php
 $templateObj = $data['templateObj'];
?>
<div class="">
<!--    <div class="page-title">
        <div class="title_left">
            <h3>Add Language</h3>
        </div>
    </div>-->
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Edit Template <small></small></h2>
                    <div class="clearfix"> </div>
                </div>
                <div class="x_content">
                    <br><br>
                    <form action="javascript:edit_template();" class="form-horizontal form-label-left" novalidate  method="post"  id="edit_template_form">
                        
                        <div id="message"  class="hide item form-group">
                            <div id="message-text"></div>
                        </div>
                        
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Title <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="template_title" class="form-control col-md-7 col-xs-12"  name="template_title" title="Title" required="required" type="text" value="<?php echo $templateObj->template_title ?>">
                            </div>
                        </div>
                        
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Content <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea  id="template_text" name="template_text" title="Content" required="required" class="form-control col-md-7 col-xs-12"><?php echo $templateObj->template_text ?></textarea>
                            </div>
                        </div>                        
                        
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Status <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="radio">
                                  <label>
                                      <input checked="checked" value="1" id="template_status" name="template_status" type="radio" <?php if($templateObj->template_status == 1) { echo "checked" ;} ?>> Enable
                                  </label>
                                  <label>
                                      <input  value="0" id="template_status" name="template_status" type="radio" <?php if($templateObj->template_status == 0) { echo "checked" ;} ?>> Disable
                                  </label>
                              </div>

                          </div>
                      </div>                        

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <a href="<?php echo $data['site_url'] ?>/admin/templates"><button type="button" class="btn btn-primary" name="cancel" id="cancel">Cancel</button></a>
                                <button type="submit" class="btn btn-success" name="add" id="add" href="edit_template">Save</button>
                                <input type="hidden" name="template_id" id="template_id" value="<?php echo $templateObj->communication_template_id ?>">
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
</div>
<script>
 var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>
<script src="<?php echo asset('js/admin/edit_template.js'); ?>"></script>

@stop
