<html>
    <head>
        @include('includes.homehead')
    </head>    
    <body class="nav-md">
        <div class="container body">
            <div class="main_container"> 
                <div class="top_nav">
                    @include('includes.homeheader')
                </div> 
                
                <!-- page content -->
                <div class="right_front" role="main">
                    @yield('content')   
                </div>
                
                @include('includes.homefooter')
            </div>
        </div>
        
        <div id="custom_notifications" class="custom-notifications dsp_none">
            <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
            </ul>
            <div class="clearfix"></div>
            <div id="notif-group" class="tabbed_notifications"></div>
        </div>
        
    <script src="<?php echo asset('js/bootstrap.min.js'); ?>"></script>
    
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var $_Tawk_API={},$_Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/5592913a4900cd9812265943/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
    
</body>
</html>