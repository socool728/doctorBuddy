@extends('layouts.customerlayout')
@section('content')
<div class="cd-main-header">		
    <a class="cd-nav-trigger" href="#0">
        <span></span>
    </a>		
</div>
<main class="cd-main-content">
    @include('customer.dashboardmenu')
     
    <div class="content-wrapper col-lg-10 col-sm-10 col-xs-12">
        
        <div class="m-b">
          <h3>Reviews
            <a href="<?php echo $data['site_url'] ?>/customer/reviews/add"  class="pull-right">
                <button class="btn btn-red m-b" type="button"> Add Review</button>
            </a>   </h3>
        </div>
        
       <?php if(Session::get('flash_msg')): ?>
            <div id="message"  class="success-alert col-lg-12 col-sm-12 col-xs-12" style="margin-bottom: 10px;">
                <div id="message-text"><?php echo Session::get('flash_msg') ?></div>
            </div>
            <?php else : ?>
            <div id="message"  class="hide col-lg-12 col-sm-12 col-xs-12" style="margin-bottom: 10px;">
                <div id="message-text"></div>
            </div>
        <?php endif ?> 
        
        
        <div class="col-lg-12 no-pad">
        <div class="table-responsive">
            <table class="table display" width="100%" cellspacing="0" id="customer_reviews">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Provider Name</th>
                    <th>Rating</th>
                    <th>Comments</th>
                    <th>Date</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php $i =0 ;?>
                <?php if(isset($data['reviewinfo'])&& count($data['reviewinfo']) > 0){ ?>
                    <?php foreach($data['reviewinfo'] as $reviewinfo){ ?>
                
                        <tr>
                            <td><?php echo ++$i; ?></td>
                            <td>
                                <?php 
                                    $name='';
                                    $name = $reviewinfo->healthcare_professional_first_name;
                                    if($reviewinfo->healthcare_professional_first_name !=''){
                                            $name .= " ".$reviewinfo->healthcare_professional_middle_name;
                                        }
                                    $name .= " ".$reviewinfo->healthcare_professional_last_name;
                                    echo $name;
                                ?>
                            </td>
                            <td>
                                <?php //echo $reviewinfo->review_score; ?>
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
                            <td> 
                                <?php 
                                    $comments=trim($reviewinfo->comments); 
                                    echo substr($comments,0,25);
                                    if(strlen($comments)>25) 
                                        echo '...'; 
                                ?>
                            </td>
                            <td><?php echo date(Config::get('constants.DATE_FORMAT'),strtotime($reviewinfo->date));?></td>
                            <td class="links">
                                <a href="<?php echo asset('customer/reviews/edit/'.$reviewinfo->review_id );?>" >   
                                    <i aria-hidden="true" class="fa fa-pencil fa-4" title="Edit Review"></i>
                                </a>&nbsp;
                                <a href="<?php echo asset('customer/reviews/delete/'.$reviewinfo->review_id );?>" onclick="return confirm('Are you sure to delete this Review?')">   
                                    <i aria-hidden="true" class="fa fa-trash-o fa-4" title="Remove Review"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>                        
                <?php }else{ ?>
                       <tr><td colspan="6" class="text-center">No Reviews to View</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
        </div>        
    </div>
</main>    

<script src="<?php echo asset('js/review/jquery.barrating.min.js'); ?>"></script>
<script>
$(document).ready(function() {
    $('#customer_reviews').DataTable();
    $('.review_score').barrating({
        theme: 'fontawesome-stars',
        readonly:'true'
      });
} );
</script>

@stop