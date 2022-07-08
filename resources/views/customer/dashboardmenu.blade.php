<?php
$currentActionName='';
$currentActionArr = explode('@',Request::route()->getActionName());
$currentActionName = $currentActionArr[1];

$myFilesClass = '';
$myReviews='';
$myAccountClass='';
$changePasswordClass='';
if(in_array($currentActionName,array('anyDashboard','anyReports','anySymptom','anyUploadfiles','anyAssignedproviders','anyConversations','anyPayment')))
{
    $myFilesClass= 'active';    
}else if(in_array($currentActionName,array('anyReviews')))
{
    $myReviews= 'active';    
}else if(in_array($currentActionName,array('anyEditprofile')))
{
    $myAccountClass= 'active';    
}else if(in_array($currentActionName,array('anyChangepassword')))
{
    $changePasswordClass= 'active';    
}


// Get logined customer
$customerId = $_SESSION['customer_id'];
$loginedCustomer = DB::table('customers')->where('customer_id', '=', $customerId)->first();   

?>
<nav class="cd-side-nav col-lg-2 col-sm-2 col-xs-12">
<ul>
    <li class="overview p5">
    <div class="text-center bg ">
        <img src="<?php echo asset('images/customer.png') ?>">
        <h3>
            <?php  if($loginedCustomer->customer_fname !=''){ echo ucfirst($loginedCustomer->customer_fname)." ".$loginedCustomer->customer_lname ; } else { echo "Guest"; } ?>
        </h3>
         <div class="des">Customer </div>
    </div>                
    </li>
    <li class="overview <?php echo $myFilesClass ?>">
        <a href="<?php echo asset('customer/dashboard')?>">My Case Files</a>
    </li>
    <li class="notifications">
        <a href="<?php echo asset('home/basic')?>"> Start New Case File</a>
    </li>
<?php if($loginedCustomer->customer_fname !='') { ?>
    <li class="comments <?php echo $myReviews ?>">
        <a href="<?php echo asset('customer/reviews')?>">My Reviews</a>
    </li>
<?php } ?>
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
