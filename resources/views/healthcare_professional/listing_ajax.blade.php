<?php $hpObjects = $data['hpObjects'];?>
<?php if(count($hpObjects) >0) : ?>
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
<?php else : ?>

<div class="col-lg-6 col-sm-6  col-xs-6  col-lg-offset-3 no-pad text-center alert alert-danger">
    No Record Found
</div>
<?php endif; ?>
