
var style_paths = SITE_URL+"/css/custom.css";
style_paths += style_paths +","+SITE_URL+"/css/style.css";
style_paths += style_paths +","+SITE_URL+"/css/bootstrap.min.css";

$( ".print" ).click(
    function(){                
        $('#pdfdv').hide();   
        $('#printdv').hide();   
        $( "#printable" ).print({
                stylesheet : style_paths
            });
            $('#pdfdv').show();   
        $('#printdv').show();   
        return( false );
    }
);

