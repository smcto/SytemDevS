$('#modal-bl').on('shown.bs.modal', function(e) {
    modal = $(e.currentTarget);
    link = $(e.relatedTarget).attr('data-href');
    modal.find('.container-iframe-bl').html('<h4 class="h3-notif text-muted text-center">Chargement du document, veuillez patienter! </h4> <iframe id="bl-iframe" frameborder="0" class="d-none" width="100%" height="800px"></iframe>')
    $('iframe#bl-iframe').attr('src', link);
    $('iframe#bl-iframe').on('load', function(event) {
        $(this).removeClass('d-none');
        $('.h3-notif').remove();
    });
});

$(document).ready(function () {
    
    $('.detail-fabrication').on('click', function () {
        if ($('.detail-fabrication').text() == 'Voir le détail') {
            $('.table-detail-fabrication').removeClass('hide');
            $('.detail-fabrication').text('Masquer le detail');
        } else {
            $('.table-detail-fabrication').addClass('hide');
            $('.detail-fabrication').text('Voir le détail');
        }
    });
    
    // Supprime Tr si vide
    // removeIfEmptyTr();
});
