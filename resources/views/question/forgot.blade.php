@extends('layouts.homelayout')
@section('content')
<!-- top tiles -->
<div class="row tile_count">
    
</div>
<!-- /top tiles -->

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="homelog_graph">
            <div class="row x_title">
                <div class="col-md-6 newxpanel">
                    <div class="animated flipInY col-sm-4 col-xs-4 tile_stats_count">
        <div class=""><div class="count"></div></div>
    </div>
                    <div class="x_panel">
                        
                        <div class="x_content bs-example-popovers">


<form action="javascript:finish();"  id="loginform" method="POST">
    <h1>Forgot Password</h1>
    <div class="frm-lgroup col-md-12 col-sm-12 col-xs-1"><div class="alertlchk" id="em" >This email not exist in our records.</div>
        <?php if($dataoutput['msg'] != ''){?><div class="alertsucc" id="nm" ><?php echo $dataoutput['msg'];?></div>
        <?php } ?>
    </div>
<div class="frm-lgroup">
    <div class="col-md-6 col-sm-6 col-xs-12">
             <label class="control-label " for="first-name">Email</label></div>
             <div class="item col-md-6 col-sm-6 col-xs-12">
                 <input id="user_email_id" name="user_email_id" value="" title="Email" required="required" class="form-control col-md-7 col-xs-12" type="email">
             </div></div>
             
    <div class="frm-lgroup">
        <label class="control-label col-md-6 col-sm-6 col-xs-12"></label>
          <div class="col-md-6 col-sm-6 col-xs-12">
              <button type="submit" href="finish"  title="Submit"  class="btn btn-primary" role="button">Submit</button>
<!--                    <button class="btn btn-primary submit" type="submit" name="log" id="log">Log in</button>-->
          </div>
<!--                    <a class="reset_pass" href="#">Lost your password?</a>-->
                </div>
    <div class="frm-lgroup">
             <label class="control-label col-md-6 col-sm-6 col-xs-12" for="first-name"></label>
             <div class="item col-md-6 col-sm-6 col-xs-12">
                 <a href="<?php echo asset('index.php/home/login'); ?>">Login</a>
             </div></div>
    </form>
    
                        </div>
                        
                        
<!--                                        <div class="ln_solid"></div>-->
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>    
<script type="text/javascript">
function finish()
{    
    if (!validator.checkAll($('form'))) {   
        return false;
    }else{        
        var user = $('#user_email_id').val();             
        $.ajax({
           type: "GET",
           url: "<?php echo asset('index.php/home/userexist'); ?>",
           data: {user: user},
           success: function(data) {  
               if(data ==0){
                   $('#em').show();
                   $('#nm').hide();  
                   return false;        
                }else{
                    $('#em').hide();
                    var action = "<?php echo asset('/home/forgotpassword'); ?>";
                    $("#loginform").attr("action", action);
                    $("#loginform").submit(); 
                }
            }
        });  
     
    }
}

</script>
@stop