/*jslint unparam: true */
/*global window, $ */
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = SITE_URL+ '/uploads/index_hp_image.php';
    $('#fileupload_image').fileupload({  
        url: url,
        dataType: 'json',
        done: function (e, data) { //alert(JSON.stringify(data.result));
            $.each(data.result.files, function (index, file) {
                //$('<p/>').text(file.name).appendTo('#files');
                //window.opener.$("#files").text(file.name).appendTo('#files');
                if(file.error){
                    $('<p style="color:red;">').text(file.error).appendTo('#upfiles_image');$("#upfiles_image").show();
                }else{
                    $("#files_image").hide();
                    $("#upfiles_image").html(file.name);
                    $("#upfiles_image").append('&nbsp;&nbsp;&nbsp;<a class="delete_link" href="javascript:void(0);" id="del_image" onclick="remove_image_file();">Remove</a>');
                    $("#upfiles_image").show();
                    $("#document_image").val(file.name);
    
                }
                
            });
        },
        progressall: function (e, data) {

        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
        
       
});

$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = SITE_URL+ '/uploads/index_hp_biodata.php';
    $('#fileupload_biodata').fileupload({  
        url: url,
        dataType: 'json',
        done: function (e, data) { //alert(JSON.stringify(data.result));
            $.each(data.result.files, function (index, file) {
                //$('<p/>').text(file.name).appendTo('#files');
                //window.opener.$("#files").text(file.name).appendTo('#files');
                if(file.error){
                    $('<p style="color:red;">').text(file.error).appendTo('#upfiles_biodata');$("#upfiles_biodata").show();
                }else{
                    $("#files_biodata").hide();
                    $("#upfiles_biodata").html(file.name);
                    $("#upfiles_biodata").append('&nbsp;&nbsp;&nbsp;<a class="delete_link" href="javascript:void(0);" id="del_biodata" onclick="remove_biodata_file();">Remove</a>');
                    $("#upfiles_biodata").show();
                    $("#document_biodata").val(file.name);
    
                }
                
            });
        },
        progressall: function (e, data) {

        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
        
       
});


function remove_image_file (){
    $.ajax({
        type: "POST",  
        data: { 'document_image' : $("#document_image").val()},
        dataType: "json",
        url :SITE_URL+"/healthcare_professional/removeimage",
        success : function(response) { 
            if(response.error == 1){
                alert(response.err_msg);
                return false;
            }else{
                    $("#document_image").val('');
                    $("#upfiles_image").hide();
                    $("#files_image").show(); 
            }
            
        },
        error : function(){
            alert("Error! Something went wrong, please try again.");
            return false;
        },
        });        
}

function remove_biodata_file (){
    
    $.ajax({
        type: "POST",  
        data: { 'document_biodata' : $("#document_biodata").val()},
        dataType: "json",
        url :SITE_URL+"/healthcare_professional/removebiodata",
        success : function(response) { 
            if(response.error == 1){
                alert(response.err_msg);
                return false;
            }else{
                $("#document_biodata").val('');
                $("#upfiles_biodata").hide();
                $("#files_biodata").show();
            }
            
        },
        error : function(){
            alert("Error! Something went wrong, please try again.");
            return false;
        },
        });
   
}