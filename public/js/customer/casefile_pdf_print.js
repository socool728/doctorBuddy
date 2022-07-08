$(document).ready(function(){
    var loadingIcon ='<div class="sk-spinner sk-spinner-three-bounce pull-left"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div></div>';
    
    $("#print_pdf_button").click(function(){
        $("#propagation").html(loadingIcon);
        
        $.ajax({
        type: "POST",    
        data: "customer_detail_id="+$("#print_pdf_button").attr('customer_detail_id'),
        dataType: "json",
        url : SITE_URL+"/home/pdfcasefile",
        success : function(response) { 
            if(response.error == 0){
                var url = SITE_URL+"/pdfreports/"+response.pdf_name; 
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