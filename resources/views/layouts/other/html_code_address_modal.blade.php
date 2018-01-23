<div class="modal inmodal fade" id="html-code" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">HTML Code</h4>
                <small class="font-bold">Paste this on your website to display a QR Code</small>
            </div>
            <div class="modal-body text-center">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#100px-tab">100px</a></li>
                        <li class=""><a data-toggle="tab" href="#150px-tab">150px</a></li>
                        <li class=""><a data-toggle="tab" href="#200px-tab">200px</a></li>
                        <li class=""><a data-toggle="tab" href="#dynamic-tab">Custom</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="100px-tab" class="tab-pane active">
                            <div class="panel-body">
                                <img src="data:image/png;base64,{{ base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(100)->generate($address->address)) }}"/>
                                <textarea style="min-width: 90%; min-height: 300px;">{{ \SimpleSoftwareIO\QrCode\Facades\QrCode::size(100)->generate($address->address) }}</textarea>
                            </div>
                        </div>
                        <div id="150px-tab" class="tab-pane">
                            <div class="panel-body">
                                <img src="data:image/png;base64,{{ base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(150)->generate($address->address)) }}"/>
                                <textarea style="min-width: 90%; min-height: 300px;">{{ \SimpleSoftwareIO\QrCode\Facades\QrCode::size(150)->generate($address->address) }}</textarea>
                            </div>
                        </div>
                        <div id="200px-tab" class="tab-pane">
                            <div class="panel-body">
                                <img src="data:image/png;base64,{{ base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(200)->generate($address->address)) }}"/>
                                <textarea style="min-width: 90%; min-height: 300px;">{{ \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate($address->address) }}</textarea>
                            </div>
                        </div>
                        <div id="dynamic-tab" class="tab-pane">
                            <div class="panel-body">
                                You may embed this URL on your website inside an <code>&#60;img&#62;</code> tag by using the following format
                                <h4>
                                    <code>http://{{ $_SERVER["HTTP_HOST"] }}/qr-code/{{ $address->address }}</code>
                                    <br><br>
                                    <br>
                                    Example
                                    <br><br>
                                    <code>{{ sprintf('<img height="200" src="http://%s/qr-code/%s"/>', $_SERVER["HTTP_HOST"], $address->address) }}</code>
                                </h4>

                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
