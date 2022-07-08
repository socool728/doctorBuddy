@extends('layouts.homelayout')
@section('content')
<!-- top tiles -->
<div class="row tile_count">
    
</div>
<!-- /top tiles -->

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="homelog_graph">
            <div class="row">
                <div class="col-md-6 newxpanel">
                    <div class="animated flipInY col-sm-4 col-xs-4 tile_stats_count">
        <div class=""></div>
    </div>
                    <div class="x_panel">
                        
                        <div class="x_content bs-example-popovers">
<!--                            <div class="alert question-box alert-dismissible fade in" role="alert">
                                
                            </div>-->

<form action="javascript:finish();"  id="loginform" method="POST">
    <h1>Login Form</h1>
    <div class="frm-lgroup col-md-12 col-sm-12 col-xs-1"><div class="alertlchk" id="em" >Invalid username or password</div><div class="alertlchk" id="nm" ></div>
        <?php if(Session::get('flash_msg') != ''){?>
        <div class="alertsucc" id="" ><?php echo Session::get('flash_msg');?></div>
        <?php } ?>
    </div>
<div class="frm-lgroup">
             <label class="control-label col-md-6 col-sm-6 col-xs-12" for="first-name">Email</label>
             <div class="item col-md-6 col-sm-6 col-xs-12">
                 <input id="user_email_id" name="user_email_id" value="" title="Email" required="required" class="form-control col-md-7 col-xs-12" type="email">
             </div></div>
             <div class="frm-lgroup">
             <label class="control-label col-md-6 col-sm-6 col-xs-12" for="first-name">Password</label>
             <div class="item col-md-6 col-sm-6 col-xs-12">
                 <input id="user_password" name="user_password" value="" title="Password" required="required" class="form-control col-md-7 col-xs-12" type="password">
             </div></div>
    <div class="frm-lgroup">
        <label class="control-label col-md-6 col-sm-6 col-xs-12"></label>
          <div class="col-md-6 col-sm-6 col-xs-12 text-right">
              <button type="submit" href="finish"  title="Log in"  class="btn btn-primary" role="button">Log in</button>

          </div>
<!--                    <a class="reset_pass" href="#">Lost your password?</a>-->
                </div>
    <div class="frm-lgroup">
             <label class="control-label col-md-6 col-sm-6 col-xs-12" for="first-name"></label>
             <div class="item col-md-6 col-sm-6 col-xs-12 text-right">
                 <a href="<?php echo asset('index.php/home/forgotpassword'); ?>">Forgot Password</a>
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
        var pwd = $('#user_password').val();
         $.ajax({
            type: "GET",
            url: "<?php echo asset('index.php/home/usercheck'); ?>",
            data: {user: user,pwd: pwd},
            success: function(data) { 
                if(data.id>0){
                    if(data.verify==1){
                        $('#em').hide();
                        $('#nm').hide();
                        var action = "/home/login";
                        $("#loginform").attr("action", action);
                        $("#loginform").submit();
//                        window.location.href = '<?php echo asset('index.php/home/finish'); ?>/'+data.id;
                    }else{
                        $('#nm').show();
                        $('#nm').html(data.linkmsg);  
                        $('#em').hide();
                        return false;  
                    }
                }else{
                    $('#nm').hide();
                    $('#em').show();
//                    $('#em').html(data);  
                    return false;                  

                }
            }
        });  
     
    }
}
function resend(id)
{    
    
         $.ajax({
            type: "GET",
            url: "<?php echo asset('index.php/home/verifysend'); ?>/"+id,
            data: {id: id},
            success: function(data) { 
                $('#nm').html(data);
            }
        });  
     
    
}
</script>
@stop