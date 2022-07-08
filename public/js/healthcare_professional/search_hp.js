var loadingIcon ='<div class="sk-spinner sk-spinner-three-bounce pull-center"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div></div></br></br>';

$(function(){
            
               $('#search_words_tags').tagit({
//                availableTags: sampleTags,
                // This will make Tag-it submit a single form value, as a comma-delimited field.
                singleField: true,
                allowSpaces: true,
		triggerKeys:['enter', 'comma', 'tab'],
		allowNewTags: true,
                singleFieldNode: $('#search_words')
            });
            
});
 
     
$(function () {
  $('[data-toggle="popover"]').popover()
})
function search_hp()
{    
        $('button').prop('disabled', true);
        $("#search_result").html(loadingIcon);
        
        $.ajax({
        type: "POST",    
        data: $("#hp_search_from").serialize(),
//        dataType: "json",
        url :SITE_URL+"/healthcare_professional/listing/search",
        success : function(response) { 
            $('button').prop('disabled', false);
            $("#search_result").html(response);
        },
        error : function(){
            $('button').prop('disabled', false);
            
            $("#message-text").html('<i class="fa-fw fa fa-times"></i><strong>Error!</strong> Something went wrong, please try again.');
            $("#message-text").show();
        },
        });  
     
    
}


function getCountryState(country){
    

 var cnty = country.value;
 $('#healthcare_professional_state_select').html('');
 $('#healthcare_professional_state_text').val('');
  $.ajax({
        type: "GET",
        url: SITE_URL+"/healthcare_professional/state",
        dataType: "json",
        data: {cnty: cnty},
        
        success: function(data) {  
            if(data.state_exist){
                $("#state_1").show();
                $("#state_2").html('');
                $("#state_2").hide();
                states = data.state_arr;      
                $('#healthcare_professional_state_select').append($('<option/>', { 
                        value: "",
                        text : "Select State"
                }));
                $.each(states, function(i,item) {
                     $('#healthcare_professional_state_select').append($('<option/>', { 
                        value: item,
                        text : item 
                    }));
                });
       
            }else{
               $("#state_1").hide();
               $("#state_2").html('<input  id="healthcare_professional_state_text" name="healthcare_professional_state_text"  title="State" class="form-control" type="text" required="required">');
               $("#state_2").show();
            }
        }
        });  
}