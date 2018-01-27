<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config("app.name", "Garliyard") }} | New TOTP</title>

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
                        <form action="/account/2fa/yubikey/add" method="post">
                            {{ csrf_field() }}
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    GOOGLE AUTHENICATOR SETUP
                                </div>
                                <div class="panel-body">
                                    <div class="text-center">
                                        <br>
                                        <span class="fa fa-lock fa-4x"></span>
                                        <br>
                                        <h2>
                                            Google Authenticator Setup
                                        </h2>
                                        <h4>Please scan the QR Code below</h4>
                                    </div>
                                    <hr>
                                    <div class="text-center">
                                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate($qr_code) !!}
                                        <h3>{{ $secret }}</h3>
                                        <small>(time based)</small>
                                        <br><br>
                                        <p>
                                            Leaving this page will result in the ability to never see this code again.
                                            <br>
                                            Please scan it and make sure that your google authenticator is working.
                                        </p>
                                        <br>
                                        <a class="btn btn-primary" href="/account/2fa">RETURN</a>
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
