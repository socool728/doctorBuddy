@extends('layouts.adminlayout')
@section('content')

<div id="wrapper">
    <div id="login" class="animate form">
        <section class="login_content">
            <form action="<?php echo $data['site_url'] ?>/admin/login" id="loginform" method="POST">
                <h1>Login Form</h1>
                <?php if (Session::has('login_msg')){ ?>
                    <div class="alert alert-info" style="text-align:center">{{Session::get('login_msg')}}</div>
                    <?php Session::forget('login_msg'); ?>
                <?php } ?>
                <div>
                    <input type="text" class="form-control" placeholder="Username" required="" name="user_email_id" id="user_email_id" />
                </div>
                <div>
                    <input type="password" class="form-control" placeholder="Password" required="" name="user_password" id="user_password" />
                    <input name="_token" type="hidden" value="{!! csrf_token() !!}" />
                </div>
                <div>
                    <button class="btn btn-default submit" type="submit" name="log" id="log" onclick="$('#loginform').submit()">Log in</button>
                    <input type="hidden" name="submit" value="login">
                </div>
                <div class="clearfix"></div>
                <div class="separator">

                   
                    <div class="clearfix"></div>
                    <br />
                    <div>
                        <h1><i style="font-size: 26px;"></i> DoctorBuddy</h1>

                        <p> Doctorbuddy. Privacy and Terms</p>
                    </div>
                </div>
            </form>
            <!-- form -->
        </section>
        <!-- content -->
    </div>
</div>
@stop
