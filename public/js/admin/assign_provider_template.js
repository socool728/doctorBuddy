var loadingIcon ='<div class="sk-spinner sk-spinner-three-bounce pull-left"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div></div>';
function assign_provider_template()
 {    
    
    if (!validator.checkAll($("#assign_provider_form"))) {   
        return false;
    }else{
            var template_id = $("#template_id").val();
            $('button').prop('disabled', true);  

            $("#message").removeClass('hide');
            $("#message-text").html(loadingIcon); 

            $.ajax({
            type: "POST",    
            data: $("#assign_provider_form").serialize(),
            dataType: "json",
            url :SITE_URL+"/admin/assignprovider/"+template_id+"/assign_provider_to_template",
            success : function(response) { 
                if(response.error == 1){
                    $("#message-text").html('<i class="fa-fw fa fa-times"></i><strong>Error!</strong>'+ response.err_msg);
                    $("#message").removeClass('hide');
                    $("#message").addClass('alert alert-danger');
                    $('button').prop('disabled', false);
                }else{
                    window.location.href= SITE_URL+"/admin/templates";
                }

            },
            error : function(){
            $('button').prop('disabled', false);    
            $("#message-text").html('<i class="fa-fw fa fa-times"></i><strong>Error!</strong> Something went wrong, please try again.');
            $("#message").removeClass('hide');
            $("#message").addClass('alert alert-danger');
            },
            });
//        }else{
//            $("#emailerr").show();
//            return false;
//        }
        
    }     
}  

$('form')
    .on('blur', 'input[required], input.optional, select.required', validator.checkField)
    .on('change', 'select.required', validator.checkField)
    .on('keypress', 'input[required][pattern]', validator.keypress);

$('.multi.required')
    .on('keyup blur', 'input', function () {
        validator.checkField.apply($(this).siblings().last()[0]);
    });
$('form').submit(function (e) {
        e.preventDefault();
        var submit = true;
        // evaluate the form using generic validaing
        if (!validator.checkAll($(this))) {
            submit = false;
        }

        if (submit)
            this.submit();
        return false;
 });
