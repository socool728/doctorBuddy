<html>
    <head>
        @include('includes.adminhead')
    </head>    
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <?php if(Request::is('admin/login')){ ?>
                <?php } else { ?>
                    @include('includes.adminside')
                <?php } ?>    
                <div class="top_nav">
                    @include('includes.adminheader')
                </div> 
                
                <!-- page content -->
                <?php if(Request::is('admin/login')) { ?> <div class='login_col' role='main'> @yield('content') </div>
                <?php } else { ?> <div class='right_col' role='main'> @yield('content') </div>
                <?php } ?>
                
                @include('includes.adminfooter')
            </div>
        </div>
        
        <div id="custom_notifications" class="custom-notifications dsp_none">
            <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
            </ul>
            <div class="clearfix"></div>
            <div id="notif-group" class="tabbed_notifications"></div>
        </div>
        
        <script src="<?php echo asset('js/bootstrap.min.js'); ?>"></script>
        
        <!-- Datatables -->
        <script src=<?php echo asset("js/datatables/js/jquery.dataTables.js"); ?>></script>
        <script src=<?php echo asset("js/datatables/tools/js/dataTables.tableTools.js"); ?>></script>
        <script>
            var asInitVals = new Array();
            $(document).ready(function () {
                var oTable = $('#example').dataTable({
                    "oLanguage": {
                        "sSearch": "Search all columns:"
                    },
                    "aoColumnDefs": [
                        {
                            'bSortable': false,
                            'aTargets': [0]
                        } //disables sorting for column one
                    ],
                    "iDisplayLength": 12,
                    "sPaginationType": "full_numbers",
                    "dom": 'T<"clear">lfrtip',
                });
                $('.DTTT_container').html('');
                $("tfoot input").keyup(function () {
                    /* Filter on the column based on the index of this element's parent <th> */
                    oTable.fnFilter(this.value, $("tfoot th").index($(this).parent()));
                });
                $("tfoot input").each(function (i) {
                    asInitVals[i] = this.value;
                });
                $("tfoot input").focus(function () {
                    if (this.className == "search_init") {
                        this.className = "";
                        this.value = "";
                    }
                });
                $("tfoot input").blur(function (i) {
                    if (this.value == "") {
                        this.className = "search_init";
                        this.value = asInitVals[$("tfoot input").index(this)];
                    }
                });
            });
        </script>

    </body>

</html>