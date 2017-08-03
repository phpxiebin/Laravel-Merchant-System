<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="{{ asset('merchant-asset/login/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('merchant-asset/login/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('merchant-asset/login/css/style.css') }}">
    <link href="{{ asset('merchant-asset/inspinia/css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">

</head>
<body class='style-2'>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <!-- Start Sign In Form -->
            <form method="post" action="{{ url('merchant/auth/login') }}" class="fh5co-form animate-box" data-animate-effect="fadeIn">
                {{ csrf_field() }}
                <h2>{{ config('app.name', 'Laravel') }}</h2>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group">
                    <label for="username" class="sr-only">用户名</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="用户名" value="{{ old('username') }}" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="password" class="sr-only">密码</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="密码" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="remember"><input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}> 记住我</label>
                </div>
                <div class="form-group">
                    <button class="ladda-button btn btn-primary" data-style="expand-right" type="submit">登  录</button>
                </div>
            </form>
            <!-- END Sign In Form -->

        </div>
    </div>
    <div class="row" style="padding-top: 60px; clear: both;">
        <div class="col-md-12 text-center">
            <p>
                <strong>Coder by @phpxiebing，您可以在 GitHub 找到 <a target="_blank" href="https://github.com/phpxiebin/Laravel-Merchant-System">本站源码</a> - CopyRight © 2017</strong>
            </p>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="{{ asset('merchant-asset/login/js/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('merchant-asset/login/js/bootstrap.min.js') }}"></script>
<!-- Placeholder -->
<script src="{{ asset('merchant-asset/login/js/jquery.placeholder.min.js') }}"></script>
<!-- Waypoints -->
<script src="{{ asset('merchant-asset/login/js/jquery.waypoints.min.js') }}"></script>
<!-- Main JS -->
<script src="{{ asset('merchant-asset/login/js/main.js') }}"></script>
<!-- Ladda -->
<script src="{{ asset('merchant-asset/inspinia/js/plugins/ladda/spin.min.js') }}"></script>
<script src="{{ asset('merchant-asset/inspinia/js/plugins/ladda/ladda.min.js') }}"></script>
<script src="{{ asset('merchant-asset/inspinia/js/plugins/ladda/ladda.jquery.min.js') }}"></script>

<script>
    $(document).ready(function () {
        // Bind normal buttons
        $('.ladda-button').ladda('bind', {timeout: 2000});
    });
</script>

</body>
</html>

