//For Delete
$(document).ready(function(){
    $( ".btn-delete" ).on( "click", function() {
        if(confirm('Are you sure to delete this Counselor?')){

      $.ajax({
      dataType: "json",
      url :SITE_URL+"/admin/counselor/delete/"+$( this ).attr('delete_id'),
      success : function(response) { 
          if(response.error == 1){
              alert(response.err_msg);  
          }else{
              window.location.href= SITE_URL+"/admin/counselor";
          }

      },
      error : function(){
          alert("Error!.Something went wrong, please try again");    
      },
      });

        }

    }); 
}); 
   