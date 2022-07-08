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
        <h3>Search Cases</h3>
        <form action="javascript:void(0);" id="hpform" name="hpform" class="form-label-left" method="post"  role="form" >
            <div class="col-lg-12 col-sm-12  col-xs-12 registration-wrap  no-pad">
                <?php if($hpObj->healthcare_professional_status ==4) : ?>
                    <div class="warning-alert">Warning : Please complete your registration to access other areas.</div>
                <?php endif ?>            
                <div id="custom_message_wrapper">
                    <?php if(Session::get('flash_msg')): ?>
                    <div  class="success-alert">
                        <div><?php echo Session::get('flash_msg') ?></div>
                    </div>
                    <?php endif ; ?>
                    <div id="message"  class="hide">
                        <div id="message-text"></div>
                    </div>

                </div>

                <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
                    <div class="form-group  col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                        <label>Country</label> 
                        <?php if(count($country)>0){ ?>
                            <select class="form-control" name="healthcare_professional_country" title="Country"  id="healthcare_professional_country" onchange="javascript:getCountryState(this);">
                            <option value="" >Select Country</option>
                            <?php 
                            foreach($country as $val){  ?>
                            <option value="<?php echo $val['country_id'];?>" ><?php echo $val['countryname'];?></option>
                            <?php } ?>
                            </select>
                        <?php } ?> 
                    </div> 
                    <div class="form-group  col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">  
                        <label>State</label> 
                        <div  id="state_1">                   
                            <select class="form-control" name="healthcare_professional_state_select" title="State"  id="healthcare_professional_state_select"></select>
                        </div>
                        <div style="display:none" id="state_2">                                               
                        </div>

                    </div>            
                </div> 

                <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">

                    <div class="form-group  col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                        <label>City/Area</label> 
                        <input  id="customer_city" name="customer_city"   title="City" class="form-control"  type="text" value="">
                    </div>             
                    <div class="form-group  col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">
                        <label>Gender</label> 
                        <select class="form-control" name="customer_sex" title="Gender"  id="customer_sex" >
                            <option value="" >All</option>
                            <option value="female" >Female</option>
                            <option value="male" >Male</option>
                            <option value="not specified" >Not specified</option>
                        </select>
                    </div>            
                </div>

                <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
                    <div class="form-group  col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad symptomtag">
                        <label>Symptom</label> 
                        <p><input name="tags" id="mySingleField" type="hidden" value=""> <!-- only disabled for demonstration purposes --></p>
                        <ul id="singleFieldTags"></ul>
                    </div>
                </div>

                <div class="col-lg-12 col-sm-12 col-xs-12 no-pad text-right">
                    <button  onclick="return search_case();" type="button"  title="Update"  class="btn btn-red" role="button">Search</button>
                    <input type="hidden" name="form_submit" value="search">
                </div>            
            </div>
            <div id="resultdiv"></div>   
        </form>        
    </div>
</main>

<script>
    var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>



<link href="<?php echo asset('css/jquery.tagit.css'); ?>" rel="stylesheet" type="text/css">
<link href="<?php echo asset('css/tagit.ui-zendesk.css'); ?>" rel="stylesheet" type="text/css">
<script src="<?php echo asset('js/tag-it.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo asset('js/healthcare_professional/searchcase.js'); ?>"></script>
@stop