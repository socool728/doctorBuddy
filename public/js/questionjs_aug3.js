var loadingIcon ='<div class="sk-spinner sk-spinner-three-bounce pull-center"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div></div></br></br>';

var  upvar =0;
$(function(){
  $("body").on("keyup", "#symptom", function(){
    var searchval = $('#symptom').val();   
    var len = searchval.length;
    if(searchval.length>2){
        $('#symptomboxdiv').show(); 
    $.ajax({
        type: "GET",
        //url: "<?php echo asset('index.php/home/loadsymptom'); ?>",
        url: SITE_URL+"/home/loadsymptom",
        data: {search: searchval},
        success: function(data) {              
                $('#symptomdiv').html(data);   
        }
    });
    }
    });
$("body").click
(
  function(e)
  {
    if(e.target.className !== "symptombox")
    {
      $('#symptomboxdiv').hide();
    }
  }
);


$("body").on("click", ".symptlist", function(){  
    
    $('#symptom-outer-area').show();
    var symptomId = $(this).attr("id");
    var symptomName = $(this).html();
    var textboxName = "symcnt_"+symptomId;
    var radiobuttonName = "rat_"+symptomId;
    var symtomBoxId = "sym-box-"+symptomId;
        
    var symptomArea='<div class="sym-box m-b" id="'+symtomBoxId+'"><a class="close-link" link-id="'+symptomId+'">x</a><label class="col-lg-12 col-sm-12 col-xs-12">'+symptomName+'</label>';
    symptomArea+='<label class="col-lg-12 col-sm-12 col-xs-12 ti">Select severity</label>';
    symptomArea+='<div class="col-lg-12"><label class="radio-inline"><input type="radio" name="'+radiobuttonName+'"  value="Light">Light</label>';                           
    symptomArea+='<label class="radio-inline"><input type="radio" name="'+radiobuttonName+'" value="Medium">Medium</label>';                            
    symptomArea+='<label class="radio-inline"><input type="radio" name="'+radiobuttonName+'" value="Severe">Severe</label>';                                
    symptomArea+='<div class="col-lg-12 no-pad m-t"><input type="text" class="form-control" name="'+textboxName+'" placeholder="Additional Details"></div>';                                  
    symptomArea+='</div><input name="symp_id[]"  type="hidden" value="'+symptomId+'" /></div>';                                
                                    
    $('#symptomboxdiv').hide(); 
    $('#symptom-inner-area').append(symptomArea);  
    $("#symptom").val('');
                    
 });
 $("body").on("click", ".close-link", function(){ 
     var symptomId = $(this).attr("link-id");
     var symtomBoxId = "sym-box-"+symptomId;
     $("#"+symtomBoxId).remove();

     if($('#symptom-inner-area').html().length == 0){
         $('#symptom-outer-area').hide();
     }
 });


    $("body").on("click", ".rightoverlay-style-toggle", function(){ 
        $(".rightoverlaybar").toggleClass("active1");
    });
    $("body").on("click", "#upload_doc", function () {  
       var left        = ($(window).width()/2)-(400/2),
           top         = ($(window).height()/2)-(250/2),
           newwindow   = window.open($(this).prop('href'), '', 'height=250,width=400,top='+top+',left='+left);
       if (window.focus) 
       {
          newwindow.focus();
       }
       return false;
    });
   $("body").on("click", "#del_doc", function () {    
       $("#files").show();
       $("#upfiles").hide();
       $("#document").val('');

    });
});
var currvar =0;

