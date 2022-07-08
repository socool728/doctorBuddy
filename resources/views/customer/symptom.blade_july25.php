@extends('layouts.customerlayout')
@section('content')
<div class="cd-main-header">		
    <a class="cd-nav-trigger" href="#0">
        <span></span>
    </a>		
</div>
<main class="cd-main-content">
    @include('customer.dashboardmenu')
     
    <div class="content-wrapper col-lg-9 col-sm-9 col-xs-12">        
        <div class="ibox float-e-margins">
        <div class="ibox-title">
                <h3>Physical symptoms of <?php echo $data['customer_nickname'];?></h3>
        </div>
        <div class="ibox-content">
            <div class="col-lg-12 col-sm-12 col-xs-12">
                 <form  action="" id="qform" name="qform"  method="post">

                    <div class="col-lg-12 col-sm-12 col-xs-12  m-b" id="addsympdv">
                        <div class="col-lg-10  ">
                            <input type="hidden" name="detailid" id="detailid" value="<?php echo $data['id'];?>" />
                        </div>
                        <div class="col-lg-2">
                            <button type="button" href="update"  title="Update" onclick="javascript:add();" class="btn btn-red" role="button">Add New</button>
                        </div>
                    </div>


                    <div class="col-lg-12 col-sm-12 col-xs-12 hidedv no-padding m-b-md" id="addsymp" style="display:none;border:1px solid gray;border-radius: 10px;">
       
                        <div class="col-lg-6">
                            <div class="item form-group">
                                <label>Symptom </label>
                                <div>
                                    <input id="symptom" name="symptom" value="" class="symptsearch form-control" type="text" autocomplete="off" placeholder="type here..">
                                </div>
                            </div>
                            <div class="symptombox symptomeditbox" id="symptomboxdiv" style="display:none;">
                                <div id="symptomdiv" ></div>      
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="col-lg-6 no-pad" id="symptom-outer-area" style="display: none;">
                                <label class="col-lg-12 col-sm-12 col-xs-12 ti no-pad">Your added symptoms</label>
                                <div class="col-lg-12 col-sm-12 col-xs-12 grey-bg added-symptons">
                                    <div id="symptom-inner-area"></div>

                                </div>
                            </div>

                        </div>


                        <div class="col-lg-12 col-sm-12 col-xs-12 m-b-md">
                            <button type="button" href="update"  title="Update" onclick="javascript:addsymptom();" class="btn btn-red" role="button">Add Symptom</button>
                        </div>
                        
                    </div>
                     
                     
                     <div id="custsymp" class="m-t">
                    <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
                    <div class="table-responsive">
                        <table class="table display" width="100%" cellspacing="0" id="case_symptoms">   
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Rate</th>
                                    <th>Comment</th>
                                    <th>Date</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $j =0 ;?>
                                <?php if(isset($data['symptomdetails'])&& count($data['symptomdetails']) > 0){ ?>
                                    <?php foreach($data['symptomdetails'] as $symptomdetail){ ?>
                                        <tr>
                                            <td><?php echo ++$j ?></td>
                                            <td><?php echo ucfirst($symptomdetail->symptom_name) ;?></td>
                                            <td>
                                                <?php if($symptomdetail->symptom_rate) { ?>
                                                    <div>
                                                        <?php echo $symptomdetail->symptom_rate ?>
                                                    </div>
                                                <?php } ?>  
                                            </td>
                                            <td><?php echo $symptomdetail->customer_note ?></td>
                                            <td><?php echo date(Config::get('constants.DATE_FORMAT'),  strtotime( $symptomdetail->created_date));?></td>
                                            <td class="links">                                 
                                                <a  href="javascript:void(0);"onclick="delete_symptom(<?php echo $symptomdetail->customer_symptom_id ?>)" title="Delete">
                                                    <img src="<?php echo asset('images/delete.png'); ?>" height="16" width="16">
                                                </a>
                                                &nbsp;
                                                <a  href="javascript:void(0);"onclick='edit_symptom(<?php echo $symptomdetail->customer_symptom_id ?>,"<?php echo ucfirst($symptomdetail->symptom_name) ;?>")' title="Edit">
                                                    <img src="<?php echo asset('images/edit-icon.png'); ?>" height="16" width="16">
                                                </a>
<!--                                                &nbsp;
                                                <a  href="javascript:void(0);" onclick='open_symptom_history(<?php echo $data['id']?>,<?php echo $symptomdetail->symptom_id ?>,"<?php echo ucfirst($symptomdetail->symptom_name) ;?>")'  title="History" class="symptom_history">
                                                    <img src="<?php echo asset('images/history-icon.png'); ?>" height="16" width="16">
                                                </a>                                                -->
                                            </td>
                                        </tr>
                                    <?php } ?>                        
                                <?php } ?>
                            </tbody>
                        </table>
                </div>
                </div>     
                </div>

     
    </form>
            </div>
        </div>
    </div>        
    </div>
</main>    
<script>
    var SITE_URL = "<?php echo $site_url ?>";
    $(document).ready(function() {
        $('#case_symptoms').DataTable();
    } );
</script>
<script src="<?php echo asset('js/customer/symptom.js'); ?>"></script>
@stop

@section('modal_popup_area')
<!-- START :History  Pop up -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="history_popup">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="history_modal_title"></h4>
        </div>
          <div class="modal-body" id="history_modal_body">
          
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
 <!-- END :History  Pop up -->    
 @stop