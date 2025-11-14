$('#modal-devis').on('shown.bs.modal', function(e) {
    modal = $(e.currentTarget);
    link = $(e.relatedTarget).attr('data-href');
    modal.find('.container-iframe-devis').html('<h4 class="h3-notif text-muted text-center">Chargement du document, veuillez patienter! </h4> <iframe id="devis-iframe" frameborder="0" class="d-none" width="100%" height="800px"></iframe>')
    $('iframe#devis-iframe').attr('src', link);
    $('iframe#devis-iframe').on('load', function(event) {
        $(this).removeClass('d-none');
        $('.h3-notif').remove();
    });
});
