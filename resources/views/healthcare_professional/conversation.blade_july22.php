@extends('layouts.healthcarelayout')
@section('content')
<?php
$hpObj =$data['hpObj'];
$customerDetailId =$data['customer_detail_id'];
$casefileToHealthcareId = $data['casefile_to_healthcare_id'];
?>
<div class="cd-main-header">		
    <a class="cd-nav-trigger" href="#0">
        <span></span>
    </a>		
</div>
<main class="cd-main-content">
    @include('healthcare_professional.dashboardmenu')
    <div class="content-wrapper col-lg-10 col-sm-10 col-xs-12">
        
        <?php if(Session::get('error_message')): ?>
            <div class=" alert alert-danger col-lg-12 col-sm-12 col-xs-12">
                <div ><?php echo Session::get('error_message') ?></div>
            </div>
        <?php else: ?>
        
        
        <?php if($hpObj->healthcare_professional_status ==4) : ?>  <!--Partial signup -->
        <div class="col-lg-12">
            <div class="warning-alert">Warning : Please complete your registration to access other areas.</div>
        </div>
        <?php endif ?> 
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
        <?php if($hpObj->healthcare_professional_status !=4) : ?>
        <h3>Conversation History</h3>
        <div class="ibox-content margin-top-20" style="border:1px solid grey;border-radius:10px;padding:10px;" >

                    <?php 
                      $conversations = DB::table('casefile_conversations')
                              ->where('customer_detail_id', '=', $customerDetailId)
                              ->where('healthcare_professional_id', '=', Session::get('hp_id'))
                              ->orderby("date","DESC")
                              ->get();
                    ?>
                    <div id="conversation_listing">
                            <?php foreach ($conversations as $conversation):  ?>
                        
                            <?php
                            $customerDetailObj = DB::table('customer_detail')->where('customer_detail_id','=',$conversation->customer_detail_id)->first();
                            $nickName = $customerDetailObj->customer_nickname;                          
                            ?>  
                        
                            <?php if($conversation->healthcare_comment): ?>
                            <div class="row  m-b m-l" >
                                <div class="form-group">
                                    <div class="col-lg-6  col-sm-6 col-xs-6 c_h_rows">
                                        <p><b>You</b></p> 
                                        <div class="col-lg-8  col-sm-8 col-xs-8 no-pad"><?php echo  $conversation->healthcare_comment ?></div>
                                        <div class="col-lg-4  col-sm-4 col-xs-4 text-right"><?php echo date(Config::get('constants.DATE_TIME_FORMAT'),  strtotime($conversation->date)); ?></div>
                                    </div>
                                </div>
                            </div>                        

                            <?php else: ?>
                            <div class="row  m-b m-r">
                                <div class="form-group">
                                    <div class="col-lg-6  col-sm-6 col-xs-6">
                                    </div>
                                    <div class="col-lg-6  col-sm-6 col-xs-6 c_h_rows">
                                        <p style="color:#00243F"><b><?php echo $nickName; ?></b></p>
                                        <div class="col-lg-8  col-sm-8 col-xs-8 no-pad"><?php echo  $conversation->customer_comment ?></div>
                                        <div class="col-lg-4  col-sm-4 col-xs-4 text-right"><?php echo date(Config::get('constants.DATE_TIME_FORMAT'),  strtotime($conversation->date)); ?></div>
                                    </div>                                                                        
                                </div>
                            </div>                        
                            <?php endif;?>
                            <?php endforeach ;?>
                    </div>
            </div>  
        <?php endif;?>
        
        
    <?php $caseFileToHealthCareObj =DB::table('casefile_to_healthcare')->where("casefile_to_healthcare_id","=",$casefileToHealthcareId)->first();?>        
            
        <?php if($caseFileToHealthCareObj->payment_status !=1 && $hpObj->healthcare_professional_status !=4) {?>
        <h3>Treatment Plan</h3>
        <div class="ibox-content margin-top-20" style="border:1px solid grey;border-radius:10px;padding:10px;">
                <form action="javascript:void(0);"  id="form_healthcare_openion" method="POST" class="m-t">
                          
                    <div class="row  m-b m-l">
                        <div id="openion-message"  class="hide">
                            <div id="openion-message-text"></div>
                        </div>
                    </div>
                   
                    <div class="row  m-b">
                        <div class="form-group">
                            <div class="col-lg-4  col-sm-4 col-xs-4">
                                <label class="white-label " for="healthcare_professional_password"> Introduction</label>
                            </div>
                            <div class="col-lg-6  col-sm-6 col-xs-6 item">
                                <textarea name="introduction" id="introduction"  title="Intoduction About You" class="form-control"><?php echo $hpObj->healthcare_professional_introduction ?></textarea>
                            </div>

                        </div>
                    </div>                    
                    <div class="row  m-b">
                        <div class="form-group">
                            <div class="col-lg-4  col-sm-4 col-xs-4">
                                <label class="white-label " for="healthcare_professional_password">Treatment plan offered to the client</label>
                            </div>
                            <div class="col-lg-6  col-sm-6 col-xs-6 item">
                                <textarea name="healthcare_comment" id="healthcare_comment" required="required"  title="Your comments to the Customer" class="form-control"></textarea>
                            </div>

                        </div>
                    </div>
                    <div class="row  m-b">
                        <div class="form-group">
                            <div class="col-lg-12" id="available_template_heading"><h3><a href="javascript:void(0);">Available Templates</a></h3></div>
                        </div>
                    </div> 
                    <div id="available_template_area" style="display:none">
                        <?php if(count($data['hpTemplates']) > 0){ ?>
                        <div class="row  m-b">    
                            <div class="form-group">
                                <?php foreach ($data['hpTemplates'] as $hpTemplate) { ?>
                                <div class="col-lg-12">
                                    <div class="col-lg-1"><input type="checkbox" name="templates[]" value="<?php echo $hpTemplate->healthcare_professional_template_id ?>"></div>
                                    <div class="col-lg-11">
                                        <a href="javascript:void(0);" id="<?php echo $hpTemplate->healthcare_professional_template_id ?>" class="template_links">
                                            <?php echo $hpTemplate->template_title ?>
                                        </a>
                                    </div>                                    
                                </div>                            
                                <?php } ?>
                            </div>
                        </div> 
                        <?php }else{ ?>
                        <div class="row  m-b"> 
                            <div class="col-lg-2">No Templates Available</div>
                        </div>
                        <?php } ?>
                    </div> 

                    <div class="row  m-b">
                        <div class="form-group">
                            <div class="col-lg-12" id="price_section_heading"><h3><a href="javascript:void(0);">Price Section</a></h3></div>
                        </div>
                    </div>
                    <div id="price_section_area" style="display:none">
                        <div class="row  m-b">    
                            <div class="form-group">
                                <div class="col-lg-4  col-sm-4 col-xs-4">
                                    <label title="Our regular price including consulting price">Regular Price</label>
                                </div>
                                <div class="col-lg-3 item">
                                    <input type="text" id="regular_amount" name="regular_amount"  title="Our regular price including consulting price" class="form-control"  value="">
                                </div>

                                <div class="col-lg-2 item">
                                    <select id="currency" name="currency" class="form-control">
                                        <option value="USD">USD</option>
<!--                                        <option value="INR">INR</option>-->
                                    </select>                                
                                </div>                            

                            </div>
                        </div> 
                        <div class="row  m-b">  
                            <div class="form-group m-b">
                                <div class="col-lg-4  col-sm-4 col-xs-4">
                                    <label>Reduction</label>
                                </div>
                                <div class="col-lg-3 item">
                                    <select id="discount" name="discount" class="form-control">
                                        <option value="0">Select</option>
                                        <option value="5">5%</option>
                                        <option value="10">10%</option>
                                        <option value="15">15%</option>
                                        <option value="20">20%</option>
                                        <option value="25">25%</option>
                                        <option value="30">30%</option>
                                    </select> 
                                </div>

                            </div>
                        </div>
                        <div class="row  m-b"> 
                            <div class="form-group">
                                <div class="col-lg-4  col-sm-4 col-xs-4">
                                    <label>Tax</label>
                                </div>
                                <div class="col-lg-3 item">
                                    <input type="text" id="tax" name="tax"  title="Tax" class="form-control"  value="">
                                </div>
                                <label class="white-label col-lg-1 no-padding">%</label>
                            </div>                         
                        </div>
                        <div class="row  m-b"> 
                            <div class="form-group">
                                <div class="col-lg-4  col-sm-4 col-xs-4">
                                    <label>Total</label>
                                </div>
                                <div class="col-lg-3 item">
                                    <input type="text" id="healthcare_charge" name="healthcare_charge"  title="Total" class="form-control"  value="">
                                </div>
                            </div>                         
                        </div>
                    </div>    

                    
                    <div class="row  m-b">
                            <div class="col-lg-4  col-sm-4 col-xs-4">
                            </div>
                            <div class="col-lg-6  col-sm-6 col-xs-6">

                                <button  onclick="return validate_healthcare_openion();"type="submit"  title="Register"  class="btn btn-red" role="button">Save</button>
                                <input type="hidden" name="form_submit" value="save">
                                <?php if(isset($casefileToHealthcareId) && $casefileToHealthcareId != '') : ?>
                                <input type="hidden" name="casefile_to_healthcare_id" value="<?php echo $casefileToHealthcareId ?>">
                                <?php endif; ?>                        
                            </div>                            
                                               
                    
                    </div> 
                </form>
                
            </div>    
        <?php } ?>
               
    </div>
        </div>  
        <input type="hidden" name="customer_detail_id"  id="customer_detail_id" value="<?php echo $customerDetailId ?>">       
        <?php endif; ?>
    </div>
</main>    


                
                          
<script>
    var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>
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
<script src="<?php echo asset('js/healthcare_professional/conversation.js'); ?>"></script>
 

@stop


@section('modal_popup_area')


<!-- START :Template  Pop up -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="template_popup">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="template_modal_title"></h4>
        </div>
          <div class="modal-body" id="template_modal_body">
          
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
 <!-- END :Template  Pop up -->   
 
 
 @stop