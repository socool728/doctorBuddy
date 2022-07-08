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
                var content="";
                $.each(data, function(i, item) {
                    content = content +"<div>Name : "+item.customer_nikname+"&nbsp;,&nbsp;Location : "+item.location+"&nbsp;,&nbsp;Time:"+item.reached_time+"</div><br>"; 
                });
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