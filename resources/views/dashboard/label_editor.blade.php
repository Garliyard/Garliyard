<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config("app.name", "Garliyard") }} | Editing {{ $address->address }}'s label</title>

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
                        <form action="/edit-label/post" method="post">
                            {{ csrf_field() }}
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    LABEL EDITOR FOR {{ strtoupper($address->address) }}
                                </div>
                                <div class="panel-body">
                                    @if($address->label != null)
                                        <p>
                                            Your current label for the address {{ $address->address }} is:
                                            <br>
                                            <b>{{ $address->label }}</b>
                                        </p>
                                        <hr>
                                    @endif
                                    <input type="hidden" name="address" value="{{ $address->address }}">
                                    <input type="text" name="label" placeholder="Enter your label here">
                                </div>
                                <div class="panel-footer">
                                    <div class="pull-right">
                                        <button class="btn btn-warning" type="submit">SET LABEL</button>
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
