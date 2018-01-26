<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name', 'Garliyard') }} | Login</title>

    <link href="/css/app.css" rel="stylesheet">

</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen   animated fadeInDown">
    <div>
        @if(session()->has("error"))
            <div class="alert alert-danger">
                {{ session()->get("error") }}
            </div>
        @endif

        <div>
            <img src="https://garlicoin.io/static/logo.040b5384.png" width="100">
        </div>
        <br>
        <h3>{{ config("app.name", 'Garliyard') }} Registration</h3>
        <p>Just a few swipes of butter away.</p>
        <form class="m-t" role="form" action="/register" method="post">
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
            <div class="form-group">
                <input type="checkbox" name="agree">
                I agree to <a href="https://github.com/Garliyard/Garliyard/wiki/Terms-of-Service">The Terms of Service</a>.

            </div>
            <button type="submit" class="btn btn-warning block full-width m-b">Register</button>

            <p class="text-muted text-center">
                <small>Already have an account?</small>
            </p>
            <a class="btn btn-sm btn-white btn-block" href="/login">Login</a>
        </form>
    </div>
</div>
</body>
</html>