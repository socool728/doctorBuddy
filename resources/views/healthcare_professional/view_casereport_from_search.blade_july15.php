@extends('layouts.healthcarelayout')
@section('content')
<div class="cd-main-header">		
    <a class="cd-nav-trigger" href="#0">
        <span></span>
    </a>		
</div>
<main class="cd-main-content">
    @include('healthcare_professional.dashboardmenu')
    <div class="content-wrapper col-lg-9 col-sm-9 col-xs-12">
      <?php $report = $data['report']; ?>
        @include('customer.common_casefile_view');       
    </div>
</main>

<script>
    var SITE_URL = "<?php echo $data['site_url'] ?>";
</script>
<script src="<?php echo asset('js/healthcare_professional/case_report.js'); ?>"></script>

@stop