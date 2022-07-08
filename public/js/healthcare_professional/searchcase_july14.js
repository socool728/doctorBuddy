    $(function(){
            var sampleTags = ['Sleep', 'Fever', 'Back pain', 'Mind', 'headache', 'Abdomen', 'Bladder', 'Chest', 'Obesity', 'skin', 'Generalities', 'Perspiration', 'Urine', 'Prostategland', 'Hearing', 'Kidneys', 'Urethra', 'External Throat', 'Chill', 'Ear', 'Teeth', 'Respiration', 'Stool', 'Eye', 'Vision', 'Vertigo', 'Throat', 'Stomach', 'Nose', 'Mouth', 'Genitalia-Male', 'Genitalia-Female', 'Face', 'Expectoration', 'Cough', 'Extremities'];
 $('#singleFieldTags2').tagit({
                availableTags: sampleTags
            });
               $('#singleFieldTags').tagit({
                availableTags: sampleTags,
                // This will make Tag-it submit a single form value, as a comma-delimited field.
                singleField: true,
                singleFieldNode: $('#mySingleField')
            });
            
        });
function search_case()
{    
    if (!validator.checkAll($("#hpform"))) {   
        return false;
    }else{
//        $('button').prop('disabled', true);
        $.ajax({
        type: "POST",    
        data: $("#hpform").serialize(),
//        dataType: "json",
        url :SITE_URL+"/healthcare_professional/searchcustomer",
        success: function(data) {   
                $('#resultdiv').html(data);   
//        }

            
        },
        error : function(){
        $('button').prop('disabled', false);    
        $("#message-text").html('<i class="fa-fw fa fa-times"></i><strong>Error!</strong> Something went wrong, please try again.');
        $("#message").addClass('alert alert-danger');
        },
        });
        
    }
    

    
}

function getCountryState(country){
 var cnty = country.value;
 $('#healthcare_professional_state_select').html('');
 $('#healthcare_professional_state_text').val('');
  $.ajax({
        type: "GET",
        url: "state",
        dataType: "json",
        data: {cnty: cnty},
        
        success: function(data) {  
            if(data.state_exist){
                $("#state_1").show();
                $("#state_2").html('');
                $("#state_2").hide();
                states = data.state_arr;                 
                $.each(states, function(i,item) {
                     $('#healthcare_professional_state_select').append($('<option/>', { 
                        value: item,
                        text : item 
                    }));
                });
       
            }else{
               $("#state_1").hide();
               $("#state_2").html('<input  id="healthcare_professional_state_text" name="healthcare_professional_state_text"  title="State" class="form-control" type="text" required="required">');
               $("#state_2").show();
            }
        }
        });  
}

$(document).ready(function(){
              
                     
                            
//      $.ajax({
//        type: "GET",
//        url: "state",
//        dataType: "json",
//        data: {cnty: countryId},
//        
//        success: function(data) {  
//            if(data.state_exist){
//                $("#state_1").show();
//                $("#state_2").html('');
//                $("#state_2").hide();
//                states = data.state_arr;                 
//                $.each(states, function(i,item) {
//                     $('#healthcare_professional_state_select').append($('<option/>', { 
//                        value: item,
//                        text : item 
//                    }));
//                });
//                
//                $('#healthcare_professional_state_select').val(stateName);
//       
//            }else{
//               $("#state_1").hide();
//               $("#state_2").html('<input  id="healthcare_professional_state_text" name="healthcare_professional_state_text"  title="State" class="frm-control" type="text" required="required" value="'+stateName+'">');
//               $("#state_2").show();
//            }
//        }
//        }); 
    
});