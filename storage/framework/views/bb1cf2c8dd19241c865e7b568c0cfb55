<div class="table-responsive">
            <table class="table display" width="100%" cellspacing="0" id="customer_casefile">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php $i =0 ;?>
                <?php if(isset($data['templates'])&& count($data['templates']) > 0){ ?>
                    <?php foreach($data['templates'] as $template){ ?>
                        <?php $templateId = $template->communication_template_id ?>
                        <tr>
                            <td><?php echo ++$i ?></td>
                            <td><?php echo ucfirst($template->template_title) ;?></td>                           
                            <td><?php echo date(Config::get('constants.DATE_FORMAT'),  strtotime($template->create_date));?></td>                             
                            <td class="links">                                    
                                <a href="javascript:void(0);" class="view_template" view_id="<?php echo $templateId ?>" >
                                    <i class="fa fa-eye fa-4" aria-hidden="true" title="View Template"></i>
                                </a>
                                <?php 
                                //Edit,Delete options for my own templates
                                if($template->create_user_type =='HP' && $template->create_user_id == $hpObj->healthcare_professional_id): ?>
                                &nbsp;
                                <a href="<?php echo $data['site_url'] ?>/healthcare_professional/templates/Edit/<?php echo $templateId ?>">
                                    <i aria-hidden="true" class="fa fa-pencil fa-4" title="Edit"></i>
                                </a>
                                
                                &nbsp;
                                <a href="javascript:void(0);" class="delete" delete_id="<?php echo $templateId ?>">
                                    <i class="fa fa-trash-o fa-4" aria-hidden="true" title="Delte"></i>
                                </a>
                                <?php endif;?>                       
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

