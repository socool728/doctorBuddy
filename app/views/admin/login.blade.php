@extends('layouts.adminlayout')
@section('content')

<div id="wrapper">
    <div id="login" class="animate form">
        <section class="login_content">
            <form action="login" id="loginform" method="POST">
                <h1>Login Form</h1>
                <div>
                    <input type="text" class="form-control" placeholder="Username" required="" name="user_email_id" id="user_email_id" />
                </div>
                <div>
                    <input type="password" class="form-control" placeholder="Password" required="" name="user_password" id="user_password" />
                </div>
                <div>
                    <button class="btn btn-default submit" type="submit" name="log" id="log">Log in</button>
                    <a class="reset_pass" href="#">Lost your password?</a>
                </div>
                <div class="clearfix"></div>
                <div class="separator">

                    <p class="change_link">New to site?
                        <a href="#" class="to_register"> Create Account </a>
                    </p>
                    <div class="clearfix"></div>
                    <br />
                    <div>
                        <h1><i style="font-size: 26px;"></i> Mindzetters</h1>

                        <p>©2015 All Rights Reserved. Mindzetters. Privacy and Terms</p>
                    </div>
                </div>
            </form>
            <!-- form -->
        </section>
        <!-- content -->
    </div>
</div>

@stop
