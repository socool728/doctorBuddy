<div class="table-responsive">
            <table class="table display" width="100%" cellspacing="0" id="customer_casefile">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php $i =0 ;?>
                <?php if(isset($data['templates'])&& count($data['templates']) > 0){ ?>
                    <?php foreach($data['templates'] as $template){ ?>
                        <?php $templateId = $template->healthcare_professional_template_id ?>
                        <tr>
                            <td><?php echo ++$i ?></td>
                            <td><?php echo ucfirst($template->template_title) ;?></td>                           
                            <td><?php echo date(Config::get('constants.DATE_FORMAT'),  strtotime($template->create_date));?></td>
                            <td>
                                <?php if($template->status): ?>
                                    <img src="<?php echo asset('images/active.png')?>" height="16" width="16" title="Active">
                                <?php else : ?>
                                    <img src="<?php echo asset('images/inactive.png')?>" height="16" width="16" title="In Active">
                                <?php endif ; ?>    
                            </td>                             
                            <td class="links">
                                <a href="javascript:void(0);" class="view_template" view_id="<?php echo $templateId ?>" ><img src="<?php echo asset('images/history-icon.png')?>" height="16" width="16" title="View"></a>&nbsp;
                                <a href="<?php echo $data['site_url'] ?>/healthcare_professional/templates/Edit/<?php echo $templateId ?>"><img src="<?php echo asset('images/edit-icon.png')?>" height="16" width="16" title="Edit"></a>&nbsp;
                                <a href="javascript:void(0);" class="delete" delete_id="<?php echo $templateId ?>"><img src="<?php echo asset('images/delete.png')?>" height="16" width="16" title="Delete"></a>
                            </td>
                        </tr>
                    <?php } ?>                        
                <?php }else{ ?>
                       <tr><td colspan="5" class="text-center">No templates available</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<script>
$(document).ready(function() {
    $('#customer_casefile').DataTable();   
} );
</script>

