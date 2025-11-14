$(document).ready(function() {
    var srcUrl = $("#id_baseUrl").attr('value');

    var trLength = $('tbody.default-data').find('tr').length-1;
    $('.add-data').unbind('click');
    $('.add-data').click(function(event) {
        clonedTr = $('tr.clone').last().clone();
        $('tbody.default-data').append(clonedTr).promise().then(function (e) {
            newTr = $('tbody.default-data').find('tr.added-tr').last();
            newTr.find('[input-name="nom"] , [input-name="prenom"] , [input-name="email"]').attr('required', 'required');
            var newTrIndex = eval(newTr.index()+trLength);
            newTr.find("input[input-name] , select[input-name]").each(function(index, el) {
                $(this).attr('name', 'client_contacts'+'['+newTrIndex+']['+$(this).attr('input-name')+']');
            });
            newTr.removeClass('d-none');
        });
    });
    
    
    $('#client-type').on('change', function () {
        if($(this).val() == 'corporation') {
            $('.client-lastname').addClass('hide');
            $('.enseigne').removeClass('hide');
            $('.client-name').text('Raison sociale (*)');
            $('.client-tel').text('Tel entreprise');
            $('.client-mail').text('Email général');
            $('.client-pro').removeClass('hide');
            $('.secteurs_activites').attr('required', 'required');
        }else {
            $('.client-lastname').removeClass('hide');
            $('.enseigne').addClass('hide');
            $('.client-name').text('Nom (*)');
            $('.client-tel').text('Téléphone');
            $('.client-mail').text('Email');
            $('.client-pro').addClass('hide');
            $('.pro').val('');
            $('.secteurs_activites').attr('required', false);
        }
    });
    $('#client-type').trigger('change');

    function removeProd() {
        $('tbody.default-data').on('click', '#remove-prod', function(event) {
            event.preventDefault();
            
            if (confirm('Êtes vous sûr de vouloir supprimer?')) {
                nbTr = $('tbody.default-data').find('tr').length;
                url = $(this).attr('data-href');
                if (nbTr == 1) {
                    alert('Cette ligne ne peut pas être supprimée');
                    return false;
                }
                currentTr = $(this).parents('tr');

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
    removeProd();


    $('.cp').on('blur', function(event) {
        event.preventDefault();
        var form = $(this).parents('form').first();

        var cpVal = $(this).val();
        var listVille = $('select.list_ville', form);

        // after ajax callback
        var emptyOption = listVille.find('option[value=""]').text();
        $.get(baseUrl+'/fr/AjaxVillesCodePostals/getByCp/'+cpVal, function(data) {
            var option = new Option(emptyOption, "", true, true);
            listVille.html('');
            listVille.append(option);
                
            $.each(data, function (key, value) {
                var option = new Option(value, key, false, false);
                listVille.append(option);
            });
            
            listVille.selectpicker('refresh');
        });   
    });

    // Ville saisi manuel input ou select
    $('[name="is_ville_manuel"]').click(function(event) {
        currentForm = $(this).parents('form');
        if ($(this).is(':checked')) {
            $('.bloc-ville .select', currentForm).addClass('d-none');
            $('.bloc-ville .input', currentForm).removeClass('d-none');
            $('.bloc-ville .input [name="ville"]', currentForm).removeAttr('disabled');
            $('.bloc-ville .input [name="new_client[ville]"]', currentForm).removeAttr('disabled');
        } else {
            $('.bloc-ville .select', currentForm).removeClass('d-none');
            $('.bloc-ville .input', currentForm).addClass('d-none');
            $('.bloc-ville .input [name="ville"]', currentForm).attr('disabled', 'disabled');
            $('.bloc-ville .input [name="new_client[ville]"]', currentForm).attr('disabled', 'disabled');
        }
    });

});
