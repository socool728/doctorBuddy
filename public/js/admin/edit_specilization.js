function edit_specilization()
 {    
    
    if (!validator.checkAll($("#edit_specilization_form"))) {   
        return false;
    }else{

        $('button').prop('disabled', true);  
        $.ajax({
        type: "POST",    
        data: $("#edit_specilization_form").serialize(),
        dataType: "json",
        url :SITE_URL+"/admin/specilization/edit/"+$("#specilization_id").val(),
        success : function(response) { 
            if(response.error == 1){
                $("#message-text").html('<i class="fa-fw fa fa-times"></i><strong>Error!</strong>'+ response.err_msg);
                $("#message").removeClass('hide');
                $("#message").addClass('alert alert-danger');
                $('button').prop('disabled', false);
            }else{
                window.location.href= SITE_URL+"/admin/specilization";
            }
            
        },
        error : function(){
        $('button').prop('disabled', false);    
        $("#message-text").html('<i class="fa-fw fa fa-times"></i><strong>Error!</strong> Something went wrong, please try again.');
        $("#message").removeClass('hide');
        $("#message").addClass('alert alert-danger');
        },
        });
        
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