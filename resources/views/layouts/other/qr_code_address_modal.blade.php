<div class="modal inmodal fade" id="qr-code" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">QR Code</h4>
                <small class="font-bold">You can crop this window or scan it with a mobile device to send currency to this address.</small>
            </div>
            <div class="modal-body text-center">
                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(400)->generate($address->address) !!}
                <h1>{{ $address->address }}</h1>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
