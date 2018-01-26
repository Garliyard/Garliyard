<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-warning">
        <div class="panel-heading">
            YUBIKEYS
        </div>
        <div class="panel-body">
            @foreach($yubikeys as $yubikey)
                <div class="row">
                    <div class="col-md-3 text-center">
                        <span class="fa fa-key fa-4x"></span>

                    </div>
                    <div class="col-md-9">
                        <b>Name:</b> {{ $yubikey->name or $yubikey->yubikey_identity }}
                        <br>
                        <b>Identity:</b> {{ $yubikey->yubikey_identity }}
                        <br>
                        <b>Added:</b> {{ \Carbon\Carbon::parse($yubikey->created_at)->toDayDateTimeString() }} ({{ \Carbon\Carbon::parse($yubikey->created_at)->diffForHumans() }})
                        <br><br>
                        <a class="btn btn-danger" href="/account/2fa/yubikey/delete/{{ $yubikey->yubikey_identity }}">DEAUTHORIZE</a>
                    </div>
                </div>
                <hr>
            @endforeach
        </div>
        <div class="panel-footer">
            <a class="btn btn-warning" href="/account/2fa/yubikey/add">ADD YUBIKEY</a>
        </div>
    </div>
</div>