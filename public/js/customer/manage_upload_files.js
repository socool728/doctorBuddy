var loadingIcon ='<div class="sk-spinner sk-spinner-three-bounce pull-left"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div></div>';


//Medical report upload
$(function () {
    $("#customer_medicalreport").val('');
    'use strict';
    var url = SITE_URL+ '/uploads/index.php';
    $('#fileupload_document').fileupload({  
        url: url,
        dataType: 'json',
        done: function (e, data) { //alert(JSON.stringify(data.result));
            $("#waiting_div").addClass("hide");
            $.each(data.result.files, function (index, file) {

                if(file.error){
                    $('<p style="color:red;">').text(file.error).appendTo('#upfiles_document');
                    $("#upfiles_document").show();
                }else{
                    var filename = file.name;
                    $("#uploadbtn").hide();
                    $("#uploadnxtbtn").show();
                    
                    $("#customer_medicalreport").val(filename);
                    
                    // Call function to insert the file name to db
                      insert_file(); 

                }

            });
        },
        progressall: function (e, data) {
            $("#waiting_div").removeClass("hide");
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
        
       
});


    
    function delete_files(id){
        var caseFileId = $('#customer_detail_id').val();
        $.ajax({
        type: "POST",    
        dataType: "json",
        url :SITE_URL+"/customer/uploadfiles/"+caseFileId+"/delete/"+id,
        success : function(response) { 
            if(response.error == 1){
                alert("Some error occured.Please try after some time")
            }else{
                $("#"+id).remove();
            }
            
        },
        error : function(){
            $('button').prop('disabled', false);
            
            $("#message-text").html('<i class="fa-fw fa fa-times"></i><strong>Error!</strong> Something went wrong, please try again.');
            $("#message-text").show();
        },
        });
    }
    
    function insert_file(){

            var caseFileId = $('#customer_detail_id').val();
            $.ajax({
            type: "POST",  
            data: $("#upload_form").serialize(),
            dataType: "json",
            url :SITE_URL+"/customer/uploadfiles/"+caseFileId+"/add",
            success : function(response) { 
                if(response.error == 0){
                    // Call function to reload the file listing area
                    refresh_file_listing();
                }else{
                    alert("some error occured during insertion.Please try after some time");
                }

            },
            error : function(){
                alert("Error! Something went wrong, please try again.");
                return false;
            },
            });

    }
   
   function refresh_file_listing(){
       
        $("#listing_upload_files").html(loadingIcon);       
        var caseFileId = $('#customer_detail_id').val();
            $.ajax({
            type: "POST",  
            dataType: "json",
            url :SITE_URL+"/customer/uploadfiles/"+caseFileId+"/ajaxlist",
            success : function(response) { 
                if(response.error == 0){
                    $("#listing_upload_files").html(response.html);
                }else{
                    alert("some error occured during refresh.Please try after some time");
                }

            },
            error : function(){
                alert("Error! Something went wrong, please try again.");
                return false;
            },
            });
       
       
   }
   
   
   /* START: Adding & remove of Dynamic text box for Dropbox */

$(function () {
    $("#btnAdd").bind("click", function () {
        var button;
        
        if($("#TextBoxContainer").html().length == 0){
           button ='<button  onclick="return save_dropbox_link();"type="submit"  title="Save"  class="btn btn-red" role="button">Save</button>';
        }
        if(button !=''){
            $("#ButtonContainer").append(button);
        }
        
        var html= GetDynamicTextBox();
        $("#TextBoxContainer").append(html);

    });
 
    $("body").on("click", ".remove_textbox", function () {
        $(this).closest("div").remove();
        if($("#TextBoxContainer").html().length == 0){
          $("#ButtonContainer").html('');
        }
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

function save_dropbox_link(){
    if (!validator.checkAll($('#dropbox_form'))) {   
        return false;
    }else{
            var caseFileId = $('#customer_detail_id').val();
            $.ajax({
            type: "POST",  
            dataType: "json",
            data: $("#dropbox_form").serialize(),
            url :SITE_URL+"/customer/ajaxdropboxfiles/"+caseFileId+"/add",
            success : function(response) { 
                if(response.error == 0){
                    refresh_dropbox_file_listing();
                }else{
                    alert("some error occured during refresh.Please try after some time");
                }

            },
            error : function(){
                alert("Error! Something went wrong, please try again.");
                return false;
            },
            });
    }
}

   function refresh_dropbox_file_listing(){
       
        
        $("#listing_dropbox_files").html(loadingIcon);
        var caseFileId = $('#customer_detail_id').val();
            $.ajax({
            type: "POST",  
            dataType: "json",
            url :SITE_URL+"/customer/ajaxdropboxfiles/"+caseFileId+"/list",
            success : function(response) { 
                if(response.error == 0){
                    $("#listing_dropbox_files").html(response.html);
                }else{
                    alert("some error occured during refresh.Please try after some time");
                }

            },
            error : function(){
                alert("Error! Something went wrong, please try again.");
                return false;
            },
            });
       
       
   }
   
    function delete_dropbox_files(id){
        var caseFileId = $('#customer_detail_id').val();
        $.ajax({
        type: "POST",    
        dataType: "json",
        url :SITE_URL+"/customer/ajaxdropboxfiles/"+caseFileId+"/delete/"+id,
        success : function(response) { 
            if(response.error == 1){
                alert("Some error occured.Please try after some time")
            }else{
                $("#dropbox_"+id).remove();
            }
            
        },
        error : function(){
            $('button').prop('disabled', false);
            
            $("#message-text").html('<i class="fa-fw fa fa-times"></i><strong>Error!</strong> Something went wrong, please try again.');
            $("#message-text").show();
        },
        });
    }

/* END: Adding & remove of Dynamic text box for Dropbox */