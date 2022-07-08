function edit_profile()
{    
    
    if (!validator.checkAll($("#hpform"))) {   
        return false;
    }else{
        $('button').prop('disabled', true);
        
        $.ajax({
        type: "POST",    
        data: $("#hpform").serialize(),
        dataType: "json",
        url :SITE_URL+"/counselor/editprofile",
        success : function(response) { 
            if(response.error == 1){
                $("#message-text").html('<div class="error-alert-messages"><i class="fa-fw fa fa-times"></i><strong>Error!</strong><br>'+ response.err_msg+'</div>');                
                $("#message").removeClass('hide success-alert');
                $("#message").addClass('alert alert-danger');
                
                $('button').prop('disabled', false);
            }else{
                
                window.location = SITE_URL+"/counselor/editprofile";
                exit;
            }
            
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
 $('#counselors_state_select').html('');
 $('#counselors_state_text').val('');
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
                     $('#counselors_state_select').append($('<option/>', { 
                        value: item,
                        text : item 
                    }));
                });
       
            }else{
               $("#state_1").hide();
               $("#state_2").html('<label>State</label><input  id="counselors_state_text" name="counselors_state_text"  title="State" class="form-control" type="text" required="required">');
               $("#state_2").show();
            }
        }
        });  
}



function remove_stored_image (){
        $.ajax({
        dataType: "json",
        url :SITE_URL+"/counselor/removestoredimage",
        success : function(response) { 
            if(response.error == 1){
                alert(response.err_msg);
                return false;
            }else{
                 window.location = SITE_URL+ '/counselor/editprofile'; 
            }
            
        },
        error : function(){
            alert("Error! Something went wrong, please try again.");
            return false;
        },
        }); 
}

$(document).ready(function(){

        //Date Picker
        
         $( "#counselors_dob" ).datepicker({
           changeMonth: true,
           changeYear: true,
           dateFormat: 'mm-dd-yy',   
           yearRange: "-100:+0",
        }); 
                            
                     
                            
      $.ajax({
        type: "GET",
        url: "state",
        dataType: "json",
        data: {cnty: countryId},
        
        success: function(data) {  
            if(data.state_exist){
                $("#state_1").show();
                $("#state_2").html('');
                $("#state_2").hide();
                states = data.state_arr;                 
                $.each(states, function(i,item) {
                     $('#counselors_state_select').append($('<option/>', { 
                        value: item,
                        text : item 
                    }));
                });
                
                $('#counselors_state_select').val(stateName);
       
            }else{
               $("#state_1").hide();
               $("#state_2").html('<label>State</label><input  id="counselors_state_text" name="counselors_state_text"  title="State" class="form-control" type="text" required="required" value="'+stateName+'">');
               $("#state_2").show();
            }
        }
        }); 
    
});