function finish()
{   
    
    if (!validator.checkAll($('form'))) {   
        return false;
    }else{

        $("header").attr('tabindex',-1);
        $("header").focus(); 

        $("#message-text").html(loadingIcon);
        $("#message").attr('class','');
        
        var customer_id = parseInt($('#customer_id').val());
        
        if(customer_id >=0){
            // Situation: Customer has already logined
            
            // Remove not using areas in this situations
            /*$("#existuser").remove();
            $("#newuser").remove();
            if($("#send_option").val() == 'no'){
               $("#send_option_area").remove();
            }
             
            var action = SITE_URL+"/home/finish";
            $("#qform").attr("action", action);
            $("#qform").submit();  */
            process_form();
            
        }else if(document.qform.existing['0'].checked==false){
            
            // Situation: Existing Customer
            var user = $('#user_email_id').val();
            var pwd = $('#user_password').val();
             $.ajax({
                type: "GET",
                dataType: "json",
                url: SITE_URL+"/customer/usercheck",
                data: {user: user,pwd: pwd},
                success: function(response) {   
                    if(response.error == 1){
                        $("#message").addClass('alert alert-danger');
                        $("#message-text").html('Invalid username or password');                        
                        return false;
                    }else{

                       /*  
                        var action = SITE_URL+"/home/finish";
                        $("#qform").attr("action", action);
                        
                        // Remove unwanted areas,So that the default browser validation won't come
                        
                         if($('input[name=existing]:checked').val() ==0){
                             $("#existuser").remove();
                         }else{
                             $("#newuser").remove();
                         }
                         
                         if($("#send_option").val() == 'no'){
                             $("#send_option_area").remove();
                         }
                         

                        $("#qform").submit();   */
                        process_form();
                    }
                },
                error : function(){
                    alert("Error! Something went wrong, please try again.");
                    return false;
                },
        });
           return false; 
        }else{
            // Situation: New Customer  
            var pwd = $('#password').val(); 
            if(pwd.length >= 4){
                $('#pwderr').hide();
                var user = $('#email').val();                
                $.ajax({
                    type: "GET",
                    url:SITE_URL+ "/customer/userexist",
                    data: {user: user},
                    success: function(data) {   
                        if(data ==0){ 
                           /* 
                            var action = SITE_URL+"/home/finish";
                            $("#qform").attr("action", action);

                            // Remove unwanted areas,So that the default browser  validation won't come

                             if($('input[name=existing]:checked').val() ==0){
                                 $("#existuser").remove();
                             }else{
                                 $("#newuser").remove();
                             }

                             if($("#send_option").val() == 'no'){
                                 $("#send_option_area").remove();
                             }


                            $("#qform").submit();*/
                            process_form();
                        }else{
                            $("#message").addClass('alert alert-danger');
                            $("#message-text").html('Email already exist');                   
                            return false;                             
                        }
                    }
                });               
           
            }else{
                $("#message").addClass('alert alert-danger');
                $("#message-text").html('Minum length of password is 4');                   
                return false; 
            }
        }
    }
}


function process_form(){
    $('button').prop('disabled', true);
    $.ajax({
    type: "POST",    
    data: $("#qform").serialize(),
    dataType: "json",
    url :SITE_URL+"/home/finish",
    success : function(response) { 
        if(response.error == 1){
            $("#message-text").html('<div class="error-alert-messages"><i class="fa-fw fa fa-times"></i><strong>Error!</strong><br>'+ response.err_msg+'</div>');               
            $("#message").removeClass('hide success-alert');
            $("#message").addClass('alert alert-danger');  
            $('button').prop('disabled', false);                        
        }else if(response.error == 2){
            $("#message").addClass('alert alert-danger');
            $("#message-text").html(response.err_msg);  
            setTimeout(
                function(){
                    window.location = SITE_URL+"/home/basic"; 
                }, 5000
            );
        }else{
            window.location = SITE_URL+"/home/result/"+response.detail_id;
        }

    },
    error : function(){
        $('button').prop('disabled', false);

        $("#message-text").html('<i class="fa-fw fa fa-times"></i><strong>Error!</strong> Something went wrong, please try again.');
        $("#message-text").show();
    },
    });    
    
}


var specialChars = "<>@!#$%^&*()_+[]{}?:;|'\"\\,./~`-="
var check = function(string){
    for(i = 0; i < specialChars.length;i++){
        if(string.indexOf(specialChars[i]) > -1){
            return true
        }
    }
    return false;
}


