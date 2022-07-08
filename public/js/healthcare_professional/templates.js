//For Data table
$(document).ready(function() {
    $('#customer_casefile').DataTable();   
} );

// Template Delete
$( document ).on( "click", ".delete", function() {  
    if(!confirm("Are you sure, you want to delete  this record ?"))
        return false;
        
    $.ajax({
     type: "POST",    
    dataType: "html",
    url :SITE_URL+"/healthcare_professional/templates/Delete/"+$(this).attr("delete_id"),
    success : function(data) { 
        $("#template_table_cover").html(data);
        $("#message-text").html("Record deleted successfully !");
        $("#message").removeClass('hide error-alert');
        $("#message").addClass('success-alert');     
    },
    error : function(){
        alert("some error has happend.Please try after some time")
    },
    }); 
});

// Template Add
function add_template()
{    
    if (!validator.checkAll($('form'))) {   
        return false;
    }else{
        
        // For fixing a tinymce issue
        tinymce.triggerSave();
        
        $('button').prop('disabled', true);
        $.ajax({
        type: "POST",    
        data: $("#template_form").serialize(),
        dataType: "json",
        url :SITE_URL+"/healthcare_professional/templates/Add",
        success : function(response) { 

            if(response.error == 1){
                $("#message-text").html('<div class="error-alert-messages"><i class="fa-fw fa fa-times"></i><strong>Error!</strong>'+ response.err_msg+'</div>');               
                $("#message").removeClass('hide success-alert');
                $("#message").addClass('alert alert-danger');  
        
                $('button').prop('disabled', false);
            }else{
                location.href=SITE_URL+"/healthcare_professional/templates";
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

// Template Edit
function edit_template()
{    
    if (!validator.checkAll($('form'))) {   
        return false;
    }else{
        
        // For fixing a tinymce issue
        tinymce.triggerSave();
        
        $('button').prop('disabled', true);
        $.ajax({
        type: "POST",    
        data: $("#template_form").serialize(),
        dataType: "json",
        url :SITE_URL+"/healthcare_professional/templates/Edit/"+$("#template_id").val(),
        success : function(response) { 

            if(response.error == 1){
                $("#message-text").html('<div class="error-alert-messages"><i class="fa-fw fa fa-times"></i><strong>Error!</strong>'+ response.err_msg+'</div>');               
                $("#message").removeClass('hide success-alert');
                $("#message").addClass('alert alert-danger');  
        
                $('button').prop('disabled', false);
            }else{
                location.href=SITE_URL+"/healthcare_professional/templates";
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

// Start: Pop up
function centerModal() {
    $(this).css('display', 'block');
    var $dialog = $(this).find(".modal-dialog");
    var offset = ($(window).height()-$dialog.height()) / 2;
    // Center modal vertically in window
    $dialog.css("margin-top", offset);
}

$('.modal').on('show.bs.modal', centerModal);

$(window).on("resize", function () {
    $('.modal:visible').each(centerModal);
});


$( document ).on( "click", ".view_template", function() {  
    
    var title = $(this).attr("view_title");
    $.ajax({
     type: "POST",    
    dataType: "json",
    url :SITE_URL+"/healthcare_professional/templates/View/"+$(this).attr("view_id"),
    success : function(response) {
        if(response.error ==0){
            $('#template_modal_title').html(response.title); 
            $('#template_modal_body').html(response.content);  
            $("#template_popup").modal('show');            
        }else{
            alert("some error has happend.Please try after some time")
        }
     
    },
    error : function(){
        alert("some error has happend.Please try after some time");
    },
    }); 
});


// End: Pop up