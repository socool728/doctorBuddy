<?php
$query = "SELECT 
    `counselors`.counselors_id, 
    `counselors`.counselors_firstname, 
    `counselors`.counselors_middlename, 
    `counselors`.counselors_lastname, 
    `counselors`.counselors_designation,  
    `counselors`.counselors_photo, 
    `counselors`.counselors_state, 
    `counselors_to_languages`.language_id, 
    (SELECT `languages`.language_name FROM `languages` WHERE languages.language_id = counselors_to_languages.language_id) AS lang_name,
    `country`.countryname
FROM `counselors`
LEFT JOIN `counselors_to_languages` ON ( `counselors`.counselors_id = `counselors_to_languages`.counselors_id ) LEFT JOIN `country` ON ( `counselors`.country_id = `country`.country_id ) WHERE counselors.counselors_status=1 order by `counselors`.counselors_id limit 0,9";
        $counselors = DB::select($query); 
        $data_counselor= array(); 
        
        if(count($counselors)>0){
            $i =0; $j =0; $counselor_idarr =array();
            foreach($counselors as $counselor_data){  
                if(!in_array($counselor_data->counselors_id,$counselor_idarr)){                                    
                    $lang_name = '';
                    $j = $i;
                    $name = $counselor_data->counselors_firstname;
                    if(!empty($counselor_data->counselors_middlename)){
                        $name .= " ".$counselor_data->counselors_middlename;
                    }
                    $name .= " ".$counselor_data->counselors_lastname;
                    $data_counselor[$i]['counselor_id'] = $counselor_data->counselors_id;;
                    $data_counselor[$i]['name'] = $name;
                    $data_counselor[$i]['designation'] = $counselor_data->counselors_designation;
                    $data_counselor[$i]['country'] = $counselor_data->countryname;   
                    $data_counselor[$i]['state'] = $counselor_data->counselors_state;
                    $data_counselor[$i]['photo'] = $counselor_data->counselors_photo;
                    $data_counselor[$i]['language'] = $counselor_data->lang_name;
                    $lang_name = $counselor_data->lang_name;
                    $i++;
                    $counselor_idarr[] = $counselor_data->counselors_id;
                }else{

                    if($counselor_data->lang_name != ''){
                        $lang_name .= ", ".$counselor_data->lang_name;
                        $data_counselor[$j]['language'] = $lang_name;
                    }
                }
            }
        }
     

?>
<h2>Counsellors </h2>
<?php foreach($data_counselor as $val){ ?>
<div class="doctor-box">
        <a href="<?php echo asset('counselor/details/'.$val['counselor_id'])?>">
        <div class="col-sm-2 col-xs-4 col-md-4">
            <div class="text-center">
                <?php if ($val['photo'] !='') : ?>
                    <img src="<?php echo asset('uploads/counselor/thumbnail/'.$val['photo']);?>" class="m-t-xs img-responsive" alt="image">
                <?php else : ?>
                    <img src="<?php echo asset('images/no_image.png');?>" class="m-t-xs img-responsive" alt="image">
                <?php endif ;?>
            </div>
        </div>
        <div class="col-sm-10 col-xs-8 col-md-8">
            <h3><strong><?php echo ucfirst($val['name'])?></strong></h3>
            <?php if($val['designation']) { ?>
                <p><?php echo ucfirst($val['designation'])?></p>
            <?php } ?>
            <address><i class="fa fa-map-marker"></i> 
<!--                <strong>Twitter, Inc.</strong><br>-->
                <?php echo $val['state'].", ".$val['country'];?><br>
<!--                <abbr title="Phone">P:</abbr> (123) 456-7890-->
            </address>
        </div>
        <div class="clearfix"></div>
            </a>
</div>
<?php } ?>
