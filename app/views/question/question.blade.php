@extends('layouts.homelayout')
@section('content')

<!-- top tiles -->
<div class="row tile_count">
    <div class="animated flipInY col-sm-4 col-xs-4 tile_stats_count">
        <div class="right"><div class="count">MindZetters</div></div>
    </div>
</div>
<!-- /top tiles -->

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="dashboard_graph">
            <div class="row x_title">
                <div class="col-md-6 newxpanel">
                    <div class="x_panel">
                        <div class="x_content bs-example-popovers">
                            <div class="alert question-box alert-dismissible fade in" role="alert">
                                <form  action="" id="qform">
                                    <div id="old_question"></div>
                                    <div class="question" id="question">{{$question}}</div>
                                    <div class="next">
                                        <button id="next" class="btn btn-primary">NEXT</button>
                                        <a href="finish" id="finish" class="btn btn-primary btn-lg active" role="button">FINISH</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $.validate({
            validateOnBlur : false, // disable validation when input looses focus
            errorMessagePosition : 'top', // Instead of 'element' which is default
            scrollToTopOnError : false, // Set this property to true if you have a long form
            onSuccess : function() {
                $("#next").hide();
                $("#old_question").show();
                var count = 0;
                var c = 0;
                var clen = $('#qform .optionspan').length;
                var options = {};
                
                var func = function(){
                    var jsonOption = JSON.stringify(options);
                    $.ajax({
                        type: "POST",
                        url:  "next",
                        data: {option: jsonOption},
                        dataType:"json",
                        success: function(response){
                            $("#question").empty();
                            $("#old_question").append(response['oldquestion']+"<br/><br/>");
                            $("#question").append(response['optionquestion']);
                            $("#old_question").animate({ scrollTop: $('#old_question')[0].scrollHeight}, 1000);
                            
                            $('#qform .optionspan').each(function(){
                                if($("[name='option_"+c+"']").is(':checkbox')){
                                    $("[name='option_"+c+"']").each(function(){    
                                        $("[name='option_"+c+"']:eq(0)")
                                        .valAttr('','validate_checkbox_group')
                                        .valAttr('qty','min1');
                                    });    
                                }
                                c++;
                            }); 
                            if(response['nextquestion'] == 0)
                                $('#next').hide();
                            else
                                $('#next').show();
                        },
                        error: function() {
                            alert('Error occured');
                        }
                    });
                };
                
                $('#qform .optionspan').each(function(){
                    var str = ''; var i = 0;
                    var attrkey = $(this).attr('id');
                    options[attrkey] = {};

                    if(($('[name=option_'+count+']').is(':radio')) || ($('[name=option_'+count+']').is(':checkbox'))){
                        str = ':checked';
                    }
                    $("[name=option_"+count+"]"+str).each(function(){
                        options[attrkey][i] = $(this).val();
                        i++;
                    });
                    

                    //Last attribute key
                    if(attrkey == 'KEY_CULTBACK'){
                        $('#finish').show();
                        $('#next').hide();
                    }
                    clen--;
                    if(clen==0) func();
                    count++;
                }); 
                
                return false;
            }
        });
       
        $(document).on('change','.option',function(){ 
            $.each($(".option"),function(index,item){
                if($(item). is(":checked")) {
                    $(item).next('span').show();
                } else {
                    $(item).next('span').hide();
                }
            }); 
        });        
    }); 
</script> 
@stop