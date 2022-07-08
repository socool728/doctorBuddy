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
                    <h2>Add Review <small></small></h2>
                    <div class="clearfix"> </div>
                </div>
                <div  id="message" class="hide warning-alert col-md-12 col-sm-12 col-xs-12">
                    <div id="message-text"></div>
                    </div>     
                <div class="x_content">
                    <br></br>
                    <form action="javascript:void(0);" novalidate="" id="addreviews" data-parsley-validate="" class="form-horizontal form-label-left" method="post">
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="customer_id">Customer Name <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="customer_id" name="customer_id" required="required" title="customer name">
                                          
                                            <?php
                                                $customers = DB::table('customers')
                                                            ->where('is_deleted','=',0)
                                                            ->where('customer_fname','!=','')       
                                                            ->orderBy('customer_fname', 'ASC')->get();
                                                if(count($customers)>0)
                                                {
                                                    
                                                ?>
                                                    <option value="">---Select---</option>
                                           <?php
                                                    foreach ($customers as $customer) {
                                           ?>
                                                    <option value="<?php echo $customer->customer_id;?>"><?php echo $customer->customer_fname.' '.$customer->customer_lname;?></option>                                                 
                                           <?php
                                                }
                                                }
                                                else
                                                {
                                            ?>
                                                    <option value=''>---No customer(s) found---</option> 
                                            <?php
                                                    
                                                }
                                           ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="healthcare_professional_id">Provider Name <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="healthcare_professional_id" name="healthcare_professional_id" required="required" title="provider name">
                                            <option value="">---Select---</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="review_score">Review Score<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select id="review_score" name="review_score" title="Review Score" required="required" class="form-control">                                                                       
                                            <option value="">Select</option>                                            
<option value="1" data-html="Terrible">1</option>
                                            <option value="2" data-html="Poor">2</option>
                                            <option value="3" data-html="Average">3</option>
                                            <option value="4" data-html="Very Good">4</option>
                                            <option value="5" data-html="Excellent">5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="comments">Comments
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea id='comments' rows="7" placeholder="Please share your consultation experience here...(as chosen customer)" class="form-control" name="comments" title="comments"></textarea>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                      <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                                          <a href="../admin/reviews"><button class="btn btn-primary" title="Cancel" type="button">Cancel</button></a>
                                          <button type="submit"  title="Add" onclick="return add();"  class="btn btn-success" role="button">Add</button>
                                          <input type="hidden" name="form_submit" value="save"> 
                                      </div>
                                </div>
                                </div>
                            </form>                                    
                </div>
            </div>
        </div>
        <br />
        <br />
        <br />
    </div>
</div>
<script type="text/javascript">
    var SITE_URL = "<?php echo $data['site_url'] ?>";
    var customerId = $('#customer_id').val();
</script>
<script src="<?php echo asset('js/review/jquery.barrating.min.js'); ?>"></script>
<script src="<?php echo asset('js/admin/addreviews.js'); ?>"></script>
@stop
