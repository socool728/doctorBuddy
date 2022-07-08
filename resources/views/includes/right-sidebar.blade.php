<?php
        $query = "SELECT 
            `healthcare_professional`.healthcare_professional_id,
            `healthcare_professional`.healthcare_professional_first_name,
            `healthcare_professional`.healthcare_professional_middle_name,
            `healthcare_professional`.healthcare_professional_last_name,
            `healthcare_professional`.healthcare_designation,
            `healthcare_professional`.healthcare_professional_state,
            `healthcare_professional_details`.healthcare_professional_image,
            `healthcare_professional_to_languages`.language_id, 
            (SELECT `languages`.language_name FROM `languages` WHERE languages.language_id = healthcare_professional_to_languages.language_id) AS lang_name,
            `country`.countryname
            FROM `healthcare_professional`
            LEFT JOIN `healthcare_professional_details` 
            ON ( `healthcare_professional`.healthcare_professional_id = `healthcare_professional_details`.healthcare_professional_id ) 
            LEFT JOIN `healthcare_professional_to_languages` 
           ON ( `healthcare_professional`.healthcare_professional_id = `healthcare_professional_to_languages`.healthcare_professional_id ) 
           LEFT JOIN `country` ON ( `healthcare_professional`.healthcare_professional_country = `country`.country_id ) 
           WHERE healthcare_professional.healthcare_professional_status='1' limit 0,15";
        $healthcare_professionals = DB::select($query);  
        $data_healthcare = array();
        if(count($healthcare_professionals)>0){
            $i =0; $j =0; $healthcare_idarr =array();
            foreach($healthcare_professionals as $healthcare_data){  
                if(!in_array($healthcare_data->healthcare_professional_id,$healthcare_idarr)){  
//                    print_r($healthcare_data);
                    $lang_name = '';
                    $j = $i;
                    $name = $healthcare_data->healthcare_professional_first_name;
                    if(!empty($healthcare_data->healthcare_professional_middle_name)){
                        $name .= " ".$healthcare_data->healthcare_professional_middle_name;
                    }
                    $name .= " ".$healthcare_data->healthcare_professional_last_name;
                    $data_healthcare[$i]['healthcare_professional_id'] = $healthcare_data->healthcare_professional_id;
                    $data_healthcare[$i]['name'] = $name;
                    $data_healthcare[$i]['photo'] = $healthcare_data->healthcare_professional_image;
                    $data_healthcare[$i]['designation'] = $healthcare_data->healthcare_designation;
                    $data_healthcare[$i]['country'] = $healthcare_data->countryname;   
                    $data_healthcare[$i]['state'] = $healthcare_data->healthcare_professional_state;
                    $data_healthcare[$i]['language'] = $healthcare_data->lang_name;
                    $lang_name = $healthcare_data->lang_name;
                    $i++;
                    $healthcare_idarr[] = $healthcare_data->healthcare_professional_id;
                }else{

                    if($healthcare_data->lang_name != ''){
                        $lang_name .= ", ".$healthcare_data->lang_name;
                        $data_healthcare[$j]['language'] = $lang_name;
                    }
                }
            }
        }        

?>
<h2>Providers</h2>
<?php foreach($data_healthcare as $val){ ?>
<div class="provider-box">
<a href="<?php echo asset('healthcare_professional/details/'.$val['healthcare_professional_id'])?>">
    <div class="col-sm-2 col-xs-4 col-md-4">
        <div class="text-center">
            <?php if ($val['photo'] !='') : ?>
                <img src="<?php echo asset('uploads/healthcare_professional/thumbnail/'.$val['photo']);?>" class="m-t-xs img-responsive" alt="image">
            <?php else : ?>
                <img src="<?php echo asset('images/no_image.png');?>" class="m-t-xs img-responsive" alt="image">
            <?php endif ;?>

        </div>
    </div>
    <div class="col-sm-10 col-xs-8 col-md-8">
        <h3><strong><?php echo ucfirst($val['name'])?></strong></h3>
        <p><i class="fa fa-map-marker"></i> <?php echo ucfirst($val['state'])." ".$val['country'];?></p>

    </div>
    <div class="clearfix"></div>
</a>
</div>
<?php } ?>
<div class="leftsidebar animated slideInLeft1 active1" id="overlay">    
</div>                