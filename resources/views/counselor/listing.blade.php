@extends('layouts.generallayout')
@section('content')

<?php $counselorObjects = $data['counselorObjects'];  //echo '<pre>';print_r($counselorObjects)?>


<h3>Counselor Listing</h3>
<?php if(Session::has('flash_msg')): ?>
<div class="col-lg-2 col-sm-2  col-xs-2" >   
</div>
<div class="col-lg-8 col-sm-8  col-xs-8 no-pad alert alert-danger text-center" >
    <?php echo Session::get('flash_msg') ?>    
</div>
<div class="col-lg-2 col-sm-2  col-xs-2" >   
</div>
<?php endif;?>

<div class="col-lg-12 col-sm-12  col-xs-12 no-pad">

    <?php $i =0 ;?>
    <div class="row">
        <?php foreach ($counselorObjects as $counselorObject) : ?>
            <?php ++$i ?>
                    <div class="col-lg-3 col-sm-6 col-xs-12 m-b">
            <div class="hp-listing-outer text-center">

                <a href="<?php echo asset('counselor/details/'.$counselorObject->counselors_id) ?>">
                    <?php if(isset($counselorObject->counselors_photo) && $counselorObject->counselors_photo !='') : ?>
                        <img src="<?php echo asset("uploads/counselor/thumbnail")."/".$counselorObject->counselors_photo ?>" width="80" height="80">
                    <?php else: ?>
                        <img src="<?php echo asset("public/images")."/user.png"?>" width="80" height="80"> 
                    <?php endif ;?>
                
                   

                    <?php
                    $nameArr=array();
                    if(isset($counselorObject->counselors_firstname) && $counselorObject->counselors_firstname !='') {
                     $nameArr[] = $counselorObject->counselors_firstname;
                    }
                    if(isset($counselorObject->counselors_middlename) && $counselorObject->counselors_middlename !='') {
                     $nameArr[] = $counselorObject->counselors_middlename;
                    }
                    if(isset($counselorObject->counselors_lastname) && $counselorObject->counselors_lastname !='') {
                     $nameArr[] = $counselorObject->counselors_lastname;
                    }
                    ?>
                <h4 class="m-b-xs">
                    <strong>                       
                        <?php  echo ucfirst(implode(" ", $nameArr)); ?>
                    </strong>
                </h4>
                
                <div class="font-bold">
                    <?php
                    if(isset($counselorObject->counselors_designation) && $counselorObject->	counselors_designation !=""){
                        echo $counselorObject->counselors_designation;
                    }
                    ?>                   
                </div>
                <address class="m-t-md">
                    <?php 
                    $addressArr =array();
                    if(isset($counselorObject->counselors_city) && $counselorObject->counselors_city !=""){
                         $addressArr[]= $counselorObject->counselors_city;
                     }

                    if(isset($counselorObject->counselors_state) && $counselorObject->counselors_state !=""){
                         $addressArr[]= $counselorObject->counselors_state;
                     }

                    if(isset($counselorObject->countryname) && $counselorObject->countryname !=""){
                         $addressArr[]= $counselorObject->countryname;
                     }                                        
                     echo implode(",", $addressArr);
                    ?>
                    <br/>

                  <?php  
                    if(isset($counselorObject->counselors_zip) && $counselorObject->counselors_zip !=""){
                         echo $counselorObject->counselors_zip;
                     } 
                   ?>

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
<script>
    var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>
@stop