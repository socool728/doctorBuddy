@extends('layouts.customerlayout')
@section('content')
<!-- top tiles -->


<div class="row questionaire">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-8">
        <h1 class="search-title">Account activation & password creation<br/></h1>    
        </div>
        <div class="clear"></div>
        
        <div class="col-md-12 col-sm-12 col-xs-12">

                 <div class="dashboard_graph">
                    <div class="x_panel">
                        <div class="x_content bs-example-popovers">
                            <div class="alert question-box alert-dismissible fade in" role="alert">
                                <form action="javascript:void(0);" id="customer_form" name="customer_form" class="form-horizontal form-label-left" method="post" >
                                    <div id="custom_message_wrapper">
                                    <?php if(Session::get('flash_msg')): ?>
                                    <div id="message"  class="success-alert">
                                        <div id="message-text"><?php echo Session::get('flash_msg') ?></div>
                                    </div>
                                    <?php else : ?>
                                    <div id="message"  class="hide">
                                        <div id="message-text"></div>
                                    </div>
                                    
                                    <?php endif ?>
                                    </div>
                                    <div>
                                          <div class="item form-group">
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <label class="control-label " for="healthcare_professional_first_name"> Password
                                                    </label>
                                            </div> 
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                         <label class="control-label" for="healthcare_professional_middle_name"> Retype password
                                                    </label>
                                            </div>
                                        </div>
                                        <div >
                                            <div class="item form-group col-md-4 col-sm-4 col-xs-12">
                                                <input  id="customer_password" name="customer_password"  required="required" title="Password" class="frm-control" type="password" minlength="6">
                                           </div> 
                                            <div class="item form-group col-md-4 col-sm-4 col-xs-12">
                                                   <input data-validate-linked="customer_password"  id="customer_password1" name="customer_password1"   title="Retype Password" class="frm-control"  type="password" required="required" minlength="6">
                                           </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="col-md-4 col-sm-4 col-xs-12"></div>    
                                        <div class="col-md-8 col-sm-12 col-xs-12 text-centered">
                                            <button  onclick="return verify_account();" type="submit"  title="Register"  class="btn btn-primary" role="button">Save</button>
                                            <input type="hidden" name="form_submit" value="save">
                                            <input type="hidden" name="key" value="<?php echo $data['key'] ?>">
                                        </div>
                                     </div>

                                    </div>
                           
                                    </form>
                        </div>                    
                </div>
        </div>
    </div>
     
            
        </div>
   
       
    </div>
</div>

<script>
    var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>
   <script src="<?php echo asset('js/customer/verify_account.js'); ?>"></script>

@stop