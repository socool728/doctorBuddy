@extends('layouts.adminlayout')
@section('content')

<div class="">

    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    
                    <h3 class="pagehd">Providers</h3>
                    <h2 class="pagehdbtn">
                        <a href="<?php echo $data['site_url'] ?>/admin/healthcareprofessional/add">
                            <i class="fa fa-plus fa-6" aria-hidden="true">&nbsp;Add Provider</i>
                        </a> 
                    </h2>
                    <div class="clearfix">  </div>
                    
                </div>
                <?php if(Session::get('flash_msg') != ''){?>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="alert alert-success" id="" ><?php echo Session::get('flash_msg');?></div>
                </div>                               
                <?php } ?>
                <div class="x_content">
                    <table id="example" class="table table-striped responsive-utilities jambo_table">
                        <thead>
                            <tr class="headings">
                                <th>SL No.</th>       
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Option</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                            $i = 0;
                            foreach($healthcareprofessionals as $healthcareprofessional){ 
                            ?>

                                <tr class="even pointer">
                                    <td class=" ">{{++$i}}</td>
                                    <td class=" ">{{ucfirst($healthcareprofessional->healthcare_professional_first_name)}}</td>
                                    <td class=" ">{{ucfirst($healthcareprofessional->healthcare_professional_last_name)}}</td>
                                    <td class=" ">{{$healthcareprofessional->healthcare_professional_email_address}}</td>
                                    <td class=" ">{{$healthcareprofessional->healthcare_professional_phone_number}}</td>
                                    
                                    
                                    <?php if($healthcareprofessional->healthcare_professional_status): ?>
<!--                                    <td class=" ">
                                        <a href="javascript:void(0);" class="status-change" record_id ="{{$healthcareprofessional->healthcare_professional_id}}" title="Change Status" ><img src="../images/active.png"></a>    
                                    </td>-->
                                    <?php else : ?>
<!--                                     <td class=" ">
                                        <a href="javascript:void(0);" class="status-change" record_id ="{{$healthcareprofessional->healthcare_professional_id}}" title="Change Status" ><img src="../images/inactive.png"></a>    
                                    </td>-->
                                    <?php endif ?>                                                                    
                                    <td>
                                        <?php if($healthcareprofessional->healthcare_professional_status==3){ ?>
                                        <a href="<?php echo asset('admin/approve-hp/'.$healthcareprofessional->healthcare_professional_id)?>" onclick="return confirm('Are you sure to approve this Healthcare Professional?')">
                                            <i class="fa fa-thumbs-o-up fa-4" aria-hidden="true" title="Approve"></i>
                                        </a> 
                                        <?php }elseif($healthcareprofessional->healthcare_professional_status==2 && $healthcareprofessional->email_verify==0){ ?>
                                        Email Not verified   
                                        <?php }elseif($healthcareprofessional->healthcare_professional_status==4){ ?>
                                        Incomplete Signup  
                                        <?php }elseif($healthcareprofessional->healthcare_professional_status==1){ ?>
                                        Approved
                                        <?php }elseif($healthcareprofessional->healthcare_professional_status==0){ ?>
                                        In Active
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo asset('admin/healthcareprofessional/view/'.$healthcareprofessional->healthcare_professional_id)?>">
                                           <i class="fa fa-eye fa-4" aria-hidden="true" title="Healthcare Details"></i>
                                        </a>
                                        &nbsp;                                       
                                        <a href="<?php echo asset('admin/templates/particular_provider/'.$healthcareprofessional->healthcare_professional_id)?>">
                                            <i class="fa fa-sliders fa-4" aria-hidden="true" title="Templates"></i>
                                        </a>
                                       &nbsp;                                         
                                        <a href="<?php echo asset('admin/healthcareprofessional/edit/'.$healthcareprofessional->healthcare_professional_id)?>">
                                            <i aria-hidden="true" class="fa fa-pencil fa-4" title="Edit"></i>
                                        </a> 
                                       &nbsp;                                         
                                        <a href="<?php echo asset('admin/casefiles/hp/'.$healthcareprofessional->healthcare_professional_id)?>">
                                            <i class="fa fa-bars fa-4" aria-hidden="true" title="Assigned Cases"></i>
                                        </a>
                                        &nbsp;
                                        <a href="javascript:void(0);" delete_id ="{{$healthcareprofessional->healthcare_professional_id}}" class="link-delete">
                                            <i class="fa fa-trash-o fa-4" aria-hidden="true" title="Delete"></i>
                                        </a>
                                    </td>
                                    
                                    
                                </tr>   
                            <?php } ?>
                        </tbody>

                    </table>
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
<script src="<?php echo asset('js/admin/list_hp.js'); ?>"></script>
@stop

