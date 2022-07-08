function updatecustprofile()
{        
    if (!validator.checkAll($("#custform"))) {   
        return false;
    }else{
        $('button').prop('disabled', true);
        
        $.ajax({
        type: "POST",    
        data: $("#custform").serialize(),
        dataType: "json",
        url :SITE_URL+"/customer/editprofile",
        success : function(response) { 
            if(response.error == 1){
                $("#message-text").html('<div class="error-alert-messages"><i class="fa-fw fa fa-times"></i><strong>Error!</strong><br>'+ response.err_msg+'</div>');                
                $("#message").removeClass('hide success-alert');
                $("#message").addClass('alert alert-danger');
                $('button').prop('disabled', false);
            }else{
                
                window.location = SITE_URL+"/customer/editprofile";
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
 $('#customer_state_select').html('');
 $('#customer_state_text').val('');
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
                     $('#customer_state_select').append($('<option/>', { 
                        value: item,
                        text : item 
                    }));
                });
       
            }else{
               $("#state_1").hide();
               $("#state_2").html('<label>State</label><input  id="customer_state_text" name="customer_state_text"  title="State" class="form-control" type="text" required="required">');
               $("#state_2").show();
            }
        }
        });  
}
$(document).ready(function(){     
                            
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
                     $('#customer_state_select').append($('<option/>', { 
                        value: item,
                        text : item 
                    }));
                });                
                $('#customer_state_select').val(stateName);       
            }else{
               $("#state_1").hide();
               $("#state_2").html('<label>State</label><input  id="customer_state_text" name="customer_state_text"  title="State" class="form-control" type="text" required="required" value="'+stateName+'">');
               $("#state_2").show();
            }
        }
        }); 
    
});