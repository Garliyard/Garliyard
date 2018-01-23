$(".pubkey-export").on('click', function () {
    $("#address-export-modal").modal();
    $("#export-address").attr("href", "/export-private-key/" + $(this).attr("key"));
});
