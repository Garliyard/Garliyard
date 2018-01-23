<div class="modal inmodal fade" id="address-export-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Export Address</h4>
            </div>
            <div class="modal-body text-center">
                <div class="alert alert-danger">
                    Exporting a address is permanent to prevent double spending on this wallet.
                    <br>
                    If you choose to continue by pressing the export button below, it will be removed from your account on {{ config("app.name", "garliyard") }}.
                </div>
            </div>

            <div class="modal-footer">
                <a id="export-address" href=""  class="btn btn-danger">Export</a>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
