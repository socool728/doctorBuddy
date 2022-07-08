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
                                Thank you for answering the questions.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>    

@stop