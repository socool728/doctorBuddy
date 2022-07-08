@extends('layouts.counselorlayout')
@section('content')
<div class="cd-main-header">		
    <a class="cd-nav-trigger" href="#0">
        <span></span>
    </a>		
</div>
<main class="cd-main-content">
    @include('counselor.dashboardmenu')
     
    <div class="content-wrapper col-lg-9 col-sm-9 col-xs-12">
        
        <div class="col-lg-12 col-sm-12 col-xs-12 ">
            <div class="m-b">
              <h3>Case Files</h3>
            </div>

            <div id="custom_message_wrapper">    
                <div id="message"  class="hide">
                    <div id="message-text"></div>
                </div>
                 <?php if(Session::get('flash_msg')) : ?>
                <div class="success-alert"><?php echo Session::get('flash_msg') ?></div>
                <?php endif ;?>
            </div>

            <div class="table-responsive" >
<table class="table display" width="100%" cellspacing="0" id="counselor-case-files">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nick Name</th>                                        
                    <th>Created On</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php $i =0 ;?>
                <?php if(isset($data['caseFileObjs'])&& count($data['caseFileObjs']) > 0){ ?>
                    <?php foreach($data['caseFileObjs'] as $caseFileObj){ ?>
                        <?php 
                        
                        $customerId = $caseFileObj->customer_id;
                        $customerDetailId = $caseFileObj->customer_detail_id;
                        $counId = $caseFileObj->counselor_id;
                        $casefileToCounselorId = $caseFileObj->casefile_to_counselor_id;
                        
                       
                        
                        ?>
                        <tr>
                            <td><?php echo ++$i ?></td>
                            <td><?php echo ucfirst($caseFileObj->customer_nickname) ;?></td>                         
                            <td><?php echo date(Config::get('constants.DATE_FORMAT'),strtotime($caseFileObj->created_at));?></td>
                            <td class="links">
                                <?php
                                
                                $val = 'casefile_id='.$casefileToCounselorId;
                                $key = urlencode(base64_encode($val));
                                $link = asset('counselor/casefileview?key='.$key);
                                ?>
                                <a href="<?php echo $link ?>">
                                    <i aria-hidden="true" class="fa fa-file-excel-o fa-4" title="View Case File"></i>
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
    $('#counselor-case-files').DataTable();
} );
</script>
@stop