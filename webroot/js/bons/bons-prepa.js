$(document).ready( function () {
    $('.tinymce').tinymce({
        language: 'fr_FR',
        menubar: false,
        plugins: ['advlist autolink link imagetools spellchecker lists autoresize'],        
        toolbar: 'bold italic underline strikethrough |numlist bullist| link removeformat ',
        relative_urls : false,
        contextmenu: false,
        remove_script_host : false,
        convert_urls : false,
        branding: false,
        statusbar: false
    });

//    totalLivre();
    restLivre();

    var tbody = $('tbody.default-data');
    tbody.unbind('blur, change').on('blur, change', 'input[input-name="quantite_livree"]', function(event) {
        
        var currentTr = $(this).parents('tr');
        var quantite = parseFloat(currentTr.find('.rest_a_livrer').val());
        var quantite_livree = parseFloat($(this).val());
        currentTr.find('.rest-text').text(parseFloat((quantite - quantite_livree).toFixed(0)));
        currentTr.find('.rest').val(parseFloat((quantite - quantite_livree).toFixed(0)));
        
        if (quantite === quantite_livree) {
            currentTr.find('.status').val('complet');
            currentTr.find('.status-text').text('Complet');
            currentTr.find('.status-text').removeClass('attente_traitement incomplet').addClass('complet');
            currentTr.removeClass('tr-attente_traitement tr-incomplet').addClass('tr-complet');
        }
        if (quantite > quantite_livree) {
            currentTr.find('.status').val('incomplet');
            currentTr.find('.status-text').text('Incomplet');
            currentTr.find('.status-text').removeClass('attente_traitement complet').addClass('incomplet');
            currentTr.removeClass('tr-attente_traitement tr-complet').addClass('tr-incomplet');
        }
        if (quantite_livree == '0') {
            currentTr.find('.status').val('attente_traitement');
            currentTr.find('.status-text').text('En attente de traitement');
            currentTr.find('.status-text').removeClass('incomplet complet').addClass('attente_traitement');
            currentTr.removeClass('tr-incomplet tr-complet').addClass('tr-attente_traitement');
        }
        
        restLivre();
    });

    $('.set-complet').on('click', function () {
        
        var currentTr = $(this).parents('tr');
        var quantite = currentTr.find('.rest_a_livrer').val();
        currentTr.find('input[input-name="quantite_livree"]').val(quantite);
        currentTr.find('input[input-name="quantite_livree"]').trigger('change');
    });
    
    function restLivre() {
        var rest = 0;
        $('.rest').each( function () {
            
            if ($(this).val()) {
                rest = sum(rest, parseFloat($(this).val()));
            }
        });
        
        $('.rest_livre').text(rest.toFixed(0));
        
        var total = $('#total_commande').val();
        $('.total_livre').text((total - rest).toFixed(0));
        $('#total_livre').val((total - rest).toFixed(0));
        
    }
    
    // set ordre line
    function orderLine() {
        var tbody = $('tbody.default-data');
        var ordre = 0;

        tbody.find('.i-position').each(function(index, el) {
            $(this).val(ordre++);
        });
    }
    
    $('.save').on('click', function () {
        
        $('.form_prepa').submit();
    });

    $('.save_quit').on('click', function () {
        
        $('#action').val('quit');
        $('.form_prepa').submit();
    });

    $('.save_print').on('click', function () {
        
        $('#action').val('print');
        $('.form_prepa').submit();
    });


    // Ordonner
    $('#sortable').sortable({
        placeholder: "tr-ligne-highlight",
        helper: function(e, ui) {
            ui.parents('table').find('thead').children().each(function() {
                $(this).width($(this).width());
            });
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        },
        cursor: "move",
        handle: 'a.fa-arrows-alt-v',
        axis: 'y',
        stop: function(event, ui) {
            tinymce.remove();
            $('.tinymce').tinymce({
                language: 'fr_FR',
                menubar: false,
                plugins: ['advlist autolink link imagetools spellchecker lists autoresize'],        
                toolbar: 'bold italic underline strikethrough |numlist bullist| link removeformat ',
                relative_urls : false,
                contextmenu: false,
                remove_script_host : false,
                convert_urls : false,
                branding: false,
                statusbar: false
            });
        },
        update: function(event, ui) {
            orderLine();
        }
    });
});