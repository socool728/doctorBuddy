<form method="post" id="edit_symptom">
    
        <div class="col-lg-12 col-sm-12 col-xs-12 m-b-md">
            <label class="col-lg-12 col-sm-12 col-xs-12 ti">Select severity</label>
            <div class="col-lg-12 col-sm-12 col-xs-12 ">
                <label class="radio-inline"><input type="radio" value="Light" name="symptom_rate" <?php if($symptomdetail->symptom_rate == 'Light') { echo "checked";} ?>>Light</label>
                <label class="radio-inline"><input type="radio" value="Medium" name="symptom_rate" <?php if($symptomdetail->symptom_rate == 'Medium') { echo "checked";} ?>>Medium</label>
                <label class="radio-inline"><input type="radio" value="Severe" name="symptom_rate" <?php if($symptomdetail->symptom_rate == 'Severe') { echo "checked";} ?>>Severe</label>
                <div class="col-lg-12 no-pad m-t">
                    <input type="text" placeholder="Additional Details" name="symptom_comment" class="form-control" value="<?php echo $symptomdetail->customer_note ?>">
                </div>
            </div>
        </div> 

        <div class="col-lg-12 col-sm-12 col-xs-12">
            <button role="button" class="btn btn-primary" type="button" onclick="process_edit_symptom();">Save</button>
            <input id="rate_<?php echo $symptomdetail->detail_id ?>_<?php echo $symptomdetail->customer_symptom_id ?>" type="hidden" name="system_rate" value="<?php echo $symptomdetail->symptom_rate ?>">
            <input type="hidden" name="customer_symptom_id" value="<?php echo $symptomdetail->customer_symptom_id ?>">
        </div>
  
</form>    



