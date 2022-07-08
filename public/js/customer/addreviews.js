function add()
{    
    if (!validator.checkAll($('form'))) {   
        return false;
    }else{
        $('button').prop('disabled', true);
        $.ajax({
        type: "POST",    
        data: $("#addreviews").serialize(),
        dataType: "json",
        url :SITE_URL+"/customer/reviews/add",
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

$('#healthcare_professional_id').change(function(){
    
console.log('checking...');
    $.ajax({
        type: "GET",
        url: SITE_URL+"/customer/checkreview",
        dataType: "json",
        data: {hp_id: $(this).val()},
        
        success: function(data) {  
            if(data.review_exist){
                     $("#comments").val(data.comments);
                     $('select').barrating('set', data.review_score);
                     $('#message-text').html("");
                     $("#message-text").html('<div class="error-alert-messages"><strong>Warning:</strong> You have already reviewed this provider. If you want you can edit the review</div>');               
                     $("#message").removeClass('hide');
                     $("#message").addClass('alert'); 
            }
            else
            {
                $("#message").addClass('hide');
                $("#comments").val('');
                $('select').barrating('clear');
            }
        }
        }); 
});

$(document).ready(function () {
    $('#review_score').barrating({
        theme: 'fontawesome-stars',
      });
});