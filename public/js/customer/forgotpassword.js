function finish()
{    
    if (!validator.checkAll($('form'))) {   
        return false;
    }else{        
        var user = $('#user_email_id').val();             
        $.ajax({
           type: "GET",
           url: SITE_URL+"customer/userexist",
           data: {user: user},
           success: function(data) {  
               if(data ==0){
                   $("#em").removeClass('hide');
                   $('#em').show();
                   $('#nm').hide();  
                   return false;        
                }else{
                    $('#em').hide();
                    var action = SITE_URL+"customer/forgotpassword";
                    $("#loginform").attr("action", action);
                    $("#loginform").submit(); 
                }
            }
        });  
     
    }
}
