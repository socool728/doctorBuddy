$(document).on("click",".print",function(){

    $('#pdfdv').hide();   
    $('#printdv').hide(); 
    $("#printable .x_panel").attr('class','x_panel_1');

                
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
    $( "#printable .x_panel_1").attr('class','x_panel');

});
