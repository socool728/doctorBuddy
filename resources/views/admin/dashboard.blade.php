@extends('layouts.adminlayout')
@section('content')

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Questions</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Sessions <small></small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="example" class="table table-striped responsive-utilities jambo_table">
                        <thead>
                            <tr class="headings">
                                <th>SL No.</th>
                                <th>Session Id</th>
                                <th>Date</th>
                                <th>PDF</th>
                                <th>Assign</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                            $i = 0;
                            foreach($answers as $answer){ 
                            ?>
                                <tr class="even pointer">
                                    <td class=" ">{{++$i}}</td>
                                    <td class=" ">{{$answer['session_id']}}</td>
                                    <td class=" ">{{$answer['modified_date']}}</td>
                                    <td class=" last">
                                        <?php if($answer['filepath'] != '') { ?> 
                                            <a href="../download/{{$answer['filepath']}}"><i class="fa fa-file-pdf-o"></i></a>
                                        <?php } ?>    
                                    </td>
                                    <td class=" ">
                                        <?php echo $answer['assign'] == 1 ? (($answer['counsellor_id'] == Session::get('counsellor_id')) ? '<span class="assigned fa fa-bookmark"> (Me)</span>' : '<span class="assigned fa fa-bookmark"></span>') : '<span id="unassigned_'.$answer['answer_id'].'" class="unassigned fa fa-bookmark-o"></span>'; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <br />
        <br />
        <br />

    </div>
</div>

<script type="text/javascript">
    $('.unassigned').on('click', function(){
        if(confirm('Are you sure to assign this to you?') == true){
            var idArr = $(this).attr('id').split('_');
            var counsid = <?php echo Session::get('counsellor_id'); ?>;
                    
            $.ajax({
                type: "POST",
                url:  "assign",
                data: {answer: idArr[1], counsellor: counsid},
                success: function(){
                    alert("Assigned Successfully.");
                },
                error: function() {
                    alert('Error occured');
                },
            });
            
            $(this).removeClass().addClass("assigned fa fa-bookmark");
            $(this).html(" (Me)");
        }
        else{
            alert("Not assigned!");
        }
    });
</script>    
@stop