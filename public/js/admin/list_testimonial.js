   $(document).ready(function(){
       
       
      //For changing the status
      
      $(".status-change" ).on( "click", function() {      
        var obj = $(this);
        
        $.ajax({
        dataType: "json",
        url :SITE_URL+"/admin/testimonial/statuschange/"+$( this ).attr('record_id'),
        success : function(response) { 
            if(response.error == 1){
                alert(response.err_msg);  
            }else{
                //success
                if(response.status == 1){
                    //Previous status       
                    obj.html('<img src="../images/active.png">');
                }else{
                    obj.html('<img src="../images/inactive.png">');
                }
                
            }
            
        },
        error : function(){
            alert("Error!.Something went wrong, please try again");    
        },
        });
             
          
  
}); 

//For Delete
$( ".btn-delete" ).on( "click", function() {
    if(confirm('Are you sure to delete this Testimonial?')){

  $.ajax({
  dataType: "json",
  url :SITE_URL+"/admin/testimonial/delete/"+$( this ).attr('delete_id'),
  success : function(response) { 
      if(response.error == 1){
          alert(response.err_msg);  
      }else{
          window.location.href= SITE_URL+"/admin/testimonial";
      }

  },
  error : function(){
      alert("Error!.Something went wrong, please try again");    
  },
  });

    }
  
}); 
   })