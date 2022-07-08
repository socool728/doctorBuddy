@extends('layouts.adminlayout')
@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Report</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Customer Answers <small></small></h2>
                    <div class="clearfix"> </div>
                </div>
                <div class="x_content">
<?php // 
//echo '<>pre>';
//print_r($data);
//echo $data['username']."KK";
//foreach($data as $val){ 
?>
       
                                        <div class="reportdv">
                                            <label class="control-rpt col-md-12 col-sm-3 col-xs-12" for="first-name">Customer Email :<?php echo $data['customer_email_id'];?>
                                            </label>
                                            </div>
                      <div class="reportdv"></div>
          
                                          <?php 
                                          $file_name ='';
                     if(count($data['detail'])>0){
                              
                          foreach($data['detail'] as $id){
                                                if(count($data[$id])>0){
                                                if(isset($data[$id]['detailinfo'])){  
                      ?>
                                  <div class="ln_solid"></div> 
                      <div class="reportdv">
                                            <label class="control-rpt col-md-12 col-sm-3 col-xs-12" for="last-name">FIle No :<?php echo $data[$id]['customer_fileno'];?>
                                            </label>
                                            
                                        </div>
                                  <div class="reportdv">
                                      <label class="control-rpt col-md-12 col-sm-3 col-xs-12" for="last-name">Customer Answers: 
                                          <a href="<?php echo asset('./admin/report/'.$data[$id]['detail_id']);?>" ><button type="button" class="btn btn-primary">View</button></a>
                                            </label>
                                            
                                  </div>
                      <div class="reportdv">
                                            <label class="control-rpt col-md-12 col-sm-3 col-xs-12" for="first-name">PDF Report :
                       <?php 
//                                            $customer_id = $data['customer_id'];
//                                            if($customer_id>0){
//                                            $report = DB::table('customer_report')->where('customer_id', '=', $customer_id)->orderBy('customer_report_id', 'DESC')->first();
//                                            if(count($report)>0){
//                                            $file_name = $report->filepath;
                                            $file_name = $data[$id]['customer_fileno'].'.pdf';
                                        ?>
                                        <a href="<?php echo asset('../pdfreports/'.$file_name);?>" target="_blank"><button type="button" class="btn btn-primary">PDF</button></a>
                                         </label>
                                            </div>
                                  
                                        <div class="reportdv">
                                            <label class="control-rpt col-md-12 col-sm-3 col-xs-12" for="last-name">Nick Name : <?php echo $data[$id]['customer_nickname'];?>
                                            </label>                                            
                                        </div>
                                  <?php if($data[$id]['customer_for_whom'] !=''){ ?>
                          <div class="reportdv">
                                            <label class="control-rpt col-md-3 col-sm-3 col-xs-12" for="last-name">For :<?php echo $data[$id]['customer_for_whom'];?>
                                            </label>
                                            
                                        </div>
                      <?php } if($data[$id]['customer_sex'] !=''){ ?>
                                        <div class="reportdv">
                                            <label class="control-rpt col-md-3 col-sm-3 col-xs-12" for="last-name">Sex : <?php echo $data[$id]['customer_sex'];?>
                                            </label>                                            
                                        </div>
                                    <?php } if($data[$id]['customer_age'] !=''){ ?>
                        <div class="reportdv">
                                            <label class="control-rpt col-md-3 col-sm-3 col-xs-12" for="last-name">Age : <?php echo $data[$id]['customer_age'];?>
                                            </label>                                            
                                        </div>
                       <?php }?>
                      <?php if($data[$id]['customer_country'] !=''){ ?>
                          <div class="reportdv">
                                            <label class="control-rpt col-md-12 col-sm-3 col-xs-12" for="last-name">Country :<?php echo $data[$id]['customer_country'];?>
                                            </label>
                                            
                                        </div>
                      <?php } if($data[$id]['customer_state'] !=''){ ?>
                                        <div class="reportdv">
                                            <label class="control-rpt col-md-12 col-sm-3 col-xs-12" for="last-name">State : <?php echo $data[$id]['customer_state'];?>
                                            </label>                                            
                                        </div>
                                    <?php } if($data[$id]['customer_city'] !=''){ ?>
                        <div class="reportdv">
                                            <label class="control-rpt col-md-12 col-sm-3 col-xs-12" for="last-name">City/Area : <?php echo $data[$id]['customer_city'];?>
                                            </label>                                            
                                        </div>
                       <?php } if($data[$id]['customer_zip'] !=''){ ?>
                        <div class="reportdv">
                                            <label class="control-rpt col-md-12 col-sm-3 col-xs-12" for="last-name">ZIP/Postal Code : <?php echo $data[$id]['customer_zip'];?>
                                            </label>                                            
                                        </div>
                       <?php } } ?>
                                  <div class="reportdv">
                                            <label class="control-rpt col-md-12 col-sm-3 col-xs-12" for="last-name">Known Disease : <?php echo $data[$id]['known_disease'];?>
                                            </label>                                            
                                        </div>
                        
                                       <?php  }?>
                   
                      <?php                   } }  ?>
                      
 
                                
                 
                </div>
            </div>
        </div>

        <br />
        <br />
        <br />

    </div>
</div>

@stop
