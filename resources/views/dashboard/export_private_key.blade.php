<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config("app.name", "Garliyard") }} | Export Private Key</title>

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
                    <div class="col-md-6 col-md-offset-3">
                        <form action="/pay" method="post">
                            {{ csrf_field() }}
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    KEY EXPORTED
                                </div>
                                <div class="panel-body">
                                    <div class="text-center">
                                        <h2>
                                            <span class="fa fa-download fa-3x"></span>
                                            <br><br>
                                            {{ $private_key }}
                                        </h2>
                                        <hr>
                                        <p>
                                            Your private key has been exported successfully and no longer exists on our records.
                                            <br>
                                            Run the following command below to import it into your garlicoin wallet.
                                        </p>
                                        <code>garlicoin-cli importprivkey {{ $private_key }}</code>
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
