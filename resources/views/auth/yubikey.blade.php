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
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        TWO FACTOR AUTHENTICATION - YUBIKEY
                                    </div>
                                    <div class="panel-body">
                                        <div class="text-center">
                                            <br>
                                            <span class="fa fa-key fa-4x"></span>
                                            <br>
                                            <h2>
                                                Yubikey Required
                                            </h2>
                                            <h4>Please press the button on your hardware token</h4>

                                        </div>
                                        <hr>
                                        <input class="form-control" type="text" name="yubikey" placeholder="Yubikey OTP Token" autofocus>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="pull-right">
                                            <a class="btn btn-danger" href="/logout">CANCEL</a>
                                            <button class="btn btn-primary" type="submit">LOGIN</button>
                                        </div>
                                        <br><br>
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