function getqn(curord,nxtord)
{
//    $('#overlay').hide();
    var divsel = currvar;
    var currgpid =0;
    if (!validator.checkAll($('form'))) { 
        return false;
    }else{
        
        $("header").attr('tabindex',-1);
        $("header").focus(); 
        
        $("#message-text").html(loadingIcon);
        $("#message").removeClass('hide');
 
        if(curord >= 0 || nxtord=='f'){
            var nxtordid = parseInt(curord)+1;
            $('#currord').val(nxtord);
             currvar++;
            var updvar = currvar+1; 
            var divhd = divsel-1;
            currgpid =  $('#gpid').val(); 
            $.ajax({
                type: "POST",
                url:  SITE_URL+"/home/loadqn",
                data: $("#qform").serialize(),
                success: function(data) {
                    
                    $("#message-text").html('');
                    $("#message").addClass('hide');

                    getrightoverlay();
                    $('#overlay').show();
                    $('.hide_show').hide();
                    if(currvar == 1){
                        

                        
                        
                        $('#qndiv').show();
                        //set the previous group id which used in right overlay
                        var divelt = '<input type="hidden" name="previousgpid[]" class="prev0" value="0" >';
                        var strappend = data + divelt;
                        $('#qndiv').html(strappend);
                    }else{  
                        //set the previous group id which used in right overlay
                        var divelt = '<input type="hidden" name="previousgpid[]" class="prev'+divsel+'" value="'+currgpid+'" >';
                        var strappend = data + divelt;
                        $('#qndiv_'+divsel).html(strappend);
                        $('#qndiv_'+divsel).show();
                    }
                   
                    
                    
                }
            });
            
            // Hide the top flow notification heading
            if(nxtord=='f'){
                $("#flow_notification_heading").hide();
            }else{
                    var flowNotificationContent ='<div class="col-lg-4 col-sm-4 col-xs-12 tab-1 m-b"><span class="title grey">Basic info</span><div class="vertical-timeline-icon graybg"> 1 </div></div>';
                    flowNotificationContent += '<div class="col-lg-4 col-sm-4 col-xs-12 tab-2 m-b"><span class="title grey">symptoms</span><div class="vertical-timeline-icon graybg"> 2 </div></div>';
                    flowNotificationContent += '<div class="col-lg-4 col-sm-4 col-xs-12 tab-3 m-b"><span class="title">questions</span><div class="vertical-timeline-icon cir-bg"> 3 </div></div>';
                    $("#flow_notification_heading").html(flowNotificationContent);
            }
            

                        
                        
//            var currgpid =  $('#gpid').val();
//            alert(currgpid);
        }
    }
}

function prevqn(curord){
    
    currvar--;
    var divsel = currvar-1;    
    $('.hide_show').hide();
    $('#currord').val(curord);
    //get the previous group id which used in right overlay
    var clprev = $(".prev"+currvar).val();
//    alert(currvar);

    if(currvar ==1){
        $('#qndiv').show();
        //Remove old contents from the comming question  display divs
        $('.clear_content').each(function(index, element ) {
            if($(element).attr('id') != 'qndiv')
                $(element).html('');
        });
        getrightoverlay(clprev);
    }else if(currvar ==0){
        $('#overlay').hide();
        $('#qnblk').show();        
        //Remove old contents from comming question  display divs
        $('.clear_content').each(function(index, element ) {
            $(element).html('');
        });
    }else{
                                               
        $('#qndiv_'+divsel).show();        
        $('.clear_content').each(function(index, element ) {            
            //Remove old contents from comming question  display divs
            if($(element).attr('id') != 'qndiv'){
                 var divID = $(element).attr('id');
                 var idArr = divID.split("_");
                 if(parseInt(idArr[1]) >parseInt(divsel))
                    $(element).html('');  
            }           
        });
        getrightoverlay(clprev);
    }
    
     //top flow notification logic
    if(currvar ==0){
        var flowNotificationContent ='<div class="col-lg-4 col-sm-4 col-xs-12 tab-1 m-b"><span class="title grey">Basic info</span><div class="vertical-timeline-icon graybg"> 1 </div></div>';
        flowNotificationContent += '<div class="col-lg-4 col-sm-4 col-xs-12 tab-2 m-b"><span class="title ">symptoms</span><div class="vertical-timeline-icon cir-bg"> 2 </div></div>';
        flowNotificationContent += '<div class="col-lg-4 col-sm-4 col-xs-12 tab-3 m-b"><span class="title grey">questions</span><div class="vertical-timeline-icon graybg"> 3 </div></div>';
        $("#flow_notification_heading").html(flowNotificationContent);    
    }
    
    // show the top flow notification heading, if  it is hided
    $("#flow_notification_heading").show();
}
function getrightoverlay(b){
    if(b === undefined) b = 'b';
    //b used to previous page answers showing in right overlay
    $.ajax({
        type: "POST",
        url:  SITE_URL+"/home/rightoverlay/"+b,
        data: $("#qform").serialize(),
        success: function(data) {       
                $('#overlay').html(data);            
        }
    });
}


