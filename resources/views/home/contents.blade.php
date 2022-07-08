@extends('layouts.questionairelayout')
@section('content')

<h3><?php echo $contentObj->contents_title ?></h3>
<div class="col-lg-12 col-sm-12 col-sx-12 no-pad">
    <?php echo $contentObj->contents_description ?>               
</div>

@stop
