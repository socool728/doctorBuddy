function edit(id)
{    
    if (!validator.checkAll($('form'))) {   
        return false;
    }else{
        $('button').prop('disabled', true);
        $.ajax({
        type: "POST",    
        data: $("#editreviews").serialize(),
        dataType: "json",
        url :SITE_URL+"/customer/reviews/edit/"+id,
         success : function(response) { 
            if(response.error == 1){
                $("#message-text").html('<div class="error-alert-messages"><i class="fa-fw fa fa-times"></i><strong>Error!</strong><br>'+ response.err_msg+'</div>');               
                $("#message").removeClass('hide success-alert');
                $("#message").addClass('alert alert-danger');  
                $('button').prop('disabled', false);
            }else{
                window.location.href= SITE_URL+"/customer/reviews";
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
$(document).ready(function () {
    $('#review_score').barrating({
        theme: 'fontawesome-stars',
      });
});