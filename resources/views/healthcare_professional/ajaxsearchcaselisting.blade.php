<div class="col-lg-12">
    <div class="table-responsive">
            <table class="table display" width="100%" cellspacing="0" id="customer_casefile">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nick Name</th>
                   <th>Sex</th>
                    <th>City</th>                    
<!--                    <th>State</th>
                    <th>Country</th>-->
                    <th>Date</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php $i =0 ;?>
                <?php if(isset($data['caseFileObjs'])&& count($data['caseFileObjs']) > 0){ ?>
                    <?php foreach($data['caseFileObjs'] as $caseFileObj){ ?>
                <?php //echo '<pre>';print_r($customerinfo);?>
                        <tr>
                            <td><?php echo ++$i ?></td>
                            <td><?php echo ucfirst($caseFileObj->customer_nickname) ;?></td>
                            <td><?php echo $caseFileObj->customer_sex ?></td>                            
                            
                            <td><?php echo $caseFileObj->customer_city ?></td>  
<!--                            <td><?php echo $caseFileObj->customer_state ?></td> 
                            <td><?php echo $caseFileObj->country_id ?></td> -->
                           <td><?php echo date(Config::get('constants.DATE_FORMAT'),strtotime($caseFileObj->created_at));?></td>
                           
                            <td class="links">
                                <?php
                                 // just reusing already existing view  page
                                 $customerDetailId = $caseFileObj->customer_detail_id;
                                 $link = asset('healthcare_professional/casefileviewfromsearch?detail_id='.$customerDetailId);
                                ?>
                                <a target="_blank" href="<?php echo $link ?>">View Case</a>
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
<script>
 //For Data table
$(document).ready(function() {
    $('#customer_casefile').DataTable();   
} );   
</script>        
