<!-- top navigation 
<div class="nav_menu">
    <nav class="" role="navigation">
        <ul class="nav navbar-nav navbar-right">
            <li class="">
                <a href="counsellor/login">Counsellor Login</a>                
            </li>
        </ul>
    </nav>
</div>
 /top navigation -->
<?php
$name = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
$filename = strtolower(basename($name, ".php"));
?>
 <header id="masthead" class="site-header">

        <!-- Logo & Menu -->
        <div class="header">
            <div class="container-fluid">
                <div class="row">
                    <div class="container-fluid">
                        <div class="site-logo animated flipInY"><a href="<?php echo asset('index.php/home'); ?>"><img src="../images/logo.png"/></a></div>

                        <nav id="primary-navigation" role="navigation">
                            <ul class="primary-nav hidden-xs">
                                <li><a href="#" class="active">Home</a></li>                              
                                <li id="test" class="drop-down"><a href="#">News</a>
                                    <ul class="sub-menu">
                                        <li><a href="#">Social</a></li>
                                        <li><a href="#">National</a></li>
                                        <li><a href="#">Regional</a></li>
                                        <li><a href="#">International</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">Contact</a></li>
                                <li class="drop-down"><a href="#">About us</a>
                                    <ul class="sub-menu">
                                        <li><a href="#">Services</a></li>
                                        <li><a href="#">Who are we</a></li>
                                        <li><a href="#">Our spaces</a></li>
                                        <li><a href="#">Careers</a></li>
                                    </ul>
                              </li>
                              <?php if($filename =='register' || $filename =='home' || $filename =='login' || $filename =='logout' || $filename =='dashboard' || $filename == 'forgotpassword'){?>
                                
                                    <?php if(Session::get('customer_id')==''){?> 
                                  <li>  <a href="/customer/login" class="">login</a></li>
                                  <?php }else{ ?>
                                   <li class="drop-down">  <a href="/customer/dashboard" class="">Dashboard</a>
                                     <ul class="sub-menu">
                                         <li><a href="/customer/logout">logout</a></li>
                                       
                                     </ul>
                                   </li>
                                     <?php } ?>
                                
                                <?php } ?>
</ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Logo & Menu -->
 </header>