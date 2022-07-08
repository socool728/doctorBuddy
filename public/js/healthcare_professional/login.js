var loadingIcon ='<div class="sk-spinner sk-spinner-three-bounce pull-center"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div></div>';


function hp_login_check()
{    
    if (!validator.checkAll($('form'))) {   
        return false;
    }else{
        
        $("header").attr('tabindex',-1);
        $("header").focus(); 

        $("#message").attr('class','');  
        $("#message-text").html(loadingIcon);
        
        
        $('button').prop('disabled', true);
        $.ajax({
        type: "POST",    
        data: $("#loginform").serialize(),
        dataType: "json",
        url :SITE_URL+"/healthcare_professional/login",       
        success : function(response) { 
            if(response.error == 1){
                $("#message-text").html(response.err_msg);
                $("#message").addClass('alert alert-danger'); 
                
                $('button').prop('disabled', false);
            }else{
                if(!REDIRECT)
                    window.location.href= SITE_URL+"/healthcare_professional/dashboard";
                else
                    window.location.href= SITE_URL+"/healthcare_professional/"+REDIRECT;
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