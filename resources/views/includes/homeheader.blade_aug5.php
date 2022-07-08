<?php
$customerId =isset($_SESSION['customer_id'])?$_SESSION['customer_id']:'';
$hpId =isset($_SESSION['hp_id'])?$_SESSION['hp_id']:'';
$counselorId =isset($_SESSION['counselor_id'])?$_SESSION['counselor_id']:'';
if($customerId == ''&& $hpId == ''&& $counselorId == ''){
    $userLogined= false;
}else{
    $userLogined= true;
}
?>

<header class="header2 navbar-fixed-top header-bgnone">
    <div class="container t1">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="social col-lg-4 pull-right text-right">
<!--                    <span class="login"><a href="customer/login">Login</a></span>-->
                    <a href="#"><img src="<?php echo asset('images/facebook-icon.png'); ?>" alt="Facebook"></a>
                    <a href="#"><img src="<?php echo asset('images/tweet.png'); ?>" alt="Twitter"></a>
                    <a href="#"><img src="<?php echo asset('images/gplus-icon.png'); ?>" alt="gplus"></a>
                </div>
             <a class="navbar-brand hidden-xs" href="<?php echo asset(''); ?>"><img src="<?php echo asset('images/logo.png'); ?>" class="img-responsive"></a>
            <a class="navbar-brand hidden-sm hidden-md hidden-lg" href="<?php echo asset(''); ?>"><img src="<?php echo asset('images/logo-xs.png'); ?>" class="img-responsive"></a>
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
     <?php
     $primaryMenus = DB::table('contents')->where('contents_position','=',1)->where('contents_status','=',1)->orderBy('display_order')->get();
     ?>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                
                <ul class="nav navbar-nav navbar-right topnav"> 
                    
                    <?php if(!$userLogined): ?>
                        <li><a href="#" data-toggle="modal" data-target="#login_selection_popup">Login</a></li>
                    <?php endif ;?>
                        
                    <?php foreach ($primaryMenus as $primaryMenu){ ?>
                     <?php $contentLink = asset("home/contents/$primaryMenu->contents_key"); ?>
                         <li><a href="<?php echo $contentLink;?>"><?php echo $primaryMenu->contents_title ?></a></li>
                    <?php } ?>
                         
                    <li><a href="<?php echo asset('home/basic'); ?>">Start New Case File</a></li>
                    
                    <?php if(!$userLogined): ?>
                        <li><a href="#" data-toggle="modal" data-target="#registration_selection_popup" >Register</a></li> 
                    <?php endif ;?>
                        
                      <!-- Start:My Dash board Link -->  
                     <?php if($customerId != '' ){ ?>
                        <li><a href="<?php echo asset('customer/dashboard'); ?>"  >Dashboard</a></li> 
                     <?php } else if ($hpId != '') { ?>
                        <li><a href="<?php echo asset('healthcare_professional/dashboard'); ?>"  >Dashboard</a></li> 
                     <?php } else if ($counselorId != '') { ?>  
                        <li><a href="<?php echo asset('counselor/dashboard'); ?>"  >Dashboard</a></li>
                     <?php } ?>   
                        
                      <!-- End:My Dash board Link -->   
                      
                    <li><a href="https://www.youtube.com/watch?v=bYKOjrcSaZ8&feature=youtu.be" target="_blank">Free Demo</a></li>
                    <?php if($userLogined): ?>
                        <li><a href="<?php echo asset('home/logout'); ?>">Logout</a></li>
                    <?php endif ; ?>        
                  
                </ul>
            </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    </div>
</header>