@extends('layouts.customerlayout')
@section('content')
<div class="cd-main-header">		
    <a class="cd-nav-trigger" href="#0">
        <span></span>
    </a>		
</div>
<main class="cd-main-content">
    @include('customer.dashboardmenu')
     
    <div class="content-wrapper col-lg-10 col-sm-10 col-xs-12">
        
        <div class="m-b">
          <h3>My Case Files</h3>
        </div>
        
        <div class="col-lg-12 no-pad">
        <div class="table-responsive">
            <table class="table display" width="100%" cellspacing="0" id="customer_casefile">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nick Name</th>
                    <th>Last Updated</th>
                    <th>Provider</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php $i =0 ;?>
                <?php if(isset($data['customerinfo'])&& count($data['customerinfo']) > 0){ ?>
                    <?php foreach($data['customerinfo'] as $customerinfo){ ?>
                <?php //echo '<pre>';print_r($customerinfo);?>
                        <tr>
                            <td><?php echo ++$i ?></td>
                            <td><?php echo ucfirst($customerinfo->customer_nickname) ;?></td>
                            <td><?php echo date(Config::get('constants.DATE_FORMAT'),strtotime($customerinfo->updated_at));?></td>
                            <td></td>
                            <td class="links">
                                 
                                <a href="<?php echo asset('customer/reports/'.$customerinfo->customer_detail_id );?>" >   
                                    <i aria-hidden="true" class="fa fa-file-excel-o fa-4" title="View Case File"></i>
                                </a>
                                &nbsp;
                                <a href="<?php echo asset('customer/symptom/'.$customerinfo->customer_detail_id );?>" >
                                    <i class="fa fa-sliders fa-4" aria-hidden="true" title="Symptoms"></i>
                                </a>
                               &nbsp;
                                <a href="<?php echo asset('customer/uploadfiles/'.$customerinfo->customer_detail_id );?>" >
                                    <i class="fa fa-upload fa-4" aria-hidden="true" title="Upload Documents"></i>
                                </a>
                                &nbsp;
                                <a href="<?php echo asset('customer/assignedproviders/'.$customerinfo->customer_detail_id );?>" >
                                    <i class="fa fa-bars fa-4" aria-hidden="true" title="Assigned Providers"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>                        
                <?php }else{ ?>
                       <tr><td colspan="6" class="text-center">No reports to View</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
        </div>        
    </div>
</main>    

<script>
$(document).ready(function() {
    $('#customer_casefile').DataTable();
} );
</script>
@stop