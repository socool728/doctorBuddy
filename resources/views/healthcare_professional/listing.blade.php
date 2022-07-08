@extends('layouts.generallayout')
@section('content')

<?php $hpObjects = $data['hpObjects']; // echo '<pre>';print_r($hpObjects)?>


<h3 class="text-center">Search Provider</h3>
<?php if(Session::has('flash_msg')): ?>
<div class="col-lg-2 col-sm-2  col-xs-2" >   
</div>
<div class="col-lg-8 col-sm-8  col-xs-8 no-pad alert alert-danger text-center" >
    <?php echo Session::get('flash_msg') ?>    
</div>
<div class="col-lg-2 col-sm-2  col-xs-2" >   
</div>
<?php endif;?>


<!-- Start:Search Area-->
<?php
 $countries = $data['countries'];
 $specilizations = $data['specilizations'];
 $insuranceCompanies = $data['insuranceCompanies'];
?>

<div class="col-lg-8 col-sm-8  col-xs-12 no-pad m-b-lg search_box">
<form action="javascript:void(0);" id="hp_search_from" name="hp_search_from" class="form-label-left" method="post"  role="form" >
        <div class="col-lg-12 col-sm-12  col-sx-12 m-t-xl registration-wrap left no-pad">
            <div id="message"  class="hide col-lg-12 col-sm-12 col-sx-12">
                <div id="message-text"></div>
            </div> 

           <div class="col-lg-12 col-sm-12 col-sx-12 no-pad">
                <div class="form-group col-lg-4 col-sm-4 col-xs-12 no-pad right-pad">
                    <label>Country</label> 
                    <?php if(count($countries)>0){ ?>
                     <select class="form-control " name="healthcare_professional_country" title="Country"  id="healthcare_professional_country" onchange="javascript:getCountryState(this);">
                                 <option value="" >Select Country</option>
                                <?php 
                                foreach($countries as $country){  ?>
                                <option value="<?php echo $country->country_id ;?>" ><?php echo $country->countryname;?></option>
                           <?php } ?>
                    </select>
                    <?php } ?>
                </div>  
                <div class="form-group col-lg-4 col-sm-4 col-xs-12 no-pad right-pad">
                    <label>State</label>
                    <div  id="state_1" >
                        <select class="form-control " name="healthcare_professional_state_select" title="State"  id="healthcare_professional_state_select"></select>
                    </div>                                       
                    <div style="display:none" id="state_2" ></div>
                </div>
               
                <div class="form-group col-lg-4 col-sm-4 col-xs-12 no-pad">
                   <label>City/Area</label> 
                   <input  id="healthcare_professional_city" name="healthcare_professional_city"   title="City" class="form-control"  type="text" ="">
                </div>
           </div>
           <div class="col-lg-12 col-sm-12 col-sx-12 no-pad">
           <div class="form-group col-lg-4 col-sm-4 col-xs-12 no-pad right-pad">
                    <label>Designaton</label> 
                    <input  id="healthcare_designation" name="healthcare_designation"   title="Designation" class="form-control" type="text">
                </div>
                <div class="form-group col-lg-4 col-sm-4 col-xs-12 no-pad right-pad">
                    <label>Fees</label> 
                    <input  id="healthcare_professional_fees" name="healthcare_professional_fees"   title="Fees" class="form-control" type="text">
                </div>
                <div class="form-group col-lg-4 col-sm-4 col-xs-12 no-pad">
                    <label>Organization</label> 
                    <input  id="healthcare_professional_organization" name="healthcare_professional_organization"   title="Organization" class="form-control" type="text">
                </div>  
                               
           </div>
			<div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
            	<div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad right-pad">
                    <label>Specialization</label> 
                    <select class="form-control " name="specilization_id[]" title="Specilization"  id="specilization_id"  multiple="true">
                                 <option value="0" >Select Specilization</option>
                                <?php 
                                foreach($specilizations as $specilizations){  ?>
                                <option value="<?php echo $specilizations->specilization_id ;?>" ><?php echo $specilizations->specilization_name;?></option>
                           <?php } ?>
                    </select>                  
                </div>
                <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad">
                    <label>Insurance</label> 
                     <select class="form-control " name="insurance_id[]" title="Insurance"  id="insurance_id" multiple="true">
                                 <option value="0" >Select Insurance</option>
                                <?php 
                                foreach($insuranceCompanies as $insuranceCompany){  ?>
                                <option value="<?php echo $insuranceCompany->insurance_id ;?>" ><?php echo $insuranceCompany->insurance_name;?></option>
                           <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-12 col-sm-12 col-xs-12 no-pad" >
                 <div class="form-group col-lg-9 col-sm-9 col-xs-12 no-pad right-pad">
                    <label>Search Words</label> 
                        <input name="search_words" id="search_words" type="hidden" value="">
                        <ul id="search_words_tags"></ul>                    
                        <a style="top:40px !important;" class="info-icon" href="javascript:void(0);"  data-container="body" data-container="body"  data-placement="top" data-toggle="popover"   data-content="The values in this field will check against the provider's profile , biodata etc">
                            <i class="clr-blu fa fa-info-circle" aria-hidden="true" ></i>
                        </a>
                </div> 
                <div class="form-group col-lg-3 col-sm-3 col-xs-12 text-right m-t-lg"><button type="submit"  onclick="return search_hp();" title="Register"  class="btn btn-red" role="button">Submit</button></div>              
            </div>

          <!-- <div class="col-lg-12 col-sm-12 col-sx-12 no-pad">
               <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
                                       
               </div>   
               
           </div>-->
        </div>                                    
                    
    </form>    
</div>    
<!-- Stop:Search Area-->


<div class="col-lg-12 col-sm-12 col-sx-12 no-pad m-b-lg" >
    <h3>Provider Listing</h3>
</div>

<div id="search_result" class="col-lg-12 col-sm-12 col-sx-12 no-pad">
    <div class="col-lg-12 col-sm-12  col-xs-12 no-pad">

    <?php $i =0 ;?>
    <div class="row">
        <?php foreach ($hpObjects as $hpObject) : ?>
            <?php ++$i ?>
        
            <div class="col-lg-3 col-sm-6 col-xs-12 m-b">
            <div class="hp-listing-outer text-center">

                <a href="<?php echo asset('healthcare_professional/details/'.$hpObject->healthcare_professional_id) ?>">
                <?php if(isset($hpObject->healthcare_professional_image) && $hpObject->healthcare_professional_image !='') : ?>
                    <img src="<?php echo asset("uploads/healthcare_professional/thumbnail")."/".$hpObject->healthcare_professional_image ?>" width="80" height="80">
                <?php else: ?>
                    <img src="<?php echo asset("public/images")."/user.png"?>" width="80" height="80"> 
                <?php endif ;?>
                   

                <?php
                    $nameArr=array();
                    if(isset($hpObject->healthcare_professional_first_name) && $hpObject->healthcare_professional_first_name !='') {
                     $nameArr[] = $hpObject->healthcare_professional_first_name;
                    }
                    if(isset($hpObject->healthcare_professional_middle_name) && $hpObject->healthcare_professional_middle_name !='') {
                     $nameArr[] = $hpObject->healthcare_professional_middle_name;
                    }
                    if(isset($hpObject->healthcare_professional_last_name) && $hpObject->healthcare_professional_last_name !='') {
                     $nameArr[] = $hpObject->healthcare_professional_last_name;
                    }

                ?>
                <h4 class="m-b-xs">
                    <strong>                       
                        <?php  echo ucfirst(implode(" ", $nameArr)); ?>
                    </strong>
                </h4>
                
                <div class="font-bold">
                    <?php
                    $desArr=array();
                    if(isset($hpObject->healthcare_designation) && $hpObject->healthcare_designation !=""){
                        $desArr[] = $hpObject->healthcare_designation;
                    }
                    if(isset($hpObject->healthcare_professional_organization) && $hpObject->healthcare_professional_organization !=""){
                        $desArr[] = $hpObject->healthcare_professional_organization;
                    }
                    echo ucfirst(implode(",", $desArr));
                    ?>                    
                </div>
                <address class="m-t-md">
                <?php 
                    $addressArr =array();

                     if(isset($hpObject->healthcare_professional_city) && $hpObject->healthcare_professional_city !=""){
                          $addressArr[]= $hpObject->healthcare_professional_city;
                      }

                     if(isset($hpObject->healthcare_professional_state) && $hpObject->healthcare_professional_state !=""){
                          $addressArr[]= $hpObject->healthcare_professional_state;
                      }

                     if(isset($hpObject->countryname) && $hpObject->countryname !=""){
                          $addressArr[]= $hpObject->countryname;
                      }                                        
                      echo implode(",", $addressArr);
                ?> 
                    <br/>

                <?php  
                    if(isset($hpObject->healthcare_professional_zip_code) && $hpObject->healthcare_professional_zip_code !=""){
                         echo $hpObject->healthcare_professional_zip_code;
                    } 
               ?> 
<!--                      <br/>
                  <abbr title="Phone">P:</abbr> -->
                        <?php //echo $hpObject->healthcare_professional_phone_code. $hpObject->healthcare_professional_phone_number ?> 
 <!--                   <br/>
                    <abbr title="Email">E:</abbr> -->
                        <?php //echo $hpObject->healthcare_professional_email_address ?>
                </address>
                
</a> 

        </div>
        </div>

            <?php 
            if($i%4 ==0)
            { 
                echo "</div><div class='row'>";
            }
            ?>

        <?php endforeach;?>
    </div>                        
                          
</div>
</div>


    


<script>
    var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>
<style>
    .ui-widget{
        font-size:0.9em !important;
    }
</style>
<link href="<?php echo asset('css/jquery.tagit.css'); ?>" rel="stylesheet" type="text/css">
<link href="<?php echo asset('css/tagit.ui-zendesk.css'); ?>" rel="stylesheet" type="text/css">
<script src="<?php echo asset('js/tag-it.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo asset('js/healthcare_professional/search_hp.js'); ?>"></script>
@stop