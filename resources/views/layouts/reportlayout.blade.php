<html>
    <head>       
        @include('includes.homehead_old')
    </head>    
    <body class="nav-md">
        <div class="container-fluid body page">
            <div class="main_container row"> 
                <!-- Header -->
                @include('includes.homeheader_old')
                <!--/ Header -->
                
                <!-- Page Content -->
                <div class="container-fluid page-content" role="main">
                    <div class="row questionnaire" >
                       
                        
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="col-xs-12 col-sm-12 col-md-12">@yield('content')</div>
                        </div>
                         
                         
                    </div>
                </div>
                <!--/ Page Content -->
                
                <!-- Footer -->
                 @include('includes.homefooter_old')
                <!--/ Footer -->
            </div>
        </div>       
    
<!-- JS Placed at the end of the document for faster page loading -->

<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
Tawk_API.visitor = {
	name  : "<?php echo Session::get('customer_nickname');?>",
};
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/56c6ad5106613232645cb53e/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->   
</body>
</html>
