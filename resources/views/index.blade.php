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
            <div class="container">
                <div class="row text-center">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content">
                                <div>
                                    <img src="https://garlicoin.io/static/logo.040b5384.png" width="100">
                                    <h1>Welcome to {{ config("app.name", "Garliyard") }}</h1>
                                    <p>
                                        Garliyard is an open source wallet system for
                                        <a href="https://garlicoin.io">Garlicoin</a> created in <a href="https://laravel.com">Laravel</a>
                                        with a few spreads of butter.
                                    </p>
                                    <hr>
                                    <div class="alert alert-warning">
                                        Garliyard is entirely experimental, and bugs may exist in production.
                                        <br>
                                        Please use this wallet at your own risk.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row text-center">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content">
                                <div class="col-md-3">
                                    <div class="row">
                                        <h1>{{ number_format(\App\User::getCount()) }}</h1>
                                    </div>
                                    <div class="row">
                                        Users
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <h1>{{ number_format( \App\Address::getCount())  }}</h1>
                                    </div>
                                    <div class="row">
                                        Addresses
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <h1>{{ number_format(\App\Transaction::getCount()) }}</h1>
                                    </div>
                                    <div class="row">
                                        Transactions
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <h1>{{ number_format(\App\Transaction::getTransfered(), 2) }}</h1>
                                    </div>
                                    <div class="row">
                                        Total GRLC Transfered
                                    </div>
                                </div>
                                <br><br><br><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="footer">
            <div class="pull-right">
                <a href="https://github.com/garliyard/garliyard">View source code on GitHub</a>
            </div>
            <div>
                <strong>Garliyard is a open source project by </strong> <a href="https://elyc.in/">Ely Haughie</a>
            </div>
        </div>

    </div>
</div>

<!-- Mainly scripts -->
<script src="/js/app.js"></script>
</body>

</html>
