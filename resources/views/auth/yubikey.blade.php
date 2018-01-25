<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config("app.name", "Garliyard") }} | Yubikey Required</title>

    <link href="/css/app.css" rel="stylesheet">

</head>

<body class="top-navigation">
<div id="wrapper">
    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom white-bg">

        </div>
        <div class="wrapper wrapper-content">
            <div class="container-fluid">
                @if(session()->has("error"))
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <div class="alert alert-danger">
                                {{ session()->get("error") }}
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <form action="/login/yubikey" method="post">
                            {{ csrf_field() }}
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    TWO FACTOR AUTHENTICATION - YUBIKEY
                                </div>
                                <div class="panel-body">
                                    <div class="text-center">
                                        <h1>
                                            <span class="fa fa-key fa-3x"></span>
                                            <br><br>
                                            Yubikey Required
                                        </h1>
                                        <h3>Please plug in your hardware token and press the button in the field below</h3>

                                    </div>
                                    <hr>
                                    <input type="text" name="yubikey" placeholder="Yubikey OTP Token" autofocus>
                                </div>
                                <div class="panel-footer">
                                    <div class="pull-right">
                                        <a class="btn btn-danger" href="/logout">LOGOUT</a>
                                        <button type="submit" class="btn btn-warning" href="https://explorer.grlc-bakery.fun/tx/{{ $transaction->transaction_id }}">LOGIN</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mainly scripts -->
<script src="/js/app.js"></script>
</body>
</html>
