<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config("app.name", "Garliyard") }} | Transaction {{ $transaction->transaction_id }}</title>

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
                        <form action="/pay" method="post">
                            {{ csrf_field() }}
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    TRANSACTION SENT
                                </div>
                                <div class="panel-body">
                                    <div class="text-center">
                                        <h1>
                                            <span class="fa fa-check-circle-o fa-3x"></span>
                                            <br><br>
                                            Transaction Successful
                                        </h1>
                                        <h3>{{ number_format($transaction->amount, 8) }} GRLC was successfully sent.</h3>

                                    </div>
                                    <hr>
                                    <div>
                                        <p>
                                            <strong>Transaction ID</strong>:
                                            <br>
                                            {{ $transaction->transaction_id }}
                                        </p>
                                        <p>
                                            <strong>Sending to</strong>:
                                            <br>
                                            {{ $transaction->to_address }}
                                        </p>
                                        <p>
                                            <strong>Amount sent</strong>:
                                            <br>
                                            {{  number_format($transaction->amount, 8) }}
                                        </p>
                                        <p>
                                            <strong>Transaction creation date</strong>:
                                            <br>
                                            {{ \Carbon\Carbon::parse($transaction->created_at)->toDayDateTimeString() }}
                                            <br>
                                            {{ \Carbon\Carbon::parse($transaction->created_at)->diffForHumans() }}
                                        </p>
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
