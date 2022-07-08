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
        <div class="col-lg-12">
    <h3>Payment</h3>
    <form action="javascript:void(0);" id="payment-form" name="payment-form" class="form-label-left" method="post"  role="form" >
        <div class="col-lg-12 col-sm-12  col-xs-12 m-t-xl registration-wrap left no-pad">
            
            <div id="custom_message_wrapper">    
                <div id="message"  class="hide">
                    <div id="message-text"></div>
                </div>
                 <?php if(Session::get('flash_msg')) : ?>
                <div class="success-alert"><?php echo Session::get('flash_msg') ?></div>
                <?php endif ;?>
            </div>

            <?php if(isset($data['error-meesage']) && $data['error-meesage'] !='')  : ?>
                <div class="alert alert-danger"><?php echo $data['error-meesage']  ?></div>
            <?php else:?>
                <div class="ibox-content">
                    <div>
                        <div class="col-lg-12 alert alert-info">Amount To be Paid: $<?php echo $data['amt'] ?></div>
                    </div>

                    <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
                            <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                                <label>Card Type</label> 
                                <select name="cc_type" id="cc_type" required="required" class="form-control" title="Card type" onchange="card_type_section(this);">
                                    <option value="VISA">Visa</option>
                                    <option value="MASTERCARD">MasterCard</option>
                                    <option value="DISCOVER">Discover Card</option>
                                    <option value="AMEX">American Express</option>
                                    <option value="SWITCH">Maestro</option>
                                    <option value="SOLO">Solo</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">
                                <label>Card Number</label> 
                                <input value="4716241891200666"  id="cc_number" name="cc_number" title="Cardnumber" required="required" class="form-control"  type="text">
                            </div>
                    </div>  
                    <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
                            <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad">
                                <label>Card Security Code (CVV2)</label> 
                                <input id="cc_cvv2" name="cc_cvv2" title="cvv2"  class="form-control" type="text" required="required" value="123">
                            </div>                         
                            <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad">
                                <label>Card Expiry Date</label>
                                <div class="col-lg-12   no-pad">
                                    <div class="col-lg-6 no-pad">
                                        <select name="cc_expire_date_month" id="cc_expire_date_month" class="form-control" title="Expire Month" >
                                            <option value="01">January</option>
                                            <option value="02">February</option>
                                            <option value="03">March</option>
                                            <option value="04">April</option>
                                            <option value="05">May</option>
                                            <option value="06">June</option>
                                            <option value="07">July</option>
                                            <option value="08">August</option>
                                            <option value="09">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>                                    
                                    </div> 
                                    <div class="col-lg-6 no-padding">
                                        <select name="cc_expire_date_year" id="cc_expire_date_year"  class="form-control" title="Expire Year">
                                            <option value="2016">2016</option>
                                            <option value="2017">2017</option>
                                            <option value="2018">2018</option>
                                            <option value="2019">2019</option>
                                            <option value="2020">2020</option>
                                            <option value="2021">2021</option>
                                            <option value="2022">2022</option>
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                        </select>                                     
                                    </div>
                                </div>



                            </div>                                            
                    </div>    
                    <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">

                        <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item right-pad  hide_area" style="display:none">
                            <label>Card Issue Number</label> 
                            <input id="cc_issue" name="cc_issue" title="Issue Number"  class="form-control" type="text" >
                        </div>

                        <div class="form-group col-lg-6 col-sm-6 col-xs-12 no-pad item left-pad  hide_area" style="display:none">
                            <label>Card Valid From Date</label> 
                            <div class="col-lg-12   no-pad">
                                <div class="col-lg-6 no-pad">
                                    <select name="cc_start_date_month" id="cc_start_date_month"  class="form-control" title="Start Month" >
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 no-padding">
                                    <select name="cc_start_date_year" id="cc_start_date_year"  class="form-control" title="Start Year" >
                                        <option value="2016">2016</option>
                                        <option value="2017">2017</option>
                                        <option value="2018">2018</option>
                                        <option value="2019">2019</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                    </select>                                    
                                </div>
                            </div>    


                        </div>                        
                    </div>    
                    <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">
                        <div class="col-lg-12 col-sm-12 col-xs-12 text-right">
                            <button  title="Update"  type="submit" onclick="return do_payment();" class="btn btn-red" role="button" id="pay-button">Pay With Card</button>
                            <input type="hidden" name="form_submit" value="save">
                            <input type="hidden" name="encoded-casefile-hp-id" id="encoded-casefile-hp-id" value="<?php echo $data['encoded-casefile-hp-id'] ?>">

                        </div>
                    </div>     
                </div>
            <?php endif; ?>                     
        </div>
    </form>
    
    
    
</div>        
    </div>
</main>

<script>
    var SITE_URL = "<?php echo $data['site_url'] ?>";
    var loadingGifPath = "<?php echo asset('images/loading.gif'); ?>";
</script>
<script src="<?php echo asset('js/customer/payment.js'); ?>"></script>
@stop