@extends('layouts.adminlayout')
@section('content')


<?php $hpObject = $data['hpObject'] ?>

<div class="">
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Helathcare Professional</h2>
                    <div class="clearfix"> </div>
                </div>
                <div class="x_content">       
                    
                    <div class="container nopad">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
    	<div class="row m-b-lg m-t-lg">
                <div class="col-lg-12 col-sm-12 col-xs-12">

                    <div class=" col-lg-3 col-sm-3 col-xs-12 text-center p-block">
                        <?php if(isset($hpObject->healthcare_professional_image) && $hpObject->healthcare_professional_image !='') : ?>
                            <img src="<?php echo asset("uploads/healthcare_professional/thumbnail")."/".$hpObject->healthcare_professional_image ?>"  class="img-circle circle-border m-b-md" alt="profile">
                        <?php else: ?>
                            <img src="<?php echo asset("public/images")."/user.png"?>" width="80" height="80" class="img-circle circle-border m-b-md" alt="profile"> 
                        <?php endif ;?>
                        <div>
                            <h3>
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
                                    echo $hpName = ucfirst(implode(" ", $nameArr));
                                  ?>
                            </h3>
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
                        <address class="m-t-md address">
                            <?php 
                                                              
                            if(isset($hpObject->healthcare_professional_zip_code) && $hpObject->healthcare_professional_zip_code !=""){
                              echo $hpObject->healthcare_professional_zip_code."<br>";
                            }
                            
                            if(isset($hpObject->healthcare_professional_city) && $hpObject->healthcare_professional_city !=""){
                                echo $hpObject->healthcare_professional_city."<br>";
                            }
                            $addressArr =array();  
                            if(isset($hpObject->healthcare_professional_state) && $hpObject->healthcare_professional_state !=""){
                                $addressArr[]= $hpObject->healthcare_professional_state;
                            }
                            if(isset($hpObject->countryname) && $hpObject->countryname !=""){
                                 $addressArr[]= $hpObject->countryname;
                             }                             
                           echo implode(",", $addressArr)."<br>";
                           ?>
                            
                            <abbr title="Phone">P:</abbr> <?php echo $hpObject->healthcare_professional_phone_code ?>&nbsp;<?php echo $hpObject->healthcare_professional_phone_number ?><br>
  <abbr title="Phone">Email:</abbr> <?php echo $hpObject->healthcare_professional_email_address ?>  
                        </address>
                        </div>
                                                
                    </div>
                    <div class="col-lg-9 col-sm-9 col-xs-12">
                        <div class="ibox m-b-40">
                            <div class="ibox-content">
                            <h3 class="detail_heading">About <?php echo $hpName ?></h3>

                            <p class="small">
                            <?php
                            if(isset($hpObject->healthcare_professional_profile) && $hpObject->healthcare_professional_profile !=""){
                            echo $hpObject->healthcare_professional_profile;
                            } 
                            ?>                                
                            </p>    
                            <p class="small text-left">  
                            <b>Cost</b> :<?php
                            if(isset($hpObject->healthcare_professional_fees) && $hpObject->healthcare_professional_fees !=""){
                            echo "<b>Cost</b> : $".$hpObject->healthcare_professional_fees;
                            }
                            ?>     
                            </p>

                            </div>
                        </div>  
                         
                        <div class="ibox m-b-40">
                        <div class="ibox-content">
                            <h3 class="detail_heading">Specialisation</h3>
                            <p class="small"><?php echo implode(",", $data['specilizations']); ?></p>    
                        </div> 
                    </div> 
                    	<div class="ibox m-b-40">
                        <div class="ibox-content">
                            <h3 class="detail_heading">Insurances</h3>
                            <p class="small">
                             <?php echo implode(",", $data['insurances']); ?>       
                            </p>
                        </div> 
                    </div>
                        <div class="ibox m-b-40">
                        <div class="ibox-content">
                            <h3 class="detail_heading">Languages</h3>
                            <p class="small">
                                <?php echo implode(",", $data['languages']); ?>  
                            </p>
                        </div> 
                    </div>      
                        
                    </div>
                </div>

            </div>
         
    </div>
                    </div>
                    <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-3">
                                <a href="<?php echo asset('admin/healthcareprofessional')?>">
                                    <button type="button" class="btn btn-primary">Back</button>
                                </a>
                                <a href="<?php echo asset('admin/casefiles/hp/'.$hpObject->healthcare_professional_id)?>">
                                    <button type="button" class="btn btn-primary">Assigned cases</button>
                                </a>                                
                                <button delete_id ="{{$hpObject->healthcare_professional_id}}" type="button" class="btn btn-delete">Delete</button>
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
<script src="<?php echo asset('js/admin/list_hp.js'); ?>"></script>    

@stop
