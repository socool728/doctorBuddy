function verify_account()
{    
    if (!validator.checkAll($("#customer_form"))) {   
        return false;
    }else{
        $('button').prop('disabled', true);
        
        $.ajax({
        type: "POST",    
        data: $("#customer_form").serialize(),
        dataType: "json",
        url :SITE_URL+"/customer/verifyemail",
        success : function(response) { 
            if(response.error == 1){
                $("#message-text").html('<div class="error-alert-messages"><i class="fa-fw fa fa-times"></i><strong>Error!</strong><br>'+ response.err_msg+'</div>');                
                $("#message").removeClass('hide success-alert');
                $("#message").addClass('error-alert');
                $('button').prop('disabled', false);
            }else{
                
                window.location = SITE_URL+"/customer/login/";
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