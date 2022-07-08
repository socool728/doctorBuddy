<form method="post" id="edit_symptom">
    <div>
        <div class="col-lg-12 m-b-md">

            <div id="r_<?php echo $symptomdetail->detail_id ?>_<?php echo $symptomdetail->customer_symptom_id ?>" class="rate_widget">
                <?php for ($i=1;$i<=5;$i++){ 

                       if($i <= $symptomdetail->symptom_rate){
                           $plus_over ="plus_over";
                       }else{
                            $plus_over ="";
                       }
                     ?>  
                    <div data-tooltip="Select severity" class="star_<?php echo $i ?> ratings_plus <?php echo $plus_over ?>"></div>
                <?php } ?>

            </div>            
        </div> 
        <div class="col-lg-12 m-b-md">
            <input type="text" name="symptom_comment" class="form-control" value="<?php echo $symptomdetail->customer_note ?>">
        </div>
        <div class="col-lg-2 m-b-md">
            <button role="button" class="btn btn-primary" type="button" onclick="process_edit_symptom();">Save</button>
            <input id="rate_<?php echo $symptomdetail->detail_id ?>_<?php echo $symptomdetail->customer_symptom_id ?>" type="hidden" name="system_rate" value="<?php echo $symptomdetail->symptom_rate ?>">
            <input type="hidden" name="customer_symptom_id" value="<?php echo $symptomdetail->customer_symptom_id ?>">
        </div>
    </div>
    <br><br><br>    
</form>    



