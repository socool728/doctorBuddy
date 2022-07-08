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
        url :SITE_URL+"/admin/reviews/edit/"+id,
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
    $('#healthcare_professional_id')
    .find('option')
    .remove()
    .end();

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
            }
            else{
                $('#healthcare_professional_id').append('<option value="">---No provider[s] found---</option>')
            }
        }
        }); 
});
$(document).ready(function () {
    $('#review_score').barrating({
        theme: 'fontawesome-stars'
    });
    var customer_id = $('#customer_id').val();
    if(customer_id!='')
    {
        $.ajax({
        type: "GET",
        url: SITE_URL+"/admin/providerlist",
        dataType: "json",
        data: {customer: customer_id},
        
        success: function(data) {  
            if(data.provider_exist){
                provider = data.provider_arr;
                $('#healthcare_professional_id').append('<option value="">---Select---</option>');
                $.each(provider, function(i,item) {
                    if(healthcareProfessionalId==i){
                     $('#healthcare_professional_id').append($('<option/>', { 
                        value: i,
                        text : item 
                    })).val(i);
                }else{
                    $('#healthcare_professional_id').append($('<option/>', { 
                        value: i,
                        text : item 
                    }));
                }
                });                
            }
            else{
                $('#healthcare_professional_id').append('<option value="">---No provider[s] found---</option>')
            }
        }
        }); 
    }
    else
    {
         $('#healthcare_professional_id').append('<option value="">---Select---</option>');
    }
    
});