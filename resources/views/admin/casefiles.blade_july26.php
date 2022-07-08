@extends('layouts.adminlayout')
@section('content')

<div class="">

    <div class="clearfix"></div>

    <div class="row">

        
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                
                <div class="x_title">
                    
                    <h3 class="pagehd">Case Files</h3>
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
                                <th>Nick Name</th>
                                <th>Code</th>
                                <th>Assigned Healthcares</th>
                                <th>Created On</th>
                                <th>Option</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                            $i = 0;
                            foreach($caseFileDetails as $caseFileDetail){ 
                                 $hpObjs = DB::table('casefile_to_healthcare')
                                         ->where('customer_detail_id','=',$caseFileDetail->customer_detail_id)
                                         ->get();
                                 $hpArr =array();
                                 foreach ($hpObjs as $hpObj){
                                     $hpArr[] = $hpObj->healthcare_professional_email;
                                 }
                            ?>

                                <tr class="even pointer">
                                    <td class=" ">{{++$i}}</td>
                                    <td class=" ">{{$caseFileDetail->customer_nickname}}</td>
                                    <td class=" ">{{$caseFileDetail->customer_code }}</td>
                                    <td class=" "><?php if(count($hpArr) >0) { echo implode("<br>",$hpArr); } ?></td>
                                    <td class=" "><?php echo date(Config::get('constants.DATE_FORMAT'),strtotime($caseFileDetail->created_at));?></td>
                                    <td class=" ">
                                        <a href="<?php echo $data['site_url'] ?>/admin/viewcasefile/<?php echo $caseFileDetail->customer_detail_id ?>">
                                            <i aria-hidden="true" class="fa fa-file-excel-o fa-4" title="View Case File"></i>
                                        </a>
                                        &nbsp;
                                        <a href="<?php echo $data['site_url'] ?>/admin/assignprovider/<?php echo $caseFileDetail->customer_detail_id?>">
                                            <i class="fa fa-hand-o-up fa-4" aria-hidden="true" title="Assign To Provider"></i>
                                        </a>
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
<script>
 var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>
<script src="<?php echo asset('js/admin/list_hp.js'); ?>"></script>
@stop

