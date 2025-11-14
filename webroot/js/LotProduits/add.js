$(document).ready(function () {

    $(".select2").select2({
    });

    $('#is-event').on('change', function () {
        if ($('#is-event').val() == '1') {
            $('#type-docs-ids').attr('disabled', false);
            $('#antenne-id').attr('disabled', false);
            $('.for-event').removeClass('hide');
        } else {
            $('#type-docs-ids').attr('disabled', true);
            $('#antenne-id').attr('disabled', true);
            $('.for-event').addClass('hide');
        }
    });

     $('#tarif_identique').on('change', function () {
         if ($('#tarif_identique').is(':checked')) {
             $('.tarif-nb-label').addClass('hide');
             $('.tarif_nb').prop('required', false);
             $('.tarif_nb').val('');
             $('.tarif_ht').removeClass('hide');
             $('#tarif_ht').prop('required', true);
         } else {
             $('.tarif-nb-label').removeClass('hide');
             $('.tarif_nb').prop('required', true);
             $('.tarif_ht').addClass('hide');
             $('#tarif_ht').val('');
             $('#tarif_ht').prop('required', false);
         }
     });

    $('#quantite').on('change', function () {
        var quantite = $(this).val();

        var valeur = parseInt($(this).val());
        if (isNaN(valeur) || valeur == 0) {
            $('#quantite').val(1);
        }

        if (quantite >= 1) {
            var nb_ancien = $('.inp-reference').length;

            if (nb_ancien < quantite) {
                for (i = nb_ancien; i < quantite; i++) {
                    j = i + 1;
                    inp = $('#inp-reference').clone();
                    inp.attr('id', 'serial_nb_' + i);
                    inp.attr('name', 'serial_nb[' + i + ']');
                    inp.attr('placeholder', 'Serial ' + j);
                    $('#bloc_serial').append(inp);
                    
                    inp = $('.inp-tarif').clone();
                    inp.attr('id', 'tarif_nb_' + i);
                    inp.attr('name', 'tarif_nb[' + i + ']');
                    inp.attr('placeholder', 'Tarif achat HT pour le numero de serie ' + j);
                    $('#bloc_tarif').append(inp);
                    $('#tarif_nb_' + i).removeClass('inp-tarif');
                    //$('#tarif_nb_' + i).prop('required', true);
                }
            } else {
                for (i = quantite; i < nb_ancien; i++) {
                    $('#serial_nb_' + i).remove();
                    $('#tarif_nb_' + i).remove();
                }
            }
        }
    });

    $('#type-equipement-id').on('change', function () {
        var type_equipement = $(this).val();
        console.log(equipements);
        var liste_equipements = equipements[type_equipement];
        var value_equipement_id = $('#value_equipement_id').val();
        var option = '';
        $.each(liste_equipements, function (key, value) {
            if (key == value_equipement_id) {
                option += '<option value="' + key + '" selected="selected">' + value + '</option>';
            } else {
                option += '<option value="' + key + '">' + value + '</option>';
            }
        });
        $('#equipement-id').html(option);
    });
    $('#type-equipement-id').trigger('change');


    // PC
    $('#type-pc').on('change', function () {
        var type_pc = $(this).val();
        var liste_pc = numeroSeriesPC[type_pc];
        var option = '';
        $.each(liste_pc, function (key, value) {
            option += '<option value="' + key + '">' + value + '</option>';
        });
        $('#numero-series-pc').html(option);
    });
    $('#type-pc').trigger('change');

    // ECRAN
    $('#type-ecran').on('change', function () {
        var type_ecran = $(this).val();
        var liste_ecran = numeroSeriesEcran[type_ecran];
        var option = '';
        $.each(liste_ecran, function (key, value) {
            option += '<option value="' + key + '">' + value + '</option>';
        });
        $('#numero-series-ecran').html(option);
    });
    $('#type-ecran').trigger('change');

    // ECRAN
    $('#type-aphoto').on('change', function () {
        var type_aphoto = $(this).val();
        var liste_aphoto = numeroSeriesAPhoto[type_aphoto];
        var option = '';
        $.each(liste_aphoto, function (key, value) {
            option += '<option value="' + key + '">' + value + '</option>';
        });
        $('#numero-series-aphoto').html(option);
    });
    $('#type-aphoto').trigger('change');

    // ECRAN
    $('#type-print').on('change', function () {
        var type_print = $(this).val();
        var liste_print = numeroSeriesPrint[type_print];
        var option = '';
        $.each(liste_print, function (key, value) {
            option += '<option value="' + key + '">' + value + '</option>';
        });
        $('#numero-series-print').html(option);
    });
    $('#type-print').trigger('change');


});