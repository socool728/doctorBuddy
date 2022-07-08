
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
     
    $('#symptom-outer-area').show();
    var symptomId = $(this).attr("id");
    var symptomName = $(this).html();
    var textboxName = "symcnt_"+symptomId;
    var radiobuttonName = "rat_"+symptomId;
    var symtomBoxId = "sym-box-"+symptomId;
        
    var symptomArea='<div class="sym-box m-b" id="'+symtomBoxId+'"><a class="close-link" link-id="'+symptomId+'">x</a><label class="col-lg-12 col-sm-12 col-xs-12">'+symptomName+'</label>';
    symptomArea+='<label class="col-lg-12 col-sm-12 col-xs-12 ti">Select severity</label>';
    symptomArea+='<div class="col-lg-12"><label class="radio-inline"><input type="radio" name="'+radiobuttonName+'"  value="Light">Light</label>';                           
    symptomArea+='<label class="radio-inline"><input type="radio" name="'+radiobuttonName+'" value="Medium">Medium</label>';                            
    symptomArea+='<label class="radio-inline"><input type="radio" name="'+radiobuttonName+'" value="Severe">Severe</label>';                                
    symptomArea+='<div class="col-lg-12 no-pad m-t"><input type="text" class="form-control" name="'+textboxName+'" placeholder="Additional Details"></div>';                                  
    symptomArea+='</div><input name="symp_id[]"  type="hidden" value="'+symptomId+'" /></div>';                                
    $('#symptomboxdiv').hide(); 
    $('#symptom-inner-area').append(symptomArea);  
    $("#symptom").val('');        
});
$("body").on("click", ".close-link", function(){ 
     var symptomId = $(this).attr("link-id");
     var symtomBoxId = "sym-box-"+symptomId;
     $("#"+symtomBoxId).remove();

     if($('#symptom-inner-area').html().length == 0){
         $('#symptom-outer-area').hide();
     }
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
    
    $("#symptom-inner-area").html('');
    $('#symptom-outer-area').hide();
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