// Remove Medical report uploaded
function remove_medicalreport_file (filename,elt){
//    alert(elt);
    $.ajax({
        type: "POST",  
        data: { 'customer_medicalreport' : $("#customer_medicalreport").val(),'filename':filename,'eltno':elt},
//        data: { 'customer_medicalreport' : $("#customer_medicalreport").val()},
        dataType: "json",
        url :SITE_URL+"/home/removeuploadfile",
        success : function(response) { 
            if(response.error == 1){
                alert(response.err_msg);
                return false;
            }else{
//                $("#customer_medicalreport").val('');
//                $("#upfiles_document").hide();
                $("#up"+elt).hide();
                $("#customer_medicalreport").val(response.result);
                $("#files_upload_area").show();
            }
            
        },
        error : function(){
            alert("Error! Something went wrong, please try again.");
            return false;
        },
        });
   
}

function getCountryState(country){
    
 var cnty = country.value;
 $('#customer_state_select').html('');
 $('#customer_state_text').val('');
  $.ajax({
        type: "GET",
        url: "state",
        dataType: "json",
        data: {cnty: cnty},
        
        success: function(data) {  
            if(data.state_exist){
                $("#state_1").show();
                $("#state_2").html('');
                $("#state_2").hide();
                states = data.state_arr;                 
                $.each(states, function(i,item) {
                     $('#customer_state_select').append($('<option/>', { 
                        value: item,
                        text : item 
                    }));
                });
       
            }else{
               $("#state_1").hide();
               $("#state_2").html('<input  id="customer_state_text" name="customer_state"  title="State" class="form-control" type="text" required="required">');
               $("#state_2").show();
            }
        }
        });  
}



