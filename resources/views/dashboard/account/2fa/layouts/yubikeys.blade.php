<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-warning">
        <div class="panel-heading">
            YUBIKEYS
        </div>
        <div class="panel-body">
            @foreach($yubikeys as $yubikey)
                <div class="row">
                    <div class="row">
                        <div class="col-md-2">
                            <span class="fa fa-key fa-3x"></span>
                        </div>
                        <div class="col-md-10">
                            <b>Name:</b> {{ $yubikey->name or $yubikey->yubikey_identity }}
                            <b>Identity:</b> {{ $yubikey->yubikey_identity }}
                            <b>Added:</b> {{ \Carbon\Carbon::parse($yubikey->created_at)->toDayDateTimeString() }} ({{ \Carbon\Carbon::parse($yubikey->created_at)->diffForHumans() }})
                        </div>
                    </div>
                    <div class="row">
                        <a class="btn btn-danger" href="/account/2fa/yubikey-deauth/{{ $yubikey->yubikey_identity }}">DEAUTHORIZE</a>
                    </div>
                </div>
                <br>
            @endforeach
        </div>
        <div class="panel-footer">
            <a class="btn btn-warning" href="/account/2fa/yubikey/add">ADD YUBIKEY</a>
        </div>
    </div>
</div>