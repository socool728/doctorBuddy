@extends('layouts.adminlayout')
@section('content')

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Contents</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
          <?php if(Session::get('flash_msg') != ''){?>
            <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="alert alert-success" id="" ><?php echo Session::get('flash_msg');?></div>
            </div>                               
        <?php } ?>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h3 class="pagehd">Contents <small></small></h3>
                       <h2 class="pagehdbtn"><a href="<?php echo $data['site_url'] ?>/admin/contents/add">Add Content</a> </h2>
                    <div class="clearfix"> </div>
                </div>
                <div class="x_content">
                    <table id="example" class="table table-striped responsive-utilities jambo_table">
                        <thead>
                            <tr class="headings">
                                <th>SL No.</th>
                                <th class="edit">Order</th>
                                <th> Content Title </th>
                                <th> Positon</th>
                                <th class="edit">Edit</th>
                                <th class="edit">Delete</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                            $i = 0;
                            foreach($contents as $content){ 
                            ?>
                                <tr class="even pointer">
                                    <td class=" ">{{++$i}}</td>
                                    <td class=" ">{{$content->display_order}}</td>
                                    <td class=" "><?php echo $content->contents_title;?></td>
                                    <td class=" last">{{$content->content_position}}</td>      
                                    <td class="edit"><a href="<?php echo $data['site_url'] ?>/admin/contents/edit/{{$content->contents_id}}"><button type="button" class="btn btn-primary">Edit</button></a></td>
                                    <td class="edit">
                                        <button delete_id ="{{$content->contents_id}}" type="button" class="btn btn-delete">Delete</button></td>
                                  
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
<script>
 var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>
<script src="<?php echo asset('js/admin/list_content.js'); ?>"></script>  
@stop