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
                @include("layouts.messages.wide_error")
                <div class="row">
                    <div class="col-md-3">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                BALANCE
                            </div>
                            <div class="panel-body">
                                <h1><span id="balance">{{ number_format($balance, 8) }}</span> GRLC</h1>
                                <p>
                                    YOUR GARLIC IS WORTH $<span id="balance-exchanged">{{ number_format($exchanged_usd, 2) }}</span> USD
                                </p>
                            </div>
                            <div class="panel-footer">
                                <a href="/pay" class="btn btn-warning">SEND GRLC</a>
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
                                </h1>
                                <hr>
                                <small>
                                    {{ ($address->label) ? strtoupper($address->getLabel()) : "CLICK THE BUTTON TO THE RIGHT TO SET A LABEL FOR THIS ADDRESS" }}
                                    &nbsp; <a href="/edit-label/{{ $address->address }}"><span class="fa fa-pencil" title="Edit Address Label"></span></a>
                                </small>
                                </h1>
                            </div>
                            <div class="panel-footer">
                                <div class="col-md-6">
                                    <div class="row">
                                        <small>
                                            {{ strtoupper("This address was created " . \Carbon\Carbon::parse($address->created_at)->diffForHumans()) }}
                                            <br>
                                            <a href="/new-address">CREATE NEW ADDRESS</a> | <a href="/addresses">VIEW ALL ADDRESSES</a>
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="pull-right">
                                            <a href="#" style="color: #000;" data-toggle="modal" data-target="#qr-code">
                                                <span class="fa fa-qrcode fa-3x"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <br><br>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                GARLIYARD IS SHUTTING DOWN
                            </div>
                            <div class="panel-body">
                                I'm sorry to do this, but the system has become unstable and isn't scaling well.
                                <br><br>
                                Your balances are still here even if you are unable to access garliyard,
                                the system is seriously struggling to keep up and is facing the same fate as breadbox.
                                <br><br>
                                Please withdraw your balances and migrate over to another wallet system such as
                                <a href="https://xske.github.io/garlium/">Garlium</a> or <a href="https://garlicwallet.com">GarlicWallet</a>.
                                <br><br>
                                For any inquiries, please contact <code>Elycin#4913</code> on Discord.
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9">
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

<!-- Mainly scripts -->
<script src="/js/app.js"></script>
<script>
    var balanceInterval = setInterval(function () {
        $.getJSON("/dashboard-api/balance", function (data) {
            $("#balance").html(data["value"].toString());
            $("#balance-exchanged").html(data["exchanged"].toString());
        })
    }, 30 * 1000);
</script>
</body>
</html>
