$(
function(){
    $( ".print" ).click(
            function(){                
                $('#pdfdv').hide();   
                $('#printdv').hide();   
                $( "#printable" ).print({
                    });
                $('#pdfdv').show();   
                $('#printdv').show();   
                return( false );
            }
            );
}
);