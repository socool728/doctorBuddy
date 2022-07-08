var loadingIcon ='<div class="sk-spinner sk-spinner-three-bounce pull-left"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div></div>';

$(function(){

    $('#symptomTags').tagit({

    // This will make Tag-it submit a single form value, as a comma-delimited field.
    singleField: true,
    allowSpaces: true,
    tagSource:function( request, response ) {

        $.ajax({
         url: SITE_URL+"/healthcare_professional/symptoms",
         dataType: "json",
         data: {
                 q: request.term
         },
         success: function( data ) {
                 response( data );
         },
         error : function(){
             alert("Some error happend");
         },
        });
    },                
    triggerKeys:['enter', 'comma', 'tab'],
    allowNewTags: true,
    singleFieldNode: $('#symptom')

    });
            
});
$(function(){           
    $('#keywordTags').tagit({

        // This will make Tag-it submit a single form value, as a comma-delimited field.
        singleField: true,
        allowSpaces: true,
        tagSource:function( request, response ) {

           $.ajax({
                   url: SITE_URL+"/home/keywords",
                   dataType: "json",
                   data: {
                           q: request.term
                   },
                   success: function( data ) {
                           response( data );
                   },
                   error : function(){
                       alert("Some error happend");
                   },
           });
        },                
        triggerKeys:['enter', 'comma', 'tab'],
        allowNewTags: true,
        singleFieldNode: $('#keyword')
    });
            
});
function search_case()
{    
    if (!validator.checkAll($("#hpform"))) {   
        return false;
    }else{
        
         $('#resultdiv').html(loadingIcon);
         
//        $('button').prop('disabled', true);
        $.ajax({
        type: "POST",    
        data: $("#hpform").serialize(),
//        dataType: "json",
        url :SITE_URL+"/healthcare_professional/ajaxsearchcaselisting",
        success: function(data) {   
                $('#resultdiv').html(data);   
//        }

            
        },
        error : function(){
        $('button').prop('disabled', false);    
        $("#message-text").html('<i class="fa-fw fa fa-times"></i><strong>Error!</strong> Something went wrong, please try again.');
        $("#message").addClass('alert alert-danger');
        },
        });
        
    }
    

    
}

function getCountryState(country){
 var cnty = country.value;
 $('#state_select').html('');
 $('#state_text').val('');
  $.ajax({
        type: "GET",
        url: "state",
        dataType: "json",
        data: {cnty: cnty},
        
        success: function(data) {  
            if(data.state_exist){
                $("#state_1").show();
                $("#state_2").html('');
                $("#state_2").hide();
                states = data.state_arr;  
                $('#state_select').append($('<option/>', { 
                        value: "",
                        text : "Select State"
                }));                
                $.each(states, function(i,item) {
                     $('#state_select').append($('<option/>', { 
                        value: item,
                        text : item 
                    }));
                });
       
            }else{
               $("#state_1").hide();
               $("#state_2").html('<input  id="state_text" name="state_text"  title="State" class="form-control" type="text" required="required">');
               $("#state_2").show();
            }
        }
        });  
}
