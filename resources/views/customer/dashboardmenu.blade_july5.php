<?php
$currentActionName='';
$currentActionArr = explode('@',Request::route()->getActionName());
$currentActionName = $currentActionArr[1];

$myFilesClass = '';
$myAccountClass='';
$changePasswordClass='';
if(in_array($currentActionName,array('anyDashboard','anyReports','anySymptom','anyUploadfiles','anyAssignedproviders','anyConversations','anyPayment')))
{
    $myFilesClass= 'active';    
}else if(in_array($currentActionName,array('anyEditprofile')))
{
    $myAccountClass= 'active';    
}else if(in_array($currentActionName,array('anyChangepassword')))
{
    $changePasswordClass= 'active';    
}

?>

<nav class="cd-side-nav col-lg-2 col-sm-2 col-xs-12">
<ul>
    <li class="overview">
        <a href="javascript:void(0);"> Welcome back <?php  if(isset($data['customer_name']) ){ echo $data['customer_name']; } else { echo "Guest"; } ?>!</a>
    </li>
    <li class="overview <?php echo $myFilesClass ?>">
        <a href="<?php echo asset('customer/dashboard')?>">My Files</a>
    </li>
    <li class="notifications">
        <a href="<?php echo asset('home/basic')?>"> Start new file</a>
    </li>
    <li class="comments <?php echo $myAccountClass ?>">
        <a href="<?php echo asset('customer/editprofile')?>">My Account</a>
    </li>
 
    <li class="comments <?php echo $changePasswordClass ?>">
        <a href="<?php echo asset('customer/changepassword')?>">Change Password</a>
    </li>   
</ul>
</nav>

<link href="<?php echo asset('css/dashboard-leftmenu.css'); ?>" rel="stylesheet" type="text/css">
<script src="<?php echo asset('js/jquery.menu-aim.js'); ?>"></script>
<script src="<?php echo asset('js/main.js'); ?>"></script>
