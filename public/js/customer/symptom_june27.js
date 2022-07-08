$(function () {
$("body").on("click", ".editbtn", function(){ 
    $('#sym').hide(); 
    $('#editsym').show(); 
});
$("body").on("click", ".ratings_plus", function(){ 
    var star = this;
    var widget = $(this).parent();
    var cl =$(star).attr('class');
    var wid = widget.attr('id');
    var rval  = cl.substring(5,6);
    var sympid = wid.substring(2);
    $('#rate_'+sympid).val(rval);
    $(this).prevAll().andSelf().addClass('plus_vote');
    });
        $("body").on("mouseenter", ".ratings_plus", function(){ 
            $(this).prevAll().andSelf().addClass('plus_over');
            $(this).nextAll().removeClass('plus_vote'); 
        });
        $("body").on("mouseleave", ".ratings_plus", function(){ 
             $(this).prevAll().andSelf().removeClass('plus_over');
        });   
   var selvar = upvar =0;
$(".symptsearch").keyup(function(){    
        var detailid = $('#detailid').val();
         var searchval = $(this).val();  
    var len = searchval.length;
    if(searchval.length>2){
        $('#symptomboxdiv').show(); 
    $.ajax({
        type: "GET",
        url: SITE_URL+"/home/loadsymptom",
        data: {search: searchval,did:detailid},
        success: function(data) {              
                $('#symptomdiv').html(data);   
        }
    });
    }
});

$("body").on("click", ".symptlist", function(){  

    upvar = selvar;
    selvar++;
    $('#seldisp').show();    
        var selsymptom = '<div class="lblsympt">'+$(this).html()+'</div>';
        var valsymp = $(this).attr("id");
        var elmt = '</div>';
        var hidelmnt = '<input name="symp_id[]" id="symp_'+upvar+'" type="hidden" value="'+valsymp+'" /><input name="rate_'+valsymp+'" id="rate_'+valsymp+'" type="hidden" />';
        var starimg = '<div class="rate_widget" id="r_'+valsymp+'"><div class="star_1 ratings_plus" data-tooltip="Select severity"></div><div class="star_2 ratings_plus" data-tooltip="Select severity"></div><div class="star_3 ratings_plus" data-tooltip="Select severity"></div><div class="star_4 ratings_plus" data-tooltip="Select severity"></div><div class="star_5 ratings_plus" data-tooltip="Select severity"></div><input type="text" name="symcnt_'+valsymp+'" /><a href="javascript:void(0);" data-tooltip="Delete Symptom" onclick="javascript: close_option(\''+valsymp+'\',\''+upvar+'\');"><img src="'+SITE_URL+'/images/delete.png" alt="Delete" ></a></div>';
        var elmtdisp = '<div id="currsympt_'+upvar+'">';


        
        var newHtml = $('#selsympt').html()+ elmtdisp+selsymptom+hidelmnt+starimg+elmt;
        $('#selsympt').html(newHtml);
        $('#symptomboxdiv').hide(); 
        $('#symptom').val("");  
});
});
function close_option(sym, id){
    if (confirm('Are you sure you want to remove this symptom')){	
    document.getElementById('currsympt_'+id).style.display='none';	
    document.getElementById('symp_'+id).disabled='disabled';	
    document.getElementById('rate_'+sym).disabled='disabled';	
    document.getElementById('symcnt_'+sym).disabled='disabled';	             
    }
}
function updatesymptom(id)
{        
    if(id > 0){
         var base = $("#qform").serialize(); 
         var did = $('#detailid').val();
         var rate = $('#rate_'+id).val();
         var cmnt = $('#symcnt_'+id).val();
        $.ajax({
            type: "POST",
            url: SITE_URL+"/customer/updatesymptom",
            data: {symid: id,detailid: did,rate:rate,cmnt:cmnt},
            success: function(data) {
                  $('#div'+id).html(data);  
            }
        });
    }
}
function viewsymptom(id){
    if(id > 0){ 
        $.ajax({
            type: "POST",
            url: SITE_URL+"/customer/viewsymptom",
            data: {detailid: id},
            success: function(data) {
                $('#his').html(data);
            }
        });
    }
}
function hidesymptom(id){
    $('#his'+id).hide();
    $('#hidehis'+id).hide();
    $('#showhis'+id).show();
}
function showsymptom(id){
    $('#his'+id).show();
    $('#hidehis'+id).show();
    $('#showhis'+id).hide();
}
function editsymptom(id){
    $('#editsympt'+id).hide();
    $('#updsym'+id).show();
}
function addsymptom()
{      
    var base = $("#qform").serialize(); 
    var did = $('#detailid').val();
    if(did >0){
        $.ajax({
            type: "POST",
            url: SITE_URL+"/customer/addsymptom",
            data: $("#qform").serialize(),
            success: function(data) {
                  $('#custsymp').html(data);  
            }
        });
        $('#addsympdv').show();
        $('#addsymp').hide();
    }
}
function add(){
    $('#addsympdv').hide();
    $('#addsymp').show();
    $('#selsympt').html('');
    
}

function delete_symptom(customer_symptom_id){
    
    if(customer_symptom_id){
        if(!confirm("Are you sure , you want to delete this symptom?"))
            return false;
        $.ajax({
            type: "POST",
            dataType: "json",
            url: SITE_URL+"/customer/deletesymptom/"+customer_symptom_id,
            success: function(response) {
                  if(response.error == 0){
                      window.location = SITE_URL+"/customer/symptom/"+response.detail_id
                  }                  
            }
        });        
        
    }
    
}


// START:responsive bootstrap popup for template

//Specific code for popup,here just write the logic
 function open_symptom_history(casefileId,symptomId,symptomName) {
    $.ajax({
    type: "POST",    
    dataType: "html",
    url :SITE_URL+"/customer/ajaxsymptomhistory/"+casefileId+"/"+symptomId,
    success : function(data) { 
        $('#history_modal_title').html(symptomName); 
        $('#history_modal_body').html(data);  
        $("#history_popup").modal('show');          
    },
    error : function(){
        alert("some error has happend during refresh.Please try after some time")
    },
    });
}

 function edit_symptom(customer_symptom_id,symptomName) {
    $.ajax({
    type: "POST",    
    dataType: "html",
    url :SITE_URL+"/customer/ajaxsymptomedit/"+customer_symptom_id,
    success : function(data) { 
        $('#history_modal_title').html(symptomName); 
        $('#history_modal_body').html(data);  
        $("#history_popup").modal('show');          
    },
    error : function(){
        alert("some error has happend during refresh.Please try after some time")
    },
    });
}
 function process_edit_symptom() {
    $.ajax({
    type: "POST",    
    dataType: "json",
    data:$("#edit_symptom").serialize(),
    url :SITE_URL+"/customer/ajaxprocesssymptomedit",
    success : function(response) { 
        if(response.error ==0){
            window.location = SITE_URL+"/customer/symptom/"+response.detail_id
            $("#history_popup").modal('hide');  
        }
    },
    error : function(){
        alert("some error has happend during refresh.Please try after some time")
    },
    });
}
// END:responsive bootstrap popup