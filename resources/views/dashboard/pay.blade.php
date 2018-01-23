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
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    MAKE PAYMENT
                                </div>
                                <div class="panel-body">
                                    <h1>{{ number_format($balance, 8) }} GRLC</h1>
                                    <p>YOUR BALANCE</p>
                                    <hr>

                                    @if(isset($to_address))
                                        <input class="form-control" type="text" name="to_address" placeholder="Address to send GRLC to" value="{{ $to_address }}">
                                    @else
                                        <input class="form-control" type="text" name="to_address" placeholder="Address to send GRLC to" value="">
                                    @endif

                                    <br>

                                    @if(isset($amount))
                                        <input class="form-control" type="number" name="amount" step="0.000001" placeholder="GRLC Amount" value="{{ $amount }}">
                                    @else
                                        <input class="form-control" type="number" name="amount" step="0.000001" placeholder="GRLC Amount">
                                    @endif

                                </div>
                                <div class="panel-footer">
                                    <div class="pull-right">
                                        <button class="btn btn-warning" type="submit">SEND</button>
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