//Medical report upload
$(function () {
    $("#customer_medicalreport").val('');
    'use strict';
    // Change this to the location of your server-side upload handler:
    var x =1;
    var url = SITE_URL+ '/uploads/index.php';
    $('#fileupload_document').fileupload({  
        url: url,
        dataType: 'json',
        done: function (e, data) { //alert(JSON.stringify(data.result));
            $.each(data.result.files, function (index, file) {
                //$('<p/>').text(file.name).appendTo('#files');
                //window.opener.$("#files").text(file.name).appendTo('#files');
                $("#waiting_div").addClass("hide");
                if(file.error){
                    $('<p style="color:red;">').text(file.error).appendTo('#upfiles_document');
                    $("#upfiles_document").show();
                }else{
//                    $("#files_upload_area").hide();
//                    $("#upfiles_document").html(file.name);
var filename = file.name;
                    $("#uploadbtn").hide();
                    $("#uploadnxtbtn").show();
//                    $("#upfiles_document").append(file.name);
                    $("#upfiles_document").append('<div id="up'+x+'">'+filename+'&nbsp;&nbsp;&nbsp;<a class="delete_link" href="javascript:void(0);"  onclick="remove_medicalreport_file(\''+filename+'\','+x+');">Remove</a></div>');
                    $("#upfiles_document").show();
                    if($("#customer_medicalreport").val() !=''){
                        var files = $("#customer_medicalreport").val()+ ','+file.name;
                        $("#customer_medicalreport").val(files);
                    }else{
                    $("#customer_medicalreport").val(file.name);
                    }
    
                }
                x++;
            });
        },
        progressall: function (e, data) {
            $("#waiting_div").removeClass("hide");
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
        
       
});
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
function forgotsend(){ 
    var user = $('#user_email_id').val();
    if(user == ''){
        alert("Please enter email address ");
        $('#user_email_id').focus();
        return false;
    }else{
//        if(confirm('Do you want to send password to your email?')){
        $("#message").removeClass('hide error-alert');
        $("#message").html('<img src="../images/loading.gif"  width="100" height="100">');       
        
        var casefile=1;
             $.ajax({
                type: "GET",
                dataType: "json",
                url: SITE_URL+"/customer/forgotpassword",
                data: {user_email_id: user,casefile: casefile},
                success: function(response) {   
                    if(response.error == 1){
                        $('#message').show(); 
                        $("#message").removeClass('hide success-alert');
                        $("#message").addClass('error-alert');
                        $('#message').html('Email entered is not exist in our records');
                        return false;
                    }else{
                        $('#message').show(); 
                        $("#message").removeClass('hide error-alert');
                        $("#message").addClass('success-alert');
                         $('#message').html('Your account password send to email');   
                         return false;
                    }
                },
                error : function(){
                    alert("Error! Something went wrong, please try again.");
                    return false;
                },
        });
//        }
    }
}

//On finish page,forward email area , hide and show
function get_send_option(obj){
            
        if($(obj).val() == 'yes'){
            // $("#forwade_email").attr("required","required");
            $("#send_option_area").removeClass("hide");
            $("#send_option_area").show();
        }else{
           // $("#forwade_email").removeAttr("required");
           // $('#forwade_email_div').find('.alert').remove();
           //  $('#forwade_email_div').removeClass("bad");
            $("#send_option_area").hide();
          
        }
}




/* START: Adding & remove of Dynamic text box for Dropbox */

$(function () {
    $("#btnAdd").bind("click", function () {
        var html = GetDynamicTextBox();
        $("#TextBoxContainer").append(html);
    });
    
    $("#btnGet").bind("click", function () {
        var values = "";
        $("input[name=DynamicTextBox]").each(function () {
            values += $(this).val() + "\n";
        });
        alert(values);
    });
    $("body").on("click", ".remove_textbox", function () {
        $(this).closest("div").remove();
    });
});
function GetDynamicTextBox() {
    var result = '<div class="col-lg-12 no-pad m-t">';
    result += '<div class="col-lg-12 no-pad item">'; 
    result += '<input  class="form-control" title="Dropbox link" name="drop_box_link[]" type="url" required="required" placeholder="https://www.dropbox.com/">'; 
    result += '</div>'; 
    result += '<a href="javascript:void(0);" class="info-icon-n remove_textbox"><i class="fa fa-times-circle" aria-hidden="true"></i></a>'; 
    result += '</div>';
    return result;

}

/* END: Adding & remove of Dynamic text box for Dropbox */

/* START: Tag-it */
$(function(){
            
    $('#known_disease_tags').tagit({
//                availableTags: sampleTags,
     // This will make Tag-it submit a single form value, as a comma-delimited field.
     singleField: true,
     allowSpaces: true,
     tagSource:function( request, response ) {

        $.ajax({
                url: SITE_URL+"/home/keywords",
                dataType: "json",
                data: {
                        q: request.term
                },
                success: function( data ) {
                        response( data );
                },
                error : function(){
                    alert("Some error happend");
                },
        });
     },                
     triggerKeys:['enter', 'comma', 'tab'],
     allowNewTags: true,
     singleFieldNode: $('#known_disease')
 });
            
});

/* END: Tag-it */