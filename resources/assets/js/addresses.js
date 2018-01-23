var last_clicked_pubkey = "";
$(".pubkey-export").on('click', function () {
    last_clicked_pubkey = $(this).attr("key");
    $("#address-export-modal").modal();
});

function exportAddress() {
    window.location.href = (window.location.hostname + "/export-private-key/" + last_clicked_pubkey);
}