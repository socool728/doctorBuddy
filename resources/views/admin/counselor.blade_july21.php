@extends('layouts.adminlayout')
@section('content')

<div class="">
    <div class="clearfix"></div>

    <div class="row">
            <?php if(Session::has('flash_msg')){?>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="alert alert-success" ><?php echo Session::get('flash_msg');?></div>
                </div>                               
            <?php } ?>
        
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    
                    <h3 class="pagehd">Counselors</h3>
                    <h2 class="pagehdbtn">
                        <a href="<?php echo $data['site_url'] ?>/admin/counselor/add">
                            <i class="fa fa-plus fa-6" aria-hidden="true">&nbsp;Add Counselor</i>
                        </a> 
                    </h2>
                    <div class="clearfix">  </div>
                    
                </div>
                <div class="x_content">
                    <table id="example" class="table table-striped responsive-utilities jambo_table">
                        <thead>
                            <tr class="headings">
                                <th>SL No.</th>    
                                <th>Counselor Email</th>
                                <th>Counselor Name</th>                                
                                <th>Added Date</th>
                                <th>Status</th>
                                <th>Option</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                            $i = 0;
                            foreach($counselors as $counselor){ 
                            ?>

                                <tr class="even pointer">
                                    <td class=" "><?php echo ++$i?></td>
                                    <td class=" "><?php echo $counselor->counselors_email_id;?></td>
                                    <td class=" "><?php echo $counselor->counselors_firstname." ".$counselor->counselors_lastname; ?></td> 
                                    <td class=" "><?php echo date(Config::get('constants.DATE_TIME_FORMAT'),  strtotime($counselor->created_at));?></td>                                     
                                    <td>
                                        <?php if($counselor->counselors_status==3){ ?>
                                        
                                        <a href="<?php echo asset('admin/approve-counselor/'.$counselor->counselors_id)?>" onclick="return confirm('Are you sure to approve this Counselor?')">
                                            <i class="fa fa-thumbs-o-up fa-4" aria-hidden="true" title="Approve"></i>
                                        </a> 
                                        <?php }elseif($counselor->counselors_status==2 && $counselor->email_verify==0){ ?>
                                        Email Not verified
                                        <?php }elseif($counselor->counselors_status==1){ ?>
                                        Approved
                                        <?php }elseif($counselor->counselors_status==0){ ?>
                                        In Active
                                        <?php } ?>
                                    </td>
                                    <td>
                                       <a href="<?php echo asset('admin/viewcounselor/'.$counselor->counselors_id)?>">
                                            <i class="fa fa-eye fa-4" aria-hidden="true" title="Customer Details"></i>
                                       </a>
                                       &nbsp; 
                                        <a href="<?php echo asset('admin/counselor/edit/'.$counselor->counselors_id)?>">
                                            <i aria-hidden="true" class="fa fa-pencil fa-4" title="Edit"></i>
                                        </a>                                         
                                        &nbsp;                                       
                                       <a href="javascript:void(0);" delete_id ="{{ $counselor->counselors_id}}" class="link-delete" >
                                        <i class="fa fa-trash-o fa-4" aria-hidden="true"></i>
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
<script src="<?php echo asset('js/admin/list_counselor.js'); ?>"></script>
@stop