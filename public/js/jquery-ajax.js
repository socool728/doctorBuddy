var selvar = upvar =0;
$(function(){
  $("body").on("keyup", "#symptom", function(){
    var searchval = $('#symptom').val();   
    var len = searchval.length;
    if(searchval.length>0){
        $('#symptomboxdiv').show(); 
    $.ajax({
        type: "GET",
        url: "home/loadsymptom",
        data: {search: searchval},
        success: function(data) {              
                $('#symptomdiv').html(data);   
        }
    });
    }
    });
$("body").on("click", ".symptlist", function(){  
    upvar = selvar;
    selvar++;
        var selsymptom = '<div class="lblsympt">'+$(this).html()+'</div>';
        var valsymp = $(this).attr("id");
        var elmt = '<div id="selsympt_'+selvar+'" class="symptsel"></div>';
        var hidelmnt = '<input name="symp_id[]" type="hidden" value="'+valsymp+'" /><input name="rat_'+valsymp+'" id="rate_'+valsymp+'" type="hidden" />';
        var starimg = '<div class="rate_widget" id="r_'+valsymp+'"><div class="star_1 ratings_stars"></div><div class="star_2 ratings_stars"></div><div class="star_3 ratings_stars"></div><div class="star_4 ratings_stars"></div><div class="star_5 ratings_stars"></div></div>';
         var elmtdisp = '<label class="symptsel col-md-3 col-sm-2 col-xs-12"></label>';
             elmtdisp = '';
        if(selvar == 1){            
            document.getElementById('selsympt').innerHTML=elmtdisp+selsymptom+hidelmnt+starimg+elmt;
        }else{           
            document.getElementById('selsympt_'+upvar).innerHTML=elmtdisp+selsymptom+hidelmnt+starimg+elmt;
        }
});
$("body").on("click", ".ratings_stars", function(){ 
    var star = this;
    var widget = $(this).parent();
    var cl =$(star).attr('class');
    var wid = widget.attr('id');
    var rval  = cl.substring(5,6);
    var sympid = wid.substring(2);
    $('#rate_'+sympid).val(rval);
    $(this).prevAll().andSelf().addClass('ratings_vote');
    });
        $("body").on("mouseenter", ".ratings_stars", function(){ 
            $(this).prevAll().andSelf().addClass('ratings_over');
            $(this).nextAll().removeClass('ratings_vote'); 
        });
        $("body").on("mouseleave", ".ratings_stars", function(){ 
             $(this).prevAll().andSelf().removeClass('ratings_over');
        });
});
var currvar =0;
function list_values()
{ 
    currvar =0;
    if($('#nick_name').val() == '')
    {
        var msg = 'Please enter Nickname';
        $('#nck').show();
        $('#nck').html(msg);
        return false;
    }else{
        var nick = $('#nick_name').val();
         $.ajax({
            type: "GET",
            url: "home/nickcheck",
            data: {nick: nick},
            success: function(data) {    
                if(data == 1){
                    getqn('0');  
                }else if(data!=''){
                    $('#nck').html(data);
                    $('#nck').show();
                }         
            }
        });  
    }
}
function finish()
{    
    if($('#name').val() == '')
    {
        var msg = 'Please enter name';
        $('#nm').show();
        $('#nm').html(msg);
        return false;
    }else if($('#name').val() != ''){
       $('#nm').hide();  
    }        
    if($('#email').val() == '')
    {
        var msg = 'Please enter Email';
        $('#em').show();
        $('#em').html(msg);
        return false;
    }else if($('#email').val() != ''){
       $('#em').hide();  
    }   
    var action = "home/finish";
    $("#qform").attr("action", action);
    $("#qform").submit();
}
function getqn(id)
{
    if (!validator.checkAll($('form'))) {   
        return false;
    }else{
        currvar++;
        var updvar = currvar+1; 
        if(id >= 0 || id==f){
             var base = $("#qform").serialize();  
            $.ajax({
                type: "POST",
                url: "home/loadqn",
                data: {gpid: id,divid:updvar,base:base},
                success: function(data) {
                    if(currvar == 1){
                        $('#qnblk').hide();    
                        $('#qndiv').html(data);
                    }else{
                        $('#qndiv_1').hide();
                        $('#qndiv_2').html(data);
                    }
                }
            });
        }
    }
}