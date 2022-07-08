$(document).ready(function(){
    
    
function load_latest_customers(){
    
        $.ajax({
        type: "POST",    
        url :SITE_URL+"/counselor/latestcustomers",
        success : function(response) { 
            $("#lastest_reached_customers").html(response);
        },
        error : function(){
        $('button').prop('disabled', false);    
        $("#message-text").html('<i class="fa-fw fa fa-times"></i><strong>Error!</strong> Something went wrong, please try again.');
        $("#message").addClass('alert alert-danger');
        },
        });
} 

//Initial calling
load_latest_customers()

setInterval( load_latest_customers, 30000 );

})