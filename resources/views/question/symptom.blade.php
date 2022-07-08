<div id="symptomdiv_1" >   
    
    <?php 
    if(count($symptom)>0){
        foreach($symptom as $symptomdetails){?>
     <?php if ($symptomdetails['symptom_name'] != '') { ?>
        
            
                <label class="lblbth col-sm-12 col-xs-12 ajsympt" for="first-name"><a class="symptlist" <?php if(isset($data['did']) && $data['did']>0){?> id="<?php echo $data['did']."_".$symptomdetails['symptom_id'];?>"  <?php }else{ ?>
                                                                                      id="<?php echo $symptomdetails['symptom_id'];?>" <?php }?>><?php echo $symptomdetails['symptom_name'];?></a>
            </label>
               
                
                

            
        <?php } }
     }
     ?>
    </div>

<div id="symptomdiv_2"></div>
                                            