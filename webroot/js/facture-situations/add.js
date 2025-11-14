$(document).ready(function () {
    
    // Objet du document
    $('.tinymce-note').tinymce({
        language: 'fr_FR',
        menubar: false,
        plugins: ['advlist autolink link imagetools spellchecker lists autoresize'],        
        toolbar: 'bold italic underline strikethrough |bullist numlist | link removeformat ',
        relative_urls : false,
        contextmenu: false,
        remove_script_host : false,
        convert_urls : false,
        branding: false,
        statusbar: false
    });
    
    $('.pourcentage_global_button').on('click', function () {
        $(this).addClass('hide');
        $('.pourcentage_global_filed').removeClass('hide');
    });
    
    $('#pourcentage-global').on('change', function() {
        var global = $(this).val();
        if(global !== '' && global != '0') {
            var tbody = $('tbody.default-data');

            tbody.find('input[input-name="avancement_pourcentage"]').each(function(index, el) {
                $(this).val(global);
                $(this).trigger('blur').trigger('change');
            });
            $(this).val(global);
        }
    });

    calculLine();

    // deinfition ordre avant save
    $('.save').on('click', function(event) {
        event.preventDefault();
        $('.form-facture-situation').submit();
    });

    $('.save_continuer').on('click', function(event) {
        event.preventDefault();
        $('#is_continue').val(1);
        $('.form-facture-situation').submit();;
    });

      
});

function calculLine() {
     var tbody = $('tbody.default-data');

        // Calcul montant TTC ligne
        tbody.unbind('blur, change').on('blur, change', 'input[input-name="avancement_euro"] , input[input-name="avancement_pourcentage"]', function(event) {
            var currentTr = $(this).parents('tr');
            var prix_ht = currentTr.find('input[input-name="prix_reference_ht"]').val();
            var remise_value = currentTr.find('[input-name="remise_value"]').val();
            var remise_unity = currentTr.find('input[input-name="remise_unity"]').val();
            var tva = currentTr.find('input[input-name="tva"]').val();
            var quantite = currentTr.find('.quantite_usuelle').text();
            var value_ht = 0;
            var value_ttc = 0;
            var avancement_euro = 0;
            var avancement_pourcentage = 0;
            var quantite_avancement = 0;
            
            if($(this).hasClass('avancement_euro')) {
                value_ht = $(this).val();
                avancement_pourcentage = ((value_ht * 100)/(prix_ht*quantite)).toFixed(2);
                avancement_euro = $(this).val();
            } else {
                if($(this).val() != $('#pourcentage-global').val()) {
                    $('#pourcentage-global').val('');
                }
                value_ht = (prix_ht * quantite * parseFloat($(this).val()/100).toFixed(2)).toFixed(2);
                avancement_pourcentage = $(this).val();
                avancement_euro = value_ht;
            }
            
            var remise = 0;
            if(remise_unity === '%') {
                remise = (parseFloat((remise_value/100).toFixed(2)) * value_ht).toFixed(2);
            }
            
            value_ht = (value_ht - remise).toFixed(2);
            
            quantite_avancement = (quantite * avancement_pourcentage / 100).toFixed(2);
            value_ttc = ((1 + (tva/100)) * value_ht).toFixed(2);
            
            currentTr.find('.remise_euro').val(remise);
            currentTr.find('.avancement_pourcentage').val(avancement_pourcentage);
            currentTr.find('.avancement_euro').val(avancement_euro);
            currentTr.find('.avancement_quantite').val(quantite_avancement);
            currentTr.find('.quantite_avancement').text(quantite_avancement);
            currentTr.find('td.montant_ht .montant_ht_value').text(value_ht);
            currentTr.find('input[input-name="montant_ht"]').val(value_ht);
            currentTr.find('td.montant_ttc .montant_ttc_value').text(value_ttc);
            currentTr.find('input[input-name="montant_ttc"]').val(value_ttc);
            
            majRecap();
        });
        
        $('input[input-name="avancement_euro"]').trigger('blur').trigger('change');
        
}


// Calcul montant récapitulation finale
function majRecap() {
    var tbody = $('tbody.default-data');
    var total_ht = 0;
    var total_ttc = 0;
    var total_remise = 0;
    
    tbody.find('.montant_ht').each(function(index, el) {
        var currentTr = $(this).parents('tr');
        var montant_ht = currentTr.find('.montant_ht_value').text();
        var montant_ttc = currentTr.find('.montant_ttc_value').text();
        var remise_euro = currentTr.find('.remise_euro').val();
        total_ht = sum(total_ht, parseFloat(montant_ht != '' ? montant_ht : 0));
        total_remise = sum(total_remise, parseFloat(remise_euro != '' ? remise_euro : 0));
        total_ttc = sum(total_ttc, parseFloat(montant_ttc != '' ? montant_ttc : 0));
    });
    
    $('.remise-global-ht').text(total_remise.toFixed(2));
    $('.total_general_ht').text(total_ht.toFixed(2));
    $('.total_general_ttc').text(total_ttc.toFixed(2));
    $('#total_ht').val(total_ht.toFixed(2));
    $('#total_ttc').val(total_ttc.toFixed(2));
}
