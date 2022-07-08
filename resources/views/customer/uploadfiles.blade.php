@extends('layouts.customerlayout')
@section('content')
<div class="cd-main-header">		
    <a class="cd-nav-trigger" href="#0">
        <span></span>
    </a>		
</div>
<main class="cd-main-content">
    @include('customer.dashboardmenu')
     
    <div class="content-wrapper col-lg-9 col-sm-9 col-xs-12">
        <div class="ibox float-e-margins">
            <div id="message"  class="hide">
                <div id="message-text"></div>
            </div>
            <div class="ibox-title">
                <h3>Manage Upload Documents</h3>
            </div>
            <div class="ibox-content">
            <?php
            $customerDetailId = $data['customer_detail_id'];
            $files = DB::table('customer_files')->where('customer_detail_id', '=', $customerDetailId)->get();
            if(count($files)>0){ 
            ?>                 
                <div class="row">
                    <div class="col-lg-3 col-sm-3 col-xs-3 ">
                        
                        <div class="form-group item">
                            <label>Files</label> 
                        </div>  
              
                    </div>
                    <div class="col-lg-6 col-sm-6 col-xs-6 ">
                        <div class="form-group item" id="listing_upload_files">
                        <?php foreach($files as $file) { ?>
                        <p id="<?php echo $file->customer_file_id ?>">
                        <a href="<?php echo asset("uploads/files/".$file->file_name);?>" target="_blank">
                        <?php echo $file->file_name ?>
                        </a>
                        &nbsp;    
                        <a href="javascript:void(0);" onclick='delete_files(<?php echo $file->customer_file_id ?>)'>
                            <i aria-hidden="true" class="fa fa-times-circle"></i>
                        </a>                              
                        </p>
                        <?php } ?>
                        </div> 
                    </div>                      
                </div>
                
           <?php } else { ?>     

                <div class="row">
                    <div class="col-lg-3 col-sm-3 col-xs-3">
                        
                        <div class="form-group item">
                            <label>Files</label> 
                        </div>  
              
                    </div>
                    <div class="col-lg-6 col-sm-6 col-xs-6 ">
                        <div class="form-group item" id="listing_upload_files">No files uploaded</div> 
                    </div>
                </div>
            <?php } ?>
                
                <form class="m-t" role="form" action="javascript:void(0);"  id="upload_form">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12 no-padding">
                        <p><b>UPLOAD</b></p> 
                        <p>You can upload medical report, photos, videos or anything that relevant to your case.</p>
                        <p>Please ensure that your personal information is not visible, if you wish to hide your personal information</p>
                    </div>
                    
                    <div class="form-group col-lg-12 col-sm-12 col-xs-12 no-pad">
                        
                          <div id="files_upload_area" class="files">
                              <div class="col-lg-3 col-sm-3 col-xs-3 no-padding">
                                   <span class="btn btn-red fileinput-button">
                                       <span  class="btn btn-red fileinput-button">
                                           <label id="uploadbtn">
                                               <i class="glyphicon glyphicon-plus"></i>
                                               BROWSE
                                           </label>
                                           <label id="uploadnxtbtn" style="display:none;">Upload Next</label>
                                           <input id="fileupload_document" type="file" name="files"  /></span>  
                                  </span>
                              </div>
                              <div  class="col-lg-2 col-sm-2 col-xs-2 ">
                                  <span id="waiting_div" class="hide">
                                      <div class="sk-spinner sk-spinner-three-bounce pull-left"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div></div>
                                  </span>
                              </div>
                              <div class="col-lg-2 col-sm-2 col-xs-2 text-left no-pad">
                              <p style="font-size:12px;" class="alert alert-info col-lg-12 col-sm-12 col-xs-12 " role="alert">
                                    <strong>Max File Size:</strong> 2MB.<br> 
                               </p>
                                </div>
                          </div>
                        
                          <div id="upfiles_document" class="files"></div>                     
                          <input type="hidden" name="customer_medicalreport" id="customer_medicalreport" value="">

                     </div>                    
                    
                </div>
                </form>

               
                
            </div>
                               
                                 
        </div>        
    </div>
    
    
    <div class="content-wrapper col-lg-9 col-sm-9 col-xs-12">
        <div class="ibox float-e-margins">

            <div class="ibox-title">
                <h3>Manage Drop Box Documents</h3>
            </div>
            <div class="ibox-content">
            <?php
            $customerDetailId = $data['customer_detail_id'];
            $dropboxFiles = DB::table('customerdetail_to_dropbox')->where('customer_detail_id', '=', $customerDetailId)->get();
            if(count($dropboxFiles)>0){ 
            ?>                 
                <div class="row">
                    <div class="col-lg-3 col-sm-3 col-xs-3 ">
                        
                        <div class="form-group item">
                            <label>Drop Box Files</label> 
                        </div>  
              
                    </div>
                    <div class="col-lg-6 col-sm-6 col-xs-6 ">
                        <div class="form-group item" id="listing_dropbox_files">
                        <?php foreach($dropboxFiles as $dropboxFile) { ?>
                        <p id="dropbox_<?php echo $dropboxFile->customerdetail_to_dropbox_id ?>">
                        <a href="<?php echo $dropboxFile->file_path ;?>" target="_blank">
                        <?php echo $dropboxFile->file_path ?>
                        </a>
                        &nbsp;    
                        <a href="javascript:void(0);" onclick='delete_dropbox_files(<?php echo $dropboxFile->customerdetail_to_dropbox_id ?>)'>
                            <i aria-hidden="true" class="fa fa-times-circle"></i>
                        </a>    
                        </p>
                        <?php } ?>
                        </div> 
                    </div>                      
                </div>
                
           <?php } else { ?>     

                <div class="row">
                    <div class="col-lg-6 col-sm-6 col-xs-6 ">
                        
                        <div class="form-group item">
                            <label>Files</label> 
                        </div>  
              
                    </div>
                    <div class="col-lg-6 col-sm-6 col-xs-6 ">
                        <div class="form-group item" id="listing_dropbox_files">No files uploaded</div> 
                    </div>
                </div>
            <?php } ?>
                
                <form class="m-t" role="form" action="javascript:void(0);"  id="dropbox_form">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12 no-padding">
                        <p><b>Add</b>&nbsp;<a href="javascript:void(0);" id="btnAdd"><i aria-hidden="true" class="fa fa-plus-circle fa-3"></i></a></p> 
 
                    </div>
                    <div id="TextBoxContainer" class="col-lg-6 col-sm-6 col-xs-6 no-padding"></div>
                    <div id="ButtonContainer" class="col-lg-12 col-sm-12 col-xs-12 no-padding m-t"></div>

                </div>
                <div class="row  no-padding m-t">
                    <div class="col-lg-12 col-sm-12 col-xs-12 no-padding">
                      <p>You can copy & past the  drop box url here.</p>    
                    </div>
                      
                </div>    
                </form>

               
                
            </div>                                                   
        </div>        
    </div>
    
    <input type="hidden" name="customer_detail_id"  id="customer_detail_id"  value="<?php echo $customerDetailId ?>" >  
</main>

<script>
    var SITE_URL = "<?php echo $data['site_url'] ?>";   
</script>
<link rel="stylesheet" href="<?php echo asset('css/jquery.fileupload.css');?>" />
<script src="<?php echo asset('js/jquery.fileupload.js');?>"></script>
<script src="<?php echo asset('js/customer/manage_upload_files.js');?>"></script>

@stop