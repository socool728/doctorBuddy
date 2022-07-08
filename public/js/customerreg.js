function getstate(sel) {
  var cnty = sel.value;
  $.ajax({
        type: "GET",
        url: "/home/state",
        data: {cnty: cnty},
        success: function(data) {  
            if(data!=''){
                $('#stated').hide();    
                $('#statedv').html(data); 
                $('#statedv').show(); 
                $('#statedelt').attr('disabled','disabled'); 
                $('#ercntry').hide();   
            }else{
                $('#stated').show();  
                $('#statedv').hide();
                $('#ercntry').hide(); 
                $('#statedelt').removeAttr('disabled');
                $('#erstate').hide();
            }
        }
        });  
    }
function finish()
{    
    if (!validator.checkAll($('form'))) {   
        return false;
    }else{       
        var user = $('#email').val();    
   
        $.ajax({
           type: "GET",
           url: "/customer/userexist",
           data: {user: user},
           success: function(data) {   
         
                if(data ==0){
                    $('#exister').hide();
                    var nick = $('#nick_name').val();
                    $.ajax({
                       type: "GET",
                       url: "/customer/nickcheck",
                       data: {nick: nick},
                       success: function(data) {    
                           if(data == 1){
                               $('#nckexist').hide();
                               if(document.qform.terms.checked==false) {
                                   $('#termer').show();
                                   form.terms.focus();
                                   return false;
                               }else{                          
                                   $('#termer').hide();
                                   var captcha_code = $('#captcha_code').val();
                                   $.ajax({
                                     type: "GET",
                                     url: "/js/captchacheck.php",
                                     data: {captcha_code: captcha_code},
                                     success: function(data) {  
                                         if(data == 1){
                                             $('#captcher').hide();
                                             var action = "/customer/register";
                                             $("#qform").attr("action", action);
                                             $("#qform").submit();
                                         }else{
                                             $('#captcher').html(data);
                                             $('#captcher').show();                         
                                             return false;
                                         }                               
                                     }
                                 });  
                               }
                           }else if(data!=''){
                               $('#nckexist').show();
                               return false;
                           }         
                       }
                   });  
                    
                }else{
                   ext = 1;
                   $('#exister').show();;  
                   return false; 
                }
            }
       }); 
    }
}
function remove(){
    $("#files").show();
    $("#upfiles").hide();
    $("#document").val('');

}
function refreshCaptcha(){
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
function login()
{    
    if (!validator.checkAll($('form'))) {   
        return false;
    }else{        
        var user = $('#user_email_id').val();
        var pwd = $('#user_password').val();
         $.ajax({
            type: "GET",
            url: "/customer/usercheck",
            data: {user: user,pwd: pwd},
            success: function(data) { 
                if(data.id>0){
                    if(data.verify==1){
                        $('#em').hide();
                        $('#nm').hide();
                        var action = "/customer/login";
                        $("#loginform").attr("action", action);
                        $("#loginform").submit();
                    }else{
                        $('#nm').show();
                        $('#nm').html(data.linkmsg);  
                        $('#em').hide();
                        return false;  
                    }
                }else{
                    $('#nm').hide();
                    $('#em').show();
                    return false; 
                }
            }
        });  
     
    }
}
function resend(id)
{        
    $.ajax({
       type: "GET",
       url: "/customer/verifysend/"+id,
       data: {id: id},
       success: function(data) { 
           $('#nm').html(data);
       }
   });      
}
function updateprofile()
{    
    if (!validator.checkAll($('form'))) {   
        return false;
    }else{  
        var action = "/customer/dashboard";
        $("#loginform").attr("action", action);
        $("#loginform").submit();
    }
}
function change_password()
{    
    if (!validator.checkAll($('form'))) {   
        return false;
    }else{
        $('button').prop('disabled', true);
        $.ajax({
        type: "POST",    
        data: $("#change_password_form").serialize(),
        dataType: "json",
        url :"/customer/changepassword",
        success : function(response) { 
            if(response.error == 1){
                $("#message-text").html(response.err_msg);
                
                $("#message").removeClass('hide alert alert-success');
                $("#message").addClass('alert alert-danger');  
        
                $('button').prop('disabled', false);
            }else{
                $("#message-text").html("Password changed successfully");
                
                $("#message").removeClass('hide alert alert-danger');
                $("#message").addClass('alert alert-success');     
                
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