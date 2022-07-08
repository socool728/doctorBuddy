@extends('layouts.homelayout')
@section('content')

<script type="text/javascript">
var selvar = upvar =0;
$(function(){
  $("body").on("keyup", "#symptom", function(){
    var searchval = $('#symptom').val();   
    var len = searchval.length;
    if(searchval.length>2){
        $('#symptomboxdiv').show(); 
    $.ajax({
        type: "GET",
        url: "<?php echo asset('index.php/home/loadsymptom'); ?>",
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
    $('#seldisp').show();    
        var selsymptom = '<div class="lblsympt">'+$(this).html()+'</div>';
        var valsymp = $(this).attr("id");
        var elmt = '</div><div id="selsympt_'+selvar+'" class="symptsel"></div>';
        var hidelmnt = '<input name="symp_id[]" id="symp_'+upvar+'" type="hidden" value="'+valsymp+'" /><input name="rat_'+valsymp+'" id="rate_'+valsymp+'" type="hidden" />';
        var starimg = '<div class="rate_widget" id="r_'+valsymp+'"><div class="star_1 ratings_stars" data-tooltip="Select severity"></div><div class="star_2 ratings_stars" data-tooltip="Select severity"></div><div class="star_3 ratings_stars" data-tooltip="Select severity"></div><div class="star_4 ratings_stars" data-tooltip="Select severity"></div><div class="star_5 ratings_stars" data-tooltip="Select severity"></div><input type="text" name="symcnt_'+valsymp+'" /><a href="javascript:void(0);" data-tooltip="Delete Symptom" onclick="javascript: close_option('+valsymp+','+upvar+');"><img src="<?php echo asset('images/delete.png')?>" alt="Delete" ></a></div>';
         var elmtdisp = '<label class="symptsel col-md-3 col-sm-2 col-xs-12"></label>';
             elmtdisp = '<div id="currsympt_'+upvar+'">';
        if(selvar == 1){            
            document.getElementById('selsympt').innerHTML=elmtdisp+selsymptom+hidelmnt+starimg+elmt;
        }else{           
            document.getElementById('selsympt_'+upvar).innerHTML=elmtdisp+selsymptom+hidelmnt+starimg+elmt;
        }
        $('#symptomboxdiv').hide(); 
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
$("body").on("change", "#country", function(){
    var cnty = $('#country').val();  
    $.ajax({
            type: "GET",
            url: "<?php echo asset('index.php/home/state'); ?>",
            data: {cnty: cnty},
            success: function(data) {    
                if(data!=''){
                    $('#stated').hide();    
                    $('#statedv').html(data); 
                    $('#statedv').show(); 
                    $('#statedelt').attr('disabled','disabled'); 
                    $('#ercntry').hide();   
                }else{
                    $('#stated').show();  
                    $('#statedv').hide();
                    $('#ercntry').hide(); 
                    $('#statedelt').removeAttr('disabled');
                    $('#erstate').hide();
                }
            }
        });  
    });
    $("body").on("click", ".style-toggle", function(){ 
        $(".leftsidebar").toggleClass("active1");
    });
    $("body").on("click", "#upload_doc", function () {  
       var left        = ($(window).width()/2)-(400/2),
           top         = ($(window).height()/2)-(250/2),
           newwindow   = window.open($(this).prop('href'), '', 'height=250,width=400,top='+top+',left='+left);
       if (window.focus) 
       {
          newwindow.focus();
       }
       return false;
    });
   $("body").on("click", "#del_doc", function () {    
       $("#files").show();
       $("#upfiles").hide();
       $("#document").val('');

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
            url: "<?php echo asset('index.php/home/nickcheck'); ?>",
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
    if (!validator.checkAll($('form'))) {   
        return false;
    }else{       
        if(document.qform.existing['0'].checked==false){
            var user = $('#user_email_id').val();
            var pwd = $('#user_password').val();
             $.ajax({
                type: "GET",
                url: "<?php echo asset('index.php/home/usercheck'); ?>",
                data: {user: user,pwd: pwd},
                success: function(data) {    
                    if(data.id>0){
                        $('#nm').hide();
                        $('#em').hide();
                        var action = "<?php echo asset('index.php/home/finish'); ?>";
                        $("#qform").attr("action", action);
                        $("#qform").submit();                        
                    }else{
                        $('#em').show(); 
                        return false;
                    }
                }
            });  
        }else{
           
            var user = $('#email').val();                
            $.ajax({
               type: "GET",
               url: "<?php echo asset('index.php/home/userexist'); ?>",
               data: {user: user},
               success: function(data) {   
                   if(data ==0){
                        $('#exister').hide();
                        if(document.qform.terms.checked==false) {
                            $('#termer').show();
                            return false;
                        }else{  
                            $('#termer').hide();
                            var captcha_code = $('#captcha_code').val();
                            $.ajax({
                              type: "GET",
                              url: "<?php echo asset('js/captchacheck.php'); ?>",
                              data: {captcha_code: captcha_code},
                              success: function(data) {  
                                  if(data == 1){
                                      $('#captcher').hide();
                                      var action = "<?php echo asset('index.php/home/finish'); ?>";
                                      $("#qform").attr("action", action);
                                      $("#qform").submit();
                                  }else{
                                      $('#captcher').html(data);
                                      $('#captcher').show();                         
                                      return false;
                                  }                               
                              }
                          });  
                        }
                   }else{
                      ext = 1;
                       $('#exister').show();;  
                       return false; 
                   }
               }
           });                
           
        }
    }
}
function getqn(id)
{
    
        var divsel = currvar;
        if(currvar==2){
            if($('#country').val() == 0){
                $('#ercntry').show();
                return false;
            }else{
                $('#ercntry').hide();   
                if($('#country').val() == '103' || $('#country').val() == '236'){
//                $('#ercntry').hide();    
                }else{
                    if($('#statedelt').val() ==''){
                        $('#erstate').show();
                        return false;
                    }else{
                        $('#erstate').hide();
                    }
                }
            }
        }
    if (!validator.checkAll($('form'))) {   
        return false;
    }else{
        currvar++;
        var updvar = currvar+1; 
        var divhd = divsel-1;
        
        if(id >= 0 || id=='f'){
             var base = $("#qform").serialize();  
            $.ajax({
                type: "POST",
                url: "<?php echo asset('index.php/home/loadqn'); ?>",
                data: {gpid: id,divid:updvar,base:base},
                success: function(data) {
                    if(currvar == 1){
                        $('#qnblk').hide();    
                        $('#qndiv').html(data);
                    }else if(currvar == 2){    
                        $('#qndiv_1').show();
                        $('#qndiv_1').html(data);
                        $('#qndiv').hide();
                    }else if(currvar>2){   
                        $('#qndiv_'+divsel).show();
                        $('#qndiv_'+divhd).hide();
                        $('#qndiv_'+divsel).html(data);
                    }
                }
            });
        }
    }
}
</script>

<!-- top tiles 
<div class="row tile_count">
    <div class="animated flipInY col-sm-4 col-xs-4 tile_stats_count">
        <div class="right"><div class="count"><a href="< //?php echo asset('index.php/home'); ?>" class="logolnk">DoctorBuddy</a></div></div>
    </div>
</div>
<!-- /top tiles -->

<div class="row questionaire">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <h1 class="search-title">This is a test heading<br/>Your subtitle goes here<br/><small>Browse. Buy. Done.</small></h1>
        <div class="dashboard_graph">
                    <div class="x_panel">
                        <div class="x_content bs-example-popovers">
                            <div class="alert question-box alert-dismissible fade in" role="alert">
                                <form  action="" id="qform" name="qform" class="form-horizontal form-label-left" method="post" data-parsley-validate>
                                    <div id="qnblk">
                                        
                                    <div id="old_question"></div>
                                        
                                    <div  id="question">
                                        <div class="questiondv">                                   
                                        <div class="frm-group">
                                            <!--<label class="control-label" for="first-name">Nick Name</label>-->
                                            <div>                                                
                                                <input id="nick_name" name="nick_name" value="" title="Nickname" class="form-control col-md-7 col-xs-12" type="text" placeholder="Enter your Nick Name here">           
                                            </div>
                                        </div> 
                                        <div class="frm-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> &nbsp;</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input name="group_id" type="hidden" value="0" /><ul id="parsley-id-3638" class="parsley-errors-list"></ul> <div class="alertnck" id="nck" ></div>
                                            </div>
                                        </div>                               
                                        </div>
                                        
                                        <div class="enterbtn">
                                            <a id="btnnxt" class="btn btn-primary btn-block" onclick="list_values();">ENTER</a>
                                            <a href="finish" id="finish" class="btn btn-primary btn-lg active" role="button">FINISH</a>
                                        </div>
                                     </div>
                                        
                                    </div>
                                    <div id="qndiv"></div>
                                    <div id="qndiv_1"></div><div id="qndiv_2"></div><div id="qndiv_3"></div><div id="qndiv_4"></div><div id="qndiv_5"></div><div id="qndiv_6"></div><div id="qndiv_7"></div><div id="qndiv_8"></div><div id="qndiv_9"></div>                                        
                                </form>
                            </div>
                        </div>                    
                </div>
        </div>
    </div>
</div>
@stop