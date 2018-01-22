<nav class="navbar navbar-static-top" role="navigation">
    <div class="navbar-header">
        <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
            <i class="fa fa-reorder"></i>
        </button>
        <a href="#" class="navbar-brand">{{ config("app.name", "Garliyard") }}</a>
    </div>
    <div class="navbar-collapse collapse" id="navbar">
        <ul class="nav navbar-nav">

        </ul>
        <ul class="nav navbar-top-links navbar-right">
            @if(\Illuminate\Support\Facades\Auth::check())
                <li>
                    <a href="/logout">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
            @else
                <li>
                    <a href="/register">
                        <i class="fa fa-user-plus"></i> Register
                    </a>
                </li>
                <li>
                    <a href="/login">
                        <i class="fa fa-user"></i> Login
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>