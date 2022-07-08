
$(
function(){
    $( ".print" ).click(
            function(){
                var printId = $(this).attr('print-id');

                $('#pdfdv_'+printId).hide();   
                $('#printdv_'+printId).hide();   
                
                $( "#printable_" +printId).print({
                        stylesheet : "<?php echo asset('/css/custom.css');?>,<?php echo asset('/css/style.css');?>,<?php echo asset('/css/bootstrap.min.css');?>"
                    });
                $('#pdfdv_'+printId).show();   
                $('#printdv_'+printId).show();  
                return( false );
            }
            );
}
);
