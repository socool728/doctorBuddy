@extends('layouts.healthcarelayout')
@section('content')

<?php $hpObject = $data['hpObject'];  //echo '<pre>';print_r($hpObjects)?>



    <?php if ( $hpObject) : ?>
    <div class="container nopad">
    <div class="col-lg-12 col-sm-12 col-xs-12">
    	<div class="row m-b-lg m-t-lg">
                <div class="col-lg-6 col-sm-12 col-xs-12">

                    <div class=" col-lg-5 col-sm-5 col-xs-12 text-center p-block">
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
                                Provider

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
                            
<!--                            <abbr title="Phone">P:</abbr> 
                                <?php //echo $hpObject->healthcare_professional_phone_code ?>&nbsp;<?php //echo $hpObject->healthcare_professional_phone_number ?><br>
                            <abbr title="Phone">Email:</abbr> 
                                <?php //echo $hpObject->healthcare_professional_email_address ?>  -->
                        </address>
                        </div>
                                                
                    </div>
                    <div class="col-lg-7 col-sm-7 col-xs-12">
						<div class="ibox">
                        <div class="ibox-content">
                            <h4>About <?php echo $hpName ?></h4>

                            <p class="small">
                               <?php
                                if(isset($hpObject->healthcare_professional_profile) && $hpObject->healthcare_professional_profile !=""){
                                    echo $hpObject->healthcare_professional_profile;
                                } 
                               ?>                                
                            </p>    
                            <p class="small text-left">  
                              <?php
                                if(isset($hpObject->healthcare_professional_fees) && $hpObject->healthcare_professional_fees !=""){
                                   echo "<b>Cost</b> : $".$hpObject->healthcare_professional_fees;
                                }
                                ?>     
                            </p>

                        </div>
                    </div>  
                    <?php
                        $desArr=array();
                        if(isset($hpObject->healthcare_designation) && $hpObject->healthcare_designation !=""){
                            $desArr[] = $hpObject->healthcare_designation;
                        }
                        if(isset($hpObject->healthcare_professional_organization) && $hpObject->healthcare_professional_organization !=""){
                            $desArr[] = $hpObject->healthcare_professional_organization;
                        }
                        if(!empty($desArr))
                        {
                    ?>                   
                    <div class="ibox">
                        <div class="ibox-content">
                            <h4>Designation</h4>
                            <p class="small"><?php echo ucfirst(implode(",", $desArr));?></p>    
                        </div> 
                    </div>
                    <?php } ?>
                        <div class="ibox">
                        <div class="ibox-content">
                            <h4>Specialisation</h4>
                            <p class="small"><?php echo implode(",", $data['specilizations']); ?></p>    
                        </div> 
                    </div> 
                    	<div class="ibox">
                        <div class="ibox-content">
                            <h4>Insurances</h4>
                            <p class="small">
                             <?php echo implode(",", $data['insurances']); ?>       
                            </p>
                        </div> 
                    </div>
                    <div class="ibox">
                        <div class="ibox-content">
                            <h4>Languages</h4>
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
    <?php endif ;?>

<script>
    var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>
@stop








