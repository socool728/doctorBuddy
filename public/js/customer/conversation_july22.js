function refresh_conversation_listing(){
     
    $.ajax({
    type: "POST",
    data: $("#conversation_comment").serialize(),
    dataType: "html",
    url :SITE_URL+"/customer/ajaxconversationlisting",
    success : function(data) { 
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
  
        $("#openion-message-text").html('<img src="'+SITE_URL+'/images/loading.gif"  width="50" height="50">');       
        $("#openion-message").removeClass('hide alert alert-danger');
        
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
                 $("#openion-message").addClass('success-alert');
                 
                 //Refresh the conversation area
                 setTimeout(function(){
                    $("#conversation_listing").html('<img src="'+SITE_URL+'/images/loading.gif"  width="50" height="50">');
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