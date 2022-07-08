/*jslint unparam: true */
/*global window, $ */
$(function () {
     $('#dob').daterangepicker({
                                singleDatePicker: true,
                                calender_style: "picker_4"
                            }, function (start, end, label) {
                                console.log(start.toISOString(), end.toISOString(), label);
                            });
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : '/drbuddygit/public/uploads/upload.php';
    $('#fileupload').fileupload({  
        url: url,
        dataType: 'json',
        done: function (e, data) { //alert(JSON.stringify(data.result));
            $.each(data.result.files, function (index, file) {
                //$('<p/>').text(file.name).appendTo('#files');
                //window.opener.$("#files").text(file.name).appendTo('#files');
                if(file.error){
                    $('<p style="color:red;">').text(file.error).appendTo('#upfiles');
                }else{
                    $("#files").hide();
                    $("#upfiles").html(file.name);
                    $("#upfiles").append('&nbsp;&nbsp;&nbsp;<a href="javascript:remove();" id="del_doc">Remove</a>');
                    $("#upfiles").show();
                    $("#document").val(file.name);
    
                }
                
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
function getstate(sel) {
  var cnty = sel.value;
  $.ajax({
    type: "GET",
    url: "/drbuddygit/home/state",
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
function remove(){
    $("#files").show();
    $("#upfiles").hide();
    $("#document").val('');

}
function refreshCaptcha(){
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
function forgot()
{    
    if (!validator.checkAll($('form'))) {   
        return false;
    }else{        
        var user = $('#user_email_id').val();             
        $.ajax({
           type: "GET",
           url: "/drbuddygit/counselor/counselorexist",
           data: {user: user},
           success: function(data) {  
               if(data ==0){
                   $('#em').show();
                   $('#nm').hide();  
                   return false;        
                }else{
                    $('#em').hide();
                    var action = "/drbuddygit/counselor/forgotpassword";
                    $("#loginform").attr("action", action);
                    $("#loginform").submit(); 
                }
            }
        });  
     
    }
}