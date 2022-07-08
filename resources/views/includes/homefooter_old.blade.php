<footer class="site-footer container-fluid">        
        <div class="inner-body-footer row">

    	   <div class="copyright text-center">&copy; 2016 DoctorBuddy. All Rights Reserved.</div>
        
            <?php $footerMenus = DB::table('contents')->where('contents_position','=',3)->where('contents_status','=',1)->orderBy('display_order')->get();?>
            <ul class="nav-menu clearfix">
                <?php foreach ($footerMenus as $footerMenu) { ?>
                    <?php $contentLink = asset("home/contents/$footerMenu->contents_id"); ?>
                    <li><a href="<?php echo $contentLink;?>"><?php echo $footerMenu->contents_title ?></a></li>
                <?php } ;?>
            </ul>

        </div>
</footer>
