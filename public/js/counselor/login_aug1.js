function counselor_login_check()
{    
    if (!validator.checkAll($('form'))) {   
        return false;
    }else{
        $('button').prop('disabled', true);
        $.ajax({
        type: "POST",    
        data: $("#loginform").serialize(),
        dataType: "json",
        url :SITE_URL+"/counselor/login",       
        success : function(response) { 
            if(response.error == 1){
                $("#message-text").html(response.err_msg);
                $("#message-text").removeClass('hide'); 
                $("#message-text").addClass('show');              
                $('button').prop('disabled', false);
            }else{
                if(!REDIRECT)
                    window.location.href= SITE_URL+"/counselor/dashboard";
                else
                    window.location.href= SITE_URL+"/counselor/"+REDIRECT;
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