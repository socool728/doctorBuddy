<html>
    <head>       
        @include('includes.printhead')
    </head>    
    <body class="nav-md">
        <div class="container-fluid body page">
            <div class="main_container row"> 
                <!-- Header -->
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
               
                <!--/ Footer -->
            </div>
        </div>       
    
   
</body>
</html>
