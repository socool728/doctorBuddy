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