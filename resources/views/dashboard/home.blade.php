<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config("app.name", "Garliyard") }}</title>

    <link href="/css/app.css" rel="stylesheet">

</head>

<body class="top-navigation">
<div id="wrapper">
    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom white-bg">
            @include("layouts.navbar")
        </div>
        <div class="wrapper wrapper-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                BALANCE
                            </div>
                            <div class="panel-body">
                                <h1>{{ number_format($garlicoin->getBalance(), 8) }} GRLC</h1>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                ADDRESS
                            </div>
                            <div class="panel-body">
                                <h1>
                                    {{ $garlicoin->getLastAddress()->address }}
                                    <a href="qr" style="color: #000;"><span class="fa fa-qrcode pull-right"></span></a>
                                </h1>
                                <small>
                                    {{ strtoupper("This address was created " . \Carbon\Carbon::parse($garlicoin->getLastAddress()->created_at)->diffForHumans()) }}
                                    <br>
                                    <a href="/new-address">CREATE NEW ADDRESS</a> | <a href="/new-address">VIEW ALL ADDRESSES</a>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-9 col-md-offset-3">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                TRANSACTIONS
                            </div>
                            <div class="panel-body">
                                @if(count($transactions) == 0)
                                    <div class="text-center">
                                        <h1>You haven't made any transactions yet.</h1>
                                        <p>Things will start to appear here as soon as you send some garlic to someone.</p>
                                    </div>
                                @else

                                @endif
                            </div>
                        </div>
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
