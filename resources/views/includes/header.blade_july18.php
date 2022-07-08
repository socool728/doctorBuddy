<header class="header3">
<div class="container">
    <nav class="navbar navbar-default">
    <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="social col-lg-4 pull-right text-right">
        <a href="javascript:void(0);"><img src="<?php echo asset('images/facebook-icon.png'); ?>" alt="Facebook"></a>
        <a href="javascript:void(0);"><img src="<?php echo asset('images/tweet.png'); ?>" alt="Twitter"></a>
        <a href="javascript:void(0);"><img src="<?php echo asset('images/gplus-icon.png'); ?>" alt="gplus"></a>
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
        
         <?php if(Session::get('customer_id') == '' && Session::get('hp_id') == ''&& Session::get('counselor_id') == ''): ?>
            <li><a href="#" data-toggle="modal" data-target="#login_selection_popup">Login</a></li>
        <?php endif ;?>
                        
                        
        <?php foreach ($primaryMenus as $primaryMenu){ ?>
            <?php $contentLink = asset("home/contents/$primaryMenu->contents_key"); ?>
            <li><a href="<?php echo $contentLink;?>"><?php echo $primaryMenu->contents_title ?></a></li>
        <?php } ?>

        <li><a href="<?php echo asset('home/basic'); ?>">Start New Case File</a></li>
        
        <?php if(Session::get('customer_id') == '' && Session::get('hp_id') == ''&& Session::get('counselor_id') == ''): ?>
            <li><a href="#" data-toggle="modal" data-target="#registration_selection_popup" >Register</a></li> 
        <?php endif ;?> 
            
        <!-- Start:My Dash board Link -->  
       <?php if(Session::get('customer_id') != '' ){ ?>
          <li><a href="<?php echo asset('customer/dashboard'); ?>"  >Dashboard</a></li> 
       <?php } else if (Session::get('hp_id') != '') { ?>
          <li><a href="<?php echo asset('healthcare_professional/dashboard'); ?>"  >Dashboard</a></li> 
       <?php } else if (Session::get('counselor_id') != '') { ?>  
          <li><a href="<?php echo asset('counselor/dashboard'); ?>"  >Dashboard</a></li>
       <?php } ?>   

        <!-- End:My Dash board Link -->   
        
        <?php if(Session::get('customer_id') != '' || Session::get('hp_id') != ''|| Session::get('counselor_id') != ''): ?>
            <li><a href="<?php echo asset('home/logout'); ?>">Logout</a></li>
        <?php endif ; ?>        

    </ul>
    </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
    </nav>
</div>
</header>