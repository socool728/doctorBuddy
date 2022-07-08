function change_password()
{    
    if (!validator.checkAll($('form'))) {   
        return false;
    }else{
        $('button').prop('disabled', true);
        $.ajax({
        type: "POST",    
        data: $("#change_password_from").serialize(),
        dataType: "json",
        url :SITE_URL+"/customer/changepassword",
         success : function(response) { 
            if(response.error == 1){
                $("#message-text").html('<div class="error-alert-messages"><i class="fa-fw fa fa-times"></i><strong>Error!</strong><br>'+ response.err_msg+'</div>');               
                $("#message").removeClass('hide success-alert');
                $("#message").addClass('alert alert-danger');  
        
                $('button').prop('disabled', false);
            }else{
                $("#message-text").html("Password changed successfully");
                
                $("#message").removeClass('hide alert alert-danger');
                $("#message").addClass('success-alert');     
                
                $('button').prop('disabled', false);
            }
            
        },
        error : function(){
            $('button').prop('disabled', false);
            
            $("#message-text").html('<i class="fa-fw fa fa-times"></i><strong>Error!</strong> Something went wrong, please try again.');
            $("#message-text").show();
        },
        });  
     
    }
}