<div class="modal inmodal fade" id="qr-code" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">QR Code</h4>
                <small class="font-bold">You can crop this window or scan it with a mobile device to send currency to this address.</small>
            </div>
            <div class="modal-body text-center">
                <img src="data:image/png;base64,{{ base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(200)->generate($address->address)) }}" />

                <h1>{{ $address->address }}</h1>
                <hr>
                You may also embed this URL on your website inside an <code>&#60;img&#62;</code> tag by using the following URL
                <code>https://{{ $_SERVER["HTTP_HOST"] }}/qr-code/{{ $address->address }}</code>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
