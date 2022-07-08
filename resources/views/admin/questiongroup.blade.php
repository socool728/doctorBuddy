@extends('layouts.adminlayout')
@section('content')

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Admin Staff</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    
                    <h3 class="pagehd">Question Group</h3>
                    <h2 class="pagehdbtn"><a href="../admin/add-questiongroup"><i class="fa fa-plus fa-6" aria-hidden="true">&nbsp;Add Question Group</i></a> </h2>
                    <div class="clearfix">  </div>
                    
                </div>
                <?php if(Session::get('flash_msg') != ''){?>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="alert alert-success" id="" ><?php echo Session::get('flash_msg');?></div>
                    </div>                               
                <?php } ?> 
                <div class="x_content">
                    <table id="example" class="table table-striped responsive-utilities jambo_table">
                        <thead>
                            <tr class="headings">
                                <th>SL No.</th>       
                                 <th>Group Order</th>
                                <th>Question Group Name</th>
                               
                                <th>Option</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                            $i = 0;
                            foreach($groups as $group){ 
                            ?>

                                <tr class="even pointer">
                                    <td class=" ">{{++$i}}</td>
                                    <td class=" ">{{$group->display_order}}</td>
                                    <td class=" ">{{$group->group_name}}</td>
                                    
                                    <td>
                                        <a href="{{URL::to('/')}}/admin/edit-questiongroup/{{$group->group_id}}">
                                             <i aria-hidden="true" class="fa fa-pencil fa-4" title="Edit"></i>
                                        </a><?php if(!isset($group->question_group_id)){?>
                                        &nbsp;
                                        <a href="{{URL::to('/')}}/admin/del-questiongroup/{{$group->group_id}}" onclick="return confirm('Are you sure to delete this Group?')" class="link-delete">
                                            <i class="fa fa-trash-o fa-4" aria-hidden="true" title="Delete"></i>
                                        </a>
                                        <?php } ?>
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

@stop