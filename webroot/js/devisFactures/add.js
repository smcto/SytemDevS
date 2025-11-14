$(document).ready(function() {
    $(".select2").select2({
        multiple:true,
    });

    $('.select2').on('select2:opening select2:closing', function( event ) {
        var $searchfield = $(this).parent().find('.select2-search__field');
        $searchfield.prop('enable', true);
    });
    
    var srcUrl = $("#id_baseUrl").attr('value');

    $('.js-data-client-ajax').each(function() {
        $(this).select2({
            allowClear: true,
            dropdownParent: $(this).parent(),
            minimumInputLength: 2,
            language:{
                inputTooShort: function () {
                  return "Veuillez saisir 2 caractères ou plus";
                }
            },
            ajax: {
                url: srcUrl + "fr/ajax-clients/search-client",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                      nom: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    });
    
    // Changement adresse
    $('#invoices_adresse').on('shown.bs.modal', function (e) {
        modal = $(e.currentTarget);
        link = $(e.relatedTarget);
        url = link.attr('data-href');
        modal.find('form').attr('action', url);
        modal.find('form').submit(function(event) {});
    });

    $('#periode').on('change', function() {
        if($(this).val() == 1) {
            $('.fin_evenement').addClass('hide');
            $('#date_evenement_fin').val('');
            $('.debut_evenement').removeClass('col-md-4').addClass('col-md-9');
        } else {
            $('.fin_evenement').removeClass('hide');
            $('.debut_evenement').removeClass('col-md-9').addClass('col-md-4');
        }
    });

    // Changement contact
    $('#invoices_contact').on('shown.bs.modal', function (e) {
        modal = $(e.currentTarget);
        link = $(e.relatedTarget);
        url = link.attr('data-href');
        modal.find('form').attr('action', url);
        modal.find('form').submit(function(event) {});
    });

    // Objet du document
    $('.tinymce-note').tinymce({
        language: 'fr_FR',
        menubar: false,
        plugins: ['advlist autolink link imagetools spellchecker lists autoresize'],        
        toolbar: 'bold italic underline strikethrough |numlist bullist| link removeformat ',
        relative_urls : false,
        contextmenu: false,
        remove_script_host : false,
        convert_urls : false,
        branding: false,
        statusbar: false,
      });

    var trLength = $('.container-objet').find('.bloc-objet').length-1;
    $('.add-data').unbind('click');

    $('.add-data').click(function(event) {
        clonedTr = $('.bloc-objet.clone').last().clone(); 

        $('.container-objet').append(clonedTr).promise().then(function (e) {
            newTr = $('.container-objet').find('.bloc-objet.added-objet').last();
            var newTrIndex = eval(newTr.index()+trLength);
            newTr.find("textarea").each(function(index, el) {
                name = 'invoices_objects'+'['+newTrIndex+']['+$(this).attr('input-name')+']';
            });
            newTr.removeClass('d-none');
        });
    });
    
    $('#delai-reglements').on('change', function() {
        if($(this).val() != 'echeances') {
            $('tbody.echeance').html('');
            $('.div-echeance').addClass('hide');
        } else {
            $('.div-echeance').removeClass('hide');
        }
    });
    
    
    $('#edit_client_btn').on('click', function() {
        var adr = $('#adresse').val();
        var adr_2 = $('#edit_client_adress_2').val();
        var cp = $('#cp').val();
        var ville = $('#ville').val();
        var pays = $('#country').val();
        var id = $('#client_id').val();
        $.ajax({
            url: srcUrl + 'fr/ajax-clients/update-adress-client/' + id,
            type: "POST",
            dataType: 'json',
            data: {
                adresse:adr,
                adresse_2:adr_2,
                cp:cp,
                ville:ville,
                country:pays
            },
            success: function(data) {
                if (data.status == 1) {
                    $('#client_adresse').val(data.client.adresse);
                    $('#client_cp').val(data.client.cp);
                    $('#client_ville').val(data.client.ville);
                    $('#client_country').val(data.client.country);
                    var html = data.client.adresse + '<br>';
                    if(data.client.adresse_2){
                        html += data.client.adresse_2 + '<br>';
                    }
                    html += data.client.cp + ' ' + data.client.ville + '<br>' + data.client.country;
                    $('.clinet_info').html(html);
                    $('#devis_factures_client_adress').modal('hide');
                }
            },
            error: function(data) {
                console.log('Erreur:', data);
            },
        });
    });
    
    $('.radios-existing-contact').on('change', function () {
        if($(this).is(':checked')) {
            $('.nouveau-contact').addClass('hide');
            $('#contact_id').prop('required',true);
            $('.contact-required').prop('required',false);
        }
    });

    $('.radios-new-contact').on('change', function () {
        if($(this).is(':checked')) {
            $('.nouveau-contact').removeClass('hide');
            $('#contact_id').val('').prop('required',false);
            $('.contact-required').prop('required',true);
        }
    });
    
    $('form#add_contact_client').on('submit', function (e) {
        e.preventDefault();

        var id = $('#client_id').val();
        $.ajax({
            type: 'POST',
            url: srcUrl + 'fr/ajax-clients/add-contact/' + id,
            dataType: 'json',
            data: $('form').serialize(),
            success: function (data) {
                if (data.status == 1) {
                    $('#client_contact_id').val(data.contact.id);
                    var civilite = data.contact.civilite!= null?data.contact.civilite:'';
                    $('.client_contact').html('À l\'attention de <b>'+ civilite + ' ' + data.contact.full_name + '</b>');
                    var option = '<option value>Séléctionner</option>';
                    $.each(data.contacts, function(key, value){
                        if(key == data.contact.id){
                            option += '<option value="'+key+'" selected = selected>'+value+'</option>';
                        }else{
                            option += '<option value="'+key+'">'+value+'</option>';
                        }
                    });
                    $('#contact_id').html(option);
                    $('.delete-contact').removeClass('hide');
                    $('#devis_factures_contact').modal('hide');
                }
            }
        });
    });
    
    $('form#edit_client_form').on('submit', function (e) {
        e.preventDefault();

        var client_id = $('#edit-client-id').val();
        $.ajax({
            type: 'GET',
            url: srcUrl + 'fr/ajax-clients/get-client-by-id/' + client_id,
            success: function (data) {
                if (data.status == 1) {
                    $('#client_id').val(data.client.id);
                    $('#client_adresse').val(data.client.adresse);
                    $('#client_adresse_2').val(data.client.adresse_2);
                    $('#client_cp').val(data.client.cp);
                    $('#client_ville').val(data.client.ville);
                    $('#client_country').val(data.client.country);
                    
                    $('#adresse').val(data.client.adresse);
                    $('#edit_client_adress_2').val(data.client.adresse_2);
                    $('#cp').val(data.client.cp);
                    $('#ville').val(data.client.ville);
                    $('#country').val(data.client.country);
                    $('.link_edit_client').attr('href', srcUrl + 'fr/clients/add/' + data.client.id);
                    var html = data.client.adresse?data.client.adresse + '<br>' : '';
                    html += data.client.adresse_2?data.client.adresse_2 + '<br>' : '';
                    html += data.client.cp?data.client.cp : '';
                    html += data.client.ville?data.client.ville + '<br>' : ''; 
                    html += data.client.country?data.client.country : '';
                    $('.clinet_info').html(html);
                    
                    var option = '<option value>Séléctionner</option>';
                    $.each(data.contacts, function(key, value){
                        option += '<option value="'+key+'">'+value+'</option>';
                    });
                    $('#contact_id').html(option);
                    $('#client_contact_id').val('');
                    $('.client_contact').html('');
                    $('#client-nom').val(data.client.nom);
                    
                    $('#edit_client').modal('hide');
                }
            }
        });
    });
    
    $('form#lier_client').on('submit', function (e) {
        e.preventDefault();
        var client_id = $('#client-id-2').val();
        $.ajax({
            type: 'GET',
            url: srcUrl + 'fr/ajax-clients/get-client-by-id/' + client_id,
            success: function (data) {
                if (data.status == 1) {
                    $('#client_id_2').val(client_id);
                    var html = 'Lié à ' + data.client.full_name + '<br>';
                    $('.clinet_info_2').html(html);
                    $('.delete-client-2').removeClass('hide');
                    $('#modal_lier_client').modal('hide');
                }
            }
        });
    });
    
    
    $('.delete-client-2').on('click', function () {
        if (confirm('Etes-vous sûr de vouloir supprimer le 2ème client?')) {
            $('#client_id_2').val('');
            $('.clinet_info_2').html('');
            $('.delete-client-2').addClass('hide');
        }
    });
    
    $('.delete-contact').on('click', function () {
        if (confirm('Etes-vous sûr de vouloir supprimer le contact?')) {
            $('#client_contact_id').val('');
            $('.client_contact').html('');
            $('.delete-contact').addClass('hide');
        }
    });
    
    function aupdateEcheance() {
        var tbody = $('tbody.echeance');
        tbody.unbind('blur').on('blur', 'input[input-name="montant"]', function(event) {
            calculTotalEcheance();
        });
    }
    aupdateEcheance();

    function removeBloc() {
        $('.container-objet').on('click', '#remove-bloc', function(event) {
            event.preventDefault();

            if (confirm('Êtes-vous sûr de vouloir supprimer?')) {
                nbTr = $('.container-objet').find('tr').length;
                url = $(this).attr('data-href');
                if (nbTr == 1) {
                    alert('Cette ligne ne peut pas être supprimée');
                    return false;
                }
                currentTr = $(this).parents('.bloc-objet');

                if (url) {
                    $.get(url, function(data, xhr) {
                        if (data.status == 'success') {
                            currentTr.remove();
                        }
                    });
                } else {
                    currentTr.remove();
                }
            }

        });
    }
    removeBloc();
    
});


var defaultData = $('tbody.echeance');
var trLength = defaultData.find('tr').length;
var today = moment().format('YYYY-MM-DD');

var paidEcheances = [];
$('tr.is_payed').each(function(index, el) {
    paidEcheances.push(new Object({
        'date': $(this).attr('date'),
        'montant': $(this).attr('montant')
    }));
});


var activeRec = false;
function echeanceAdd(max) {
    if (max > 0) {
        // $('tbody.echeance tr:not(.is_payed)').remove();
        $('tbody.echeance').empty();
        var now = setIncrementedDate(0);
        var montant = $('.total_general_ttc').text();
        // si echeance 2x, 3x etc regénérées en mode édition, ca efface toutes les echeances en cours et réajoute les nouveaux
        if ($('#devis_id').val() != "") {
            $('.is_echeance_regenerated').val(1);
        }
        if (montant !== '') {
            montant = parseFloat(montant / max).toFixed(2);
        }
        var number = 0;
        var clonedTr = $('tfoot.echeance tr').last().clone();
        var recurs = addTr(clonedTr, now, number, max, montant);

        // determine qd le recursive s'arrête
        var timer = setInterval(function () {
            // process formule pour qu'il n'y ait pas de reste, on ajout dans l'une ligne des echéances génerées    
            if ($('.rest_echeances').text() > 0 || $('.rest_echeances').text() < 0) {
                var lastEcheance = $('tbody.echeance tr:last input[input-name="montant"]');
                var lastEcheanceVal = parseFloat(lastEcheance.val());
                var resteEchance = parseFloat($('.rest_echeances').text());
                lastEcheance.val((lastEcheanceVal+resteEchance).toFixed(2));
                calculTotalEcheance();
                $('.rest_echeances').text(Math.abs($('.rest_echeances').text())+'.00');
            }
            // -- fin
            if (activeRec == true) {
                clearInterval(timer);
            }
        }, 500)
        
    } else {
        var clonedTr = $('tfoot.echeance tr').last().clone();
        $('tbody.echeance').append(clonedTr).promise().then(function(e) {
            newRow = $('tbody.echeance').find('tr').last();
            newTrIndRow = eval(newRow.index());
            newRow.find("input[input-name] , select[input-name]").each(function(index, el) {
                $(this).attr('name', 'devis_factures_echeances' + '[' + newTrIndRow + '][' + $(this).attr('input-name') + ']');
            });
        });
    }
}

function addTr(clonedTr, date, number, max, montant) {

    if (number < max) {
        // console.log(date.toLocaleDateString("fr-FR"))
        $('tbody.echeance').append(clonedTr).promise().then(function(e) {
            var newTr = $('tbody.echeance').find('tr').last();
            var currentTr = newTr.prev();
            var newTrIndRow = eval(newTr.index() + trLength);

            newTr.find("[input-name]").each(function(index, el) {
                $(this).attr('name', 'devis_factures_echeances' + '[' + newTrIndRow + '][' + $(this).attr('input-name') + ']');
            });

            prevDate = currentTr.find('[input-name="date"]').val();
            newTr.find('[input-name="date"]').val(date);
            newTr.find('[input-name="montant"]').val(montant);

            number++;
            clonedTr = $('tfoot tr').last().clone();
            calculTotalEcheance();
            date = setIncrementedDate(number);
            addTr(clonedTr, date, number, max, montant);
        }) 
    }
    else {
        activeRec = true;
    }

    return false;
}

function setIncrementedDate(kMonth = 0) {
    currentDate = moment().format('YYYY-MM-DD');
    return moment(currentDate).add(kMonth, 'M').format('YYYY-MM-DD');
}

function addMonths(date, months) {
    date.setMonth(date.getMonth() + months);
    function pad(s) { return (s < 10) ? '0' + s : s; };
    return [date.getFullYear(), pad(date.getMonth()) != '00'?pad(date.getMonth()):12 ,pad(date.getDate())].join('-');
}

function echeanceUpdate() {

    var number = $('tbody.echeance').find('tr').length;
    var montant = $('.total_general_ttc').text();
    if (montant !== '') {
        montant = parseFloat(montant / number).toFixed(2);
    }
    var now = new Date(Date.now());
    $('tbody.echeance').find('tr').each(function(index, el) {
        $(this).find('[input-name="date"]').val(addMonths(now, 1));
        $(this).find('[input-name="montant"]').val(montant);
        calculTotalEcheance();
    });
}

function calculTotalEcheance() {
    var montant = Number($('.total_general_ttc').text());
    var total = 0;
    $('tbody.echeance').find('.echeance-montant').each(function() {
        total += Number($(this).val() != '' ? $(this).val() : 0);
        $('.total_echeances').text(total.toFixed(2));
        $('.rest_echeances').text((montant - total).toFixed(2));
    });


    if ($('tbody.echeance .echeance-montant').length < 1) {
        $('.total_echeances').text((0).toFixed(2));
        $('.rest_echeances').text(montant);
    }
}


function deleteRow(r) {
    var i = r.parentNode.parentNode.rowIndex;
    document.getElementById("echeance").deleteRow(i);
    calculTotalEcheance();
}
