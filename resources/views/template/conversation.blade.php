<!DOCTYPE html>
<html>
    <head>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>DoctorBuddy</title>
    
    <link href="<?php echo asset('css/custom.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo asset('css/custom_extra.css'); ?>" rel="stylesheet" type="text/css" />
    
 
    <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700,300italic,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>

     <!--End:Help Tool tip -->
    </head>
    <body>
        <style>
            .outer {
                border-collapse:separate;
                border:solid #ddd 1px;
                border-radius:10px;
                -moz-border-radius:10px;
                font-size:13px;}
            
            td, tr {border: 0}
            
            .c_h_rows1 {
            background: #ffd69a none repeat scroll 0 0;
            border-radius: 5px;
            font-size: 13px !important;
            padding: 10px;
        }
        .c_h_rows2 {
            background: #d9d9d9 none repeat scroll 0 0;
            border-radius: 5px;
            font-size: 13px !important;
            padding: 10px;
        }
		.c_h_rows1 p, .c_h_rows2 p {
		padding:0!important;
		margin:0!important;
		}
        </style>
<div>
    <table>
    <tr>
        <td><div style="width:100%">
     <img src="<?php echo asset("images/logo-xs.png");?>">                          
	</div></td>
    </tr> 
  
    </table>
 
    <table>
    <tr>
        <td><label>Conversation History of Case File No: <?php echo $report['conversation_file_no'];?></label></td>
    </tr>  
    </table>   
    
    <!-- Start :Basic Info -->
    
        <table class="outer"  cellpadding="5"  width="100%">
            
            <colgroup>
            <col width="20%">
            <col width="20%">
            <col width="10%">
            <col width="20%">
            <col width="20%">
            </colgroup>

            <?php 
            $conversations=$report['conversation'];
            if( count($conversations)>0) : ?>   

            <?php
                $customerDetailObj = DB::table('customer_detail')->where('customer_detail_id','=',$report['customerDetailId'])->first();
                $nickName = $customerDetailObj->customer_nickname; 
                
                $hpObj = DB::table('healthcare_professional')->where('healthcare_professional_id','=',$report['hp_id'])->first();
                $hpNamArr = array();
                if($hpObj->healthcare_professional_first_name)
                    $hpNamArr[] =$hpObj->healthcare_professional_first_name;
                if($hpObj->healthcare_professional_middle_name)
                    $hpNamArr[] =$hpObj->healthcare_professional_middle_name;
                if($hpObj->healthcare_professional_last_name)
                    $hpNamArr[] =$hpObj->healthcare_professional_last_name;                  
                $hpName=implode(' ',$hpNamArr);
            
                if($report['flag']=='hp')
                {
                    $hp_label='You';
                    $customer_label=$nickName;
                }
                else if($report['flag']=='customer')
                {
                    $hp_label=$hpName;
                    $customer_label='You';
                }
                else
                {
                    $hp_label=$hpName;
                    $customer_label=$nickName;
                }
            ?>
            
            
            <?php foreach ($conversations as $conversation):  ?>
            <tr>
                <?php if($conversation->healthcare_comment): ?>
                <?php if($report['flag']=='hp') { ?>
                <td colspan="3" >
                    <table class="outer c_h_rows1"  width="100%" >
                        <tr>
                            <td colspan="2"><p><b><?php echo $hp_label;?></b></p></td>
                        </tr>
                        <tr>
                            <td width="75%"><?php echo  $conversation->healthcare_comment ?></td>
                            <td width="25%"><?php echo date(Config::get('constants.DATE_TIME_FORMAT'),  strtotime($conversation->date)); ?></td>
                        </tr>
                    </table>                        
                </td>
                <td colspan="2"></td>
                 <?php } else { ?>
                <td colspan="2"></td>
                <td colspan="3">
                    <table class="outer c_h_rows2"  width="100%">
                        <tr>
                            <td colspan="2"><p><b><?php echo $hp_label;?></b></p></td>
                        </tr>
                        <tr>
                            <td width="75%"><?php echo  $conversation->healthcare_comment ?></td>
                            <td width="25%"><?php echo date(Config::get('constants.DATE_TIME_FORMAT'),  strtotime($conversation->date)); ?></td>
                        </tr>
                    </table>                        
                </td>
                <?php } ?>
                <?php else: ?>
                <?php if($report['flag']=='hp') { ?>
                <td colspan="2"></td>
                <td colspan="3">
                    <table class="outer c_h_rows2" width="100%">
                        <tr>
                            <td colspan="2"><p style="color:#00243F"><b><?php echo $customer_label;?></b></p></td>
                        </tr>
                        <tr>
                            <td width="70%"><?php echo  $conversation->customer_comment ?></td>
                            <td width="30%"><?php echo date(Config::get('constants.DATE_TIME_FORMAT'),  strtotime($conversation->date)); ?></td>
                        </tr>
                    </table>
                </td>
                <?php } else {?>
                
                <td colspan="3">
                    <table class="outer c_h_rows1" width="100%">
                        <tr>
                            <td colspan="2"><p style="color:#00243F"><b><?php echo $customer_label;?></b></p></td>
                        </tr>
                        <tr>
                            <td width="70%"><?php echo  $conversation->customer_comment ?></td>
                            <td width="30%"><?php echo date(Config::get('constants.DATE_TIME_FORMAT'),  strtotime($conversation->date)); ?></td>
                        </tr>
                    </table>
                </td>
                <td colspan="2"></td>
                <?php } ?>
                <?php endif;?>
            </tr>
            <?php endforeach ;?>
            <?php else: ?>
            <p>No history</p>
            <?php endif ;?>
        </table>
</div>

    </body>
    </html>
