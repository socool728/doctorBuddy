$(document).ready(function(){
    var loadingIcon ='<div class="sk-spinner sk-spinner-three-bounce pull-left"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div></div>';
    
    $("#print_pdf_button").click(function(){
        $("#propagation").html(loadingIcon);
        
        $.ajax({
        type: "POST",    
        data: "customer_detail_id="+$("#print_pdf_button").attr('customer_detail_id')+'&hp_id='+$("#print_pdf_button").attr('hp_id')+'&flag='+$("#print_pdf_button").attr('flag'),
        dataType: "json",
        url : SITE_URL+"/home/pdfconversation",
        success : function(response) { 
            if(response.error == 0){
                var url = SITE_URL+"/pdfreports/conversation_reports/"+response.pdf_name; 
                 $("#propagation").html("");
                 myWindow = window.open(url, "myWindow");
                 myWindow.print();
            }
            else{
                alert("Some error happend.");
            }

        },
        error : function(){
            alert("Some error happend.");
        },
        });

    })
})