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


$('.step-vente tr:not(.d-none , .show)').find('td:eq(1):not(.d-none)').each(function(index, el) {
    if ($.trim($(this).text()) == '') {
        $(this).parents('tr').addClass('d-none');
    }
});


// Gmap à supprimer si pas utile après modifs récentes
// function initializeGmap() {
//     var lat = $('#mapCanvas').attr('data-client-lat');
//     var lng = $('#mapCanvas').attr('data-client-lng');
//     var latLng = new google.maps.LatLng(lat, lng);

//     // var latLng = new google.maps.LatLng(48.51418, -2.7658350000000382);
//     var map = new google.maps.Map(document.getElementById('mapCanvas'), {
//         zoom: 17,
//         center: latLng,
//         mapTypeId: google.maps.MapTypeId.ROADMAP,
//         streetViewControl: false,
//         mapTypeControl: false

//     });

//     var marker = new google.maps.Marker({
//         position: latLng,
//         map: map,
//         draggable: true,
//         title:"Vous pouvez glisser-déposer pour la destination souhaitée. Ou dans le champ de recherche, saisissez l'emplacement et sélectionnez."
//     });

    
// }
// google.maps.event.addDomListener(window, 'load', initializeGmap);

// MAJ de l'état d'une vente
$('#change-state').on('shown.bs.modal', function(event) {
    event.preventDefault();

    srcBtn = $(event.relatedTarget);
    calledModal = $(event.currentTarget);
    venteId = srcBtn.attr('data-id');
    currentForm = calledModal.find('form');
    currentForm.attr('action', srcBtn.attr('data-action'));
    etatFacturationSelect = calledModal.find('select.etat_facturation');
    etatFacturationSelect = calledModal.find('select.etat_facturation');
    dateFacturationInput = calledModal.find('input.date_facturation');
    saveBtn = currentForm.find('button.save');
    dateFacturation = srcBtn.attr('data-date-facturation');

    // --- si pre maj ----
    etatFacturationSelect.val(srcBtn.attr('data-etat-facturation'));
    etatFacturationSelect.selectpicker('refresh');
    dateFacturationInput.val(dateFacturation);
}); 

// alternance sur les tableaux sur les tr != d-none
$('table thead tr.d-none , table tbody tr.d-none').remove();

function removeProd() {
    $('.block-client-contacts').on('click', ' tbody.default-data #remove-prod', function(event) {
        event.preventDefault();
        var self = $(this);
        
        nbTr = $('tbody.default-data').find('tr').length;
        if (nbTr == 1) {
            alert('Cette ligne ne peut pas être supprimée');
            return false;
        }
        currentTr = $(this).parents('tr');
        var url = baseUrl+'fr/AjaxVentes/deleteContact/0/'+self.attr('data-key');

        if (url) {
            $.get(url, function(data, xhr) {
                if (data.status == 'success') {
                    currentTr.remove();
                }
            });
        } else {
            currentTr.remove();
        }

        
    });
}
removeProd();