<div class="col-md-4 col-md-offset-4">
    <div class="panel panel-warning">
        <div class="panel-heading">
            TWO FACTOR AUTHENTICATION SETUP
        </div>
        <div class="panel-body text-center">

            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-introduction">Introduction</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-totp">Google Authenticator</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-yubikey">Yubikey</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab-introduction" class="tab-pane active">
                        <div class="panel-body">
                            <strong>Two Factor Authentication is secure</strong>
                            <br>
                            <p>
                                Albeit Garlicoin is a cryptocurrency, financial data is always a good thing to protect.
                                <br>
                                This page will allow you to configure multiple hardware tokens or Google Authenticatior
                                as a second factor to keep someone out of your account if your password is guessed.
                                <br><br>
                                Please select one of the methods above.
                            </p>
                        </div>
                    </div>
                    <div id="tab-totp" class="tab-pane">
                        <div class="panel-body">
                            <span class="fa fa-lock fa-3x"></span>
                            <br><br>
                            <h3>Google Authenticator Setup</h3>
                            <p>
                                Setting up google authenticator as a second factor will render your account inaccessable if you lsoe or factory reset your phone. beware.
                            </p>
                            <br><br>
                            <a class="btn btn-warning" href="/account/2fa/totp/create">SETUP</a>
                        </div>
                    </div>
                    <div id="tab-yubikey" class="tab-pane">
                        <div class="panel-body">
                            <span class="fa fa-key fa-3x"></span>
                            <br><br>
                            <h3>No Yubikeys attached to your account</h3>
                            <br><br>
                            <a class="btn btn-warning" href="/account/2fa/yubikey/add">ADD YUBIKEY</a>
                        </div>
                    </div>
                </div>


            </div>


        </div>
    </div>
</div>