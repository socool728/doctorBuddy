<table class="table display" width="100%" cellspacing="0" id="customer_casefile">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php $i =0 ;?>
                <?php if(isset($resultArr)&& count($resultArr) > 0){ ?>
                    <?php foreach($resultArr as $result){ ?>
                        <tr>
                            <td><?php echo ++$i ?></td>
                            <td><?php echo ucfirst($result['customer_nikname']) ;?></td>
                            <td><?php echo $result['location'] ?></td>
                            <td><?php echo date(Config::get('constants.DATE_TIME_FORMAT'),strtotime($result['reached_time']));?></td>
                        </tr>
                    <?php } ?>                        
                <?php }else{ ?>
                       <tr><td colspan="4" class="text-center">No Customers to View</td></tr>
                <?php } ?>
            </tbody>
</table>

<script>
$(document).ready(function() {
    $('#customer_casefile').DataTable();
} );
</script>