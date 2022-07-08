function validate_forgotpassword()
{    
    
    if (!validator.checkAll($("#forgotpassword_form"))) {   
        return false;
    }else{
        $("#message").removeAttr('style');
        $("#message").removeClass('success-alert');
        
        $("#message-text").html('<img src="../images/loading.gif"  width="50" height="50">');       
        $("#message").removeClass('hide error-alert');
        
        $.ajax({
        type: "POST",    
        data: $("#forgotpassword_form").serialize(),
        dataType: "json",
        url :SITE_URL+"counselor/forgotpassword",
        success : function(response) { 
            if(response.error == 1){
                $("#message-text").html('<div class="error-alert-messages"><i class="fa-fw fa fa-times"></i><strong>Error!</strong><br>'+ response.err_msg+'</div>');
                $("#message").removeClass('hide');
                $("#message").addClass('alert alert-danger');
                $('button').prop('disabled', false);

            }else{
                 $("#message").removeClass('hide alert alert-danger');
                 $("#message-text").html('<strong>Success!</strong><br> New password has been sent successfully !.');
                 $("#message").addClass('success-alert');

            }
            
        },
        error : function(){ 
            $("#message-text").html('<i class="fa-fw fa fa-times"></i><strong>Error!</strong> Something went wrong, please try again.');
            $("#message").removeClass('hide');
            $("#message").addClass('alert alert-danger');
        },
        });
        
    }
    

    
}
