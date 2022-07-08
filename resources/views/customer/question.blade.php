@extends('layouts.homelayout')
@section('content')



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
                                        
                                    <div id="question" class="question-wrapper">
                                        <div class="questiondv">                                   
                                            <div class="frm-group">
                                                <!--<label class="control-label" for="first-name">Nick Name</label>-->
                                                <div>                                                
                                                    <input id="nick_name" name="nick_name" value="" title="Nickname" class="form-control" type="text" placeholder="Enter your Nick Name here">           
                                                </div>
                                            </div> 
                                            <div class="frm-group">
                                                <div>
                                                    <input name="group_id" type="hidden" value="0" />
                                                    <ul id="parsley-id-3638" class="parsley-errors-list"></ul>
                                                    <div class="alertnck animated flipInX" id="nck" ></div>
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