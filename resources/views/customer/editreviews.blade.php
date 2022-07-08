@extends('layouts.customerlayout')
@section('content')
<div class="cd-main-header">		
    <a class="cd-nav-trigger" href="#0">
        <span></span>
    </a>		
</div>
<main class="cd-main-content">
    @include('customer.dashboardmenu')    
    <div class="content-wrapper col-lg-9 col-sm-9 col-xs-12">
    <h3>Edit Review</h3>
    <form action="javascript:void(0);" id="editreviews" name="editreviews" class="form-label-left" method="post"  role="form" >
    <div class="col-lg-12 col-sm-12  col-xs-12 m-t-xl registration-wrap  no-pad">
        
        <?php if(Session::get('flash_msg')): ?>
            <div id="message"  class="success-alert col-lg-12 col-sm-12 col-xs-12">
                <div id="message-text"><?php echo Session::get('flash_msg') ?></div>
            </div>
            <?php else : ?>
            <div id="message"  class="hide col-lg-12 col-sm-12 col-xs-12">
                <div id="message-text"></div>
            </div>
        <?php endif ?> 
        
        <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
            <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                <label>Provider Name</label> 
                <select disabled="disabled" id="healthcare_professional_id" title="Provider Name" name="healthcare_professional_id" class="form-control" >
                    <?php 
                        $hp_arr=DB::table('casefile_to_healthcare')
                                ->leftjoin('healthcare_professional', 'casefile_to_healthcare.healthcare_professional_id', '=', 'healthcare_professional.healthcare_professional_id')
                                ->where('casefile_to_healthcare.customer_id', '=',$_SESSION['customer_id'])
                                ->where('healthcare_professional.healthcare_professional_status', '=',1)
                                ->select('healthcare_professional.healthcare_professional_id','healthcare_professional.healthcare_professional_first_name','healthcare_professional.healthcare_professional_middle_name','healthcare_professional.healthcare_professional_last_name')
                                ->distinct()
                                ->get();
                                if(count($hp_arr)>0)
                                {
                    ?>
                                        <option value=''>---Select---</option>
                                        <?php
                                            foreach ($hp_arr as $hp)
                                            {
                                                $name = $hp->healthcare_professional_first_name;
                                                if($hp->healthcare_professional_first_name !=''){
                                                    $name .= " ".$hp->healthcare_professional_middle_name;
                                                }
                                                $name .= " ".$hp->healthcare_professional_last_name;
                                        ?>
                                                <option value="{{$hp->healthcare_professional_id}}" <?php if($data['healthcare_professional_id']==$hp->healthcare_professional_id){ echo "selected='selected'";}?>>
                                                    {{$name}}
                                                </option>
                                        <?php      
                                            }
                                }
                                else
                                {
                    ?>
                                       <option value=''>---No provider(s) found---</option> 
                    <?php
                                    
                                }
                    ?>
                </select>
            </div>
            
        </div>
        
        <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
            <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                <label>Review Score</label> 
                <select id="review_score" name="review_score" title="Review Score" required="required" class="form-control">                                                                       
                    <option value="1" data-html="Terrible" <?php if($data['review_score']=="1"){ echo "selected='selected'";}?>>1</option>
                    <option value="2" data-html="Poor" <?php if($data['review_score']=="2"){ echo "selected='selected'";}?>>2</option>
                    <option value="3" data-html="Average" <?php if($data['review_score']=="3"){ echo "selected='selected'";}?>>3</option>
                    <option value="4" data-html="Very Good" <?php if($data['review_score']=="4"){ echo "selected='selected'";}?>>4</option>
                    <option value="5" data-html="Excellent" <?php if($data['review_score']=="5"){ echo "selected='selected'";}?>>5</option>
              </select>
            </div>
            
        </div>
        
        <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
            <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                <label>Comments</label> 
                <textarea placeholder="Please share your consultation experience here..." rows="7" id="comments" name="comments" title="Comments"  class="form-control"><?php if($data['comments']){ echo $data['comments'];}?></textarea>                                                                      
            </div>
            
        </div>
        
        <div class="col-lg-12 col-sm-12 col-xs-12 no-pad text-right">
            <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
            <button type="submit" title="Update" onclick="return edit(<?php echo $data['id']; ?>);"  class="btn btn-red" role="button">Update</button>               
            <input type="hidden" name="form_submit" value="save"> 
            </div>
        </div>
        
        
    </div>
      <input type="hidden" value="<?php echo $data['healthcare_professional_id'];?>" name="healthcare_professional_id">
</form>
</div> <!-- .content-wrapper -->        
</main>    

<script>
    var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>
<script src="<?php echo asset('js/review/jquery.barrating.min.js'); ?>"></script>
<script src="<?php echo asset('js/customer/editreviews.js'); ?>"></script>
@stop