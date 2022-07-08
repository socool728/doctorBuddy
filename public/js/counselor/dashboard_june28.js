$(document).ready(function(){
    
    
function load_latest_customers(){
    
        $.ajax({
        type: "POST",    
        dataType: "json",
        url :SITE_URL+"/counselor/latestcustomers",
        success : function(response) { 
            if(response.error == 1){
                $("#lastest_reached_customers").html(response.message);                
            }else{
                data = response.result;
                var content='<table class="table display" width="100%" cellspacing="0" id="health_quotes">';
                content+='<thead><tr><th>#</th><th>Name</th><th>Location</th><th>Time</th></tr></thead>';
                content+='<tbody>';
                $.each(data, function(i, item) {
                    content = content +"<tr><td></td><td>"+item.customer_nikname+"</td><td>"+item.location+"</td><td>"+item.reached_time+"</td></tr>";
                });
                content+='</tbody></table>';
                $("#lastest_reached_customers").html(content);
            }
            
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