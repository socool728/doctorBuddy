<div class="col-md-3 left_col">
    <div class="left_col scroll-view">

        <div class="navbar nav_title" style="border: 0;">
            <a href="" class="site_title"><i class="fa fa-paw"></i> <span>DoctorBuddy</span></a>
        </div>
        <div class="clearfix"></div>

        <!-- menu prile quick info -->
        <div class="profile">
            <div class="profile_pic">
                <img src="<?php echo asset('images/img.jpg'); ?>" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>Admin</h2>
            </div>
        </div>
        <!-- /menu prile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    
                    
                     <li><a href="<?php echo url('admin/questions'); ?>"><i class="fa fa-edit"></i> Questions </a></li>
                     <li><a href="<?php echo url('admin/questiongroup'); ?>"><i class="fa fa-edit"></i> Question Group </a></li>
                     <li><a href="<?php echo url('admin/contents'); ?>"><i class="fa fa-edit"></i> Content </a></li>
                     <li><a href="<?php echo url('admin/testimonial'); ?>"><i class="fa fa-edit"></i> Testimonials </a></li>
                     <?php if(Session::get('admin_id')=='1'){ ?>          
                     <li><a href="<?php echo url('admin/staff'); ?>"><i class="fa fa-edit"></i> Admin Staff </a></li>
                     <?php } ?>
                     <li><a href="<?php echo url('admin/symptom'); ?>"><i class="fa fa-edit"></i> Symptoms </a></li>
                      <li><a href="<?php echo url('admin/securityquestion'); ?>"><i class="fa fa-edit"></i> Security Question </a></li>
                     <li><a href="<?php echo url('admin/customer'); ?>"><i class="fa fa-edit"></i> Customers</a></li>
                     <li><a href="<?php echo url('admin/counselor'); ?>"><i class="fa fa-edit"></i> Counselors </a></li>
                     <li><a href="<?php echo url('admin/healthcareprofessional'); ?>"><i class="fa fa-edit"></i> Providers </a></li>
                     <li><a href="<?php echo url('admin/templates'); ?>"><i class="fa fa-edit"></i> Provider Templates </a></li>
                     <li><a href="<?php echo url('admin/language'); ?>"><i class="fa fa-edit"></i> Languages </a></li>
                     <li><a href="<?php echo url('admin/specilization'); ?>"><i class="fa fa-edit"></i>Specilizations </a></li>
                     <li><a href="<?php echo url('admin/insurance'); ?>"><i class="fa fa-edit"></i>Insurances </a></li>
                     <li><a href="<?php echo url('admin/casefiles'); ?>"><i class="fa fa-edit"></i>Case Files</a></li>
                     <li><a href="<?php echo url('admin/customerpayments'); ?>"><i class="fa fa-edit"></i>Customer Payments </a></li>
                     <li><a href="<?php echo url('admin/logout'); ?>"><i class="fa fa-edit"></i> Logout </a></li>

                </ul>
            </div>
            
        </div>
        <!-- /sidebar menu -->
    </div>
</div>