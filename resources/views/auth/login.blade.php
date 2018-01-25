<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name', 'Garliyard') }} | Login</title>

    <link href="/css/app.css" rel="stylesheet">
</head>
<body class="gray-bg">
<div class="loginColumns animated fadeInDown">
    <div class="row">
        <div class="col-md-6">
            <h2 class="font-bold">Welcome to {{ config('app.name', 'Garlicoin') }}</h2>
            <p>
                If you need support, please contact <strong>{{ env('DISCORD_SUPPORT', 'Undefined#0000') }}</strong> on Discord.
            </p>


        </div>
        <div class="col-md-6">
            <div class="ibox-content">
                <form class="m-t" role="form" action="/login" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        @if(isset($username))
                            <input type="text" class="form-control" name="username" placeholder="Username" required="" value="{{$username}}">
                        @else
                            <input type="text" class="form-control" name="username" placeholder="Username" required="">
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password" required="">
                    </div>
                    <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                    <p class="text-muted text-center">
                        <small>Do not have an account?</small>
                    </p>
                    <a class="btn btn-sm btn-white btn-block" href="/register">Create an account</a>
                </form>
            </div>
        </div>
    </div>
    <hr/>
</div>

</body>

</html>
