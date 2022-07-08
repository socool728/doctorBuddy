var loadingIcon ='<div class="sk-spinner sk-spinner-three-bounce pull-left"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div></div>';

function validate_healthcare_openion()
{    
    
    if (!validator.checkAll($("#form_healthcare_openion"))) {   
        return false;
    }else{
       // $('button').prop('disabled', true);
        $("#openion-message-text").html(loadingIcon);       
        $("#openion-message").removeClass('hide alert alert-danger');
        $("#openion-message").attr('tabindex',-1);
        $("#openion-message").focus();
        
        // For fixing a tinymce issue
        tinymce.triggerSave();
        
        $.ajax({
        type: "POST",    
        data: $("#form_healthcare_openion").serialize(),
        dataType: "json",
        url :SITE_URL+"/healthcare_professional/savecasefilecomment",
        success : function(response) { 
            if(response.error == 1){
                $("#openion-message-text").html('<div class="error-alert-messages"><i class="fa-fw fa fa-times"></i><strong>Error!</strong><br>'+ response.err_msg+'</div>');
                $("#openion-message").removeAttr("style");
                $("#openion-message").removeClass('hide success-alert');
                $("#openion-message").addClass('alert alert-danger');
            }else{
                 $("#openion-message").removeAttr("style");   
                 $("#openion-message-text").html('Details saved successfully !');
                 $("#openion-message").removeClass('hide');
                 $("#openion-message").addClass('success-alert alert');
                 
                 //Refresh the conversation area
                 setTimeout(function(){
                    $("#conversation_listing").html(loadingIcon);
                    $("#healthcare_comment").val('');
                    refresh_conversation(); 
                 },2000);
                 
            }
            
        },
        error : function(){
 
        $("#openion-message-text").html('<i class="fa-fw fa fa-times"></i><strong>Error!</strong> Something went wrong, please try again.');
        $("#openion-message").removeClass('hide');
        $("#openion-message").addClass('alert alert-danger');
        },
        });
        
    }
    

    
}







 $( "#price_section_heading" ).click(function() {
    $( "#price_section_area" ).slideToggle( "slow", function() {
        // Animation complete.
  });
});




$( "#regular_amount,#tax" ).keyup(function() {
    calculate_total();
});
$( "#discount" ).change(function() {
    calculate_total();
});

//calculate total price
function calculate_total(){
    
    if($( "#regular_amount" ).val() !="")
        var regularAmt =  parseFloat($( "#regular_amount" ).val());
    else
        var regularAmt =  0;
    
   var discount =  $( "#discount" ).val();
   
   if($( "#tax" ).val() !="")
        var tax =  parseFloat($( "#tax" ).val());
   else
      var tax = 0;
  
   var discountAmt = regularAmt*(discount/100);
   var taxAmt = regularAmt*(tax/100);
   var Total = regularAmt -discountAmt + taxAmt;
   $("#healthcare_charge").val(Total);
}

function refresh_conversation(){
   var customer_detail_id =$("#customer_detail_id").val();

    $.ajax({
    type: "POST",    
    dataType: "html",
    url :SITE_URL+"/healthcare_professional/ajaxconversationlisting/"+customer_detail_id,
    success : function(data) {        
        $("#conversation_listing").html(data);
        $("header").attr('tabindex',-1);
        $("header").focus();         
    },
    error : function(){
        alert("some error has happend during refresh.Please try after some time")
    },
    });
}


//Specific code for popup,here just write the logic
$(".template_links").on("click", function() {
    var templateId = $(this).attr('id');
       
    $.ajax({
    type: "POST",    
    dataType: "json",
    url :SITE_URL+"/healthcare_professional/ajaxtemplate/"+templateId,
    success : function(response) { 
        if(response.error ==0){
            $('#template_modal_title').html(response.template_title); 
            $('#template_modal_body').html(response.template_body);  
            $("#template_popup").modal('show'); 
        }
 
    },
    error : function(){
        alert("some error has happend during refresh.Please try after some time")
    },
    });
});

// END:responsive bootstrap popup

$(".load_template").on("click", function() {
    var templateId = $(this).val();
    $.ajax({
    type: "POST",    
    dataType: "json",
    url :SITE_URL+"/healthcare_professional/ajaxtemplate/"+templateId,
    success : function(response) { 
        if(response.error ==0){
            tinyMCE.get('healthcare_comment').setContent(response.template_body);
        }
 
    },
    error : function(){
        alert("some error has happend during refresh.Please try after some time")
    },
    });
});

 