@extends('layouts.adminlayout')
@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Counselors</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Counselors  <small></small></h2>
                    <div class="clearfix"> </div>
                </div>
                <div class="x_content">       
                    <div class="reportdv">
                        <label class="control-rpt col-md-12 col-sm-3 col-xs-12" for="first-name">Counselors Email :<?php echo $data['counselors_email_id'];?>
                        </label>
                    </div>
                     <div class="reportdv"></div>
                        <div class="ln_solid"></div> 
                        <?php if($data['counselors_country'] !=''){ ?>
                          <div class="reportdv">
                                <label class="control-rpt col-md-12 col-sm-3 col-xs-12" for="last-name">Country :<?php echo $data['counselors_country'];?>
                                </label>
                                            
                           </div>
                      <?php } if($data['counselors_state'] !=''){ ?>
                            <div class="reportdv">
                                <label class="control-rpt col-md-12 col-sm-3 col-xs-12" for="last-name">State : <?php echo $data['counselors_state'];?>
                                </label>                                            
                            </div>
                        <?php } if($data['counselors_city'] !=''){ ?>
                        <div class="reportdv">
                            <label class="control-rpt col-md-12 col-sm-3 col-xs-12" for="last-name">City/Area : <?php echo $data['counselors_city'];?>
                            </label>                                            
                        </div>
                       <?php } if($data['counselors_zip'] !=''){ ?>
                        <div class="reportdv">
                            <label class="control-rpt col-md-12 col-sm-3 col-xs-12" for="last-name">ZIP/Postal Code : <?php echo $data['counselors_zip'];?>
                            </label>                                            
                        </div>
                        <?php } if($data['counselors_phone'] !=''){ ?>
                        <div class="reportdv">
                            <label class="control-rpt col-md-12 col-sm-3 col-xs-12" for="last-name">Phone : <?php echo $data['counselors_phone'];?>
                            </label>                                            
                        </div>
                        <?php  }?>
                        <div class="reportdv">
                            <label class="control-rpt col-md-12 col-sm-3 col-xs-12" for="last-name">Status : <?php echo $data['counselors_status'];?>
                            </label>                                            
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <a href="../counselor"><button type="button" class="btn btn-primary">Back</button></a>
                                <?php if($data['counselors_status']=='new' || $data['counselors_status']=='waiting for approval'){ ?>
                                        <a href="../approve-counselor/<?php echo $data['counselors_id']?>" onclick="return confirm('Are you sure to approve this Counselor?')"><button type="button" class="btn btn-delete">Approve</button></a> 
                                 <?php } else if($data['counselors_status']=='approved' ){ ?>
                                        <a href="../inactivate-counselor/<?php echo $data['counselors_id']?>" onclick="return confirm('Are you sure to inactivate this Counselor?')"><button type="button" class="btn btn-delete">Inactivate</button></a> 
                                 <?php }  else if($data['counselors_status']=='inactive' ){ ?>
                                        <a href="../approve-counselor/<?php echo $data['counselors_id']?>" onclick="return confirm('Are you sure to approve this Counselor?')"><button type="button" class="btn btn-delete">Activate</button></a> 
                                 <?php } ?>
                            </div>
                        </div>
                </div>
            </div>
        </div>

        <br />
        <br />
        <br />

    </div>
</div>

@stop
