@extends('layouts.adminlayout')
@section('content')

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Customer Reviews</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h3 class="pagehd">Customer Reviews <small></small></h3>
                    <h2 class="pagehdbtn"><a title="Add Customer Review" href="{{URL::to('/')}}/admin/reviews/add"><i class="fa fa-plus fa-6" aria-hidden="true">&nbsp;Add Review</i></a> </h2>
                    <div class="clearfix"> </div>
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
                                <th  class="edit">SL No.</th>
                                <th> Customer Name</th>
                                <th> Provider Name </th>
                                <th> Rating</th>
                                <th> Date</th>
                                <th class="edit">Options</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                            $i = 0;
                            if(isset($data['reviewinfo'])&& count($data['reviewinfo']) > 0){
                                foreach($data['reviewinfo'] as $reviewinfo){ ?>

                                <tr class="even pointer">
                                    <td class=" ">{{++$i}}</td>
                                    <td class=" "><?php $name = $reviewinfo->customer_fname.' '.$reviewinfo->customer_lname;echo $name;?></td>
                                    <td class=" ">
                                        <?php $name = $reviewinfo->healthcare_professional_first_name;
                                        if($reviewinfo->healthcare_professional_first_name !=''){
                                            $name .= " ".$reviewinfo->healthcare_professional_middle_name;
                                        }
                                        $name .= " ".$reviewinfo->healthcare_professional_last_name;
                                        echo $name;?>
                                    </td>
                                    <td class=" ">
                                        <?php //echo  $reviewinfo->review_score;?>
                                        <form class="dt-review">
                                        <select title="Review Score" class="form-control review_score">                                                                       
                                            <option value="1" <?php if($reviewinfo->review_score=="1"){ echo "selected='selected'";}?>>1</option>
                                            <option value="2" <?php if($reviewinfo->review_score=="2"){ echo "selected='selected'";}?>>2</option>
                                            <option value="3" <?php if($reviewinfo->review_score=="3"){ echo "selected='selected'";}?>>3</option>
                                            <option value="4" <?php if($reviewinfo->review_score=="4"){ echo "selected='selected'";}?>>4</option>
                                            <option value="5" <?php if($reviewinfo->review_score=="5"){ echo "selected='selected'";}?>>5</option>
                                        </select>
                                        </form> 
                                    </td>     
                                    <td><?php echo date(Config::get('constants.DATE_FORMAT'),strtotime($reviewinfo->date));?></td>
                                    <td class="links">
                                        <a href="<?php echo asset('admin/reviews/edit/'.$reviewinfo->review_id );?>" >   
                                            <i aria-hidden="true" class="fa fa-pencil fa-4" title="Edit Review"></i>
                                        </a>&nbsp;
                                        <a href="<?php echo asset('admin/reviews/delete/'.$reviewinfo->review_id );?>" onclick="return confirm('Are you sure to delete this Review?')">   
                                            <i aria-hidden="true" class="fa fa-trash-o fa-4" title="Remove Review"></i>
                                        </a>
                                    </td>
                                </tr>    
                            <?php }?>
                                   <?php }else{ ?>
                       <tr><td colspan="6" class="text-center">No Reviews to View</td></tr>
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
<script src="<?php echo asset('js/review/jquery.barrating.min.js'); ?>"></script>
<script>
$(document).ready(function() {
    $('.review_score').barrating({
        theme: 'fontawesome-stars',
        readonly:'true'
      });
} );
</script>
@stop
