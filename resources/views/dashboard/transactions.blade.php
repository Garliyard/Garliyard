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
                        <div class="col-md-12">
                            <div class="alert alert-danger">
                                {{ session()->get("error") }}
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                TRANSACTIONS ({{ count($transactions) }})
                            </div>
                            <div class="panel-body">
                                @include("layouts.other.transactions")
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include("layouts.other.address_export_modal")
<!-- Mainly scripts -->
<script src="/js/app.js"></script>
</body>
</html>
