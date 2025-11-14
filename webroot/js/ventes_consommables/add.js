$(document).ready(function($) {

    $('.tr-container-checkbox input[type="checkbox"]').click(function(event) {
        self = $(this);
        dataTarget  = self.attr('data-target');

        if ($(this).is(':checked')) {
            $('tr#'+dataTarget).removeClass('d-none');
            $('tr#'+dataTarget).find('input[type="number"]').val('');
        } else {
            $('tr#'+dataTarget).addClass('d-none');
        }
    });


    $('#commentaire').tinymce({
        language: 'fr_FR',
        menubar: false,
        plugins: ['advlist autolink link imagetools spellchecker lists autoresize'],        
        toolbar: 'bold italic underline strikethrough |bullist numlist | link removeformat ',
        relative_urls : false,
        contextmenu: false,
        remove_script_host : false,
        convert_urls : false,
        branding: false,
        statusbar: false,
    });


    // charge les devis selon le client choisi
    $('[name="client_id"]').on('change', function(event) {
        client_id = $(this).val();

        devisSelect = $('[name="devis_id"]');
        emptyOption = devisSelect.find('option[value=""]').text();
        $.get(base_url+'fr/AjaxVentesConsommables/loadDevisByCientId/'+client_id, function(data) {
            
            // after ajax callback
            var option = new Option(emptyOption, "", true, true);
            devisSelect.html('');
            devisSelect.append(option);
                
            $.each(data, function (key, value) {
                var option = new Option(value, key, false, false);
                devisSelect.append(option);
            });
            
            devisSelect.selectpicker('refresh');   
        });
    });

    // charge les produits du devis choisi
    $('[name="devis_id"]').on('change', function(event) {

        var devis_id = $(this).val();

        // 2 = accessoires cf table catalog_sous_categories
        $.get(base_url+'fr/AjaxVentesConsommables/getDevisAndProduits/'+devis_id+'/2', function(data) {
            $('.container-accessoires').html(data);
        });

        // 16 = consommables cf table catalog_sous_categories
        $.get(base_url+'fr/AjaxVentesConsommables/getDevisAndProduits/'+devis_id+'/16', function(data) {
            $('.container-consommables').html(data);
        });
    });


}); 