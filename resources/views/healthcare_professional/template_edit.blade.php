@extends('layouts.healthcarelayout')
@section('content')

<div class="cd-main-header">		
    <a class="cd-nav-trigger" href="#0">
        <span></span>
    </a>		
</div>
<main class="cd-main-content">
    @include('healthcare_professional.dashboardmenu')
    <div class="content-wrapper col-lg-9 col-sm-9 col-xs-12">
        <h3>Edit Template</h3>
        <form action="javascript:void(0);" id="template_form" name="template_form"  method="post"  role="form" >
            <div class="col-lg-12 col-sm-12  col-sx-12 registration-wrap  no-pad"> 
                <div id="custom_message_wrapper">    
                    <div id="message"  class="hide">
                        <div id="message-text"></div>
                    </div>
                     <?php if(Session::get('flash_msg')) : ?>
                    <div class="success-alert"><?php echo Session::get('flash_msg') ?></div>
                    <?php endif ;?>
                </div>

            <div class="col-lg-12 col-sm-12 col-sx-12 no-pad">
                <div class="form-group  col-lg-6 col-sm-6 col-sx-12 no-pad item right-pad">
                    <label>Title</label> 
                    <input  id="template_title" name="template_title"  required="required" title="Title" class="form-control" type="text" value="<?php echo $templateObj->template_title ?>">
                </div> 
            </div>
            <div class="col-lg-12 col-sm-12 col-sx-12 no-pad">
                <div class="form-group  col-lg-12 col-sm-12 col-sx-12 no-pad item">
                    <label>Content</label> 
                    <textarea  id="template_text" name="template_text"  required="required" title="Text" class="form-control" ><?php echo $templateObj->template_text ?></textarea>
                </div>         
            </div> 

            <div class="col-lg-12 col-sm-12 col-sx-12 no-pad text-right">
                <button  onclick="return edit_template();" type="button"  title="Save"  class="btn btn-red" role="button">Save</button>
                <input type="hidden" name="form_submit" value="save">
                <input type="hidden" name="template_id" id="template_id" value="<?php echo $templateObj->communication_template_id ?>">        
            </div> 
            </div>  
         </form>        
    </div>
</main>

<script>
 var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>
<script src="<?php echo asset('js/healthcare_professional/templates.js'); ?>"></script>
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
  ]
  }
              );
 </script>
@stop