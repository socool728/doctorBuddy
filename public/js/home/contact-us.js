var loadingIcon ='<div class="sk-spinner sk-spinner-three-bounce pull-left"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div></div></br></br>';
function validate_contact()
{     
    
    if (!validator.checkAll($("#contactform"))) { 
        return false;
    }else{
        $('button').prop('disabled', true);
        $("#message-text").html(loadingIcon);       
        $("#message").removeClass('hide alert alert-danger success-alert');
        
        $("header").attr('tabindex',-1);
        $("header").focus();        
       
        $.ajax({
        type: "POST",    
        data: $("#contactform").serialize(),
        dataType: "json",
        url :SITE_URL+"/home/contactus",
        success : function(response) { 
            $('button').prop('disabled', false);   
            if(response.error == 1){
                $("#message-text").html('<div class="error-alert-messages"><i class="fa-fw fa fa-times"></i><strong>Error!</strong>'+ response.err_msg+'</div>');
                $("#message").removeClass('hide');
                $("#message").addClass('alert alert-danger');
            }else{
                $("#message-text").html("Message  has been sent successfully")
                $("#message").removeClass('hide alert-danger');
                $("#message").addClass('success-alert');

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
    $('#healthcare_professional_phone_code').val(phoneCode);


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