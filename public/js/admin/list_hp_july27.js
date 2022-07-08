   $(document).ready(function(){
       
  
    $( ".btn-delete" ).on( "click", function() {
          if(confirm('Are you sure to delete this Healthcare Professional?')){
              
        $.ajax({
        dataType: "json",
        url :SITE_URL+"/admin/healthcareprofessional/delete/"+$( this ).attr('delete_id'),
        success : function(response) { 
            if(response.error == 1){
                alert(response.err_msg);  
            }else{
                window.location.href= SITE_URL+"/admin/healthcareprofessional";
            }
            
        },
        error : function(){
            alert("Error!.Something went wrong, please try again");    
        },
        });
             
          }
  
    }); 
    
   })