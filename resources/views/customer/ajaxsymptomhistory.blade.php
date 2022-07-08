<div class="col-lg-12">
    <div class="table-responsive">
        <table class="table display" width="100%" cellspacing="0" id="case_symptoms_history">   
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Rate</th>
                    <th>Comment</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php $j =0 ;?>
                <?php if(isset($symptomHistorydetails)&& count($symptomHistorydetails) > 0){ ?>
                    <?php foreach($symptomHistorydetails as $symptomHistorydetail){ ?>
                        <tr>
                            <td><?php echo ++$j ?></td>
                            <td><?php echo ucfirst($symptomHistorydetail->symptom_name) ;?></td>
                            <td>
                                <?php if($symptomHistorydetail->symptom_rate) { ?>
                                    <div class="rate_widget">
                                    <?php for ($i=1;$i<= $symptomHistorydetail->symptom_rate;$i++){ ?> 
                                        <div class="ratings_plus " ></div>
                                    <?php } ?>
                                    </div>
                                <?php } ?>  
                            </td>
                            <td><?php echo $symptomHistorydetail->customer_note ?></td>
                            <td><?php echo date(Config::get('constants.DATE_FORMAT'),  strtotime( $symptomHistorydetail->created_date));?></td>
                        </tr>
                    <?php } ?>                        
                <?php }else{ ?>
                       <tr><td colspan="5" class="text-center">No history available</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div> 

<!--<script>
    $(document).ready(function() {
        $('#case_symptoms_history').DataTable();
    } );
</script>-->