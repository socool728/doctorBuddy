/*jslint unparam: true */
/*global window, $ */
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = SITE_URL+ '/uploads/index_counselor_image.php';
    $('#fileupload').fileupload({  
        url: url,
        dataType: 'json',
        done: function (e, data) { //alert(JSON.stringify(data.result));
            $.each(data.result.files, function (index, file) {
                //$('<p/>').text(file.name).appendTo('#files');
                //window.opener.$("#files").text(file.name).appendTo('#files');
                if(file.error){
                    $('<p style="color:red;">').text(file.error).appendTo('#upfiles');$("#upfiles").show();
                }else{
                    $("#files").hide();
                    $("#upfiles").html(file.name);
                    $("#upfiles").append('&nbsp;&nbsp;&nbsp;<a href="javascript:remove_file();" id="del_doc">Remove</a>');
                    $("#upfiles").show();
                    $("#document").val(file.name);
    
                }
                
            });
        },
        progressall: function (e, data) {

        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
        
       
});


function remove_file (){
    
        $.ajax({
        type: "POST",  
        data: { 'document' : $("#document").val()},
        dataType: "json",
        url :SITE_URL+"/admin/counselor/remove_image",
        success : function(response) { 
            if(response.error == 1){
                alert(response.err_msg);
                return false;
            }else{
                $("#document").val('');
                $("#upfiles").hide();
                $("#files").show();
            }
            
        },
        error : function(){
            alert("Error! Something went wrong, please try again.");
            return false;
        },
        });  

}
