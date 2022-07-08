@extends('layouts.adminlayout')
@section('content')
<?php
$templateObj =$data['templateObj'] ;
$hpObjs =$data['hpObjs'] ;
$alreadyAssignedHpIds = $data['alreadyAssignedHpIds'] ;
?>
<div class="">

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Assign Provider(s) for the template <i><?php echo $templateObj->template_title ?></h2>
                    <div class="clearfix"> </div>
                </div>
                <div class="x_content">
                    
                    <div id="message"  class="hide item form-group">
                        <div id="message-text"></div>
                    </div>
                    <form action="javascript:void(0);" class="form-horizontal form-label-left" novalidate  method="post"  id="assign_provider_form">
                        <table id="example" class="table table-striped responsive-utilities jambo_table">
                        <thead>
                            <tr class="headings">
                                <th>SL No.</th>    
                                <th></th>
                                <th>Name</th>                                
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Designation</th>
                                <th>Location</th>
                                <th>Option</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                            $i = 0;
                            foreach($hpObjs as $hpObj){ 
                            ?>

                                <tr class="even pointer">
                                    <td ><?php echo ++$i?></td>
                                    <td>
                                        <?php
                                        if(in_array($hpObj->healthcare_professional_id,$alreadyAssignedHpIds)){
                                            $checked = "checked";
                                        }else{
                                            $checked = "";
                                        }

                                        ?>
                                        <input type="checkbox" name="providers[]" id="providers" value="<?php echo $hpObj->healthcare_professional_id ?>" <?php echo $checked ?>>
                                    </td>
                                    <td >
                                        <?php 
                                        $name = $hpObj->healthcare_professional_first_name;
                                        if($hpObj->healthcare_professional_first_name !=''){
                                            $name .= " ".$hpObj->healthcare_professional_middle_name;
                                        }
                                        $name .= " ".$hpObj->healthcare_professional_last_name;
                                        echo $name;
                                        ?>
                                    </td>
                                    <td ><?php echo $hpObj->healthcare_professional_email_address; ?></td>   
                                    <td ><?php echo $hpObj->healthcare_professional_phone_code.$hpObj->healthcare_professional_phone_number; ?></td>
                                    <td ><?php echo $hpObj->healthcare_designation; ?></td>  
                                    <td >
                                        <?php
                                        $address =array();
                                        if($hpObj->healthcare_professional_city !='')
                                            $address[] = $hpObj->healthcare_professional_city;
                                        
                                        if($hpObj->healthcare_professional_state !='')
                                            $address[] = $hpObj->healthcare_professional_state;
                                        
                                        $address[] = $hpObj->countryname;
                                        $addressStr = implode(",", $address);
                                        
                                         if($hpObj->healthcare_professional_zip_code !='')
                                            $addressStr .=  "<br/>".$hpObj->healthcare_professional_zip_code;
                                         echo $addressStr;

                                        ?>
                                    </td>  
                                    <td>
                                        <a href="<?php echo asset('admin/healthcareprofessional/view/'.$hpObj->healthcare_professional_id)?>" target="_blank">
                                            <i class="fa fa-eye fa-4" aria-hidden="true" title="More Details"></i>
                                        </a>
                                        &nbsp;
                                    </td>
                                   
                                </tr>   
                            <?php } ?>
                        </tbody>

                    </table>


                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <a href="<?php echo $data['site_url'] ?>/admin/templates">
                                    <button type="button" class="btn btn-primary" name="cancel" id="cancel">Cancel</button>
                                </a>
                                <button type="submit" class="btn btn-success" name="assign" id="assign" onclick="return assign_provider_template();">Assign</button>
                                <input type="hidden" name="form_submit" value="save">
                                <input type="hidden" name="template_id"  id="template_id" value="<?php echo $templateObj->communication_template_id ?>">
                               
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>

        <br />
        <br />
        <br />

    </div>
</div>
<script>
 var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>
<script src="<?php echo asset('js/admin/assign_provider_template.js'); ?>"></script>

@stop
