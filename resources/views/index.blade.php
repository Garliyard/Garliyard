<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Garliyard - An alternative wallet system for Garlicoin">
    <meta name="author" content="Elycin#4913">

    <title>{{ config("app.name", "Garliyard") }}</title>

    <link href="/css/app.css" rel="stylesheet">

</head>

<body class="top-navigation">
<div id="wrapper">
    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom white-bg">d
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
                                    <div class="alert alert-success">
                                        Garliyard is now running stable in production without issues.
                                        <br><br>
                                        Under the circumstance that issues occur, please contact <b>Elycin#4913</b>
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
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="row">
                                            <h1>{{ number_format(\App\User::getCount()) }}</h1>
                                        </div>
                                        <div class="row">
                                            Users
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            <h1>{{ number_format( \App\Address::getCount())  }}</h1>
                                        </div>
                                        <div class="row">
                                            Addresses
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            <h1>{{ number_format(\App\Transaction::getCount()) }}</h1>
                                        </div>
                                        <div class="row">
                                            Transactions
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-3 col-md-offset-3">
                                        <div class="row">
                                            <h1>{{ number_format(\App\Transaction::getTransfered(), 8) }}</h1>
                                        </div>
                                        <div class="row">
                                            Total GRLC Transfered
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row">
                                            <h1>{{ number_format(\App\Http\Controllers\Controller::getServerBalanceGetter(), 8) }}</h1>
                                        </div>
                                        <div class="row">
                                            Current GRLC Holdings
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <small>
                                    <p>The values above are cached and updated once every ten minutes.</p>
                                </small>
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
