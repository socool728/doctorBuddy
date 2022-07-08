function validate_healthcare_openion()
{    
    
    if (!validator.checkAll($("#form_healthcare_openion"))) {   
        return false;
    }else{
       // $('button').prop('disabled', true);
        $("#openion-message-text").html('<img src="../images/loading.gif"  width="50" height="50">');       
        $("#openion-message").removeClass('hide alert alert-danger');
        
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
                 $("#openion-message").addClass('success-alert');
                 //Refresh the conversation area
                 setTimeout(function(){
                    $("#conversation_listing").html('<img src="'+SITE_URL+'/images/loading.gif"  width="50" height="50">');
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

function send_pdf()
{    
    
    if (!validator.checkAll($("#form_pdf_send"))) {   
        return false;
    }else{
       // $('button').prop('disabled', true);
        $("#pdf-message-text").html('<img src="../images/loading.gif"  width="50" height="50">');       
        $("#pdf-message").removeClass('hide alert alert-danger');
        
        $.ajax({
        type: "POST",    
        data: $("#form_pdf_send").serialize(),
        dataType: "json",
        url :SITE_URL+"/healthcare_professional/sendcasefilepdf",
        success : function(response) { 
            if(response.error == 1){
                $("#pdf-message-text").html('<div class="error-alert-messages"><i class="fa-fw fa fa-times"></i><strong>Error!</strong><br>'+ response.err_msg+'</div>');
                $("#pdf-message").removeAttr("style");
                $("#pdf-message").removeClass('hide success-alert');
                $("#pdf-message").addClass('alert alert-danger');
            }else{
                 $("#pdf-message").removeAttr("style");   
                 $("#pdf-message-text").html('Mail send successfully !');
                 $("#pdf-message").removeClass('hide');
                 $("#pdf-message").addClass('success-alert');
                 
            }
            
        },
        error : function(){
 
        $("#pdf-message-text").html('<i class="fa-fw fa fa-times"></i><strong>Error!</strong> Something went wrong, please try again.');
        $("#pdf-message").removeClass('hide');
        $("#pdf-message").addClass('alert alert-danger');
        },
        });
        
    }
    

    
}


$(document).on("click",".print",function(){

    $('#pdfdv').hide();   
    $('#printdv').hide(); 
                
$( "#printable").print({
    globalStyles: true,
    mediaPrint: false,
    stylesheet: null,
    noPrintSelector: ".no-print",
    iframe: true,
    append: null,
    prepend: null,
    manuallyCopyFormValues: true,
    deferred: $.Deferred(),
    timeout: 250,
    title: null,
    doctype: '<!doctype html>'
    });
    
    $('#pdfdv').show();   
    $('#printdv').show();  
});




 $( "#price_section_heading" ).click(function() {
    $( "#price_section_area" ).slideToggle( "slow", function() {
        // Animation complete.
  });
});

 $( "#available_template_heading" ).click(function() {
    $( "#available_template_area" ).slideToggle( "slow", function() {
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
    },
    error : function(){
        alert("some error has happend during refresh.Please try after some time")
    },
    });
}



// START:responsive bootstrap popup for template

//General code needed for all popup become responsive
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