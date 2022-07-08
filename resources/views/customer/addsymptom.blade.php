<div class="col-lg-12">
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
                                                    <div >
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
                                <?php }else{ ?>
                                       <tr><td colspan="6" class="text-center">No symptoms to View</td></tr>
                                <?php } ?>
                            </tbody>
                        </table>
                </div>
                </div> 

<script>
    $(document).ready(function() {
        $('#case_symptoms').DataTable();
    } );
</script>