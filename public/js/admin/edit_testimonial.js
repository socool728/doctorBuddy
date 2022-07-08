function edit_testimonial()
 {    
    
    if (!validator.checkAll($("#edit_testimonial_form"))) {   
        return false;
    }else{

        $('button').prop('disabled', true);  
        $.ajax({
        type: "POST",    
        data: $("#edit_testimonial_form").serialize(),
        dataType: "json",
        url :SITE_URL+"/admin/testimonial/edit/"+$("#testimonial_id").val(),
        success : function(response) { 
            if(response.error == 1){
                $("#message-text").html('<i class="fa-fw fa fa-times"></i><strong>Error!</strong>'+ response.err_msg);
                $("#message").removeClass('hide');
                $("#message").addClass('alert alert-danger');
                $('button').prop('disabled', false);
            }else{
                window.location.href= SITE_URL+"/admin/testimonial";
            }
            
        },
        error : function(){
        $('button').prop('disabled', false);    
        $("#message-text").html('<i class="fa-fw fa fa-times"></i><strong>Error!</strong> Something went wrong, please try again.');
        $("#message").removeClass('hide');
        $("#message").addClass('alert alert-danger');
        },
        });
        
    }     
}  

$('form')
    .on('blur', 'input[required], input.optional, select.required', validator.checkField)
    .on('change', 'select.required', validator.checkField)
    .on('keypress', 'input[required][pattern]', validator.keypress);

$('.multi.required')
    .on('keyup blur', 'input', function () {
        validator.checkField.apply($(this).siblings().last()[0]);
    });
$('form').submit(function (e) {
        e.preventDefault();
        var submit = true;
        // evaluate the form using generic validaing
        if (!validator.checkAll($(this))) {
            submit = false;
        }

        if (submit)
            this.submit();
        return false;
 });
 function delete_file (id){
    
    $.ajax({
        type: "POST",  
        data: { 'image' : id},
        dataType: "json",
        url :SITE_URL+"/admin/deletefile",
        success : function(response) { 
            if(response.error == 1){
                alert(response.err_msg);
                return false;
            }else{
                $("#image").val('');
                $("#uploadedfile").hide();
                $("#files_upload_area").show();
                $("#upfiles_document").hide();
                
                
            }
            
        },
        error : function(){
            alert("Error! Something went wrong, please try again.");
            return false;
        },
        });
   
}
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = SITE_URL+ '/uploads/index_testimonial.php';
    $('#fileupload_document').fileupload({  
        url: url,
        dataType: 'json',
        done: function (e, data) { 
//            alert(JSON.stringify(data.result));
            $.each(data.result.files, function (index, file) {
                $('<p/>').text(file.name).appendTo('#files');
                //window.opener.$("#files").text(file.name).appendTo('#files');
                if(file.error){
                    $('<p style="color:red;">').text(file.error).appendTo('#upfiles_document');
                    $("#upfiles_document").show();
                }else{
                    $("#files_upload_area").hide();
                    $("#upfiles_document").html(file.name);
                    $("#upfiles_document").append('&nbsp;&nbsp;&nbsp;<a class="delete_link" href="javascript:void(0);"  onclick="remove_media_file();">Remove</a>');
                    $("#upfiles_document").show();
                    $("#image").val(file.name);
    
                }
                
            });
        },
        progressall: function (e, data) {

        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
        
       
});
function remove_media_file (){
    
    $.ajax({
        type: "POST",  
        data: { 'image' : $("#image").val()},
        dataType: "json",
        url :SITE_URL+"/admin/removeuploadfile",
        success : function(response) { 
            if(response.error == 1){
                alert(response.err_msg);
                return false;
            }else{
                $("#image").val('');
                $("#upfiles_document").hide();
                $("#files_upload_area").show();
            }
            
        },
        error : function(){
            alert("Error! Something went wrong, please try again.");
            return false;
        },
        });
   
}