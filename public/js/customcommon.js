function prevqn(id){
        currvar--;
        var divsel = currvar-1;
        if(id >= 0 || id=='f'){
            var base = $("#qform").serialize();  
            if(currvar == 1){
                $('#qndiv_1').hide();
                $('#qndiv').show();
            }else if(currvar>1){
                $('#qndiv_'+currvar).hide();
                $('#qndiv_'+divsel).show();
            }
        }   
}
function close_option(sym, id){
	if (confirm('Are you sure you want to remove this symptom')){	
            $('#symptom').val("");   
            document.getElementById('currsympt_'+id).style.display='none';	
            document.getElementById('symp_'+id).disabled='disabled';	
            document.getElementById('rat_'+sym).disabled='disabled';	
            document.getElementById('symcnt_'+sym).disabled='disabled';	            
	}	
}
function show_userform(){           
    if(document.qform.existing['0'].checked==false){			
        $("#existuser").show();
        $("#newuser").hide();

        $('#email').attr('disabled','disabled'); 
        $('#password').attr('disabled','disabled'); 
        $('#password2').attr('disabled','disabled');                 
        $('#user_email_id').removeAttr('disabled');
        $('#user_password').removeAttr('disabled');
    }else{
        $("#newuser").show();
        $("#existuser").hide();
        $('#user_email_id').attr('disabled','disabled'); 
        $('#user_password').attr('disabled','disabled'); 
        $('#email').removeAttr('disabled');
        $('#password').removeAttr('disabled');
        $('#password2').removeAttr('disabled');

    }
}
function refreshCaptcha(){
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}