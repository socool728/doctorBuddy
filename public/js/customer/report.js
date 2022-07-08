
$(document).on("click",".print",function(){


    $('#pdfdv').hide();   
    $('#printdv').hide(); 
                
$( "#printable").print({
    globalStyles: true,
    mediaPrint: false,
    stylesheet: null,
    noPrintSelector: ".no-print",
    iframe: true,
    append: null,
    prepend: null,
    manuallyCopyFormValues: true,
    deferred: $.Deferred(),
    timeout: 250,
    title: null,
    doctype: '<!doctype html>'
    });
    
    $('#pdfdv').show();   
    $('#printdv').show();  
});