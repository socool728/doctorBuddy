<!DOCTYPE html>
<html>    
    <head>        
        @include('includes.questionairehead')    
    </head>    
    <body>        
        <div class="wrapper sub">            
            @include('includes.header')                        
            <section>        	
                <div class="container m-t">                    
                    <div class="col-lg-6 col-sm-12  col-xs-12 content-area" id="content-area">                        
                        @yield('content')                    
                    </div>                    
                    @include('includes.right-area')                                         
                    <!--Start:The area where the right overlay of filled answers displays -->                    
                    <div id="right_overlay_wraper">                    
                        <div id="overlay" class="rightoverlaybar animated slideInLeft1 active1"></div>                    
                    </div> 
                    <!--End :The area where the right overlay of filled answers displays -->                                    
                </div>            
            </section>                                   
            @include('includes.footer')         
        </div>         
        @include('includes.login_selection_popup')          
        @include('includes.registration_selection_popup')    
    </body>
</html>

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
        

<!--Start :Hiding of success message with sliding effect-->
<script>
    $(document).ready(function(){
        setInterval('$( ".success-alert" ).slideUp( "slow");', 3000 );          
    })
</script>
<!--End :Hiding of success message with sliding effect-->


<!--Start :Form validator  initializations-->
<script src="<?php echo asset('js/customfooter.js'); ?>"></script>
<!--Start :Form validator  initializations-->


<!--Start :Google Analytics-->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
 
  ga('create', 'UA-76342611-1', 'auto');
  ga('send', 'pageview');
 
</script>
<!--End :Google Analytics-->
