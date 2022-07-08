    
function do_payment()
{        
    if (!validator.checkAll($("#payment-form"))) {   
        return false;
    }else{
        
        $('button').prop('disabled', true);
        $("#message").removeClass('hide alert alert-danger success-alert');        
        $("#message-text").html('<img src="'+loadingGifPath+'" width="100" height="100">');
        
        $.ajax({
        type: "POST",    
        data: $("#payment-form").serialize(),
        dataType: "json",
        url :SITE_URL+"/customer/payment/"+$("#encoded-casefile-hp-id").val(),
        success : function(response) { 
            if(response.error == 1){
                $("#message-text").html('<div class="error-alert-messages"><i class="fa-fw fa fa-times"></i><strong>Error!</strong><br>'+ response.err_msg+'</div>');                
                $("#message").removeClass('hide success-alert');
                $("#message").addClass('alert alert-danger');
                $('button').prop('disabled', false);
                return false;
            }else{
                
                window.location = SITE_URL+"/customer/healthquote/"+response.customer_detail_id;
                exit;
            }
            
        },
        error : function(){
        $('button').prop('disabled', false);    
        $("#message-text").html('<i class="fa-fw fa fa-times"></i><strong>Error!</strong> Something went wrong, please try again.');
        $("#message").addClass('alert alert-danger');
        },
        });        
    }    
}    

function card_type_section(obj){

    if($(obj).val() == 'SWITCH' || $(obj).val() =='SOLO'){
        $("#cc_issue").attr('required','required');
        $(".hide_area").show();
    }else{
        $("#cc_issue").removeAttr('required');
        $(".hide_area").hide();
    }
}

function getCountryState(country){
 var cnty = country.value;
 $('#state_select').html('');
 $('#state_text').val('');
  $.ajax({
        type: "GET",
        url: "state",
        dataType: "json",
        data: {cnty: cnty},
        
        success: function(data) {  
            if(data.state_exist){
                $("#state_1").removeClass('bad');
                $("#state_1").show();
                $("#state_2").html('');
                $("#state_2").hide();
                states = data.state_arr;                 
                $.each(states, function(i,item) {
                     $('#state_select').append($('<option/>', { 
                        value: item,
                        text : item 
                    }));
                });
       
            }else{
               $("#state_1").hide();
               $("#state_2").html('<input  id="state_text" name="state_text"  title="State" class="frm-control" type="text" required="required">');
               $("#state_2").removeClass('bad');
               $("#state_2").show();
            }
        }
        });  
}
$(document).ready(function(){
    if($("#cc_type").val() == 'SWITCH' || $("#cc_type").val() =='SOLO'){
        $("#cc_issue").attr('required','required');    
        $(".hide_area").show();
    }else{
        $("#cc_issue").removeAttr('required');
        $(".hide_area").hide();
    } 
})