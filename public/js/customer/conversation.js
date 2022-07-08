var loadingIcon ='<div class="sk-spinner sk-spinner-three-bounce pull-left"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div></div>';

function refresh_conversation_listing(){
     
    $.ajax({
    type: "POST",
    data: $("#conversation_comment").serialize(),
    dataType: "html",
    url :SITE_URL+"/customer/ajaxconversationlisting",
    success : function(data) { 
        $("header").attr('tabindex',-1);
        $("header").focus();  
        $("#conversation_listing").html(data);
 
    },
    error : function(){
        alert("Some error has happend during refresh.Please try after some time")
    },
    });
}


function send_comment()
{    
    
    if (!validator.checkAll($("#conversation_comment"))) {   
        return false;
    }else{
  
        $("#openion-message-text").html(loadingIcon);       
        $("#openion-message").removeClass('hide alert alert-danger');
        $("#openion-message").attr('tabindex',-1);
        $("#openion-message").focus();
        
        // For fixing a tinymce issue
        tinymce.triggerSave();
        
        $.ajax({
        type: "POST",    
        data: $("#conversation_comment").serialize(),
        dataType: "json",
        url :SITE_URL+"/customer/sendcomment",
        success : function(response) { 
            if(response.error == 1){
                $("#openion-message-text").html('<div class="error-alert-messages"><i class="fa-fw fa fa-times"></i><strong>Error!</strong><br>'+ response.err_msg+'</div>');
                $("#openion-message").removeAttr("style");
                $("#openion-message").removeClass('hide success-alert');
                $("#openion-message").addClass('alert alert-danger');
            }else{
                 $("#openion-message").removeAttr("style");   
                 $("#openion-message-text").html('Details saved successfully !');
                 $("#openion-message").removeClass('hide');
                 $("#openion-message").addClass('success-alert alert');
                 
                 //Refresh the conversation area
                 setTimeout(function(){                    
                    $("#conversation_listing").html(loadingIcon);
                    $("#customer_comment").val('');
                    refresh_conversation_listing(); 
                 },2000);
  
                 
            }
            
        },
        error : function(){
 
        $("#openion-message-text").html('<i class="fa-fw fa fa-times"></i><strong>Error!</strong> Something went wrong, please try again.');
        $("#openion-message").removeClass('hide');
        $("#openion-message").addClass('alert alert-danger');
        },
        });
        
    }
    

    
}