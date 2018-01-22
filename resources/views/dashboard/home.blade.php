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
                                <h1>{{ number_format($balance, 8) }} GRLC</h1>
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
                                    {{ $address->address }}
                                    <span class="pull-right">
                                        <a href="#" style="color: #000;" data-toggle="modal" data-target="#qr-code">
                                            <span class="fa fa-qrcode"></span>
                                        </a>
                                        <a href="#" style="color: #000;" data-toggle="modal" data-target="#html-code">
                                            <span class="fa fa-code"></span>
                                        </a>
                                    </span>
                                </h1>
                                <small>
                                    {{ strtoupper("This address was created " . \Carbon\Carbon::parse($address->created_at)->diffForHumans()) }}
                                    <br>
                                    <a href="/new-address">CREATE NEW ADDRESS</a> | <a href="/addresses">VIEW ALL ADDRESSES</a>
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
                                    @include("layouts.messages.no_transactions")
                                @else
                                    @include("layouts.other.transactions")
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include("layouts.other.qr_code_address_modal")
@include("layouts.other.html_code_address_modal")

<!-- Mainly scripts -->
<script src="/js/app.js"></script>
</body>
</html>
