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
        url :SITE_URL+"/admin/reviews/add",
         success : function(response) { 
            if(response.error == 1){
                $("#message-text").html('<div class="error-alert-messages"><i class="fa-fw fa fa-times"></i><strong>Error!</strong><br>'+ response.err_msg+'</div>');               
                $("#message").removeClass('hide success-alert');
                $("#message").addClass('alert alert-danger');  
        
                $('button').prop('disabled', false);
            }else{
                  window.location.href= SITE_URL+"/admin/reviews";
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

$('#customer_id').change(function(){
    $('#healthcare_professional_id').find('option').remove().end();
    
    $.ajax({
        type: "GET",
        url: SITE_URL+"/admin/providerlist",
        dataType: "json",
        data: {customer: $(this).val()},
        
        success: function(data) {  
            if(data.provider_exist){
                provider = data.provider_arr; 
                $('#healthcare_professional_id').append('<option value="">---Select---</option>');
                $.each(provider, function(i,item) {
                     $('#healthcare_professional_id').append($('<option/>', { 
                        value: i,
                        text : item 
                    }));
                });                
            }else{
                $('#healthcare_professional_id').append('<option value="">---No provider[s] found---</option>')
            }
        }
        }); 
});

$('#healthcare_professional_id').change(function(){
    
console.log('checking...');
    $.ajax({
        type: "GET",
        url: SITE_URL+"/admin/checkreview",
        dataType: "json",
        data: $("#addreviews").serialize(),
        
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
                $('select').barrating('clear');
                $("#message").addClass('hide');
                $("#comments").val('');
                
            }
        }
        }); 
});

$(document).ready(function () {
$('#review_score').barrating({
        theme: 'fontawesome-stars'
      });

});