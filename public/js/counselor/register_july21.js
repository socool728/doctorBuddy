function register()
{    
    
    if (!validator.checkAll($("#qform"))) {   
        return false;
    }else{
        $('button').prop('disabled', true);
        $("#message-text").html('<img src="../images/loading.gif"  width="100" height="100">');       
        $("#message").removeClass('hide alert alert-danger');
        $.ajax({
        type: "POST",    
        data: $("#qform").serialize(),
        dataType: "json",
        url :"register",
        success : function(response) { 
            if(response.error == 1){
                $("#message-text").html('<div class="error-alert-messages"><i class="fa-fw fa fa-times"></i><strong>Error!</strong>'+ response.err_msg+'</div>');
                $("#message").removeClass('hide');
                $("#message").addClass('alert alert-danger');
                $('button').prop('disabled', false);
                $("#qform").attr('tabindex',-1);
                $("#qform").focus();

 
            }else{
                window.location.href= "finish";
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
    
var phoneCode = $(country).find(":selected").attr('phone_code');
if(phoneCode !='undefined')
    $('#counselors_phone_code').val(phoneCode);

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
               $("#state_2").html('<input  id="customer_state_text" name="customer_state_text"  title="State" class="form-control" type="text" required="required">');
               $("#state_2").show();
            }
        }
        });  
}